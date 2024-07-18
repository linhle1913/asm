<?php

namespace App\Http\Controllers\FrontController;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class FrontController extends Controller
{
    public function login(){
        return view('client.login');
    }

    public function register(){
        return view('client.register');
    }

    public function index(){
        return view('client.home');
    }

    public function detail(){
        return view('client.post-detail');
    }

    public function list(){
        return view('client.list');
    }

    public function about(){
        return view('client.about');
    }

    public function profile(){
        return view('client.profile');
    }
}
