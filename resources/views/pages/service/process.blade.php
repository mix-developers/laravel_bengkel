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
                                            <th>Status Service</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($service as $item)
                                            <tr>
                                                <td width="10">{{ $loop->iteration }}</td>
                                                <td>
                                                    @if ($item->user->role != 'member')
                                                        {{ App\Models\ServiceOut::getIdentity($item->code)->name }} <br>
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
                                                        {{ App\Models\ServiceStatus::getLastStatus($item->id)->status }}
                                                    </span>
                                                </td>
                                                <td>
                                                    <a href="{{ route('service.show', $item->id) }}"
                                                        class="btn btn-light-primary btn-md "><i
                                                            class="feather icon-eye  f-16 "></i> Lihat
                                                    </a>
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
