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
                            <h5>Identitas </h5>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-4">
                                    <table class="table table-bordered">
                                        <tr>
                                            <td>Nama</td>
                                            @if (Auth::user()->role != 'customer')
                                                <td>
                                                    {!! $service->user->role == 'customer'
                                                        ? $service->user->name
                                                        : App\Models\ServiceOut::getIdentity($service->code)->name ??
                                                            'Tanpa nama' . ' <span class="badge badge-light-danger"> (Non-member)</span>' !!}
                                                    <br>
                                                    @if ($service->user->role == 'customer')
                                                        <small class="text-muted">{{ $service->user->phone }}</small>
                                                    @else
                                                        <small
                                                            class="text-muted">{{ App\Models\ServiceOut::getIdentity($service->code)->phone ?? '0' }}</small>
                                                    @endif
                                                </td>
                                            @else
                                                <td>{{ Auth::user()->name }}</td>
                                            @endif
                                        </tr>
                                        <tr>
                                            <td>Code</td>
                                            <td>
                                                <strong>{{ $service->code }}</strong>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>Alamat</td>
                                            <td>
                                                @if (Auth::user()->role != 'customer')
                                                    {{ $service->user->role == 'customer' ? $service->user->address : App\Models\ServiceOut::getIdentity($service->code)->address ?? '-' }}
                                                @else
                                                    {{ Auth::user()->address }}
                                                @endif
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>Keterangan</td>
                                            <td>
                                                {{ $service->description }}
                                            </td>
                                        </tr>
                                    </table>
                                </div>
                                <div class="col-md-4">
                                    <div class="my-2">
                                        @if (Auth::user()->role != 'customer')
                                            <form action="{{ route('service.storeMechanical') }}" method="POST"
                                                enctype="multipart/form-data">
                                                @csrf
                                                <div class="input-group mb-3">
                                                    <input type="hidden" name="id_service" value="{{ $service->id }}">
                                                    <select class="custom-select" id="inputGroupSelect04"
                                                        aria-label="Example select with button addon" name="id_mechanic">
                                                        <option selected value="">--Mekanik--</option>
                                                        @foreach ($mechanical as $item)
                                                            <option value="{{ $item->id }}">{{ $item->name }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                    <div class="input-group-append">
                                                        <button class="btn btn-success" type="submit" id="button-addon2"><i
                                                                class="fa fa-plus"></i></button>
                                                    </div>
                                                </div>
                                            </form>
                                        @else
                                            <center>
                                                <strong class="mb-3 text-primary">Mekanik</strong>
                                            </center>
                                        @endif
                                        <table class="table table-bordered">
                                            <thead>
                                                <tr>
                                                    <td>#</td>
                                                    <td>Nama</td>
                                                    @if (Auth::user()->role != 'customer')
                                                        <td>Aksi</td>
                                                    @endif
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($mechanical_service as $item)
                                                    <tr>
                                                        <td>{{ $loop->iteration }}</td>
                                                        <td>{{ $item->mechanical->name }}</td>
                                                        @if (Auth::user()->role != 'customer')
                                                            <td style="width: 30px;">
                                                                <form
                                                                    action="{{ route('service.destroyMechanic', $item->id) }}"
                                                                    method="POST">
                                                                    @csrf
                                                                    @method('DELETE')
                                                                    <button type="submit" class="btn text-danger"><i
                                                                            class="fa fa-trash"></i></button>
                                                                </form>
                                                            </td>
                                                        @endif
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="my-2">
                                        @if (Auth::user()->role != 'customer')
                                            <form action="{{ route('service.storePart') }}" method="POST"
                                                enctype="multipart/form-data">
                                                @csrf
                                                <div class="input-group mb-3">
                                                    <input type="hidden" name="id_service" value="{{ $service->id }}">
                                                    <select class="custom-select" id="inputGroupSelect04"
                                                        aria-label="Example select with button addon" name="id_part">
                                                        <option selected value="">--Spare Part--</option>
                                                        @foreach ($part as $item)
                                                            <option value="{{ $item->id }}">{{ $item->name }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                    <div class="input-group-append">
                                                        <button class="btn btn-success" type="submit" id="button-addon2"><i
                                                                class="fa fa-plus"></i></button>
                                                    </div>
                                                </div>
                                            </form>
                                        @else
                                            <center>
                                                <strong class="mb-3 text-primary">Spare Part</strong>
                                            </center>
                                        @endif
                                        <table class="table table-bordered">
                                            <thead>
                                                <tr>
                                                    <td>#</td>
                                                    <td>Part</td>
                                                    @if (Auth::user()->role != 'customer')
                                                        <td>Aksi</td>
                                                    @endif
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($part_service as $item)
                                                    <tr>
                                                        <td>{{ $loop->iteration }}</td>
                                                        <td>{{ $item->part->name }}</td>
                                                        @if (Auth::user()->role != 'customer')
                                                            <td style="width: 30px;">
                                                                <form
                                                                    action="{{ route('service.destroyPart', $item->id) }}"
                                                                    method="POST">
                                                                    @csrf
                                                                    @method('DELETE')
                                                                    <button type="submit" class="btn text-danger"><i
                                                                            class="fa fa-trash"></i></button>
                                                                </form>
                                                            </td>
                                                        @endif
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card">
                        <div class="card-header">
                            <strong>Biaya Service</strong>
                        </div>
                        <div class="card-body">
                            <div>
                                @if (Auth::user()->role != 'customer')
                                    <form action="{{ route('service.storePrice') }}" method="POST"
                                        enctype="multipart/form-data">
                                        @csrf
                                        <div class="input-group mb-3">
                                            <input type="hidden" name="id_service" value="{{ $service->id }}">
                                            <input type="text" class="form-control" name="price"
                                                placeholder="Biaya Jasa">
                                            <div class="input-group-append">
                                                <button class="btn btn-success" type="submit" id="button-addon2"><i
                                                        class="fa fa-plus"></i></button>
                                            </div>
                                        </div>
                                    </form>
                                @endif
                                <table class="table table-bordered">
                                    <thead>
                                        <tr>
                                            <td>#</td>
                                            <td>Biaya</td>
                                            @if (Auth::user()->role != 'customer')
                                                <td>Aksi</td>
                                            @endif
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($price as $item)
                                            <tr>
                                                <td>{{ $loop->iteration }}</td>
                                                <td>Rp {{ number_format($item->price) }}</td>
                                                @if (Auth::user()->role != 'customer')
                                                    <td style="width: 30px;">
                                                        <form action="{{ route('service.destroyPrice', $item->id) }}"
                                                            method="POST">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit" class="btn text-danger"><i
                                                                    class="fa fa-trash"></i></button>
                                                        </form>
                                                    </td>
                                                @endif
                                            </tr>
                                        @endforeach
                                        <tr>
                                            <td><strong>Biaya Jasa</strong></td>
                                            <td colspan="2"><span class="text-danger">Rp
                                                    {{ number_format($price->sum('price')) }}</span>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td><strong>Biaya Part</strong></td>
                                            <td colspan="2"><span class="text-danger">Rp
                                                    {{ number_format($biaya_part) }}</span>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td><strong>TOTAL</strong></td>
                                            <td colspan="2"><span class="text-danger">
                                                    <strong>Rp
                                                        {{ number_format($biaya_total) }}</strong></span>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-8">
                    <div class="card">
                        <div class="card-header">
                            <strong>Status Service</strong>
                        </div>
                        <div class="card-body">
                            @if (Auth::user()->role != 'customer')
                                <div class="my-3 d-flex justify-content-end">
                                    <a type="button" class="btn btn-success" href="#" data-toggle="modal"
                                        data-target="#create_status"><i class="fa fa-plus"></i> Tambah Status </a>
                                </div>
                            @endif
                            <table class="lara-dataTable table table-bordered table-hover">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Status</th>
                                        <th>Karyawan</th>
                                        @if (Auth::user()->role != 'customer')
                                            <th>Aksi</th>
                                        @endif
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($service_status as $item)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>
                                                @if ($item->foto != '')
                                                    <a type="button" href="#" data-toggle="modal"
                                                        data-target="#foto-{{ $item->id }}">
                                                        <img src="{{ Storage::url($item->foto) }}" style="height: 80px;">
                                                    </a>
                                                    <br>
                                                @endif
                                                <strong>{{ $item->status->status }}</strong><br>{{ $item->description }}<br>
                                                <small class="text-muted">{{ $item->created_at }}</small>
                                            </td>
                                            <td>
                                                @if ($item->user->role == 'customer')
                                                    @if ($item->id_user == Auth::user()->id)
                                                        Dilakukan Secara Mandiri<br> oleh anda ({{ $item->user->name }})
                                                    @else
                                                        Dilakukan Oleh customer
                                                    @endif
                                                @else
                                                    {{ $item->user->name }}
                                                @endif
                                            </td>
                                            @if (Auth::user()->role != 'customer')
                                                <td>
                                                    <form action="{{ route('service.destroyStatus', $item->id) }}"
                                                        method="POST">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn text-danger"><i
                                                                class="fa fa-trash"></i></button>
                                                    </form>
                                                </td>
                                            @endif
                                        </tr>
                                        @include('pages.service.components.modal_foto')
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <!-- subscribe end -->
            </div>
            <!-- [ Main Content ] end -->
        </div>

        @include('pages.service.components.modal_status')
    </section>
@endsection
