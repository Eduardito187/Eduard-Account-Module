<?php

namespace Eduard\Account\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Eduard\Search\Models\IndexCatalog;
use Eduard\Search\Models\HistoryIndexProccess;
use Eduard\Search\Models\HistoryQuerySearch;
use Eduard\Account\Models\CustomersAccount;
use Eduard\Account\Models\NotificationsClient;
use Eduard\Account\Models\SupportClient;
use Eduard\Account\Models\ContactClient;
use Eduard\Mailing\Models\Mailing;
use Eduard\Analitycs\Models\Events;

class Client extends Model
{
    use HasFactory;

    protected $table = 'client';
    protected $fillable = [
        'name',
        'code',
        'count_attributes',
        'count_products',
        'count_index',
        'status',
        'limit_query',
        'limit_record',
        'limit_event'];
    protected $hidden = ['created_at', 'updated_at'];
    protected $primaryKey = 'id';
    public $incrementing = true;
    protected $keyType = 'integer';
    public $timestamps = false;

    /**
     * @inheritDoc
     */
    public function allEvents() {
        return $this->hasMany(Events::class, 'id_client', 'id');
    }

    /**
     * @inheritDoc
     */
    public function allMailing() {
        return $this->hasMany(Mailing::class, 'id_client', 'id');
    }

    /**
     * @inheritDoc
     */
    public function notificationClient() {
        return $this->hasOne(NotificationsClient::class, 'id_client', 'id');
    }

    /**
     * @inheritDoc
     */
    public function supportClient() {
        return $this->hasOne(SupportClient::class, 'id_client', 'id');
    }

    /**
     * @inheritDoc
     */
    public function contactClient() {
        return $this->hasOne(ContactClient::class, 'id_client', 'id');
    }

    /**
     * @inheritDoc
     */
    public function allCustomers() {
        return $this->hasMany(CustomersAccount::class, 'id_client', 'id');
    }

    /**
     * @inheritDoc
     */
    public function indexes() {
        return $this->hasMany(IndexCatalog::class, 'id_client', 'id');
    }

    /**
     * @inheritDoc
     */
    public function autorizationToken() {
        return $this->hasOne(AutorizationToken::class, 'id_client', 'id');
    }

    /**
     * @inheritDoc
     */
    public function historyIndex() {
        return $this->hasMany(HistoryIndexProccess::class, 'id_client', 'id');
    }

    /**
     * @inheritDoc
     */
    public function historyQuerySearch() {
        return $this->hasMany(HistoryQuerySearch::class, 'id_client', 'id');
    }

    /**
     * @inheritDoc
     */
    public function recentMonthHistoryQuerySearch() {
        return $this->hasMany(HistoryQuerySearch::class, 'id_client', 'id')->whereIn('code', ['feed_response', 'page_search_response'])->where('created_at', '>=', now()->subDays(30));
    }

    /**
     * @inheritDoc
     */
    public function recentMonthHistoryIndex() {
        return $this->hasMany(HistoryIndexProccess::class, 'id_client', 'id')->where('created_at', '>=', now()->subDays(30));
    }

    /**
     * @inheritDoc
     */
    public function recentMonthHistoryQuerySearchFeed() {
        return $this->hasMany(HistoryQuerySearch::class, 'id_client', 'id')->where('code', 'feed_response')->where('created_at', '>=', now()->subDays(30));
    }

    /**
     * @inheritDoc
     */
    public function recentMonthHistoryQuerySearchPage() {
        return $this->hasMany(HistoryQuerySearch::class, 'id_client', 'id')->where('code', 'page_search_response')->where('created_at', '>=', now()->subDays(30));
    }

    /**
     * @inheritDoc
     */
    public function recentMonthHistoryQuerySearchSuggestion() {
        return $this->hasMany(HistoryQuerySearch::class, 'id_client', 'id')->where('code', 'suggestion_feed_response')->where('created_at', '>=', now()->subDays(30));
    }
}