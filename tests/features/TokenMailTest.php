<?php

use App\{User, Token};
use Illuminate\Support\Facades\Mail;
use \Symfony\Component\DomCrawler\Crawler;

class TokenMailTest extends FeatureTestCase
{
    /**
     * @test
     */
    public function it_sends_a_link_with_the_token()
    {
        $user = new User([
            'first_name' => 'Victor',
            'last_name' => 'Hoyos',
            'email' => 'bikcodeh@gmail.com',
            'username' => 'bikcode'
        ]);

        $token = new Token([
            'token' => 'this-is-a-token',
            'user' => $user
        ]);
        
        $this->open(new \App\Mail\TokenMail($token))
            ->seeLink("{$token->url}", $token->url);

    }
    
    protected function open(\Illuminate\Mail\Mailable $mailable)
    {
        $transport = Mail::getSwiftMailer()->getTransport();
        $transport->flush();

        Mail::send($mailable);

        $message = $transport->messages()->first();

        $this->crawler = new Crawler($message->getBody());

        return $this;
    }
}
