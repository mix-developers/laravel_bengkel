<?php

namespace App\Http\Controllers;

use App\Models\Mechanical;
use App\Models\Part;
use App\Models\Service;
use App\Models\ServiceMechanic;
use App\Models\ServiceOut;
use App\Models\ServicePart;
use App\Models\ServicePayment;
use App\Models\ServicePrice;
use App\Models\ServiceStatus;
use App\Models\Status;
use Faker\Provider\ar_SA\Payment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Barryvdh\DomPDF\Facade as PDF;

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
        $customer =  Service::where('id_user', Auth::user()->id)->get();
        $admin =  Service::where('accepted', 0)->get();
        $data = [
            'title' => 'data service member',
            'service' => Auth::user()->role == 'customer' ? $customer : $admin,
        ];
        return view('pages.service.member', $data);
    }
    public function payment()
    {
        $data = [
            'title' => 'data Pembayaran',
            // 'payment' => ServicePayment::where('is_verified', 0)->get(),
            'payment' => ServicePayment::latest()->get(),
        ];
        return view('pages.service.payment', $data);
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
            'statuses' => Status::all(),
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
    public function verified_complite($id)
    {
        $payment = ServicePayment::find($id);
        $payment->is_verified = 1;
        $payment->save();
        return redirect()->back()->with('success', 'Pembayaran berhasil di konfirmasi');
    }
    public function verified_reject($id)
    {
        $payment = ServicePayment::find($id);
        $payment->is_verified = 2;
        $payment->save();
        return redirect()->back()->with('success', 'Pembayaran berhasil di ditolak');
    }
    public function accept(Request $request, $id)
    {
        $ServiceStatus = new ServiceStatus();
        if ($request->jenis == 'non-member') {

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
            $ServiceStatus->service()->associate($Service);
            $ServiceOut->save();
            // dd('berhasil');
        } else {
            $service = Service::find($id);
            $service->accepted = 1;
            $service->save();
            $ServiceStatus->id_service = $service->id;
            // dd('gagal');
        }

        $ServiceStatus->id_user = Auth::user()->id;
        $ServiceStatus->id_status = 1;
        $ServiceStatus->description = 'Service oleh non member dan diterima oleh : ' . Auth::user()->name;


        if ($ServiceStatus->save()) {
            return redirect()->back()->with('success', 'Berhasil menerima service');
        } else {
            return redirect()->back()->with('danger', 'Gagal menambahkan data');
        }
    }
    public function storeStatus(Request $request)
    {
        $request->validate([
            'id_service' => ['required'],
            'id_status' => ['required'],
        ]);
        $ServiceStatus = new ServiceStatus();
        $ServiceStatus->id_user = Auth::user()->id;
        $ServiceStatus->id_service = $request->id_service;
        $ServiceStatus->id_status = $request->id_status;
        if ($request->hasFile('foto')) {
            $filename = Str::random(32) . '.' . $request->file('foto')->getClientOriginalExtension();
            $file_path = $request->file('foto')->storeAs('public/fotos', $filename);
        }
        $ServiceStatus->foto =  isset($file_path) ? $file_path : null;
        $ServiceStatus->description = 'keterangan : ' . $request->description;

        if ($request->input('id_status') == 5) {
            $payment = new ServicePayment();
            $payment->id_service = $request->id_service;
            $payment->total_fee = $request->total_fee;
            $payment->method = $request->method;
            $payment->id_bank = $request->id_bank;
            if (Auth::user()->role != 'customer') {
                $payment->is_verified = 1;
            } else {
                $payment->is_verified = 0;
            }
            $payment->thumbnail = isset($file_path) ? $file_path : null;
            $payment->save();
        }
        if ($ServiceStatus->save()) {
            return redirect()->back()->with('success', 'Berhasil menerima status');
        } else {
            return redirect()->back()->with('danger', 'Gagal menambahkan status');
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
    public function destroyStatus($id)
    {
        $serviceStatus = ServiceStatus::find($id);
        if ($serviceStatus->foto != '') {
            Storage::delete($serviceStatus->foto);
        }
        if ($serviceStatus->id_status == 5) {
            $payment = ServicePayment::where('id_service', $serviceStatus->id_service)->first();
            if ($payment->thumbnail != '') {
                Storage::delete($payment->thumbnail);
            }
            $payment->delete();
        }
        $serviceStatus->delete();
        return redirect()->back()->with('success', 'Berhasil Menghapus part');
    }
    public function invoice($id)
    {
        $data = Service::find($id);

        $price = ServicePrice::where('id_service', $id)->get();
        $biaya_jasa = $price->sum('price');

        $total_part = ServicePart::select('id')
            ->where('id_service', $data->id)
            ->groupBy('id') // Add the GROUP BY clause
            ->withSum('part', 'price')
            ->get()
            ->toArray();
        $biaya_part = array_sum(array_column($total_part, 'part_sum_price'));
        $biaya_total = $biaya_jasa + $biaya_part;

        $pdf = \PDF::loadview('pages/service/pdf/invoice', [
            'data' => $data,
            'total_biaya' => $biaya_total,
        ])
            ->setPaper(array(0, 0, 160, 330));
        return $pdf->stream('INVOICE_' . $data->code . '.pdf');
    }
}
