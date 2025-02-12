<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'name', 'price', 'clicks', 'views', 'roas', 'profit_margin', 'added_to_cart'
    ];

    public function labels()
    {
        return $this->hasMany(ProductLabel::class);
    }
}
