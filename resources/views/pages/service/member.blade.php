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
                                            <th>Nama</th>
                                            <th>Keterangan</th>
                                            <th>Alamat</th>
                                            <th>Nomor Hp</th>
                                            <th>Terima</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($service as $item)
                                            <tr>
                                                <td width="10">{{ $loop->iteration }}</td>
                                                <td>
                                                    {{ $item->user->name }}
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
                                                    @if ($item->accepted == 0)
                                                        <form method="POST"
                                                            action="{{ url('/service/acceptMember', $item->id) }}"
                                                            class="d-inline-block">
                                                            @csrf
                                                            @method('PUT')
                                                            <button type="submit" class="btn btn-light-primary btn-md "><i
                                                                    class="feather icon-chack  f-16 "></i> Terima
                                                            </button>
                                                        </form>
                                                    @else
                                                        Diterima
                                                    @endif
                                                </td>
                                                <td>
                                                    <button type="button" class="btn btn-light-primary btn-md "><i
                                                            class="feather icon-eye  f-16 "></i> Lihat
                                                    </button>
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
