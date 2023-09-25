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
                                            <td>
                                                {!! $service->user->role == 'member'
                                                    ? $service->user->name
                                                    : App\Models\ServiceOut::getIdentity($service->code)->name .
                                                        ' <span class="badge badge-light-danger"> (Non-member)</span>' !!}
                                                <br>
                                                <small
                                                    class="text-muted">{{ App\Models\ServiceOut::getIdentity($service->code)->phone }}</s>
                                            </td>
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
                                                {{ $service->user->role == 'member' ? $service->user->address : App\Models\ServiceOut::getIdentity($service->code)->address }}
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
                                        <form action="{{ route('service.storeMechanical') }}" method="POST"
                                            enctype="multipart/form-data">
                                            @csrf
                                            <div class="input-group mb-3">
                                                <input type="hidden" name="id_service" value="{{ $service->id }}">
                                                <select class="custom-select" id="inputGroupSelect04"
                                                    aria-label="Example select with button addon" name="id_mechanic">
                                                    <option selected value="">--Mekanik--</option>
                                                    @foreach ($mechanical as $item)
                                                        <option value="{{ $item->id }}">{{ $item->name }}</option>
                                                    @endforeach
                                                </select>
                                                <div class="input-group-append">
                                                    <button class="btn btn-success" type="submit" id="button-addon2"><i
                                                            class="fa fa-plus"></i></button>
                                                </div>
                                            </div>
                                        </form>
                                        <table class="table table-bordered">
                                            <thead>
                                                <tr>
                                                    <td>#</td>
                                                    <td>Nama</td>
                                                    <td>Aksi</td>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($mechanical_service as $item)
                                                    <tr>
                                                        <td>{{ $loop->iteration }}</td>
                                                        <td>{{ $item->mechanical->name }}</td>
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
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="my-2">
                                        <form action="{{ route('service.storePart') }}" method="POST"
                                            enctype="multipart/form-data">
                                            @csrf
                                            <div class="input-group mb-3">
                                                <input type="hidden" name="id_service" value="{{ $service->id }}">
                                                <select class="custom-select" id="inputGroupSelect04"
                                                    aria-label="Example select with button addon" name="id_part">
                                                    <option selected value="">--Spare Part--</option>
                                                    @foreach ($part as $item)
                                                        <option value="{{ $item->id }}">{{ $item->name }}</option>
                                                    @endforeach
                                                </select>
                                                <div class="input-group-append">
                                                    <button class="btn btn-success" type="submit" id="button-addon2"><i
                                                            class="fa fa-plus"></i></button>
                                                </div>
                                            </div>
                                        </form>
                                        <table class="table table-bordered">
                                            <thead>
                                                <tr>
                                                    <td>#</td>
                                                    <td>Part</td>
                                                    <td>Aksi</td>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($part_service as $item)
                                                    <tr>
                                                        <td>{{ $loop->iteration }}</td>
                                                        <td>{{ $item->part->name }}</td>
                                                        <td style="width: 30px;">
                                                            <form action="{{ route('service.destroyPart', $item->id) }}"
                                                                method="POST">
                                                                @csrf
                                                                @method('DELETE')
                                                                <button type="submit" class="btn text-danger"><i
                                                                        class="fa fa-trash"></i></button>
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
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card">
                        <div class="card-header">
                            <strong>Biaya Service</strong>
                        </div>
                        <div class="card-body">
                            <div>
                                <form action="{{ route('service.storePrice') }}" method="POST"
                                    enctype="multipart/form-data">
                                    @csrf
                                    <div class="input-group mb-3">
                                        <input type="hidden" name="id_service" value="{{ $service->id }}">
                                        <input type="text" class="form-control" name="price" placeholder="Biaya Jasa">
                                        <div class="input-group-append">
                                            <button class="btn btn-success" type="submit" id="button-addon2"><i
                                                    class="fa fa-plus"></i></button>
                                        </div>
                                    </div>
                                </form>
                                <table class="table table-bordered">
                                    <thead>
                                        <tr>
                                            <td>#</td>
                                            <td>Biaya</td>
                                            <td>Aksi</td>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($price as $item)
                                            <tr>
                                                <td>{{ $loop->iteration }}</td>
                                                <td>Rp {{ number_format($item->price) }}</td>
                                                <td style="width: 30px;">
                                                    <form action="{{ route('service.destroyPrice', $item->id) }}"
                                                        method="POST">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn text-danger"><i
                                                                class="fa fa-trash"></i></button>
                                                    </form>
                                                </td>
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
                            <table class="lara-dataTable table table-bordered table-hover">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Status</th>
                                        <th>Karyawan</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($service_status as $item)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>
                                                <strong>{{ $item->status }}</strong><br>{{ $item->description }}<br>
                                                <small class="text-muted">{{ $item->created_at }}</small>
                                            </td>
                                            <td>{{ $item->user->name }}</td>
                                            <td>
                                                <button type="submit" class="btn text-danger"><i
                                                        class="fa fa-trash"></i></button>
                                            </td>
                                        </tr>
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
    </section>
@endsection
