<?php

namespace coursely\App\Controllers;

use coursely\App\Models\ModelInterface;
use duncan3dc\Laravel\BladeInstance;

class CategoryController implements ControllerInterface
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

        $view = 'taxonomy.category.category';

        echo $this->blade->make($view, [
          'data'=>$this->model->get_post_data()
        ])->render();
    }
}