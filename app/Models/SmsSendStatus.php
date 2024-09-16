<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SmsSendStatus extends Model
{
    public $timestamps = false;
    protected $table = 'sms_send_status';
}
