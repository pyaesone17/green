<?php 
namespace Green\Support;

class PasswordHasher
{
    public static function hash($plainPassword)
    {
        $hashedPassword = password_hash($plainPassword, PASSWORD_DEFAULT);
        return $hashedPassword;
    }

    public static function verify($plainPassword, $hashedPassword)
    {
        return password_verify($plainPassword, $hashedPassword);
    }
}
