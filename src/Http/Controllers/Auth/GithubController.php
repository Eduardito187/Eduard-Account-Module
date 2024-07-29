<?php

namespace Eduard\Account\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Laravel\Socialite\Facades\Socialite;
use Eduard\Account\Helpers\Account\Customer;
use Exception;
use Illuminate\Http\Request;

class GithubController extends Controller
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
        return Socialite::driver('github')->redirect();
    }

    /**
     * Obtain the user information from GitHub.
     *
     * @return \Illuminate\Http\Response
     */
    public function handleProviderCallback(Request $request)
    {
        try {
            $githubUser = Socialite::driver('github')->stateless()->user();

            if ($githubUser == null) {
                return redirect('/login')->with('error-danger', "Lo sentimos, no logramos recolectar información de GitHub.");
            }

            if ($githubUser->email == null) {
                return redirect('/login')->with('error-danger', "Lo sentimos, tu e-mail de GitHub se encuentra privado.");
            }

            $customerAccount = $this->customer->getCustomerByMail($githubUser->email);

            if ($customerAccount == null) {
                return redirect('/login')->with('error-danger', "El email ".$githubUser->email." no se encuentra asociado a una cuenta.");
            }

            $customerAccount->name_github = $githubUser->name;
            $customerAccount->github_id = $githubUser->id;
            $customerAccount->avatar_github = $githubUser->avatar;
            $customerAccount->token_github = $githubUser->token;
            $customerAccount->github_nickname = $githubUser->nickname;
            $customerAccount->save();
        } catch (Exception $e) {
            return redirect('/login')->with('error-danger', $e->getMessage());
        }

        return redirect()->intended('/home')->with('message-success', 'Sesión iniciada exitosamente por GitHub.');
    }
}