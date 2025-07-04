<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Job extends Model
{
    //
    protected $fillable = [
        'title',
        'description',
        'location',
        'created_by',
    ];

    public function creator()
{
    return $this->belongsTo(User::class, 'created_by');
}

}
