<?php
/**
 * Created by PhpStorm.
 * User: Medewerker
 * Date: 16-2-2018
 * Time: 15:12
 */

interface ValidationService
{
    /** Validates whether a user is valid based on given user input.
     * @param $userInput This data has to be to validated.
     * @return bool return whether user is valid
     */
    public function validate($userInput);
}