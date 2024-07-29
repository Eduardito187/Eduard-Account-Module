<?php

namespace Eduard\Account\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Eduard\Account\Models\Client;

class NotificationsClient extends Model
{
    use HasFactory;

    protected $table = 'notifications_client';
    protected $fillable = ['report_day', 'report_month', 'alert_usage', 'alert_billing', 'ai'];
    protected $hidden = ['id_client', 'created_at', 'updated_at'];
    protected $primaryKey = 'id';
    public $incrementing = true;
    protected $keyType = 'integer';
    public $timestamps = false;

    /**
     * @inheritDoc
     */
    public function client() {
        return $this->hasOne(Client::class, 'id', 'id_client');
    }
}