<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Image extends Model
{
    protected $fillable = [
        'gallery_id',
        'name',
        'image_url',
    ];

    use HasFactory;

    public function gallery()
    {
        return $this->belongsTo(Gallery::class);
    }
}
