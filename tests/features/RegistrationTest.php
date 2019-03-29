<?php

use \App\{ User, Token } ;
use App\Mail\TokenMail;

use Illuminate\Support\Facades\Mail;

class RegistrationTest extends FeatureTestCase
{
    public function test_a_user_can_create_an_account()
    {
        Mail::fake();

        $this->visitRoute('register')
            ->type('admin@styde.net', 'email')
            ->type('bikcode', 'username')
            ->type('Victor', 'first_name')
            ->type('Hoyos', 'last_name')
            ->press('Registrate');

        $this->seeInDatabase('users', [
            'email' => 'admin@styde.net',
            'first_name' => 'Victor',
            'last_name' => 'Hoyos',
            'username' => 'bikcode'
        ]);

        $user = User::where('email', '=', 'admin@styde.net')->first();

        $this->seeInDatabase('tokens', [
            'user_id' => $user->id
        ]);

        $token = Token::where('user_id', $user->id)->first();

        $this->assertNotNull($token);

        Mail::assertSentTo($user, TokenMail::class, function ($mail) use ($token){
            return $mail->token->id == $token->id;
        });

        //TODO: finalizar esta parte de la prueba

        /*
        $this->seeRouteIs('register_confirmation')
            ->see('Gracias por registrarte')
            ->see('Enviamos a tu email un enlace para que inicies sesion');
        */
    }
}
