<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CatalogueImage extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected $appends =[
        'src_original'
    ];

    public $timestamps = false;

    public function getSrcAttribute()
    {
        return $this->attributes['src'] ? asset('storage/' . $this->attributes['src']) : asset('frontend\images\product-placeholder.webp');
    }

    public function getSrcOriginalAttribute()
    {
        return $this->attributes['src'];
    }

    public function catalogue()
    {
        return $this->belongsTo(Catalogue::class, 'catalogue_id','id');
    }
}
