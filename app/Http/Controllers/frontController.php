<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderCart;
use App\Models\Part;
use App\Models\PartStok;
use App\Models\Service;
use App\Models\ServiceOut;
use App\Models\ServicePart;
use App\Models\ServicePrice;
use App\Models\ServiceStatus;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class frontController extends Controller
{
    public function index()
    {
        $data = [
            'title' => 'Home',
            'part' => Part::paginate(10),
        ];
        return view('landing_page.index', $data);
    }
    public function search(Request $request)
    {
        $data = [
            'title' => 'Home',
            'part' => Part::where('name', 'like', '%' . $request->keywords . '%')->paginate(10),
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

        $service = new Service();
        $service->id_user = Auth::user()->id;
        $service->description = $request->description;
        $service->brand = $request->brand;
        $service->code = 'BIJ' . $milliseconds;
        if ($service->save()) {

            return redirect()->back()->with('success', 'Berhasil mengajukan service');
        } else {
            return redirect()->back()->with('danger', 'Gagal mengajukan service');
        }
    }
    public function status(Request $request)
    {
        $code = $request->code;
        $service = Service::where('code', $code)->first();

        if ($service == null) {
            return redirect()->back()->with('danger', 'Kode service tidak dikenali..');
        }
        $price = ServicePrice::where('id_service', $service->id)->get();
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
            'title' => 'Status : ' . $service->code,
            'service' => $service,
            'total_biaya' => $biaya_total
        ];
        return view('landing_page.status', $data);
    }
    public function add_cart(Request $request)
    {
        if ($request->count < 1) {
            return redirect()->back()->with('danger', 'Maaf, permintaan anda tidak dapat di proses karena jumlah kurang dari 1');
        } else {
            $part = Part::find($request->id_part);
            $stok = PartStok::getStok($part->id);
            if ($request->count > $stok) {
                return redirect()->back()->with('danger', 'Maaf, stok tidak mencukupi');
            } else {
                $cek_cart = OrderCart::where('id_user', Auth::user()->id)->where('id_part', $request->id_part)->count();
                if ($cek_cart == 0) {
                    $cart = new OrderCart();
                    $cart->count = $request->count;
                    $cart->id_part = $request->id_part;
                    $cart->id_user = Auth::user()->id;
                    $cart->total_price = $part->price * $request->count;
                    $cart->save();
                    return redirect()->back()->with('success', 'Berhasil menambahkan ke keranjang anda');
                } else {
                    return redirect()->back()->with('danger', 'Sparepart ini sudah ada dalam keranjang anda');
                }
            }
        }
    }
    public function destroyCart($id)
    {
        $cart = OrderCart::find($id);
        $cart->delete();
        return redirect()->back()->with('success', 'Berhasil menghapus pada keranjang');
    }
    public function add_order(Request $request)
    {
        try {
            $order = new Order();
            $order->is_service = $request->is_service;
            $order->id_service = $request->id_service;
            $order->id_part = $request->id_part;
            $order->count = $request->count;
            $order->total_price = $request->total_price;
            $order->id_user = Auth::user()->id;
            $order->save();
            if ($request->is_service == 1) {
                $ServiceStatus = new ServiceStatus();
                $ServiceStatus->id_user = Auth::user()->id;
                $ServiceStatus->id_service = $request->id_service;
                $ServiceStatus->id_status = 4;
                $ServiceStatus->foto = '';
                $ServiceStatus->description = 'Penambahan sparepart oleh customer';
                $ServiceStatus->save();

                $ServicePart = new ServicePart();
                $ServicePart->id_service = $request->id_service;
                $ServicePart->id_part = $request->id_part;
                $ServicePart->save();
                return redirect()->back()->with('success', 'Berhasil menambahkan sparepart');
            } else {
                return redirect()->back()->with('success', 'Berhasil Membuat order');
            }

            $PartStok = new PartStok();
            $PartStok->id_part = $request->id_part;
            $PartStok->stok = $request->count;
            $PartStok->type = 0;
            $cekStok = PartStok::getStok($request->id_part);
            if ($request->count > $cekStok) {
                return redirect()->back()->with('danger', 'Stok tidak mencukupi');
            } else {
                $PartStok->save();
            }

            $cart = OrderCart::where('id', $request->id_cart)->first();
            $cart->delete();
        } catch (\Exception $e) {
            return redirect()->back()->with('danger', 'Terjadi kesalahan : ' . $e->getMessage());
        }
    }
}
