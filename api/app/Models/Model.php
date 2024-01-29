<?php

namespace App\Models;

use Watson\Rememberable\Rememberable;
use Illuminate\Database\Eloquent\Model as BaseModel;

class Model extends BaseModel
{
    use Rememberable;
}
