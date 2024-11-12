<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Group extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
    ];

    public function user()
    {
       return $this->hasMany(User::class);
    }

    public function file()
    {
       return $this->hasMany(File::class);
    }



    public function users()
    {
        return $this->hasMany(User::class, 'user_group')
                    ->withPivot('role')
                    ->withTimestamps();
    }
}
