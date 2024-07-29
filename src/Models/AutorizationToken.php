<?php

namespace Eduard\Account\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Eduard\Search\Models\AccessIndex;
use Eduard\Account\Models\Client;

class AutorizationToken extends Model
{
    use HasFactory;

    protected $table = 'autorization_token';

    protected $fillable = ['name', 'token', 'status', 'id_client'];
    protected $hidden = ['created_at', 'updated_at'];
    protected $primaryKey = 'id';
    public $incrementing = true;
    protected $keyType = 'integer';
    public $timestamps = false;

    /**
     * @inheritDoc
     */
    public function indexAccess() {
        return $this->hasMany(AccessIndex::class, 'id_autorization_token', 'id');
    }

    /**
     * @inheritDoc
     */
    public function client() {
        return $this->hasOne(Client::class, 'id', 'id_client');
    }
}