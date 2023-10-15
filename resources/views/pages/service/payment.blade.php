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
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h5>{{ $title }} </h5>
                        </div>
                        <div class="card-body">
                            <div class="my-3">
                                <a type="button" href="#" data-toggle="modal" class="btn btn-primary"
                                    data-target="#create"><i class="fa fa-plus"></i> Tambah Pembayaran
                                </a>
                            </div>
                            <div class="table-responsive">
                                <table class="table table-bordered table-striped mb-0 lara-dataTable">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Nama</th>
                                            <th>Keterangan</th>
                                            <th>Total Bayar</th>
                                            <th>Bukti Pembayaran</th>
                                            <th>Status</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($payment as $item)
                                            <tr>
                                                <td width="10">{{ $loop->iteration }}</td>
                                                <td>
                                                    @if ($item->service->user->role != 'customer')
                                                        {{ App\Models\ServiceOut::getIdentity($item->service->code)->name }}
                                                        <br>
                                                        <span class="badge badge-light-danger">(Non Member)</span>
                                                    @else
                                                        {{ $item->service->user->name }}<br>
                                                        <span class="badge badge-light-primary">(Member)</span>
                                                    @endif
                                                </td>
                                                <td>
                                                    Code : <strong>{{ $item->service->code }}</strong><br>
                                                    Nomor HP : <strong>{{ $item->service->user->phone }}</strong><br>
                                                    Metode Pembayaran : <strong>{{ $item->method }}</strong><br>
                                                    @if ($item->method == 'Transfer')
                                                        Bank : <strong
                                                            style="color: {{ $item->id_bank != null ? $item->bank->color : 'grey' }};">{{ $item->id_bank != null ? $item->bank->bank : '-' }}
                                                            - {{ $item->bank->no_rekening }}</strong><br>
                                                        Atas Nama : <strong
                                                            style="color: {{ $item->id_bank != null ? $item->bank->color : 'grey' }};">{{ $item->bank->nama_pemilik }}</strong>
                                                    @endif
                                                </td>
                                                <td>
                                                    <strong class="text-primary">Rp
                                                        {{ number_format($item->total_fee) }}</strong>
                                                </td>
                                                <td>
                                                    <a type="button" href="#" data-toggle="modal"
                                                        data-target="#thumbnail-{{ $item->id }}">
                                                        <img src="{{ Storage::url($item->thumbnail) }}"
                                                            style="height: 80px;">
                                                    </a>
                                                </td>
                                                <td>
                                                    @if ($item->is_verified == 0)
                                                        <span class="badge badge-light-warning">Menunggu Konfirmasi</span>
                                                    @elseif($item->is_verified == 1)
                                                        <span class="badge badge-light-success">Berhasil dikonfirmasi</span>
                                                    @elseif($item->is_verified == 2)
                                                        <span class="badge badge-light-danger">Pembayaran Ditolak</span>
                                                    @endif
                                                </td>
                                                <td>
                                                    @if ($item->is_verified == 0)
                                                        <div class="form-inline">
                                                            <form
                                                                action="{{ route('service.verified_complite', $item->id) }}"
                                                                method="POST">
                                                                @csrf
                                                                @method('PUT')
                                                                <button type="submit"
                                                                    class="btn btn-sm btn-success">Terima</button>
                                                            </form>
                                                            <form
                                                                action="{{ route('service.verified_reject', $item->id) }}"
                                                                method="POST">
                                                                @csrf
                                                                @method('PUT')
                                                                <button type="submit"
                                                                    class="btn btn-sm btn-danger">Tolak</button>
                                                            </form>
                                                        </div>
                                                    @elseif($item->is_verified == 1)
                                                        <span class="text-success">Pembayaran telah dikonfirmasi</span> <br>
                                                        <form action="{{ route('service.verified_reject', $item->id) }}"
                                                            method="POST">
                                                            @csrf
                                                            @method('PUT')
                                                            <button type="submit" class="btn btn-sm btn-danger">Batalkan
                                                                dan tolak</button>
                                                        </form>
                                                    @elseif($item->is_verified == 2)
                                                        <span class="text-danger"> Pembayaran telah ditolak</span> <br>
                                                        <form action="{{ route('service.verified_complite', $item->id) }}"
                                                            method="POST">
                                                            @csrf
                                                            @method('PUT')
                                                            <button type="submit" class="btn btn-sm btn-success">Batalkan
                                                                dan Konfrimasi</button>
                                                        </form>
                                                    @endif
                                                </td>
                                            </tr>
                                            @include('pages.service.components.modal_payment')
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
