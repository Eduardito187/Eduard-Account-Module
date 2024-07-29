<?php

namespace Eduard\Account\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Eduard\Account\Helpers\Account\Customer;
use Eduard\Account\Models\PasswordReset;

class PasswordResetController extends Controller
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

    public function showResetForm($token)
    {
        return view('frontend.account.reset.restore-password', ['token' => $token]);
    }

    public function reset(Request $request)
    {
        $request->validate([
            'token' => 'required',
            'password' => 'required',
            'password_confirmation' => 'required'
        ]);

        $passwordReset = PasswordReset::where('token', $request->token)->active()->first();
        
        if (strlen($request->password) < 8) {
            return back()->withErrors(['password' => 'La contraseña no cumple con los parametros de seguridad.']);
        }
        
        if ($request->password != $request->password_confirmation) {
            return back()->withErrors(['password' => 'La contraseña de confirmación no coinciden.']);
        }

        if (!$passwordReset || Carbon::parse($passwordReset->created_at)->addMinutes(10)->isPast()) {
            return back()->withErrors(['account' => 'El link es invalido o ha expirado.']);
        }

        $user = $this->customer->getCustomerByMail($passwordReset->email);

        if (!$user) {
            return back()->withErrors(['account' => 'Cuenta invalida.']);
        }

        $user->password = $this->customer->encryptedPawd($request->password);
        $user->save();
        $this->customer->sendEventConfirmRestorePassword($passwordReset->email);
        $passwordReset->delete();

        return redirect('/login')->with('message-success', '¡Tu contraseña ha sido restablecida!');
    }
}