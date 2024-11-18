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

    public function user_group()
    {
        return $this->hasMany(User_Group::class);
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
