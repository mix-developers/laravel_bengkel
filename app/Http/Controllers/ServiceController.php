<?php

namespace App\Http\Controllers;

use App\Models\Mechanical;
use App\Models\Part;
use App\Models\Service;
use App\Models\ServiceMechanic;
use App\Models\ServiceOut;
use App\Models\ServicePart;
use App\Models\ServicePrice;
use App\Models\ServiceStatus;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ServiceController extends Controller
{
    public function non_member()
    {
        $data = [
            'title' => 'data service non member',
            'service' => ServiceOut::where('accepted', 0)->get(),
        ];
        return view('pages.service.non_member', $data);
    }
    public function member()
    {
        $data = [
            'title' => 'data service member',
            'service' => Service::where('accepted', 0)->get(),
        ];
        return view('pages.service.member', $data);
    }
    public function show($id)
    {
        $service = Service::find($id);
        $price = ServicePrice::where('id_service', $id)->get();
        $biaya_jasa = $price->sum('price');

        $total_part = ServicePart::select('id')
            ->where('id_service', $service->id)
            ->groupBy('id') // Add the GROUP BY clause
            ->withSum('part', 'price')
            ->get()
            ->toArray();
        $biaya_part = array_sum(array_column($total_part, 'part_sum_price'));
        $biaya_total = $biaya_jasa + $biaya_part;
        $data = [
            'title' => 'Status Service',
            'service' => $service,
            'service_status' => ServiceStatus::where('id_service', $id)->get(),
            'mechanical' => Mechanical::all(),
            'part' => Part::all(),
            'mechanical_service' => ServiceMechanic::where('id_service', $id)->get(),
            'part_service' => ServicePart::where('id_service', $id)->get(),
            'price' => $price,
            'biaya_jasa' => $biaya_jasa,
            'biaya_part' => $biaya_part,
            'biaya_total' => $biaya_total,
        ];
        return view('pages.service.show', $data);
    }
    public function process()
    {
        $data = [
            'title' => 'data Proses service',
            'service' => Service::where('accepted', 1)->get(),
        ];
        return view('pages.service.process', $data);
    }
    public function accept($id)
    {
        $Service = new Service();
        $ServiceOut = ServiceOut::find($id);
        $ServiceOut->accepted = 1;

        $Service->id_user = Auth::user()->id;
        $Service->code = $ServiceOut->code;
        $Service->description = $ServiceOut->description;
        $Service->brand = '-';
        $Service->thumbnail = '';
        $Service->accepted = 1;
        $Service->save();

        $ServiceStatus = new ServiceStatus();
        $ServiceStatus->service()->associate($Service);
        $ServiceStatus->id_user = Auth::user()->id;
        $ServiceStatus->status = 'Service telah diterima';
        $ServiceStatus->description = 'Service oleh non member dan diterima oleh : ' . Auth::user()->name;


        if ($ServiceOut->save() && $ServiceStatus->save()) {
            return redirect()->back()->with('success', 'Berhasil menerima service');
        } else {
            return redirect()->back()->with('danger', 'Gagal menambahkan data');
        }
    }
    public function storeMechanical(Request $request)
    {
        $request->validate([
            'id_service' => ['required'],
            'id_mechanic' => ['required'],
        ]);
        $ServiceMechanic = new ServiceMechanic();
        $ServiceMechanic->id_service = $request->id_service;
        $ServiceMechanic->id_mechanic = $request->id_mechanic;
        $ServiceMechanic->save();
        return redirect()->back()->with('success', 'Berhasil menambah mekanik');
    }
    public function storePart(Request $request)
    {
        $request->validate([
            'id_service' => ['required'],
            'id_part' => ['required'],
        ]);
        $ServicePart = new ServicePart();
        $ServicePart->id_service = $request->id_service;
        $ServicePart->id_part = $request->id_part;
        $ServicePart->save();
        return redirect()->back()->with('success', 'Berhasil menambah part');
    }
    public function storePrice(Request $request)
    {
        $request->validate([
            'id_service' => ['required'],
            'price' => ['required'],
        ]);
        $ServicePrice = new ServicePrice();
        $ServicePrice->id_service = $request->id_service;
        $ServicePrice->price = $request->price;
        $ServicePrice->save();
        return redirect()->back()->with('success', 'Berhasil menambah harga');
    }
    public function destroyMechanic($id)
    {
        $ServiceMechanic = ServiceMechanic::find($id);
        $ServiceMechanic->delete();
        return redirect()->back()->with('success', 'Berhasil Menghapus mekanik');
    }
    public function destroyPrice($id)
    {
        $ServicePrice = ServicePrice::find($id);
        $ServicePrice->delete();
        return redirect()->back()->with('success', 'Berhasil Menghapus harga');
    }
    public function destroyPart($id)
    {
        $ServicePart = ServicePart::find($id);
        $ServicePart->delete();
        return redirect()->back()->with('success', 'Berhasil Menghapus part');
    }
}
