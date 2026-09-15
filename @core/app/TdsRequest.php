<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TdsRequest extends Model
{
    protected $table = 'tds_request';
    protected $fillable = ['works_id','name','email','company'];

    public function getCategoriesIdAttribute($value){
        return unserialize($value);
    }
}
