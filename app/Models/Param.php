<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Param extends Model
{
    use HasFactory;

    protected $fillable = ['offer_id', 'param_id', 'value'];
    protected $guarded = [];

    public function offer()
    {
        return $this->belongsTo(Offer::class);
    }

    public function paramdata()
    {
        return $this->hasMany(ParamData::class, 'id', 'param_id');
    }

    public function getNameById($id){
        $param_data = new ParamData;
        $result = $param_data->find($id);
        return $result;
    }
}
