<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateGalleryRequest;
use App\Models\Gallery;
use App\Models\Image;
use App\Models\Comment;
use App\Models\User;

use Illuminate\Http\Request;

class GalleryController extends Controller
{
    public function index(Request $request)
    {
        $term = $request->input('term', '');
        $userID = $request->input('userId', '');

        if ($userID) {
            return Gallery::query()->with('images', 'user')->SearchByUser($userID)->orderBy('id', 'desc')->paginate(10);
        }
        return Gallery::query()->with('images', 'user')->SearchByTerm($term)->orderBy('created_at', 'desc')->paginate(10);
    }

    public function store(CreateGalleryRequest $request)
    {

        if ($request->has('title') || $request->has('description')) {
            $validated = $request->validated();
            $gallery = new Gallery();
            $gallery->title = $validated['title'];
            $gallery->description = $validated['description'];
            $gallery->user_id = $validated['user_id'];
            $gallery->save();

            foreach ($validated['images'] as $image) {
                $gallery->images()->saveMany([
                    new Image(['gallery_id' => $gallery->id, 'image_url' => $image])
                ]);
            }
            return $gallery;
        }

        if ($request->has('body')) {
            $comment = new Comment([
                'body' => $request['body'],
                'user_id' => $request['user_id']
            ]);

            $gallery = Gallery::find($request['gallery_id']);
            $user = User::find($request['user_id']);
            $gallery->comments()->save($comment);
            $user->comments()->save($comment);

            return $comment;
        }


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
