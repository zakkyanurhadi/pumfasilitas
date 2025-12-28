<?php

namespace App\Controllers;

use App\Models\LaporanModel;

class Home extends BaseController
{
    public function index()
    {
        $laporanModel = new LaporanModel();
        $stats = $laporanModel->getStatistik();

        // Gabungkan view header, konten, dan footer
        return view('landing_page', ['stats' => $stats]);
    }
}
