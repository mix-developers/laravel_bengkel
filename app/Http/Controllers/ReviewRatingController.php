<?php

namespace App\Http\Controllers;

use App\Models\Notifikasi;
use App\Models\ReviewRating;
use App\Models\Service;
use App\Models\ServiceFinished;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

use function PHPSTORM_META\type;

class ReviewRatingController extends Controller
{
    public function index()
    {
        $data = [
            'title' => 'Ulasan customers',
            'rating' => ReviewRating::latest()->get(),
        ];
        return view('pages.rating.index', $data);
    }
    public function store(Request $request)
    {
        $request->validate([
            'star_rating' => ['required', 'string', 'max:255'],
            'id_service' => ['required', 'string', 'max:255'],
        ]);
        //create rating
        $rating = new ReviewRating();
        $rating->id_service = $request->id_service;
        $rating->comments = $request->comments;
        $rating->star_rating = $request->star_rating;
        $rating->id_user = Auth::user()->id;
        if ($request->hasFile('thumbnail')) {
            $filename = Str::random(32) . '.' . $request->file('thumbnail')->getClientOriginalExtension();
            $file_path = $request->file('thumbnail')->storeAs('public/fotos', $filename);
        }
        $rating->thumbnail = isset($file_path) ? $file_path : null;

        //create service finish
        $serviceFinished = new ServiceFinished();
        $serviceFinished->id_service = $request->id_service;

        //create notifikasi
        $service = Service::find($request->id_service);
        foreach (User::where('role', 'admin')->get() as $item) {
            $notifikasi = new Notifikasi();
            $notifikasi->type = 'success';
            $notifikasi->url = '/rating';
            $notifikasi->id_user = $item->id;
            $notifikasi->content = Auth::user()->name . ' telah memberikan ulasan pada service ' . $service->code;
            $notifikasi->save();
        }

        if ($serviceFinished->save() && $rating->save()) {
            return redirect()->back()->with('success', 'Berhasil klaim');
        } else {
            return redirect()->back()->with('danger', 'Gagal klaim');
        }
    }
}
