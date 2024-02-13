<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ToolController extends Controller
{
    public function __construct()
    {
        $this->middleware('admin');
        $this->middleware('active');
    }

    public function php_info()
    {
        phpinfo();
    }
}
