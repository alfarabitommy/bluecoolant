<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class WorksSubcategory extends Model
{
    protected $table = 'works_subcategory';
    protected $fillable = ['name','status','lang','category_id'];
}
