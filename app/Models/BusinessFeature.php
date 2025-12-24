<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BusinessFeature extends Model
{
    protected $table = 'business_features';

    protected $fillable = ['business_id', 'feature_id', 'feature_name'];

    public function business()
    {
        return $this->belongsTo(BusinessListing::class, 'business_id');
    }
}
