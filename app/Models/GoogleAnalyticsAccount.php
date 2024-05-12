<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GoogleAnalyticsAccount extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public function googleAccount()
    {
        return $this->belongsTo(GoogleAccount::class);
    }

    public function properties()
    {
        return $this->hasMany(GoogleAnalyticsProperty::class);
    }
}
