<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Department extends Model
{
    protected $fillable = [
        'name',
        'company_id'
    ];

    public function company()
    {
        return $this->belongsTo(Company::class, 'company_id', 'id');

    }
    public function users()
    {
        return $this->hasOne(User::class);
    }
}
