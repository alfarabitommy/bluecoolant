<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Works extends Model
{
    protected $table = 'works';
    protected $fillable = ['title','lang','categories_id','category_id','sectors_id','gallon','jerrycan','drum','ibc','file','start_date','end_date','location','clients','description','image','slug','meta_title','meta_tags','meta_description','gallery','status','oem_id','industry_id','packaging_id','benefit','subcategory_id','tds'];

    public function getCategoriesIdAttribute($value){
        return unserialize($value);
    }
}
