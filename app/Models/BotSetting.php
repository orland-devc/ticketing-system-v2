<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BotSetting extends Model
{
    protected $fillable = [
        'name',
        'profile_picture',
        'system_prompt',
        'greeting_message',
        'error_message',
    ];
}
