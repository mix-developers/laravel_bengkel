<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class frontController extends Controller
{
    public function index()
    {
        $data = [
            'title' => 'Home',
        ];
        return view('landing_page.index', $data);
    }
}
