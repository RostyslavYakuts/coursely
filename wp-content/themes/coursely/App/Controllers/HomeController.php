<?php

namespace coursely\App\Controllers;

use duncan3dc\Laravel\BladeInstance;
use coursely\App\Models\ModelInterface;

class HomeController implements ControllerInterface
{
    protected BladeInstance $blade;
    protected ModelInterface $model;

    public function __construct($model)
    {
        $this->model = $model;
        $views = get_template_directory().('/App/Views');
        $cache = get_template_directory().('/storage/cache');
        $this->blade = new BladeInstance($views, $cache);
    }

    public function render(): void
    {
        $view = "page.home.front-page";
        $data = $this->model->get_post_data();
        echo $this->blade->make($view, [
            'data' => $data
        ])->render();
    }
}