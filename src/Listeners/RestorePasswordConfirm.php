<?php

namespace Eduard\Account\Listeners;

use Eduard\Account\Events\SendEmailConfirmRestorePassword;
use Eduard\Account\Helpers\Account\Customer;
use Illuminate\Contracts\Queue\ShouldQueue;

class RestorePasswordConfirm implements ShouldQueue
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
    public string $queue = 'restore_password_confirm';

    /**
     * @var Customer
     */
    protected $customer;

    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct(Customer $customer)
    {
        $this->customer = $customer;
    }

    /**
     * Handle the event.
     *
     * @param SendEmailConfirmRestorePassword $event
     * @return void
     */
    public function handle(SendEmailConfirmRestorePassword $event)
    {
        $this->customer->sendConfirmRestorePassword(
            $event->email
        );
    }
}