<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PpcAttribution extends Model
{
    use HasFactory;

    protected $table = 'ppc_attribution'; // ✅ Fix table name

    protected $fillable = [
        'platform',
        'clicks',
        'conversions',
        'cost',
        'revenue',
        'roas',
        'date'
    ];
}
