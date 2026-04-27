<?php

namespace coursely\App\Core;

class FrontendAccountAccessGuard
{
    // Frontend-only customer accounts must never access wp-admin.
    private const BACKEND_CAPABILITY = 'manage_options';
    public function __construct(){
        add_action('admin_init', [$this,'block_admin_access']);
        add_filter('show_admin_bar', [$this,'hide_admin_bar']);
        add_filter('login_redirect', [$this,'login_redirect'], 10, 3);
    }

    public function block_admin_access(): void
    {
        if (wp_doing_ajax() || wp_doing_cron() || $this->has_backend_access() || $this->is_allowed_admin_request()) {
            return;
        }

        wp_safe_redirect(home_url());
        exit;
    }

    public function hide_admin_bar(bool $show): bool
    {
        if (!$this->has_backend_access()) {
            return false;
        }

        return $show;
    }

    public function login_redirect(string $redirect_to, string $request, $user): string {

        if ($user instanceof \WP_User && !$this->has_backend_access($user)) {
            return home_url();
        }

        return $redirect_to;
    }

    private function has_backend_access(?\WP_User $user = null): bool
    {
        $user = $user ?: wp_get_current_user();

        if (!$user instanceof \WP_User || !$user->exists()) {
            return false;
        }

        return user_can(
            $user,
            self::BACKEND_CAPABILITY
        );
    }

    private function is_allowed_admin_request(): bool
    {
        global $pagenow;

        return in_array($pagenow, [
            'admin-ajax.php',
            'async-upload.php',
            'admin-post.php'
        ], true);
    }

}