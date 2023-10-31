@extends('layouts.app')
@section('content')
    @include('landing_page.component.modals')

    <section class="banner bg-tertiary position-relative overflow-hidden">
        <div class="container">
            <div class="row align-items-center justify-content-center">
                <div class="col-8 text-center">
                    <form action="{{ route('status') }}" method="GET" enctype="multipart/form-service">
                        <div class="input-group mb-3">
                            <input type="search" class="form-control" placeholder="Kode service" aria-label="Kode service"
                                aria-describedby="button-addon2" name="code" required value="{{ old('code') }}">
                            <div class="input-group-append">
                                <button class="btn btn-primary" type="submit" id="button-addon2"
                                    style="border-top-right-radius: 5px; border-bottom-right-radius: 5px; border-bottom-left-radius: 0px; border-top-left-radius: 0px; height:100%;">Cek</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <div class="container" style="width: 500px;">
                @php
                    $status = App\Models\ServiceStatus::getLastStatus($service->id);
                @endphp
                <div class="table-responsive">
                    <table class="table table-bordered  text-black " style="font-size:14px;">
                        <thead>
                            <tr>
                                <th colspan='2' style="text-align:center;"><strong>Invoice</strong></th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>Kode Service</td>
                                <td>
                                    <strong>{{ $service->code }}</strong>
                                </td>
                            </tr>
                            <tr>
                                <td>Nama</td>
                                <td>
                                    @if ($service->user->role != 'customer')
                                        <strong>{{ App\Models\ServiceOut::getIdentity($service->code)->name }}</strong><br>
                                        <small>Non-member</small>
                                    @else
                                        <strong>{{ $service->user->name }}</strong><br>
                                        <small>Member</small>
                                    @endif
                                </td>
                            </tr>
                            <tr>
                                <td>Total Bayar</td>
                                <td><strong>Rp {{ number_format($total_biaya) }}</strong></td>
                            </tr>
                            <tr>
                                <td>Tanggal Service</td>
                                <td>{{ $service->created_at->format('d F Y') }}</td>
                            </tr>
                            <tr>
                                <td>Status Service</td>
                                <td>{!! $status != null ? $status->status->status : '<span class="text-danger">Masih dalam antrian</span>' !!}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <hr>
                <center class="text-black">Pembayaran : </center>
                <table class="table text-black">
                    <tr>
                        <td>1</td>
                        <td>Cash</td>
                    </tr>
                    @foreach (App\Models\Bank::all() as $item)
                        <tr>
                            <td>{{ $loop->iteration + 1 }}</td>
                            <td><strong>{{ $item->no_rekening }}</strong><br>{{ $item->bank . ' - ' . $item->nama_pemilik }}
                            </td>
                        </tr>
                    @endforeach
                </table>

                </body>
            </div>
            @include('landing_page.component.shapes')
    </section>
@endsection
@push('js')
    @include('landing_page.component.leaflet')
@endpush
