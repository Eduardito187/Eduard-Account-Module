<?php

namespace Eduard\Account\Http\Controllers\Api\Customer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Eduard\Account\Helpers\Account\Customer;

class Account extends Controller
{
    /**
     * @var Customer
     */
    protected $customer;

    /**
     * Constructor Account Customer
     */
    public function __construct(Customer $customer) {
        $this->customer = $customer;
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function closeSession(Request $request)
    {
        return response()->json(
            $this->customer->closeSession(
                $request->all(),
                $request->header()
            )
        );
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function getCustomerInformation(Request $request)
    {
        return response()->json(
            $this->customer->getCustomerInformation(
                $request->all(),
                $request->header()
            )
        );
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function customerValidateLogin(Request $request)
    {
        return response()->json(
            $this->customer->customerValidateLogin(
                $request->all(),
                $request->header()
            )
        );
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function customerResetPassword(Request $request)
    {
        return response()->json(
            $this->customer->customerResetPassword(
                $request->all(),
                $request->header()
            )
        );
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function generatePassword(Request $request)
    {
        return response()->json(
            $this->customer->generatePasswordCustomer(
                $request->all(),
                $request->header()
            )
        );
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function getDashboardData(Request $request)
    {
        return response()->json(
            $this->customer->getDashboardData(
                $request->all(),
                $request->header()
            )
        );
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function getInfraestructureData(Request $request)
    {
        return response()->json(
            $this->customer->getInfraestructureData(
                $request->all(),
                $request->header()
            )
        );
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function getAplicationData(Request $request)
    {
        return response()->json(
            $this->customer->getAplicationData(
                $request->all(),
                $request->header()
            )
        );
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function getMyAccount(Request $request)
    {
        return response()->json(
            $this->customer->getMyAccountData(
                $request->all(),
                $request->header()
            )
        );
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function getUsersTeam(Request $request)
    {
        return response()->json(
            $this->customer->getUsersTeamData(
                $request->all(),
                $request->header()
            )
        );
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function getSupportTeam(Request $request)
    {
        return response()->json(
            $this->customer->getSupportTeamData(
                $request->all(),
                $request->header()
            )
        );
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function getAllIndex(Request $request)
    {
        return response()->json(
            $this->customer->getAllIndex(
                $request->all(),
                $request->header()
            )
        );
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function getAllKeys(Request $request)
    {
        return response()->json(
            $this->customer->getAllKeys(
                $request->all(),
                $request->header()
            )
        );
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function getConfigNotifications(Request $request)
    {
        return response()->json(
            $this->customer->getConfigNotifications(
                $request->all(),
                $request->header()
            )
        );
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function setConfigNotifications(Request $request)
    {
        return response()->json(
            $this->customer->setConfigNotifications(
                $request->all(),
                $request->header()
            )
        );
    }
    /**
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function getConfigContacts(Request $request)
    {
        return response()->json(
            $this->customer->getConfigContacts(
                $request->all(),
                $request->header()
            )
        );
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function setConfigContacts(Request $request)
    {
        return response()->json(
            $this->customer->setConfigContacts(
                $request->all(),
                $request->header()
            )
        );
    }
}