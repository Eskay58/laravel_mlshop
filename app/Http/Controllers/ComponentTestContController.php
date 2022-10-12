<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ComponentTestContController extends Controller
{
    //
    public function showComponentTest1(){
        $message = 'メッセージ';
        return view('tests.component-test1', compact('message'));
    }

    public function showComponentTest2(){
        $message = 'メッセージ';
        return view('tests.component-test2', compact('message'));
    }
}
