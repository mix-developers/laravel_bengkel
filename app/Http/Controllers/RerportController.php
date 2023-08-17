<?php

namespace App\Http\Controllers;

use App\Models\Part;
use Illuminate\Http\Request;

class RerportController extends Controller
{
    public function part()
    {
        $data = [
            'title' => 'Laporan Stok Spare Parts',
            'part' => Part::all(),
        ];
        return view('pages.report.part', $data);
    }
    public function services()
    {
        $data = [
            'title' => 'Laporan Service',
            // 'part' => Part::all(),
        ];
        return view('pages.report.service', $data);
    }
}
