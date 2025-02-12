<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FeedExport extends Model
{
    use HasFactory;

    protected $fillable = [
        'name', 'platform', 'export_url', 'columns', 'filters'
    ];

    protected $casts = [
        'columns' => 'array',
        'filters' => 'array'
    ];
}
