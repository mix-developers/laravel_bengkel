@extends('layouts.app')
@section('content')
    @include('landing_page.component.modals')

    <section class="banner bg-tertiary position-relative overflow-hidden">
        <div class="container">
            <div class="row align-items-center justify-content-center">
                <div class="col-lg-8 col-12 text-center">
                    <form action="{{ route('status') }}" method="GET" enctype="multipart/form-data">
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
            <hr>
            <div class="row align-items-center justify-content-center">
                <div class="col-lg-6 mb-5 mb-lg-0">
                    <div class="block text-center text-lg-start pe-0 pe-xl-5">
                        <h1 class="text-capitalize mb-4">{{ env('APP_NAME') }}</h1>
                        <p class="mb-4">Klik tombol di bawah untuk melakukan pengajuan service tanpa melakukan login,
                            dan
                            untuk menjadi member pada bengkel {{ env('APP_NAME') }} klik tombol register di pojok kanan
                            atas...
                        </p> <a type="button" class="btn btn-primary" href="#" data-bs-toggle="modal"
                            data-bs-target="#applyLoan">Ajukan Service <span style="font-size: 14px;"
                                class="ms-2 fas fa-arrow-right"></span></a>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="ps-lg-5 text-center">
                        <img loading="lazy" decoding="async" src="{{ asset('img/bengkel.png') }}" alt="banner image"
                            class="w-100">

                    </div>
                </div>
            </div>
            <hr>
            <div class="mt-3 mb-5">
                <h1 class="text-center text-capitalize">Ulasan pelanggan</h1>
                <div class="my-3">
                    <div class="row d-flex justify-content-center">
                        @if (App\Models\ReviewRating::where('star_rating', '>=', 3)->limit(4)->latest()->count() != 0)
                            @foreach (App\Models\ReviewRating::where('star_rating', '>=', 3)->limit(4)->latest()->get() as $item)
                                <div class="col-lg-3">
                                    <div class="card border border-success">
                                        <div class="card-body">
                                            @for ($i = 1; $i <= $item->star_rating; $i++)
                                                <i class="fa fa-star text-warning "></i>
                                            @endfor
                                            <br>
                                            <h3>{{ $item->service->user->name }}</h3>
                                            <p>{{ $item->comments }}</p>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        @else
                            <div class="col">
                                <h3 class="text-muted">Belum ada ulasan dari pelanggan</h3>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
            <hr>
            <div class="my-3">
                <h1 class="text-center text-capitalize">Spare Part</h1>
                <form action="{{ route('search') }}" method="GET" enctype="multipart/form-data">
                    <div class="input-group my-3">
                        <input type="search" class="form-control" placeholder="Cari Spare Part di sini..."
                            aria-label="Cari Spare Part di sini..." aria-describedby="button-addon2" name="keywords"
                            required value="{{ old('keywords') }}">
                        <div class="input-group-append">
                            <button class="btn btn-primary" type="submit" id="button-addon2"
                                style="border-top-right-radius: 5px; border-bottom-right-radius: 5px; border-bottom-left-radius: 0px; border-top-left-radius: 0px; height:100%;">Cari</button>
                            <a class="btn btn-secondary" href="{{ url('/') }}"
                                style="border-top-right-radius: 5px; border-bottom-right-radius: 5px; border-bottom-left-radius: 5px; border-top-left-radius: 5px; height:100%;">Reset</a>
                        </div>
                    </div>
                </form>
            </div>
            <div class="row align-items-center justify-content-center">
                @foreach ($part as $item)
                    @php
                        $stok = App\Models\PartStok::getStok($item->id);
                    @endphp
                    <div class="col-lg-3 col-md-6 mt-2">
                        <div class="card border border-success text-center">
                            <div class="card-body">
                                <h4>{{ $item->name }}</h4>
                                <hr>
                                {!! $stok != 0
                                    ? '<span class="bg-success rounded p-2 text-white">Tersedia : ' . $stok . '</span>'
                                    : '<span class="bg-danger rounded p-2 text-white">Kosong</span>' !!}
                                <br><img
                                    src="{{ $item->thumbnail != null || $item->thumbnail != '' ? Storage::url($item->thumbnail) : asset('img/favicon.png') }}"
                                    style="height: 150px" class="my-3">
                                <h2 class="text-danger">Rp {{ number_format($item->price) }}</h2>
                            </div>
                            @guest
                                <div class="card-footer bg-white">
                                    <div class="form-inline d-flex justify-content-center">
                                        <a href="{{ route('register') }}" class="btn btn-sm btn-success">Daftar
                                        </a>
                                    </div>
                                </div>
                            @else
                                <div class="card-footer bg-white">
                                    <form action="{{ route('add_cart') }}" enctype="multipart/form-data" method="POST">
                                        @csrf
                                        <div class="form-inline d-flex justify-content-center">
                                            <input type="hidden" name="id_part" value="{{ $item->id }}">
                                            <input type="number" class="form-control mx-2" style="width: 70px;" name="count"
                                                value="1">
                                            <button type="submit" href="" class="btn btn-sm btn-success">Tambah
                                                <svg xmlns="http://www.w3.org/2000/svg" height="1em" viewBox="0 0 576 512">
                                                    <style>
                                                        svg {
                                                            fill: #ffffff
                                                        }
                                                    </style>
                                                    <path
                                                        d="M0 24C0 10.7 10.7 0 24 0H69.5c22 0 41.5 12.8 50.6 32h411c26.3 0 45.5 25 38.6 50.4l-41 152.3c-8.5 31.4-37 53.3-69.5 53.3H170.7l5.4 28.5c2.2 11.3 12.1 19.5 23.6 19.5H488c13.3 0 24 10.7 24 24s-10.7 24-24 24H199.7c-34.6 0-64.3-24.6-70.7-58.5L77.4 54.5c-.7-3.8-4-6.5-7.9-6.5H24C10.7 48 0 37.3 0 24zM128 464a48 48 0 1 1 96 0 48 48 0 1 1 -96 0zm336-48a48 48 0 1 1 0 96 48 48 0 1 1 0-96z" />
                                                </svg>
                                            </button>
                                        </div>
                                    </form>
                                </div>

                            @endguest
                        </div>
                    </div>
                @endforeach
                <div class="mt-4 d-flex justify-content-center">
                    {{ $part->links() }}
                </div>
            </div>
        </div>
        @include('landing_page.component.shapes')
    </section>
@endsection
@push('js')
    @include('landing_page.component.leaflet')
@endpush
