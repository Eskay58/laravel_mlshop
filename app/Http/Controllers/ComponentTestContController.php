<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ComponentTestContController extends Controller
{
    //
    public function showComponentTest1(){
        return view('tests.component-test1');
    }

    public function showComponentTest2(){
        return view('tests.component-test2');
    }
}
