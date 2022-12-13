<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Comment;

class CommentsController extends Controller
{
    public function destroy($id)
    {
        return Comment::find($id)->delete();
    }
}
