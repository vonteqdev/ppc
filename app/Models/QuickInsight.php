<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class QuickInsight extends Model
{
    use HasFactory;

    protected $fillable = ['message', 'importance', 'timestamp'];

    public $timestamps = false;
}
