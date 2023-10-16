<?php

namespace App\Http\Controllers;

use App\Models\Notifikasi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NotifikasiController extends Controller
{
    public function index()
    {
        $data = [
            'title' => 'Semua notifikasi',
            'notifikasi' => Notifikasi::where('id_user', Auth::user()->id)->latest()->get(),
        ];
        return view('pages.notifikasi.index', $data);
    }
    public function read($id)
    {
        $notifikasi = Notifikasi::find($id);
        $notifikasi->is_read = 1;
        $notifikasi->save();

        return redirect()->to($notifikasi->url);
    }
}
