<?php

namespace App\Controllers;

class Home extends BaseController
{
    public function index()
    {
        // Gabungkan view header, konten, dan footer
        return
            view('landing_page');
    }
}
