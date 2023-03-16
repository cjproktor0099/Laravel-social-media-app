<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ExampleController extends Controller
{
public function HomePage(){
        $residence = ['Chrisjelo B. Vega', 'Jocely D. Butande', 'Leonilo N. Vega',
        'Jocenil B. Vega','Jonilo B. Vega'];
        $startNum = 10;
        $num = 1;
        return view('homepage',['residences'=>$residence, 'start'=>$startNum, 'num'=>$num]);
}

public function SinglePost(){
    return view('single-post');
}
public function AboutPage(){
    return view('about');
}
public function Contact(){
    return view('contact');
}
}
