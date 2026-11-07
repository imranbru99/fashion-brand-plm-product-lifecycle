<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Http\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as LaravelController;
use Illuminate\Support\Facades\Auth;

class Controller extends LaravelController
{
    use ValidatesRequests;

    protected function authenticated()
    {
        return Auth::check();
    }
}
