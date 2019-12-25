<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    protected $table = 'post';

    protected $fillable = [
    	'id',
    	'title',
    	'name',
    	'cost',
    	'producer',
    	'seats',
    	'view',
    	'detail',
    ];

    public function hasProduct()
    {
       return $this->hasOne('App\Product');
    }

    public function user()
    {
       return $this->belongsTo('App\User');
    }
}
