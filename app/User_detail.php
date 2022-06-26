<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class User_detail extends Model
{
    protected $fillable = [
        'phone_number',
        'address',
        'user_id'

    ];


    public function users()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');

    }
}
