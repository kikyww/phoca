<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Photo extends Model
{
    use HasFactory;
    protected $fillable = [
        'photo_url',
        'photo_path',
        'filename',
        'mime_type',
        'size',
        'order',
    ];


    public function status()
    {
        return $this->belongsTo(Status::class);
    }
}
