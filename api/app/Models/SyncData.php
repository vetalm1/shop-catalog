<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SyncData extends Model
{

    protected $table = 'sync_data';

    protected $fillable = ['text', 'type', 'request', 'data'];

}
