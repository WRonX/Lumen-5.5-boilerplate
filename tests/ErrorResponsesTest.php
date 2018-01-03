<?php

class ErrorResponsesTest extends TestCase
{
    public function testAuthenticationRoute403NonExistingUser()
    {
        $this->json('POST', testRoute('authenticate_user'),
                    [
                        'email' => 'someStrangeUsername@OuterSpace',
                        'password' => 'thisReallyDoesntMatterHere',
                    ]);
        $this->assertResponseStatus(403);
    }
    
    public function testAuthenticateRoute406Response()
    {
        $this->post(testRoute('authenticate_user'));
        $this->assertResponseStatus(406);
    }
}