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

                <form method="POST" action="{{ url('/bank/update', $item->id) }}" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="form-group">
                        <label for="nama_pemilik">Nama Pemilik</label>
                        <input type="text" class="form-control @error('nama_pemilik') is-invalid @enderror"
                            name="nama_pemilik" value="{{ $item->nama_pemilik }}">
                    </div>
                    <div class="form-group">
                        <label for="bank">Nama Bank</label>
                        <input type="text" class="form-control @error('bank') is-invalid @enderror" name="bank"
                            value="{{ $item->bank }}">
                    </div>
                    <div class="form-group">
                        <label for="no_rekening">Nomor Rekening</label>
                        <input type="number" class="form-control @error('no_rekening') is-invalid @enderror"
                            name="no_rekening" value="{{ $item->no_rekening }}">
                    </div>
                    <div class="form-group">
                        <label for="color">Warna Bank</label>
                        <input type="color" class="form-control @error('color') is-invalid @enderror" name="color"
                            value="{{ $item->color }}">
                    </div>
                    <div class="form-group">
                        <label for="thumbnail">Icon Bank</label>
                        <input type="file" class="form-control @error('thumbnail') is-invalid @enderror"
                            name="thumbnail">
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
