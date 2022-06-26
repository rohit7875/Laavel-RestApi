<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Company extends Model
{
    protected $fillable = [
        'name'
    ];

    public function department()
    {
        return $this->hasMany(Department::class);
    }

}
