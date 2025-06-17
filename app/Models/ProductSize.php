<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use App\Models\Product;
use App\Models\CategorySize;

class ProductSize extends Model
{
    protected $fillable = ['product_id', 'category_size_id', 'price'];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function categorySize()
    {
        return $this->belongsTo(CategorySize::class);
    }
}