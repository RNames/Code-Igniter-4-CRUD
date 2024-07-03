<?php

namespace App\Controllers;

class Home extends BaseController
{
    public function index()
    {
        return view('welcome_message');
    }

    public function coba()
    {
        $data['title']  = 'Hallo Dunia !';
        $data['msg']    = 'Selamat datang di CodeIgniter 4';
		return view('halo_view',$data);
    }
}
