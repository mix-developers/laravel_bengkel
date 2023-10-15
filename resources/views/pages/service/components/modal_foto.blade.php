<div class="modal  fade" id="foto-{{ $item->id }}" tabindex="-1" aria-labelledby="applyLoanLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header border-bottom-0">
                <h4 class="modal-title" id="exampleModalLabel">Foto</h4>
            </div>
            <div class="modal-body">
                <img src="{{ Storage::url($item->foto) }}" style="width: 100%;">
            </div>
        </div>
    </div>
</div>
