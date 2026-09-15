<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class HeaderSlider extends Model
{
    protected $table = 'header_sliders';
    protected $fillable = ['title','lang','description','btn_01_status','btn_02_status','btn_01_text','btn_02_text','btn_01_url','btn_02_url','image'];
}
