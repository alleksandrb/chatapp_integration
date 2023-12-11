<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LogMessage extends Model
{
    use HasFactory;
    protected $guarded = [];
    protected $table = 'log_messages';

    public static array $status = [
        'viewed' => 3,
        'sent' => 2,
        'delivered' => 1,
        'failed' => 0,
    ];
}
