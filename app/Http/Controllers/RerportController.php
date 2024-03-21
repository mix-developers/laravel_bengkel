<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Part;
use App\Models\PartStok;
use App\Models\Service;
use App\Models\ServicePart;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade as PDF;

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
    public function cetak_part()
    {
        $part = Part::all();
        $pdf = \PDF::loadview('pages/report/pdf/pdf_stok', [
            'data' => $part,
            'title' => 'Laporan Stok Spare Part Bengkel Intan Jaya',
        ])
            ->setPaper('a4', 'landscape');
        return $pdf->stream('Laporan_stok_' . date('d/m/Y') . '.pdf');
    }
    public function services()
    {
        $data = [
            'title' => 'Laporan Service',
            'service' => Service::where('accepted', 1)->get(),
        ];
        return view('pages.report.service', $data);
    }
    public function cetak_services(Request $request)
    {

        $service = Service::where('accepted', 1)
            ->where('created_at', '>=', $request->from_date)
            ->where('created_at', '<=', $request->to_date)
            ->get();

        if ($service->isEmpty()) {
            return redirect()->back()->with('danger', 'Data tidak tersedia');
        }
        $pdf = \PDF::loadview('pages/report/pdf/pdf_service', [
            'data' => $service,
            'title' => 'Laporan Service Bengkel Intan Jaya',
            'from_date' => $request->from_date,
            'to_date' => $request->to_date,
        ])
            ->setPaper('a4', 'landscape');
        return $pdf->stream('Laporan_service_' . $request->from_date . '-' . $request->to_date . '.pdf');
    }
    public function pengeluaran()
    {
        $data = [
            'title' => 'Laporan Pengeluaran',
            'stok' => ServicePart::latest()->get(),
        ];
        return view('pages.report.pengeluaran', $data);
    }
    public function cetak_pengeluaran(Request $request)
    {

        $stok = ServicePart::where('created_at', '>=', $request->from_date)
            ->where('created_at', '<=', $request->to_date)
            ->with('part')
            ->latest()
            ->get();

        $order = Order::where('created_at', '>=', $request->from_date)
            ->where('created_at', '<=', $request->to_date)->where('id_service', null)->with(['part', 'user'])->get();

        if ($stok->isEmpty()) {
            return redirect()->back()->with('danger', 'Data tidak tersedia');
        }
        $pdf = \PDF::loadview('pages/report/pdf/pdf_pengeluaran', [
            'data' => $stok,
            'dataNoService' => $order,
            'title' => 'Laporan Pengeluaran Bengkel Intan Jaya',
            'from_date' => $request->from_date,
            'to_date' => $request->to_date,
        ])
            ->setPaper('a4', 'landscape');
        return $pdf->stream('Laporan_pengeluaran_' . $request->from_date . '-' . $request->to_date . '.pdf');
    }
}
