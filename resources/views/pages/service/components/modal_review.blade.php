@push('css')
    <style>
        .rate {
            float: left;
            height: 50px;
            padding: 0 10px;
        }

        .rate:not(:checked)>input {
            position: absolute;
            display: none;
        }

        .rate:not(:checked)>label {
            float: right;
            width: 1em;
            overflow: hidden;
            white-space: nowrap;
            cursor: pointer;
            font-size: 30px;
            color: #ccc;
        }

        .rated:not(:checked)>label {
            float: right;
            width: 1em;
            overflow: hidden;
            white-space: nowrap;
            cursor: pointer;
            font-size: 30px;
            color: #ccc;
        }

        .rate:not(:checked)>label:before {
            content: '★ ';
        }

        .rate>input:checked~label {
            color: #ffc700;
        }

        .rate:not(:checked)>label:hover,
        .rate:not(:checked)>label:hover~label {
            color: #deb217;
        }

        .rate>input:checked+label:hover,
        .rate>input:checked+label:hover~label,
        .rate>input:checked~label:hover,
        .rate>input:checked~label:hover~label,
        .rate>label:hover~input:checked~label {
            color: #c59b08;
        }

        .star-rating-complete {
            color: #c59b08;
        }

        .rating-container .form-control:hover,
        .rating-container .form-control:focus {
            background: #fff;
            border: 1px solid #ced4da;
        }

        .rating-container textarea:focus,
        .rating-container input:focus {
            color: #000;
        }

        .rated {
            float: left;
            height: 46px;
            padding: 0 10px;
        }

        .rated:not(:checked)>input {
            position: absolute;
            display: none;
        }

        .rated:not(:checked)>label {
            float: right;
            width: 1em;
            overflow: hidden;
            white-space: nowrap;
            cursor: pointer;
            font-size: 30px;
            color: #ffc700;
        }

        .rated:not(:checked)>label:before {
            content: '★ ';
        }

        .rated>input:checked~label {
            color: #ffc700;
        }

        .rated:not(:checked)>label:hover,
        .rated:not(:checked)>label:hover~label {
            color: #deb217;
        }

        .rated>input:checked+label:hover,
        .rated>input:checked+label:hover~label,
        .rated>input:checked~label:hover,
        .rated>input:checked~label:hover~label,
        .rated>label:hover~input:checked~label {
            color: #c59b08;
        }
    </style>
@endpush
<div class="modal  fade" id="review-{{ $item->id }}" tabindex="-1" aria-labelledby="applyLoanLabel" aria-hidden="true">
    <div class="modal-dialog ">
        <div class="modal-content">
            <div class="modal-header border-bottom-0">
                <h4 class="modal-title" id="exampleModalLabel">Klaim service</h4>
            </div>
            @if (App\Models\ReviewRating::where('id_service', $item->id)->count() <= 0 &&
                    App\Models\ServiceFinished::where('id_service', $item->id)->count() <= 0)
                <form class="py-2 px-4" action="{{ route('rating.store') }}" method="POST"
                    enctype="multipart/form-data">
                    @csrf
                    <div class="modal-body">
                        <div class="form-group row d-flex justify-content-center">
                            <input type="hidden" name="id_service" value="{{ $item->id }}">
                            <input type="hidden" name="id_user" value="{{ Auth::user()->id }}">
                            <div class="">
                                <div class="rate">
                                    <input type="radio" id="star5" class="rate" name="star_rating"
                                        value="5" />
                                    <label for="star5" title="5 stars">5 stars</label>
                                    <input type="radio" id="star4" class="rate" name="star_rating"
                                        value="4" />
                                    <label for="star4" title="4 stars">4 stars</label>
                                    <input type="radio" id="star3" class="rate" name="star_rating"
                                        value="3" />
                                    <label for="star3" title="3 stars">3 stars</label>
                                    <input type="radio" id="star2" class="rate" name="star_rating"
                                        value="2">
                                    <label for="star2" title="2 stars">2 stars</label>
                                    <input type="radio" id="star1" class="rate" name="star_rating"
                                        value="1" />
                                    <label for="star1" title="1 stars">1 star</label>
                                </div>
                            </div>
                        </div>
                        <div class="my-2">
                            <label>Sertakan Foto ?</label>
                            <input type="file" class="form-control" name="thumbnail">
                        </div>
                        <div class="form-group row mt-4">
                            <div class="col">
                                <textarea class="form-control" name="comments" rows="6 " placeholder="Ulasan anda" maxlength="200"></textarea>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button class="btn py-2 px-3 btn-light" data-dismiss="modal">Batal
                            </button>
                            <button class="btn py-2 px-3 btn-success">Klaim
                            </button>
                        </div>
                    </div>
                </form>
            @else
                <div class="modal-body">
                    @foreach (App\Models\ReviewRating::where('id_service', $item->id)->where('id_user', Auth::user()->id)->get() as $rating)
                        @if ($rating->thumbnail != null)
                            <div class="form-group text-center">
                                <img src="{{ Storage::url($rating->thumbnail) }}" height="150px">
                            </div>
                            <hr>
                        @endif
                        <div class="form-group text-center">
                            <div class="ratings">
                                @for ($i = 1; $i <= $rating->star_rating; $i++)
                                    <i class="fa fa-star text-warning h1"></i>
                                @endfor
                            </div>
                        </div>

                        <div class="form-group">
                            <strong>Ulasan : </strong>
                            <p>{{ $rating->comments }}</p>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>
    </div>
</div>
