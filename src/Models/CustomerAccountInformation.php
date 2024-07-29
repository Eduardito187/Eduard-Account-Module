<?php

namespace Eduard\Account\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CustomerAccountInformation extends Model
{
    use HasFactory;

    protected $table = 'customer_account_information';
    protected $fillable = ['first_name', 'last_name', 'phone_number', 'company'];
    protected $hidden = ['id_customers_account', 'created_at', 'updated_at'];
    protected $primaryKey = 'id';
    public $incrementing = true;
    protected $keyType = 'integer';
    public $timestamps = false;
}