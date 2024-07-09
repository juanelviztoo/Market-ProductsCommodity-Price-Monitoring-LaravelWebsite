<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BotChatLog extends Model
{
    use HasFactory;

    protected $fillable = [
        'chat_id',
        'status',
        'mode',
        'selected_pasar'
    ];
}