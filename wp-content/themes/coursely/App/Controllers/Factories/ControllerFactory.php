<?php

namespace coursely\App\Controllers\Factories;

use coursely\App\Controllers\AboutPageController;
use coursely\App\Controllers\AccountPageController;
use coursely\App\Controllers\BlogController;
use coursely\App\Controllers\CategoryController;
use coursely\App\Controllers\CheckoutController;
use coursely\App\Controllers\ContactPageController;
use coursely\App\Controllers\ControllerInterface;
use coursely\App\Controllers\CoursesPageController;
use coursely\App\Controllers\Error404Controller;
use coursely\App\Controllers\HomeController;
use coursely\App\Controllers\PageController;
use coursely\App\Controllers\PostController;
use coursely\App\Controllers\CourseController;
use coursely\App\Controllers\LessonController;
use coursely\App\Controllers\TagController;
use coursely\App\Models\AboutPageModel;
use coursely\App\Models\AccountPageModel;
use coursely\App\Models\BlogModel;
use coursely\App\Models\CategoryModel;
use coursely\App\Models\CheckoutModel;
use coursely\App\Models\ContactModel;
use coursely\App\Models\CourseModel;
use coursely\App\Models\CoursesPageModel;
use coursely\App\Models\HomeModel;
use coursely\App\Models\LessonModel;
use coursely\App\Models\PostModel;
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

        if (is_singular('post')) {
            $postModel = new PostModel($current_obj);
            return new PostController($postModel);
        }

        if (is_singular('course')) {
            $courseModel = new CourseModel($current_obj);
            return new CourseController($courseModel);
        }
        if (is_singular('lesson')) {
            $lessonModel = new LessonModel($current_obj);
            return new LessonController($lessonModel);
        }

        if (is_page()) {
            $template = get_post_meta(get_queried_object_id(), '_wp_page_template', true);
            return match ($template) {
                'page-blog.php' => new BlogController(new BlogModel($current_obj)),
                'page-account.php' => new AccountPageController(new AccountPageModel($current_obj)),
                'page-courses.php' => new CoursesPageController(new CoursesPageModel($current_obj)),
                'page-about.php' => new AboutPageController(new AboutPageModel($current_obj)),
                'page-pricing.php' => new PricingPageController(new PricingPageModel($current_obj)),
                'page-contact-us.php' => new ContactPageController(new ContactModel($current_obj)),
                'page-checkout.php' => new CheckoutController(new CheckoutModel($current_obj)),
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