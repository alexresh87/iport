<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    //protected $fillable = ['id','title'];
    protected $guarded = [];

    public function offers()
    {
        return $this->hasMany(Offer::class, 'categoryId');
    }

    public function insert($category_data)
    {
        $category = Category::firstOrNew(['id' => $category_data['id']]);
        foreach ($category_data as $key => $item) {
            if ($key == "id") continue;
            $category->$key = $item;
        }
        $category->save();
        
        return $this;
    }

    public static function deleteAll()
    {
        foreach (Category::cursor() as $category) {
            $category->delete();
        }
    }
}
