<?php
interface AuthenticationService
{
    /** Authenticate the user based on input.
     * @param $system_id INT - original protected resource the user was trying to access.
     * @param $userInput array - user input array with credentials that have to be validated
     * @return bool Returns TRUE when the user input was valid and FALSE when it was not.
     */
    public function auth($system_id, $userInput);
}