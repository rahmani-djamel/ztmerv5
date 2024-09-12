<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class City extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'state_id','slug'];

    public function state()
    {
        return $this->belongsTo(State::class);
    }

    public function scopeSearch($query, $search)
    {
        return $query->where('name', 'like', "%{$search}%")
                     ->orWhereHas('state', function ($query) use ($search) {
                         $query->where('name', 'like', "%{$search}%");
                     });
    }


    public function scopeWithState($query)
    {
        return $query->with('state');
    }



}
