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
                    <form action="{{ route('report.cetak_services') }}" method="GET">
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
                                            <th>Nama</th>
                                            <th>Keterangan</th>
                                            <th>Alamat</th>
                                            <th>Nomor Hp</th>
                                            <th>Status Service</th>
                                            <th>Pembayaran</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($service as $item)
                                            <tr>
                                                <td width="10">{{ $loop->iteration }}</td>
                                                <td> {{ $item->created_at->format('d/m/Y') }}</td>
                                                <td>
                                                    @if ($item->user->role != 'customer')
                                                        {{ App\Models\ServiceOut::getIdentity($item->code)->name ?? 'Tanpa Nama' }}
                                                        <br>
                                                        <span class="badge badge-light-danger">(Non Member)</span>
                                                    @else
                                                        {{ $item->user->name }}<br>
                                                        <span class="badge badge-light-primary">(Member)</span>
                                                    @endif
                                                </td>
                                                <td>
                                                    {!! $item->description !!}
                                                </td>
                                                <td>
                                                    {{ $item->user->address }}
                                                </td>
                                                <td>
                                                    {{ $item->user->phone }}
                                                </td>
                                                <td>
                                                    <span class="badge badge-light-primary">
                                                        {{ App\Models\ServiceStatus::getLastStatus($item->id)->status->status ?? '-' }}
                                                    </span>
                                                </td>
                                                <td>
                                                    @if (App\Models\ServicePayment::where('id_service', $item->id)->first() == null)
                                                        <span class="badge badge-light-danger">Belum membayar
                                                        </span>
                                                    @else
                                                        @php
                                                            $bayar = App\Models\ServicePayment::where('id_service', $item->id)->first();
                                                        @endphp
                                                        @if ($bayar->is_verified == 0)
                                                            <span class="badge badge-light-warning">Menunggu
                                                                Konfirmasi</span>
                                                        @elseif($bayar->is_verified == 1)
                                                            <span class="badge badge-light-success">Berhasil
                                                                dikonfirmasi</span>
                                                        @elseif($bayar->is_verified == 2)
                                                            <span class="badge badge-light-danger">Pembayaran
                                                                Ditolak</span>
                                                        @else
                                                            -
                                                        @endif
                                                    @endif
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
