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

                <form method="POST" action="{{ url('/part/update', $item->id) }}" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    @if ($item->thumbnail != null || $item->thumbnail != '')
                        <center>
                            <img src="{{ Storage::url($item->thumbnail) }}" height="100px">
                        </center>
                    @endif
                    <div class="form-group">
                        <div class="form-group">
                            <label for="thumbnail">Foto Spare part</label>
                            <input type="file" class="form-control @error('thumbnail') is-invalid @enderror"
                                name="thumbnail">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="name">Nama</label>
                        <input type="text" class="form-control @error('name') is-invalid @enderror" name="name"
                            value="{{ $item->name }}">
                    </div>
                    <div class="form-group">
                        <label for="price">harga</label>
                        <input type="text" class="form-control @error('price') is-invalid @enderror" name="price"
                            value="{{ $item->price }}">
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
