<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class State extends Model
{
    use HasFactory;

    protected $fillable = ['name','slug'];

    public function cities()
    {
        return $this->hasMany(City::class);
    }

    //products belong to the state
    public function products()
    {
        return $this->hasMany(Product::class);
    }

    public function scopeSearch($query, $search)
    {
        return $query->where('name', 'like', '%'.$search.'%');
    }

}
