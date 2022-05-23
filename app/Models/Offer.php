<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Offer extends Model
{
    use HasFactory;

    protected $guarded = [];
    //protected $fillable = ['id', 'categoryId', 'model', 'url', 'price'];


    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function pictures()
    {
        return $this->hasMany(Picture::class, 'offer_id');
    }

    public function params()
    {
        return $this->hasMany(Param::class, 'offer_id');
    }

    public function insert($offer_data)
    {
        //$offer = new Offer;
        $offer = Offer::firstOrNew(['id' => $offer_data['id']]);
        foreach ($offer_data as $key => $item) {
            //if ($key == "id") continue;
            if ($key == "pictures") continue;
            if ($key == "params") continue;
            if ($key == "delivery-options") {
                $item = json_encode($item);
            };
            $offer->$key = $item;
        }
        $offer->save();
        $offer = Offer::find($offer_data['id']);

        //Добавляем все картинки товара
        if (isset($offer_data['pictures'])) {
            foreach ($offer_data['pictures'] as $url) {
                $offer->insertPicture($url);
            }
        }

        //Добавляем все параметры товара
        if (isset($offer_data['params'])) {
            foreach ($offer_data['params'] as $key => $param) {
                $offer->insertParam($key, $param);
            }
        }

        return $this;
    }

    /**
     * insertPicture
     *
     * @param  mixed $url
     * @return Picture
     */
    public function insertPicture($url): Picture
    {
        return Picture::create([
            'offer_id' => $this->id,
            'url' => $url
        ]);
    }
    
    /**
     * insertParam
     *
     * @param  mixed $param_name
     * @param  mixed $param_value
     * @return void
     */
    public function insertParam($param_name, $param_value)
    {
        $param_data = ParamData::firstOrNew(['title' => $param_name]);
        $param_data->save();
        $param_data = ParamData::where('title', $param_name)->first();

        return Param::create([
            'offer_id' => $this->id,
            'param_id' => $param_data->id,
            'value' => $param_value
        ]);
    }


    /**
     * deleteAll
     *
     * @return bool
     */
    public static function deleteAll(): bool
    {
        foreach (Offer::cursor() as $offer) {
            $offer->delete();
        }
        return true;
    }
}
