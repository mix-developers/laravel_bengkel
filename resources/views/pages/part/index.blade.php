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
                            <h5>Tambah Spare Parts</h5>
                        </div>
                        <div class="card-body">
                            <form method="POST" action="{{ url('/part/store') }}" enctype="multipart/form-data">
                                @csrf
                                <div class="form-group">
                                    <label for="thumbnail">Foto Spare part</label>
                                    <input type="file" class="form-control @error('thumbnail') is-invalid @enderror"
                                        name="thumbnail">
                                </div>
                                <div class="form-group">
                                    <label for="name">Nama</label>
                                    <input type="text" class="form-control @error('name') is-invalid @enderror"
                                        name="name">
                                </div>
                                <div class="form-group">
                                    <label for="price">harga</label>
                                    <input type="number" class="form-control @error('price') is-invalid @enderror"
                                        name="price">
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
                                            <th>Foto</th>
                                            <th>Nama</th>
                                            <th>Harga</th>
                                            <th>Stok</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($Part as $item)
                                            @php
                                                $stok = App\Models\PartStok::getStok($item->id);
                                            @endphp
                                            <tr>
                                                <td width="10">{{ $loop->iteration }}</td>
                                                <td>
                                                    <img src="{{ $item->thumbnail != null || $item->thumbnail != '' ? Storage::url($item->thumbnail) : asset('img/favicon.png') }}"
                                                        height="50px">
                                                </td>
                                                <td>
                                                    {{ $item->name }}
                                                </td>
                                                <td>
                                                    Rp. {{ number_format($item->price) }}
                                                </td>
                                                <td>
                                                    {!! $stok != 0 ? 'Tersedia : ' . $stok : '<span class="text-danger">Kosong</span>' !!}
                                                </td>
                                                <td width="200">
                                                    <button type="button" class="btn btn-light-warning btn-md"
                                                        data-toggle="modal" data-target=".edit-{{ $item->id }}"><i
                                                            class="icon feather icon-edit f-16"></i>
                                                        Edit</button>
                                                    @include('pages.part.modal_edit')
                                                    <form method="POST" action="{{ url('/part/destroy', $item->id) }}"
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
