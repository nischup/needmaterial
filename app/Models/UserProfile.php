<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserProfile extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected $appends = ['reg_copy_doc_download', 'vat_copy_doc_download'];

    public function company()
    {
        return $this->belongsTo(Company::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function getRegCopyDocDownloadAttribute()
    {
        return $this->attributes['reg_copy_doc'] ? asset('storage/profile/' . $this->attributes['reg_copy_doc']) : null;
    }
    public function getVatCopyDocDownloadAttribute()
    {
        return $this->attributes['vat_copy_doc'] ? asset('storage/profile/' . $this->attributes['vat_copy_doc']) : null;
    }

}
