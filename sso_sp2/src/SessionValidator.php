<?php

require('SessionValidation.php');

class SessionValidator implements SessionValidation
{
    private $ssoLocation;

    public function __construct($ssoLocation) {
        $this->ssoLocation = $ssoLocation;
    }

    public function isUserAuthenticated()
    {
        if(isset($_COOKIE['access_token'])) {
            return true;
        }
        else {
            //TODO: Check with SSO store to see if token has been granted
            return false;
        }
    }

    public function validate($token)
    {

    }
}