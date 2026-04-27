<?php
namespace coursely\App\Core;


use coursely\App\Controllers\PaginationController;
use coursely\App\Core\CPT\CPTRegistrar;
use coursely\App\Core\Handlers\AjaxAuthHandler;
use coursely\App\Core\Handlers\AjaxHandler;
use coursely\App\Core\Helpers\FilterDataCustomisationHelper;
use coursely\App\Core\Setup\ACFInteractionSetup;
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

class Bootstrap
{
    public static function init(): void
    {
        (new HomePageInitializer())->register();
        (new StaticPagesInitializer())->register();
        (new PermalinkInitializer())->register();
        (new ACFInteractionSetup())->initialize();
        (new YoastInteractionSetup)->initialize();
        (new CommentsSetup)->initialize();
        (new DefaultHeadIncludesCleaner)->initialize();
        (new EmojiSetup)->initialize();
        (new FeedsSetup)->initialize();
        (new FilesModSetup)->initialize();
        (new NavMenuSetup)->initialize();
        (new ThumbnailSetup)->initialize();
        (new Enqueuer)->initialize();
        new CPTRegistrar;
        new PaginationController;
        new AjaxHandler();
        new AjaxAuthHandler();
        (new DateShortcodes())->register();
        new RestAPISetup();
        new FilterDataCustomisationHelper();
        new FrontendAccountAccessGuard();
    }

}