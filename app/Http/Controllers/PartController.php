<?php

namespace App\Http\Controllers;

use App\Models\Part;
use Illuminate\Http\Request;

class PartController extends Controller
{
    public function index()
    {
        $data = [
            'title' => 'Data Spare Parts',
            'Part' => Part::all(),
        ];
        return view('pages.part.index', $data);
    }
    public function store(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'price' => ['required', 'string', 'max:255'],
        ]);

        $Part = new Part;
        $Part->name = $request->name;
        $Part->price = $request->price;
        if ($Part->save()) {

            return redirect()->back()->with('success', 'Berhasil menambahkan data');
        } else {
            return redirect()->back()->with('danger', 'Gagal menambahkan data');
        }
    }
    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'price' => ['required', 'string', 'max:255'],
        ]);

        $Part = Part::find($id);
        $Part->name = $request->name;
        $Part->price = $request->price;
        if ($Part->save()) {

            return redirect()->back()->with('success', 'Berhasil menambahkan data');
        } else {
            return redirect()->back()->with('danger', 'Gagal menambahkan data');
        }
    }
    public function destroy($id)
    {
        $Part = Part::find($id);
        $Part->delete();
        return redirect()->back()->with('success', 'Berhasil menghapus data');
    }
}
