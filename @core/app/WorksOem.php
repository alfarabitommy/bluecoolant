<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class WorksOem extends Model
{
    protected $table = 'works_oem';
    protected $fillable = ['spec','approval'];

    public function getCategoriesIdAttribute($value){
        return unserialize($value);
    }
}
