<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class WorksIndustry extends Model
{
    protected $table = 'works_industry';
    protected $fillable = ['spec','approval'];

    public function getCategoriesIdAttribute($value){
        return unserialize($value);
    }
}
