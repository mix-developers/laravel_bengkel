<?php

namespace App\Http\Controllers;

use App\Models\Bank;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class BankController extends Controller
{
    public function index()
    {
        $data = [
            'title' => 'Data Bank',
            'bank' => Bank::all()
        ];
        return view('pages.bank.index', $data);
    }
    public function store(Request $request)
    {
        $request->validate([
            'nama_pemilik' => ['required', 'string', 'max:255'],
            'bank' => ['required', 'string', 'max:255'],
            'no_rekening' => ['required', 'string', 'max:255'],
            'color' => ['required', 'string', 'max:255'],
            'thumbnail' => ['nullable'],
        ]);

        $Bank = new Bank;
        $Bank->nama_pemilik = $request->nama_pemilik;
        $Bank->bank = $request->bank;
        $Bank->no_rekening = $request->no_rekening;
        $Bank->color = $request->color;
        if ($request->hasFile('thumbnail')) {
            $filename = Str::random(32) . '.' . $request->file('thumbnail')->getClientOriginalExtension();
            $file_path = $request->file('thumbnail')->storeAs('public/fotos', $filename);
        }
        $Bank->thumbnail = isset($file_path) ? $file_path : null;
        if ($Bank->save()) {

            return redirect()->back()->with('success', 'Berhasil menambahkan data');
        } else {
            return redirect()->back()->with('danger', 'Gagal menambahkan data');
        }
    }
    public function update(Request $request, $id)
    {
        $request->validate([
            'nama_pemilik' => ['required', 'string', 'max:255'],
            'bank' => ['required', 'string', 'max:255'],
            'no_rekening' => ['required', 'string', 'max:255'],
            'color' => ['required', 'string', 'max:255'],
            'thumbnail' => ['nullable'],
        ]);
        $Bank = Bank::find($id);
        $Bank->nama_pemilik = $request->nama_pemilik;
        $Bank->bank = $request->bank;
        $Bank->no_rekening = $request->no_rekening;
        $Bank->color = $request->color;
        if ($request->hasFile('thumbnail')) {
            $filename = Str::random(32) . '.' . $request->file('thumbnail')->getClientOriginalExtension();
            $file_path = $request->file('thumbnail')->storeAs('public/fotos', $filename);
        }
        $Bank->thumbnail = isset($file_path) ? $file_path : $Bank->thumbnail;
        if ($Bank->save()) {

            return redirect()->back()->with('success', 'Berhasil mengubah data');
        } else {
            return redirect()->back()->with('danger', 'Gagal mengubah data');
        }
    }
    public function destroy($id)
    {
        $Bank = Bank::find($id);
        if ($Bank->thumbnail != '' ||   $Bank->thumbnail != null) {
            Storage::delete($Bank->thumbnail);
        }
        $Bank->delete();
        return redirect()->back()->with('success', 'Berhasil menghapus data');
    }
}
