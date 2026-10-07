<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        return view('index');

    }
    public function AbouteUs()
    {
        return view('Aboute.index');
    }
    public function export()
    {
        return view('export.index');
    }
    public function import(){
        return view('import.index');
    }
    public function logistics()
    {
        return view('Logistics.index');
    }
    public function markets()
    {
        return view('markets.index');
    }
 public function suppliers()
 {
        return view('suppliers.index');
 }
}
