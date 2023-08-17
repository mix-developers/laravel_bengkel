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
                            <h5>Tambah Stok</h5>
                        </div>
                        <div class="card-body">
                            <form method="POST" action="{{ url('/part_stok/store') }}" enctype="multipart/form-data">
                                @csrf

                                <div class="form-group">
                                    <label for="id_part">Spare Part</label>
                                    <select class="form-control" name="id_part">
                                        <option value="" selected>--pilih part--</option>
                                        @foreach ($Part as $list)
                                            <option value="{{ $list->id }}">{{ $list->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="stok">Stok</label>
                                    <input type="number" class="form-control @error('stok') is-invalid @enderror"
                                        name="stok">
                                </div>
                                <div class="form-group">
                                    <label for="type">Jenis</label>
                                    <select class="form-control" name="type">
                                        <option value="1" selected>Pemasukkan</option>
                                        <option value="0">Pengeluaran</option>
                                    </select>
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
                                            <th>Spare Part</th>
                                            <th>Stok</th>
                                            <th>Jenis</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($PartStok as $item)
                                            <tr>
                                                <td width="10">{{ $loop->iteration }}</td>
                                                <td>
                                                    {{ $item->part->name }}
                                                </td>
                                                <td>
                                                    {{ number_format($item->stok) }}
                                                </td>
                                                <td>
                                                    {!! $item->type == 1
                                                        ? '<span class="text-primary">Pemasukkan</span>'
                                                        : '<span class="text-danger">Pengeluaran</span>' !!}
                                                </td>
                                                <td width="200">
                                                    <button type="button" class="btn btn-light-warning btn-md"
                                                        data-toggle="modal" data-target=".edit-{{ $item->id }}"><i
                                                            class="icon feather icon-edit f-16"></i>
                                                        Edit</button>
                                                    @include('pages.part_stok.modal_edit')
                                                    <form method="POST" action="{{ url('/part_stok/destroy', $item->id) }}"
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
