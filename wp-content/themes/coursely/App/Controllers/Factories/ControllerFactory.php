<?php

namespace coursely\App\Controllers\Factories;

use coursely\App\Controllers\AuthorController;
use coursely\App\Controllers\BlogController;
use coursely\App\Controllers\CategoryController;
use coursely\App\Controllers\ContactPageController;
use coursely\App\Controllers\ControllerInterface;
use coursely\App\Controllers\CoursesPageController;
use coursely\App\Controllers\Error404Controller;
use coursely\App\Controllers\HomeController;
use coursely\App\Controllers\PageController;
use coursely\App\Controllers\PostController;
use coursely\App\Controllers\ServiceController;
use coursely\App\Controllers\TagController;
use coursely\App\Models\AuthorModel;
use coursely\App\Models\BlogModel;
use coursely\App\Models\CategoryModel;
use coursely\App\Models\ContactModel;
use coursely\App\Models\CoursesPageModel;
use coursely\App\Models\HomeModel;
use coursely\App\Models\PostModel;
use coursely\App\Models\ServiceModel;
use coursely\App\Models\TagModel;
use coursely\App\Controllers\PricingPageController;
use coursely\App\Models\PricingPageModel;


class ControllerFactory
{
    public static function make($current_obj): ControllerInterface
    {

        if (is_front_page()) {
            $homeModel = new HomeModel($current_obj);
            return new HomeController($homeModel);
        }

        if(is_author()){
            $authorModel = new AuthorModel($current_obj);
            return new AuthorController($authorModel);
        }

        if (is_singular('post')) {
            $postModel = new PostModel($current_obj);
            return new PostController($postModel);
        }
        if (is_singular('service')) {
            $serviceModel = new ServiceModel($current_obj);
            return new ServiceController($serviceModel);
        }



        if (is_page()) {
            $template = get_post_meta(get_queried_object_id(), '_wp_page_template', true);
            return match ($template) {
                'page-blog.php' => new BlogController(new BlogModel($current_obj)),
                'page-courses.php' => new CoursesPageController(new CoursesPageModel($current_obj)),
                'page-pricing.php' => new PricingPageController(new PricingPageModel($current_obj)),
                'page-contact-us.php' => new ContactPageController(new ContactModel($current_obj)),
                default => new PageController(),
            };
        }

        if (is_category()) {
            $categoryModel = new CategoryModel($current_obj);
            return new CategoryController($categoryModel);
        }

        if (is_tag()) {
            $tagModel = new TagModel($current_obj);
            return new TagController($tagModel);
        }

        return new Error404Controller();
    }
}