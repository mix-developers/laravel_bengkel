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
