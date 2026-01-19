<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BusinessFeature extends Model
{
    protected $table = 'business_features';

    // ✅ icon class removed, image added
    protected $fillable = [
        'business_id',
        'feature_id',
        'feature_name',
        'feature_image',
    ];

    public function business()
    {
        return $this->belongsTo(BusinessListing::class, 'business_id');
    }

    public function feature()
    {
        return $this->belongsTo(\App\Models\Feature::class, 'feature_id');
    }
}
