<?php
/**
 * Created by PhpStorm.
 * User: Medewerker
 * Date: 19-2-2018
 * Time: 10:45
 */

interface MigrationService
{
    /** Gets the user from the SSO database based on an origin URL and user input.
     * @param $originURL string - domain name that was accessed by the user before redirected to the IDP.
     * @param $userInput array - user input that was given for the authentication
     * @return User model or NULL depending on whether the user for the input exists.
     */
    public function getUser($originURL, $userInput);

    /** Checks with migration API for a given system and tries to validate the user input there.
     *  Saves user in SSO database if external validation was a success.
     * @param $system_id int - id from the system where the user is from
     * @param $userInput array - provided user input
     * @return User model if validation was successful or NULL when not successful.
     */
    public function migrateUser($system_id, $userInput);
}