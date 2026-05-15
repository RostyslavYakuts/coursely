<?php

namespace coursely\App\Controllers;

use coursely\App\Core\Services\AccessService;
use coursely\App\Models\ModelInterface;
use duncan3dc\Laravel\BladeInstance;

class LessonController implements ControllerInterface
{
    protected BladeInstance $blade;
    protected ModelInterface $model;

    public function __construct($model)
    {
        $this->model = $model;
        $views = get_theme_file_path('App/Views');
        $cache = get_theme_file_path('storage/cache');
        $this->blade = new BladeInstance($views, $cache);
    }

    public function render(): void
    {
        $userId = get_current_user_id();
        $data = $this->model->get_post_data();

        if (!AccessService::canViewLesson($userId, $data['id'])) {
            status_header(403);
            exit;
        }

        $view = 'single.lesson.index';
        $data = $this->model->get_post_data();
        echo $this->blade->make($view, [
            'data' => $data
        ])->render();
    }
}