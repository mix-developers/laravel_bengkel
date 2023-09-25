<?php

namespace App\Http\Controllers;

use App\Models\ServiceOut;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class frontController extends Controller
{
    public function index()
    {
        $data = [
            'title' => 'Home',
        ];
        return view('landing_page.index', $data);
    }
    public function storeServiceOut(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'phone' => ['required', 'string', 'max:255'],
            'address' => ['required', 'string', 'max:255'],
            'description' => ['required', 'string', 'max:255'],
            'latitude' => ['required', 'string', 'max:255'],
            'longitude' => ['required', 'string', 'max:255'],
        ]);
        $milliseconds = round(microtime(true) * 1000);

        $service = new ServiceOut();
        $service->name = $request->name;
        $service->phone = $request->phone;
        $service->address = $request->address;
        $service->description = $request->description;
        $service->latitude = $request->latitude;
        $service->longitude = $request->longitude;
        $service->code = 'BIJ' . $milliseconds;
        if ($service->save()) {

            return redirect()->back()->with('success', 'Berhasil mengajukan service');
        } else {
            return redirect()->back()->with('danger', 'Gagal mengajukan service');
        }
    }
    public function storeServiceIn(Request $request)
    {
        $request->validate([
            'brand' => ['required', 'string', 'max:255'],
            'description' => ['required', 'string', 'max:255'],
        ]);

        $milliseconds = round(microtime(true) * 1000);

        $service = new ServiceOut();
        $service->id_user = Auth::user()->id;
        $service->description = $request->description;
        $service->code = 'BIJ' . $milliseconds;
        if ($service->save()) {

            return redirect()->back()->with('success', 'Berhasil mengajukan service');
        } else {
            return redirect()->back()->with('danger', 'Gagal mengajukan service');
        }
    }
}
