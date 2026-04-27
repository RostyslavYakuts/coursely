<?php

namespace coursely\App\Controllers;

use duncan3dc\Laravel\BladeInstance;

class Error404Controller implements ControllerInterface
{
    protected BladeInstance $blade;

    public function __construct()
    {
        $views = get_template_directory().('/App/Views');
        $cache = get_template_directory().('/storage/cache');
        $this->blade = new BladeInstance($views, $cache);
    }

    public function render(): void
    {
        $view = "global.404";
        echo $this->blade->make($view, [
            'data' => [
                '404_image' => get_field('404_image', 'options') ?? '',
                '404_text' => get_field('404_text', 'options') ?? '',
            ],
        ])->render();
    }

}