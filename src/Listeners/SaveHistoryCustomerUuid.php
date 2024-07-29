<?php

namespace Eduard\Account\Listeners;

use Eduard\Account\Events\HistoryCustomerUuid;
use Eduard\Account\Helpers\System\CoreHttp;
use Illuminate\Contracts\Queue\ShouldQueue;

class SaveHistoryCustomerUuid implements ShouldQueue
{
    /**
     * The name of the connection the job should be sent to.
     *
     * @var string|null
     */
    public string $connection = 'database';

    /**
     * The name of the queue the job should be sent to.
     *
     * @var string|null
     */
    public string $queue = 'save_history_customer_uuid';

    /**
     * @var CoreHttp
     */
    protected $coreHttp;

    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct(CoreHttp $coreHttp)
    {
        $this->coreHttp = $coreHttp;
    }

    /**
     * Handle the event.
     *
     * @param  \Eduard\Account\Events\HistoryCustomerUuid  $event
     * @return void
     */
    public function handle(HistoryCustomerUuid $event)
    {
        $this->coreHttp->setCustomerHistoryUuid(
            $event->ip,
            $event->customerUuid
        );
    }
}