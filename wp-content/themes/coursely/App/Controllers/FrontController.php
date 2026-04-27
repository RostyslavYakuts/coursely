<?php
namespace coursely\App\Controllers;
use coursely\App\Controllers\Factories\ControllerFactory;

class FrontController
{
    public function handle($current_obj): void
    {
        if (!$current_obj) {
            wp_die('Set your homepage as static page in admin first');
        }
        $controller = ControllerFactory::make($current_obj);
        $controller->render();
    }
}