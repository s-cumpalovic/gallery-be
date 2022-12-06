<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateGalleryRequest;
use App\Models\Gallery;
use Illuminate\Http\Request;

class GalleryController extends Controller
{
    public function index()
    {
        return Gallery::with('images')->get();
    }

    public function store(CreateGalleryRequest $request)
    {
        $validated = $request->validated();

        $gallery = new Gallery();
        $gallery->title = $validated['title'];
        $gallery->description = $validated['description'];
        $gallery->save();
        
        return $gallery;
    }

    public function show($id)
    {
        return Gallery::with('images')->find($id);
    }

    public function update(CreateGalleryRequest $request, $id)
    {
        $validated = $request->validated();
        $gallery = Gallery::find($id);
        $gallery->title = $validated['title'];
        $gallery->description = $validated['description'];
        $gallery->save();
        
        return $gallery;
    }

    public function destroy($id)
    {
        return Gallery::find($id)->delete();
    }
}
