<?php
interface AuthenticationService
{
    /** Authenticate the user based on input.
     * @param $origin The original protected resource the user was trying to access.
     * @param $userInput The user input that has to be checked
     * @return bool Returns TRUE when the user input was valid and FALSE when it was not.
     */
    public function auth($origin, $userInput);
}