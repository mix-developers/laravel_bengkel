@extends('layouts.app')
@section('content')
    @include('landing_page.component.modals')

    <section class="banner bg-tertiary position-relative overflow-hidden">
        <div class="container">
            <div class="row align-items-center justify-content-center">
                <div class="col-8 text-center">
                    <div class="input-group mb-3">
                        <input type="search" class="form-control" placeholder="Kode service" aria-label="Kode service"
                            aria-describedby="button-addon2">
                        <div class="input-group-append">
                            <button class="btn btn-primary" type="button" id="button-addon2"
                                style="border-top-right-radius: 5px; border-bottom-right-radius: 5px; border-bottom-left-radius: 0px; border-top-left-radius: 0px; height:100%;">Cek</button>
                        </div>
                    </div>
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
        </div>
        @include('landing_page.component.shapes')
    </section>
@endsection
@push('js')
    @include('landing_page.component.leaflet')
@endpush
