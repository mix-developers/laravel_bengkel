<div class="modal  fade" id="thumbnail-{{ $item->id }}" tabindex="-1" aria-labelledby="applyLoanLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header border-bottom-0">
                <h4 class="modal-title" id="exampleModalLabel">Bukti Pembayaran</h4>
            </div>
            <div class="modal-body">
                <img src="{{ Storage::url($item->thumbnail) }}" style="width: 100%;">
            </div>
        </div>
    </div>
</div>
<div class="modal  fade" id="create" tabindex="-1" aria-labelledby="applyLoanLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header border-bottom-0">
                <h4 class="modal-title" id="exampleModalLabel">Tambah Pembayaran</h4>
            </div>
            <form action="{{ route('service.storeStatus') }}" enctype="multipart/form-data" method="POST">
                <div class="modal-body">
                    @csrf
                    {{-- <input type="hidden" name="total_fee" value="{{ $biaya_total }}"> --}}
                    <div class="form-group">
                        <label for="foto">Foto <span class="text-danger">*</span></label>
                        <input type="file" name="foto" class="form-control">
                    </div>
                    @if (Auth::user()->role != 'customer')
                        <div class="form-group">
                            <label for="id_service">Service <span class="text-danger">*</span></label>
                            <select class="custom-select" id="inputGroupSelect04"
                                aria-label="Example select with button addon" name="id_service" required>
                                <option selected value="">--pilih Service--</option>
                                @foreach (App\Models\Service::all() as $item)
                                    <option value="{{ $item->id }}">
                                        {{ $item->code }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    @else
                        <input type="hidden" name="id_service" value="{{ $item->id }}">
                    @endif
                    <input type="hidden" name="id_status" value="5">
                    <div class="form-group">
                        <label>Total Bayar <span class="text-danger">*</span></label>
                        <input type="text" name="total_fee" class="form-control" placeholder="total bayar" required>
                    </div>
                    <div class="form-group">
                        <label for="description">Keterangan</label>
                        <textarea class="form-control @error('description') is-invalid @enderror" name="description">-</textarea>
                    </div>
                    <div class="form-group">
                        <label for="method">Methode Pembayaran <span class="text-danger">*</span></label>
                        <select class="custom-select" id="inputGroupSelect04"
                            aria-label="Example select with button addon" name="method" required>
                            <option selected value="Cash">Cash</option>
                            <option value="Transfer">Transfer</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="id_bank">Bank </label>
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
                    <button type="submit" class="btn btn-success"><i class="fa fa-save"></i> Simpan Pembayaran</button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal"
                        aria-label="Close">Cancel</button>
                </div>
            </form>
        </div>
    </div>
</div>
