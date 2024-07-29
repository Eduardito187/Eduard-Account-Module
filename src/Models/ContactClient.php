<?php

namespace Eduard\Account\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Eduard\Account\Models\Client;

class ContactClient extends Model
{
    use HasFactory;

    protected $table = 'contact_client';
    protected $fillable = ['name_privacy', 'phone_privacy', 'mail_privacy', 'mail_security'];
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