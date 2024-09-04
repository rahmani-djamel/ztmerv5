<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use HasFactory,SoftDeletes;

    protected $fillable = [
        'name',
        'description',
        'price',
        'qte',
        'category_id',
        'unit_id',
        'state_id',
        'city_id',
        'user_id',
    ];

        // Define relationships
        public function category()
        {
            return $this->belongsTo(Category::class);
        }
    
        public function unit()
        {
            return $this->belongsTo(Unit::class);
        }
    
        public function state()
        {
            return $this->belongsTo(State::class);
        }
    
        public function city()
        {
            return $this->belongsTo(City::class);
        }
    
        public function user()
        {
            return $this->belongsTo(User::class, 'auth_id');
        }

        public function media()
        {
            return $this->morphMany(File::class, 'fileable');
        }

        public function scopeSearch($query, $search)
        {
            return $query->where(function ($query) use ($search) {
                $query->where('name', 'like', '%' . $search . '%')
                    ->orWhere('description', 'like', '%' . $search . '%');
            });
        }

        //scope get products based on role 
        public function scopeRole($query)
        {
            return auth()->user()->hasRole('Vendor') ? $query->where('user_id', auth()->id()) : $query;
        }


}
