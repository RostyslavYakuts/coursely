<?php
namespace coursely\App\Core;


use coursely\App\Controllers\PaginationController;
use coursely\App\Core\CPT\CPTRegistrar;
use coursely\App\Core\CPT\CPTSlugRewrite;
use coursely\App\Core\CT\CustomTaxonomyRegister;
use coursely\App\Core\Handlers\AjaxAccountHandler;
use coursely\App\Core\Handlers\AjaxAuthHandler;
use coursely\App\Core\Handlers\AjaxCancelSubscription;
use coursely\App\Core\Handlers\AjaxCheckout;
use coursely\App\Core\Handlers\AjaxCheckoutStatus;
use coursely\App\Core\Handlers\AjaxHandler;
use coursely\App\Core\Helpers\FilterDataCustomisationHelper;
use coursely\App\Core\Setup\ACFInteractionSetup;
use coursely\App\Core\Setup\AfterSwitchTheme;
use coursely\App\Core\Setup\CommentsSetup;
use coursely\App\Core\Setup\DefaultHeadIncludesCleaner;
use coursely\App\Core\Setup\EmojiSetup;
use coursely\App\Core\Setup\FeedsSetup;
use coursely\App\Core\Setup\FilesModSetup;
use coursely\App\Core\Setup\HomePageInitializer;
use coursely\App\Core\Setup\NavMenuSetup;
use coursely\App\Core\Setup\PermalinkInitializer;
use coursely\App\Core\Setup\RestAPISetup;
use coursely\App\Core\Setup\StaticPagesInitializer;
use coursely\App\Core\Setup\ThumbnailSetup;
use coursely\App\Core\Setup\YoastInteractionSetup;
use coursely\App\Core\Shortcodes\DateShortcodes;
use coursely\App\Core\Webhooks\StripeWebhookHandler;

class Bootstrap
{
    public static function init(): void
    {
        new AfterSwitchTheme();
        new HomePageInitializer()->register();
        new StaticPagesInitializer()->register();
        new PermalinkInitializer()->register();
        new ACFInteractionSetup()->initialize();
        new YoastInteractionSetup()->initialize();
        new CommentsSetup()->initialize();
        new DefaultHeadIncludesCleaner()->initialize();
        new EmojiSetup()->initialize();
        new FeedsSetup()->initialize();
        new FilesModSetup()->initialize();
        new NavMenuSetup()->initialize();
        new ThumbnailSetup()->initialize();
        new Enqueuer()->initialize();
        new CPTRegistrar();
        new CustomTaxonomyRegister();
        new PaginationController();
        new AjaxHandler();
        new AjaxAuthHandler();
        new AjaxAccountHandler();
        new AjaxCheckout();
        new AjaxCancelSubscription();
        new AjaxCheckoutStatus();
        new StripeWebhookHandler();
        new DateShortcodes()->register();
        new RestAPISetup();
        new FilterDataCustomisationHelper();
        new FrontendAccountAccessGuard();
        new CPTSlugRewrite('course', 'courses');
    }

}