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
                            <div class="table-responsive">
                                <table class="table table-bordered table-striped mb-0 lara-dataTable">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Kode</th>
                                            @if (Auth::user()->role == 'customer')
                                                <th>Keterangan</th>
                                                <th>Status</th>
                                                <th>Pembayaran</th>
                                                <th>Aksi</th>
                                            @endif
                                            @if (Auth::user()->role != 'customer')
                                                <th>Keterangan</th>
                                                <th>Alamat</th>
                                                <th>Nomor Hp</th>
                                                <th>Terima</th>
                                            @endif
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($service as $item)
                                            <tr>
                                                <td width="10">{{ $loop->iteration }}</td>
                                                <td>
                                                    <strong>{{ $item->code }}</strong>
                                                    <br>
                                                    {{ $item->user->name }}
                                                </td>
                                                @if (Auth::user()->role == 'customer')
                                                    <td>
                                                        {!! $item->description !!}
                                                    </td>
                                                    <td>
                                                        {{ App\Models\ServiceStatus::getLastStatus($item->id)->status->status ?? '-' }}
                                                        @if (App\Models\ServiceStatus::checkFinish($item->id) != null)
                                                            @if (App\Models\ServiceFinished::where('id_service', $item->id)->count() <= 0)
                                                                <hr class="my-0">
                                                                <span class="text-warning">belum di klaim</span>
                                                            @else
                                                                <hr class="my-0">
                                                                <span class="text-success">telah di klaim</span>
                                                                @foreach (App\Models\ReviewRating::where('id_service', $item->id)->where('id_user', Auth::user()->id)->get() as $rating)
                                                                    <div class="form-group mb-0">
                                                                        <div class="ratings">
                                                                            @for ($i = 1; $i <= $rating->star_rating; $i++)
                                                                                <i class="fa fa-star text-warning "></i>
                                                                            @endfor
                                                                        </div>
                                                                    </div>
                                                                @endforeach
                                                            @endif
                                                        @else
                                                            -
                                                        @endif
                                                    </td>
                                                    <td>
                                                        @if (App\Models\ServicePayment::where('id_service', $item->id)->first() == null)
                                                            <a type="button" href="#" data-toggle="modal"
                                                                class="btn btn-primary" data-target="#create"> Bayar
                                                            </a>
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
                                                            @endif
                                                        @endif
                                                    </td>
                                                    <td>
                                                        <a href="{{ route('service.show', $item->id) }}"
                                                            class="btn btn-light-primary btn-md "><i
                                                                class="feather icon-eye  f-16 "></i> Lihat
                                                        </a>
                                                        @if (App\Models\ServiceStatus::checkFinish($item->id) != null &&
                                                                App\Models\ServiceFinished::where('id_service', $item->id)->count() <= 0)
                                                            <a type="button" href="#" data-toggle="modal"
                                                                class="btn btn-light-success btn-md"
                                                                data-target="#review-{{ $item->id }}"><i
                                                                    class="feather icon-check  f-16 "></i> Klaim
                                                            </a>
                                                        @else
                                                            <a type="button" href="#" data-toggle="modal"
                                                                class="btn btn-light-success btn-md"
                                                                data-target="#review-{{ $item->id }}"><i
                                                                    class="feather icon-message-circle f-16 "></i> Lihat
                                                                Ulasan
                                                            </a>
                                                        @endif
                                                    </td>
                                                @endif
                                                @if (Auth::user()->role != 'customer')
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
                                                        @if ($item->accepted == 0)
                                                            <form method="POST"
                                                                action="{{ url('/service/accept', $item->id) }}"
                                                                class="d-inline-block">
                                                                @csrf
                                                                @method('PUT')
                                                                <button type="submit"
                                                                    class="btn btn-light-primary btn-md "><i
                                                                        class="feather icon-chack  f-16 "></i> Terima
                                                                </button>
                                                            </form>
                                                        @else
                                                            Diterima
                                                        @endif
                                                    </td>
                                                @endif

                                            </tr>
                                            @include('pages.service.components.modal_payment')
                                            @include('pages.service.components.modal_review')
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
