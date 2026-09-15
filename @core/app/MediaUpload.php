<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MediaUpload extends Model
{
    use HasFactory;

    protected $table = "media_uploads";
    protected $fillable = ['title','alt','size','path','dimensions'];
}
