<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class WorksPackaging extends Model
{
    protected $table = 'works_packaging';
    protected $fillable = ['name'];

    public function getCategoriesIdAttribute($value){
        return unserialize($value);
    }
}
