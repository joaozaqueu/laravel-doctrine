<?php

namespace App\Http\Controllers\Auth;

use App\Entities\User;
use App\Http\Controllers\Controller;

use Doctrine\ORM\EntityManagerInterface;
use Illuminate\Foundation\Auth\ResetsPasswords;

class ResetPasswordController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Password Reset Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling password reset requests
    | and uses a simple trait to include this behavior. You're free to
    | explore this trait and override any methods you wish to tweak.
    |
    */

    use ResetsPasswords;

    /**
     * Where to redirect users after resetting their password.
     *
     * @var string
     */
    protected $redirectTo = '/home';

    protected $em;

    /**
     * ResetPasswordController constructor.
     * @param EntityManagerInterface $em
     */
    public function __construct(EntityManagerInterface $em)
    {
        $this->middleware('guest');
        $this->em = $em;
    }

    protected function resetPassword(User $user, $password)
    {
        $user->setPassword(bcrypt($password));
        $user->setRememberToken(Str::random(60));

        $this->em->persist($user);
        $this->em->flush();

        $this->guard()->login($user);
    }
}
