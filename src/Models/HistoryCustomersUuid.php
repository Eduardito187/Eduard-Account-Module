<?php

namespace Eduard\Account\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HistoryCustomersUuid extends Model
{
    use HasFactory;

    protected $table = 'history_customers_uuid';
    protected $fillable = ['ip', 'customer_uuid'];
    protected $hidden = ['created_at', 'updated_at'];
    protected $primaryKey = 'id';
    public $incrementing = true;
    protected $keyType = 'integer';
    public $timestamps = false;
}