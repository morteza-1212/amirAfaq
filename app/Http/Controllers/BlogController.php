<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class BlogController extends Controller
{
    public function export()
    {
        return view('blog.export');

    }
    public function import()
    {
        return view('blog.import');
    }
    public function markets()
    {
        return view('blog.market');
    }
}
