<div class="modal  fade" id="create_status" tabindex="-1" aria-labelledby="applyLoanLabel" aria-hidden="true">
    <div class="modal-dialog ">
        <div class="modal-content">
            <div class="modal-header border-bottom-0">
                <h4 class="modal-title" id="exampleModalLabel">Tambah Status</h4>

            </div>
            <form action="{{ route('service.storeStatus') }}" method="POST" enctype="multipart/form-data">
                <div class="modal-body">
                    @csrf
                    <input type="hidden" name="id_service" value="{{ $service->id }}">
                    <input type="hidden" name="total_fee" value="{{ $biaya_total }}">
                    <div class="form-group">
                        <label for="foto">Foto</label>
                        <input type="file" name="foto" class="form-control">
                    </div>

                    <div class="form-group">
                        <label for="name">Status<span class="text-danger">*</span></label>
                        <select class="custom-select" id="inputGroupSelect04"
                            aria-label="Example select with button addon" name="id_status">
                            <option selected value="">--Status--</option>
                            @foreach ($statuses as $item)
                                <option value="{{ $item->id }}">{{ $item->status }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="description">Keterangan</label>
                        <textarea class="form-control @error('description') is-invalid @enderror" name="description">-</textarea>
                    </div>
                </div>
                <hr>
                <label class="mb-2">*Diisi jika status pembayaran</label>
                <div class="p-2 border bg-light">
                    <div class="form-group">
                        <label for="method">Methode Pembayaran</label>
                        <select class="custom-select" id="inputGroupSelect04"
                            aria-label="Example select with button addon" name="method">
                            <option selected value="Cash">Cash</option>
                            <option value="Transfer">Transfer</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="id_bank">Bank</label>
                        <select class="custom-select" id="inputGroupSelect04"
                            aria-label="Example select with button addon" name="id_bank">
                            <option selected value="">--pilih bank--</option>
                            @foreach (App\Models\Bank::all() as $item)
                                <option value="{{ $item->id }}" style="color: {{ $item->color }};">
                                    {{ $item->bank . ' - ' . $item->nama_pemilik }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-success"><i class="fa fa-save"></i> Simpan</button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal"
                        aria-label="Close">Cancel</button>
                </div>
            </form>
        </div>
    </div>
</div>
