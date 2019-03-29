<?php

use Illuminate\Support\Facades\Mail;
use App\Token;

class AuthenticationTest extends FeatureTestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    public function test_a_guest_user_can_request_a_token()
    {
        //Having
        Mail::fake();

        $user = $this->defaultUser([
            'email' => 'admin@styde.net',
            'username' => 'bikcode'
        ]);

        //When
        $this->visitRoute('login')
            ->type('admin@styde.net', 'email')
            ->press('Solicitar token');
        

        //Then: a new token is created in the database
        $token = Token::where('user_id', $user->id)->first();

        $this->assertNotNull($token, 'A token was no created');

        //And sent to the user
        Mail::assertSentTo($user, \App\Mail\TokenMail::class, function ($mail) use ($token){
            return $mail->token->id === $token->id;
        });

        $this->dontSeeIsAuthenticated();

        $this->see('Enviamos a tu email un enlace para que inices sesion.');
        
    }

    public function test_a_guest_user_can_request_a_token_without_an_email()
    {
        //Having
        Mail::fake();

        //When
        $this->visitRoute('login')
            ->press('Solicitar token');
        

        //Then: a new token is NOT created in the database
        $token = Token::first();

        $this->assertNull($token, 'A token was created');

        //And sent to the user
        Mail::assertNotSent(\App\Mail\TokenMail::class);

        $this->dontSeeIsAuthenticated();

        $this->seeErrors([
            'email' => 'El campo correo electrónico es obligatorio'
        ]); 
    }

    public function test_a_guest_user_can_request_a_token_with_an_invalid_email()
    {
        //When
        $this->visitRoute('login')
            ->type('Silence', 'email')
            ->press('Solicitar token');

        $this->seeErrors([
            'email' => 'correo electrónico no es un correo válido'
        ]); 
    }

    public function test_a_guest_user_can_request_a_token_with_a_non_existent_email()
    {
        $user = $this->defaultUser([
            'email' => 'admin@styde.net',
            'username' => 'bikcode'
        ]);

        //When
        $this->visitRoute('login')
            ->type('silence@styde.net', 'email')
            ->press('Solicitar token');

        $this->seeErrors([
            'email' => 'Este correo electrónico no existe.'
        ]); 
    }
}
