<div class="modal fade edit-{{ $item->id }}" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title h4" id="myLargeModalLabel">Edit</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                        aria-hidden="true">&times;</span></button>
            </div>
            <div class="modal-body">

                <form method="POST" action="{{ url('/part_stok/update', $item->id) }}" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="form-group">
                        <label for="id_part">Spare Part</label>
                        <select class="form-control" name="id_part">
                            <option value="">--pilih part--</option>
                            @foreach ($Part as $list)
                                <option value="{{ $list->id }}" {{ $list->id == $item->id_part ? 'selected' : '' }}>
                                    {{ $list->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="stok">Stok</label>
                        <input type="number" class="form-control @error('stok') is-invalid @enderror" name="stok"
                            value="{{ $item->stok }}">
                    </div>
                    <div class="form-group">
                        <label for="type">Jenis</label>
                        <select class="form-control" name="type">
                            <option value="1" {{ $item->type == 1 ? 'selected' : '' }}>Pemasukkan</option>
                            <option value="0" {{ $item->type == 0 ? 'selected' : '' }}>Pengeluaran</option>
                        </select>
                    </div>
                    <button type="submit" class="btn  btn-primary">Simpan</button>
                </form>
            </div>
        </div>
    </div>
</div>
@push('js')
    <script src="{{ asset('admin_theme') }}/assets/plugins/ckeditor/ckeditor.js"></script>
    <!-- CKEditor -->
    <script src="{{ asset('admin_theme') }}/assets/plugins/ckeditor/ckeditor.js"></script>
@endpush
