<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ResponsibleEmployee extends Model
{
    protected $table = 'responsible_employees';

    protected $fillable = [
        'name',
        'email',
        'type',
    ];

}
