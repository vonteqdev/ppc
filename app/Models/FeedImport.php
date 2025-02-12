<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FeedImport extends Model
{
    use HasFactory;

    protected $fillable = [
        'name', 'source', 'type', 'frequency', 'last_fetched_at'
    ];
}
