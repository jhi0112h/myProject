<?php

namespace App\Components\Sign\Models;

use Illuminate\Database\Eloquent\Model;

class ProductProcess extends Model
{

    public function sign()
    {
        return $this->belongsTo('App\Components\Sign\Models\Sign', 'sign_id');
    }
}
