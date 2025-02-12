<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LabelingRule extends Model
{
    use HasFactory;

    protected $fillable = [
        'platform',
        'label',
        'metric',
        'condition',
        'value'
    ];
}
