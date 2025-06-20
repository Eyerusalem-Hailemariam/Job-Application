<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Application extends Model
{
    //
    protected $fillable = [
        'applicant_id',
        'job_id',
        'resume_link',
        'cover_letter',
        'status',
    ];
}
