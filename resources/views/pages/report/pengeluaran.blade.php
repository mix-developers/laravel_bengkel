@extends('layouts.backend.admin')

@section('content')
    <section class="pc-container">

        <div class="pcoded-content">
            <!-- [ breadcrumb ] start -->
            @include('layouts.backend.title')
            <!-- [ breadcrumb ] end -->
            <!-- [ Main Content ] start -->
            <div class="row">
                <!-- subscribe start -->
                <div class="col-12 mb-4">
                    <form action="{{ route('report.cetak_pengeluaran') }}" method="GET">
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text">Dari tanggal</span>
                            </div>
                            <input type="date" class="form-control" name="from_date"
                                value="{{ date('Y-m-d', strtotime('-1 month')) }}">
                            <div class="input-group-prepend">
                                <span class="input-group-text">Sampai</span>
                            </div>
                            <input type="date" class="form-control" name="to_date" value="{{ date('Y-m-d') }}">
                            <div class="input-group-append">
                                <button type="submit" class="btn btn-primary">
                                    <i class="fa fa-print"></i> Cetak Laporan
                                </button>

                            </div>
                        </div>
                    </form>
                </div>
                <div class="col-12">

                    <div class="card">
                        <div class="card-header">
                            <h5>{{ $title }} </h5>
                        </div>
                        <div class="card-body">

                            <div class="table-responsive">
                                <table class="table table-bordered table-striped mb-0 lara-dataTable">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Tanggal</th>
                                            <th>Spare Part</th>
                                            <th>Kode Service</th>
                                            <th>Harga</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($stok as $item)
                                            <tr>
                                                <td width="10">{{ $loop->iteration }}</td>
                                                <td>
                                                    {{ $item->created_at->format('d/m/Y') }}
                                                </td>
                                                <td>
                                                    {{ $item->part->name }}
                                                </td>
                                                <td>
                                                    {{ $item->service->code }}
                                                </td>
                                                <td>
                                                    Rp {{ number_format($item->part->price) }}
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- subscribe end -->
            </div>
            <!-- [ Main Content ] end -->
        </div>
    </section>
@endsection
