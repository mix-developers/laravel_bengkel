<div class="modal applyLoanModal fade" id="applyLoan" tabindex="-1" aria-labelledby="applyLoanLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header border-bottom-0">
                <h4 class="modal-title" id="exampleModalLabel">Pengajuan service</h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                @guest
                    <form id="coordinateForm" action="{{ route('storeServiceOut') }}" method="post"
                        enctype="multipart/form-data">
                        @csrf
                        <div class="row">
                            <input type="hidden" id="latitude" name="latitude">
                            <input type="hidden" id="longitude" name="longitude">
                            <div id="map" style="height: 400px;" class="my-4 col-12"></div>
                            <div id="coordinates" class="mb-3"></div>
                            <div class="col-lg-12 mb-4 ">
                                <div class="form-group">
                                    <label for="name" class="form-label">Nama Lengkap</label>
                                    <input type="text" name="name" class="form-control shadow-none">
                                </div>
                            </div>
                            <div class="col-12 mb-4 ">
                                <div class="form-group">
                                    <label for="description" class="form-label">Keterangan Kerusakan</label>
                                    <textarea name="description" class="form-control"></textarea>
                                </div>
                            </div>
                            <div class="col-lg-12 mb-4 ">
                                <div class="form-group">
                                    <label for="address" class="form-label">Lokasi Kendaraan</label>
                                    <input type="text" class="form-control shadow-none" name="address">
                                </div>
                            </div>
                            <div class="col-lg-12 mb-4 ">
                                <div class="form-group">
                                    <label for="phone" class="form-label">Nomor HP</label>
                                    <input type="text" name="phone" class="form-control shadow-none">
                                </div>
                            </div>
                            <div class="col-lg-12">
                                <button type="submit" class="btn btn-primary w-100">Ajukan Service</button>
                            </div>
                        </div>
                    </form>
                @else
                    <form action="{{ route('storeServiceIn') }}" method="post" enctype="multipart/form-data">
                        @csrf
                        <div class="row">
                            <div class="col-12 mb-4 ">
                                <div class="form-group">
                                    <label for="description" class="form-label">Keterangan Kerusakan</label>
                                    <textarea name="description" class="form-control"></textarea>
                                </div>
                            </div>
                            <div class="col-lg-12 mb-4 ">
                                <div class="form-group">
                                    <label for="brand" class="form-label">Merek Motor</label>
                                    <input type="text" class="form-control shadow-none" name="brand">
                                </div>
                            </div>
                            <div class="col-lg-12">
                                <button type="submit" class="btn btn-primary w-100">Ajukan Service</button>
                            </div>
                        </div>
                    </form>
                @endguest
            </div>
        </div>
    </div>
</div>

@if (Auth::check())
    <div class="modal cart fade" id="cart" tabindex="-1" aria-labelledby="applyLoanLabel" aria-hidden="true">
        <div class="modal-dialog  modal-lg">
            <div class="modal-content">
                <div class="modal-header border-bottom-0">
                    <h4 class="modal-title" id="exampleModalLabel">Keranjang anda</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body text-left">
                    <table class="table table-borderless text-black">
                        <tr>
                            <td>#</td>
                            <td>Spare Part</td>
                            <td>Total Bayar</td>
                            <td class="text-center"></td>
                        </tr>

                        @foreach (App\Models\OrderCart::where('id_user', Auth::user()->id)->get() as $item)
                            <tr>
                                <td style="width: 10px;">{{ $loop->iteration }}</td>
                                <td>
                                    <strong>{{ $item->part->name }}</strong><br>
                                    Jumlah Pesanan : <span class="text-success">{{ $item->count }}</span> Pcs
                                </td>
                                <td><strong class="text-danger">Rp {{ number_format($item->total_price) }}</strong>
                                </td>
                                <td style="width: 200px;">
                                    <div class="d-flex">

                                        <a type="button" href="#" class="btn btn-warning p-2 mx-2"
                                            data-bs-toggle="modal" data-bs-target="#chackout-{{ $item->id }}">
                                            Checkout
                                        </a>
                                        <form action="{{ route('destroyCart', $item->id) }}" method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger btn-sm py-2">x</button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </table>
                </div>
            </div>
        </div>
    </div>
    @foreach (App\Models\OrderCart::where('id_user', Auth::user()->id)->get() as $item)
        <div class="modal cart fade" id="chackout-{{ $item->id }}" tabindex="-1"
            aria-labelledby="applyLoanLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header border-bottom-0">
                        <h4 class="modal-title" id="exampleModalLabel">Checkout {{ $item->part->name }}</h4>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                            aria-label="Close"></button>
                    </div>
                    <form action="{{ route('add_order') }}" enctype="multipart/form-data" method="POST">
                        @csrf
                        <div class="modal-body ">
                            <input type="hidden" name="id_cart" value="{{ $item->id }}">
                            <input type="hidden" name="id_part" value="{{ $item->id_part }}">
                            <input type="hidden" name="total_price" value="{{ $item->total_price }}">
                            <input type="hidden" name="count" value="{{ $item->count }}">
                            <div class="form-group my-3">
                                <label for="method">Apakah bagian dari service ? <span
                                        class="text-danger">*</span></label>
                                <select class="form-control" id="inputGroupSelect04"
                                    aria-label="Example select with button addon" name="is_service" required>
                                    <option selected value="0">Tidak</option>
                                    <option value="1">Bagian dari service</option>
                                </select>
                            </div>
                            <div class="form-group my-3">
                                <label for="method">Pilih Kode Service Anda </label>
                                <select class="form-control" id="inputGroupSelect04"
                                    aria-label="Example select with button addon" name="id_service">
                                    <option selected value="">--pilih service-- </option>
                                    @foreach (App\Models\Service::where('id_user', Auth::user()->id)->get() as $item)
                                        <option value="{{ $item->id }}">{{ $item->code }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-warning">Checkout sekarang</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    @endforeach
@endif
