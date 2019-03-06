<?php

class ExampleTest extends FeatureTestCase
{
  
    function test_basic_example()
    {
        $user = factory(\App\User::class)->create([
            'name'  => 'Bikcode Holes',
            'email' => 'adminCode@bik.com'

        ]);

        $this->actingAs($user, 'api');

        $this->visit('api/user')
             ->see('Bikcode Holes')
             ->see('adminCode@bik.com');
    }
}
