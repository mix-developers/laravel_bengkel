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
                                            <th>Foto</th>
                                            <th>kode service</th>
                                            <th>Rating</th>
                                            <th>ulasan</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($rating as $item)
                                            <tr>
                                                <td width="10">{{ $loop->iteration }}</td>
                                                <td>
                                                    @if ($item->thumbnail != null)
                                                        <img src="{{ Storage::url($item->thumbnail) }}" height="50px">
                                                    @endif
                                                </td>
                                                <td>
                                                    <strong>{{ $item->service->code }}</strong>
                                                </td>
                                                <td>
                                                    <div class="form-group mb-0">
                                                        <div class="ratings">
                                                            @for ($i = 1; $i <= $item->star_rating; $i++)
                                                                <i class="fa fa-star text-warning "></i>
                                                            @endfor
                                                        </div>
                                                    </div>
                                                </td>
                                                <td>
                                                    {{ $item->comments }}
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
