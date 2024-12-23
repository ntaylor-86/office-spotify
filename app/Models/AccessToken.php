<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AccessToken extends Model
{
    protected function casts(): array
    {
        return [
            'expirationTime' => 'datetime:Y-m-d H:i:s'
        ];
    }
}
