<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{

    use SoftDeletes;

    protected $dates=['deleted_at'];

    protected $casts=[
      'market_element'=>'json',
      'guess_like'=>'json'
    ];

    protected $fillable=['id','name','logo','market_element','corner_id','slogan','rate_unit','rate_value','repay_unit','repay_min','repay_max',
        'quota_min','quota_max','fast_lend_unit','fast_lend_value','success_rate','redirect_url','apply_condition','auto_down_sale_num','status',
        'sort','base_apply_num','guess_like','deal_type','deal_price','first_onsale_at','district_limit','district_code','fast_lend_sort','control_volume','auto_up_date','pc_sort','pc_hot'];
    //
    public function corner(){

        return $this->belongsTo(Corner::class,'corner_id','id');
    }

    public function material(){

        return $this->belongsToMany(ProductMaterial::class,'product_has_materials','product_id','material_id');
    }

    public function label(){

        return $this->belongsToMany(ProductLabel::class,'product_has_labels','product_id','label_id');
    }

    public function category(){

        return $this->belongsToMany(ProductCategory::class,'product_has_categories','product_id','category_id');
    }

    public function column(){

        return $this->belongsToMany(ProductColumn::class,'product_has_columns','product_id','column_id');
    }

    public function district(){

        return $this->belongsToMany(District::class,'product_has_districts','product_id','district_id');

    }

    public function platform(){

        return $this->hasMany(ProductPlatform::class,'product_id','id');

    }

    public function newLabel(){

        return $this->belongsToMany(Label::class,'label_has_products','product_id','label_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     * 区域限制
     */
    public function limitDistrict(){
        return $this->hasMany(ProductDistrict::class,'product_id','id');
    }



    //产品评价
    public function productComment()
    {
        return $this->hasOne(Comment::class,'product_id','id');
    }


}
