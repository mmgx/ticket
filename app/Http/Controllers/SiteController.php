<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Base\BaseController;

class SiteController extends BaseController
{
    public function home()
    {
        return view('pages.home');
    }
}
