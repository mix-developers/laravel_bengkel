<?php

namespace App\Http\Controllers;

use App\Models\Part;
use App\Models\PartStok;
use Illuminate\Http\Request;

class PartStokController extends Controller
{
    public function index()
    {
        $data = [
            'title' => 'Data Stok Spare Part',
            'PartStok' => PartStok::all(),
            'Part' => Part::all(),
        ];
        return view('pages.part_stok.index', $data);
    }
    public function store(Request $request)
    {
        $request->validate([
            'id_part' => ['required', 'string', 'max:255'],
            'stok' => ['required', 'string', 'max:255'],
            'type' => ['required', 'string', 'max:255'],
        ]);

        $PartStok = new PartStok;
        $PartStok->id_part = $request->id_part;
        $PartStok->stok = $request->stok;
        $PartStok->type = $request->type;
        //check stok
        $cekStok = PartStok::getStok($request->id_part);
        // dd($cekStok);
        if ($request->type == 0 && $request->stok > $cekStok) {
            return redirect()->back()->with('danger', 'Gagal menambahkan data, pengeluaran lebih besar dari stok yang tersedia');
        } else {
            $PartStok->save();
            return redirect()->back()->with('success', 'Berhasil menambahkan data');
        }
    }
    public function update(Request $request, $id)
    {
        $request->validate([
            'id_part' => ['required', 'string', 'max:255'],
            'stok' => ['required', 'string', 'max:255'],
            'type' => ['required', 'string', 'max:255'],
        ]);

        $PartStok = PartStok::find($id);
        $PartStok->id_part = $request->id_part;
        $PartStok->stok = $request->stok;
        $PartStok->type = $request->type;
        //check stok
        $cekStok = PartStok::getStok($request->id_part);
        // dd($cekStok);
        if ($request->type == 0 && $request->stok > $cekStok) {
            return redirect()->back()->with('danger', 'Gagal mengubah data, pengeluaran lebih besar dari stok yang tersedia');
        } else {
            $PartStok->save();
            return redirect()->back()->with('success', 'Berhasil mengubah data');
        }
    }
    public function destroy($id)
    {
        $PartStok = PartStok::find($id);
        $PartStok->delete();
        return redirect()->back()->with('success', 'Berhasil menghapus data');
    }
}
