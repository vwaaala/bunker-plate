<?php

namespace App\Helpers;

use Illuminate\Support\Facades\Route;

class PanelHelper
{
    public static function controller()
    {
        $chunks = explode("\\", Route::currentRouteAction());
        return explode("@", end($chunks))[0];
    }

    public static function action()
    {
        $actionArray = explode("@", Route::currentRouteAction());
        return end($actionArray);
    }
}
