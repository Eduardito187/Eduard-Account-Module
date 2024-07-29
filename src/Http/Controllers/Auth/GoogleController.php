<?php

namespace Eduard\Account\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Laravel\Socialite\Facades\Socialite;
use Eduard\Account\Helpers\Account\Customer;
use Exception;
use Illuminate\Http\Request;

class GoogleController extends Controller
{
    /**
     * @var Customer
     */
    protected $customer;

    /**
     * Constructor Auth PasswordResetController
     */
    public function __construct(Customer $customer) {
        $this->customer = $customer;
    }

    /**
     * Redirect the user to the GitHub authentication page.
     *
     * @return \Illuminate\Http\Response
     */
    public function redirectToProvider(Request $request)
    {
        return Socialite::driver('google')->redirect();
    }

    /**
     * Obtain the user information from GitHub.
     *
     * @return \Illuminate\Http\Response
     */
    public function handleProviderCallback(Request $request)
    {
        try {
            $googleUser = Socialite::driver('google')->stateless()->user();

            if ($googleUser == null) {
                return redirect('/login')->with('error-danger', "Lo sentimos, no logramos recolectar información de Google.");
            }

            if ($googleUser->email == null) {
                return redirect('/login')->with('error-danger', "Lo sentimos, tu e-mail de Google se encuentra privado.");
            }

            $customerAccount = $this->customer->getCustomerByMail($googleUser->email);

            if ($customerAccount == null) {
                return redirect('/login')->with('error-danger', "El email ".$googleUser->email." no se encuentra asociado a una cuenta.");
            }

            $customerAccount->name_google = $googleUser->name;
            $customerAccount->google_id = $googleUser->id;
            $customerAccount->avatar_google = $googleUser->avatar;
            $customerAccount->token_google = $googleUser->token;
            $customerAccount->google_refresh_token = $googleUser->refreshToken;
            $customerAccount->save();
        } catch (Exception $e) {
            return redirect('/login')->with('error-danger', $e->getMessage());
        }

        return redirect()->intended('/home')->with('message-success', 'Sesión iniciada exitosamente por Google.');
    }
}