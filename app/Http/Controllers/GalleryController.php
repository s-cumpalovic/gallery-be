<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateGalleryRequest;
use App\Models\Gallery;
use App\Models\Image;
use App\Models\Comment;
use Illuminate\Http\Request;

class GalleryController extends Controller
{
    public function index(Request $request)
    {
        $term = $request->input('term', '');
        return Gallery::query()->with('images', 'user')->SearchByTerm($term)->paginate(10);
    }

    public function store(CreateGalleryRequest $request)
    {
        $validated = $request->validated();

        $gallery = new Gallery();
        $gallery->title = $validated['title'];
        $gallery->description = $validated['description'];
        $gallery->user_id = $validated['user_id'];
        $gallery->save();

        foreach ($validated['images'] as $image) {
            $gallery->images()->save(
                new Image(['gallery_id' => $gallery->id, 'image_url' => $image])
            );
        }

        return $gallery;
    }

    public function show($id)
    {
        return Gallery::with(['user', 'images', 'comments.user'])->find($id);
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
