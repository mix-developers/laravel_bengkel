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
                <div class="col-md-3">
                    <div class="card">
                        <div class="card-header">
                            <h5>Tambah Bank</h5>
                        </div>
                        <div class="card-body">
                            <form method="POST" action="{{ url('/bank/store') }}" enctype="multipart/form-data">
                                @csrf

                                <div class="form-group">
                                    <label for="nama_pemilik">Nama Pemilik</label>
                                    <input type="text" class="form-control @error('nama_pemilik') is-invalid @enderror"
                                        name="nama_pemilik">
                                </div>
                                <div class="form-group">
                                    <label for="bank">Nama Bank</label>
                                    <input type="text" class="form-control @error('bank') is-invalid @enderror"
                                        name="bank">
                                </div>
                                <div class="form-group">
                                    <label for="no_rekening">Nomor Rekening</label>
                                    <input type="number" class="form-control @error('no_rekening') is-invalid @enderror"
                                        name="no_rekening">
                                </div>
                                <div class="form-group">
                                    <label for="color">Warna Bank</label>
                                    <input type="color" class="form-control @error('color') is-invalid @enderror"
                                        name="color">
                                </div>
                                <div class="form-group">
                                    <label for="thumbnail">Icon Bank</label>
                                    <input type="file" class="form-control @error('thumbnail') is-invalid @enderror"
                                        name="thumbnail">
                                </div>
                                <button type="submit" class="btn  btn-primary">Simpan</button>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="col-md-9">
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
                                            <th>Rekening</th>
                                            <th>Nama</th>
                                            <th>icon</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($bank as $item)
                                            <tr>
                                                <td width="10">{{ $loop->iteration }}</td>
                                                <td>
                                                    <strong
                                                        style="color:{{ $item->color }};">{{ $item->no_rekening }}</strong><br>
                                                    <div
                                                        style="width: 100%; background-color:{{ $item->color }}; height:5px; border-radius:10px;">

                                                    </div>
                                                </td>
                                                <td>
                                                    {{ $item->nama_pemilik }}<br>
                                                    <strong style="color:{{ $item->color }};">{{ $item->bank }}</strong>
                                                </td>
                                                <td>
                                                    <img src="{{ $item->thumbnail != null || $item->thumbnail != '' ? Storage::url($item->thumbnail) : asset('img/no-image.jpg') }}"
                                                        height="50px;">
                                                </td>
                                                <td width="200">
                                                    <button type="button" class="btn btn-light-warning btn-md"
                                                        data-toggle="modal" data-target=".edit-{{ $item->id }}"><i
                                                            class="icon feather icon-edit f-16"></i>
                                                        Edit</button>
                                                    @include('pages.bank.modal_edit')
                                                    <form method="POST" action="{{ url('/bank/destroy', $item->id) }}"
                                                        class="d-inline-block">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit"
                                                            class="btn btn-light-danger btn-md delete-button"><i
                                                                class="feather icon-trash-2  f-16 "></i> Delete
                                                        </button>
                                                    </form>
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
