@extends('layouts.backend.admin')

@section('content')
    <div class="pc-container">
        <div class="pcoded-content">
            <!-- Page Heading -->
            <h1 class="h3 mb-4 text-gray-800">{{ __('Dashboard') }}</h1>

            @if (session('success'))
                <div class="alert alert-success border-left-success alert-dismissible fade show" role="alert">
                    {{ session('success') }}
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            @endif

            @if (session('status'))
                <div class="alert alert-success border-left-success" role="alert">
                    {{ session('status') }}
                </div>
            @endif
            @if (Auth::user()->role == 'admin' || Auth::user()->role == 'owner')
                <div class="row">
                    <!-- Earnings (Monthly) Card Example -->
                    <div class="col-xl-3 col-md-6 mb-4">
                        <div class="card border-left-primary ">
                            <div class="card-body">
                                <div class="row no-gutters align-items-center">
                                    <div class="col mr-2">
                                        <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Earnings
                                            (Monthly)</div>
                                        <div class="h5 mb-0 font-weight-bold text-gray-800">$40,000</div>
                                    </div>
                                    <div class="col-auto">
                                        <i class="fas fa-calendar fa-2x text-gray-300"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Earnings (Monthly) Card Example -->
                    <div class="col-xl-3 col-md-6 mb-4">
                        <div class="card border-left-success ">
                            <div class="card-body">
                                <div class="row no-gutters align-items-center">
                                    <div class="col mr-2">
                                        <div class="text-xs font-weight-bold text-success text-uppercase mb-1">Earnings
                                            (Annual)</div>
                                        <div class="h5 mb-0 font-weight-bold text-gray-800">$215,000</div>
                                    </div>
                                    <div class="col-auto">
                                        <i class="fas fa-dollar-sign fa-2x text-gray-300"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Earnings (Monthly) Card Example -->
                    <div class="col-xl-3 col-md-6 mb-4">
                        <div class="card border-left-info ">
                            <div class="card-body">
                                <div class="row no-gutters align-items-center">
                                    <div class="col mr-2">
                                        <div class="text-xs font-weight-bold text-info text-uppercase mb-1">Tasks</div>
                                        <div class="row no-gutters align-items-center">
                                            <div class="col-auto">
                                                <div class="h5 mb-0 mr-3 font-weight-bold text-gray-800">50%</div>
                                            </div>
                                            <div class="col">
                                                <div class="progress progress-sm mr-2">
                                                    <div class="progress-bar bg-info" role="progressbar" style="width: 50%"
                                                        aria-valuenow="50" aria-valuemin="0" aria-valuemax="100"></div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-auto">
                                        <i class="fas fa-clipboard-list fa-2x text-gray-300"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Users -->
                    <div class="col-xl-3 col-md-6 mb-4">
                        <div class="card border-left-warning ">
                            <div class="card-body">
                                <div class="row no-gutters align-items-center">
                                    <div class="col mr-2">
                                        <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                                            {{ __('Users') }}</div>
                                        <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $users }}</div>
                                    </div>
                                    <div class="col-auto">
                                        <i class="fas fa-users fa-2x text-gray-300"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @elseif(Auth::user()->role == 'customer')
                <div class="row">
                    <div class="col-lg-4">
                        <div class="card">
                            <div class="card-header">Service <span class="badge badge-danger">{{ $service->count() }}</span>
                            </div>
                            <div class="card-body">
                                @foreach ($service->take(3)->latest()->get() as $item)
                                    <div class="card border border-primary mb-2" style="border-radius: 20px;">
                                        <div class="card-body p-3">
                                            <strong>{{ $item->code }}</strong><br>
                                            <small>
                                                Status :
                                                {{ App\Models\ServiceStatus::getLastStatus($item->id)->status->status }}</small>

                                            @if (App\Models\ServiceStatus::checkFinish($item->id) != null &&
                                                    App\Models\ServiceFinished::where('id_service', $item->id)->count() <= 0)
                                                <br>
                                                <a type="button" href="#" data-toggle="modal"
                                                    class="btn btn-light-success btn-sm"
                                                    data-target="#review-{{ $item->id }}"><i
                                                        class="feather icon-check  f-16 "></i> Klaim
                                                </a>
                                            @endif
                                        </div>
                                    </div>
                                    @include('pages.service.components.modal_review')
                                @endforeach
                            </div>
                            <div class="card-footer">
                                <a href="{{ route('service.member') }}" class="btn btn-primary">Lihat semua</a>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="card">
                            <div class="card-header">Review dan rating
                                <span
                                    class="badge badge-warning">{{ App\Models\ReviewRating::where('id_user', Auth::user()->id)->count() }}</span>
                            </div>
                            <div class="card-body">
                                @foreach (App\Models\ReviewRating::where('id_user', Auth::user()->id)->take(3)->latest()->get() as $rating)
                                    <div class="card border border-primary mb-2" style="border-radius: 20px;">
                                        <div class="card-body p-3">
                                            <div class="row">
                                                @if ($rating->thumbnail != null)
                                                    <div class="col-4 mr-3">
                                                        <img src="{{ Storage::url($rating->thumbnail) }}" height="50px">
                                                    </div>
                                                @endif
                                                <div class="col mb-0">
                                                    <div class="ratings">
                                                        @for ($i = 1; $i <= $rating->star_rating; $i++)
                                                            <i class="fa fa-star text-warning "></i>
                                                        @endfor
                                                        <br>
                                                        <strong>{{ App\Models\Service::find($rating->id_service)->code }}</strong>
                                                        <br>
                                                        <small
                                                            class="text-muted">{{ Str::limit($rating->comments, 50) }}</small>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                            <div class="card-footer">
                                <a href="{{ route('service.member') }}" class="btn btn-primary">Lihat semua</a>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="card">
                            <div class="card-header">Order Spare parts <span
                                    class="badge badge-primary">{{ App\Models\Order::where('id_user', Auth::user()->id)->count() }}</span>
                            </div>
                            <div class="card-body">
                                @foreach (App\Models\Order::where('id_user', Auth::user()->id)->take(3)->latest()->get() as $item)
                                    <div class="card border border-primary mb-2" style="border-radius: 20px;">
                                        <div class="card-body p-3">
                                            <strong>{{ $item->part->name }}</strong>
                                            <small>({{ $item->count . ' x Rp ' . number_format($item->part->price) }})</small>
                                            <h5 class="text-danger">Rp {{ number_format($item->total_price) }}</h5>
                                            <span
                                                class="badge badge-{{ $item->is_service == 1 ? 'primary' : 'warning' }}">{{ $item->is_service == 1 ? 'Include || ' . $item->service->code : 'no-include' }}</span>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                            <div class="card-footer">
                                <a href="{{ route('order') }}" class="btn btn-primary">Lihat semua</a>
                            </div>
                        </div>
                    </div>
                </div>
            @endif

        </div>
    </div>
@endsection
