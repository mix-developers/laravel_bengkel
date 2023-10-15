<?php

namespace App\Http\Controllers;

use App\Models\Mechanical;
use Illuminate\Http\Request;

class MechanicalControler extends Controller
{
    public function index()
    {
        // $Mechanical = Mechanical::all();
        $data = [
            'title' => 'Data Mekanik',
            'Mechanical' => Mechanical::all(),
        ];
        return view('pages.mechanical.index', $data);
    }
    public function store(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'phone' => ['required', 'string', 'max:255'],
            'address' => ['required', 'string', 'max:255'],
        ]);

        $Mechanical = new Mechanical;
        $Mechanical->name = $request->name;
        $Mechanical->phone = $request->phone;
        $Mechanical->address = $request->address;
        if ($Mechanical->save()) {

            return redirect()->back()->with('success', 'Berhasil menambahkan data');
        } else {
            return redirect()->back()->with('danger', 'Gagal menambahkan data');
        }
    }
    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'phone' => ['required', 'string', 'max:255'],
            'address' => ['required', 'string', 'max:255'],
        ]);

        $Mechanical = Mechanical::find($id);
        $Mechanical->name = $request->name;
        $Mechanical->phone = $request->phone;
        $Mechanical->address = $request->address;
        if ($Mechanical->save()) {

            return redirect()->back()->with('success', 'Berhasil menambahkan data');
        } else {
            return redirect()->back()->with('danger', 'Gagal menambahkan data');
        }
    }
    public function destroy($id)
    {
        $Mechanical = Mechanical::find($id);
        $Mechanical->delete();
        return redirect()->back()->with('success', 'Berhasil menghapus data');
    }
}
