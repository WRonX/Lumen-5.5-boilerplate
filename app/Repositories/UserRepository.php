<?php

namespace App\Repositories;

use App\Models\User;

class UserRepository
{
    public static function findByActivationToken(string $activation_token) {
        return self::findOneByField('activation_token', $activation_token);
    }
    
    public static function findByUsername(string $username) {
        return self::findOneByField('username', $username);
    }
    
    public static function findByEmail(string $email) {
        return self::findOneByField('email', $email);
    }
    
    private static function findOneByField(string $field, $value) {
        return self::findByField($field, $value)->first();
    }
    
    private static function findByField(string $field, $value) {
        return User::where([$field => $value]);
    }
    
}