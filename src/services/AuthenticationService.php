<?php
interface AuthenticationService
{
    public function auth($origin, $userInput);
    public function accessUserDetails($systemId, $userInput);
}