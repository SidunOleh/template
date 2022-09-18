<?php

namespace App\Controllers;

use App\Components\Response;

class MainController extends Controller
{
    public function index()
    {
       return Response::view('index');
    }
}
