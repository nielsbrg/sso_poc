<?php

interface SessionValidation
{
    public function isUserAuthenticated();
    public function validate($token);
}