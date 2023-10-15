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
                                            <th>Sparepart</th>
                                            <th>Jumlah</th>
                                            <th>Total harga</th>
                                            <th>Service</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($order as $item)
                                            <tr>
                                                <td width="10">{{ $loop->iteration }}</td>
                                                <td>
                                                    <strong>{{ $item->part->name }}</strong>
                                                </td>
                                                <td>{{ $item->count }} pcs</td>
                                                <td>Rp {{ number_format($item->total_price) }}</td>
                                                <td>
                                                    @if ($item->is_service == 1)
                                                        <a href="{{ url('/service/show', $item->id_service) }}"
                                                            class="text-link">
                                                            {{ $item->service->code }}
                                                        </a>
                                                    @else
                                                        <span class="badge badge-light-danger">Tidak termasuk service</span>
                                                    @endif
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
