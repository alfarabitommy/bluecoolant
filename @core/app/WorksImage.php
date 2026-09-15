<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class WorksImage extends Model
{
    protected $table = 'works_image';
    protected $fillable = ['works_id','image','lang'];

    public function getCategoriesIdAttribute($value){
        return unserialize($value);
    }
}
