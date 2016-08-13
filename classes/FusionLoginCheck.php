<?php

namespace Jhendess\FusionAuth\Classes;

class FusionLoginCheck {

    /**
     * Check a given password using PHP Fusion's default authentication.
     * @param $password string password to hash.
     * @param $passwordHash string hashed password from PHP Fusion
     * @param $algorithm string algorithm used for hashing.
     * @param $salt string salt for hashing.
     * @return bool true, if the password equals the hashed data correctly.
     */
    public static function checkPassword($password, $passwordHash, $salt, $algorithm) {
        $hash = self::hashPassword($password, $algorithm, $salt);
        return $hash === $passwordHash;
    }

    /**
     * Encrypts a given password with a given algorithm and salt like PHP Fusion.
     * @param $password string password to hash.
     * @param $algorithm string algorithm used for hashing.
     * @param $salt string salt for hashing.
     * @return string hash
     */
    private static function hashPassword($password, $algorithm, $salt) {
        if ($algorithm != "md5") {
            return hash_hmac($algorithm, $password, $salt);
        } else {
            return md5(md5($password));
        }
    }
}