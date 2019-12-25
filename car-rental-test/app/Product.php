<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $table = 'product';

    protected $fillable = [
    	'id',
    	'title',
        'name',
    	'cost',
        'producer',
        'seats',
        'url_image',
    ];

    public function Post()
    {
       return $this->belongsTo('App\User');
    }
}
