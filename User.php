<?php

/**
 * Created by PhpStorm.
 * User: elaela
 * Date: 24.11.2015
 * Time: 16:08
 */
class User
{
    public $username;
    public $email;
    public function __construct($username, $email)
    {
        $this->username = $username;
        $this->email = $email;
    }
}