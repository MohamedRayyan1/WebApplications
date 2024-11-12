<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class File extends Model
{
    use HasFactory;

    protected $fillable = [
        'fileName',
        'status',
        'user_id',
        'filePath',
        'group_id',
    ];

    public function reservation()
{
    return $this->hasMany(Reservation::class);
}

public function versions()
{
    return $this->hasMany(FileVersion::class);
}

public function groups()
{
    return $this->belongsTo(Group::class);
}
public function user()
{
    return $this->belongsTo(User::class);
}

}

