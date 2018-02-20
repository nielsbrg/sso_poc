<?php
/**
 * Created by PhpStorm.
 * User: Medewerker
 * Date: 19-2-2018
 * Time: 10:40
 */

interface TokenService
{
    public function generateToken($user);
}