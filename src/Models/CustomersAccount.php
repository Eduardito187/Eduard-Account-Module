<?php

namespace Eduard\Account\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Eduard\Account\Models\Client;
use Eduard\Account\Models\CustomerAccountInformation;

class CustomersAccount extends Model
{
    use HasFactory;

    protected $table = 'customers_account';
    protected $fillable = [
        'mail',
        'password',
        'status',
        'name_github',
        'github_id',
        'avatar_github',
        'github_nickname',
        'token_github',
        'name_google',
        'google_id',
        'avatar_google',
        'token_google',
        'google_refresh_token'
    ];
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

    /**
     * @inheritDoc
     */
    public function customerAccountInformation() {
        return $this->hasOne(CustomerAccountInformation::class, 'id_customers_account', 'id');
    }
}