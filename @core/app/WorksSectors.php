<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class WorksSectors extends Model
{
    protected $table = 'works_sectors';
    protected $fillable = ['name','status','lang'];
}
