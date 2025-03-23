<?php

namespace App\Domain\User;

use App\Domain\Cpf\Cpf;
use App\Models\User;
use DateTime;
use Exception;

class UserDataValidator {

    private const ID_MAX_LENGTH = 36;
    private const NAME_MAX_LENGTH = 100;
    private const EMAIL_MAX_LENGTH = 100;
    private const PASSWORD_MAX_LENGTH = 100;
    
    private const UUID_REGEX = '/[0-9a-fA-F]{8}\-[0-9a-fA-F]{4}\-[0-9a-fA-F]{4}\-[0-9a-fA-F]{4}\-[0-9a-fA-F]{12}/';

    private const EMAIL_REGEX = '/^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/';

    public function validateId(string $id): void {
        if (($id == '') || (!is_string($id)) || (preg_match(self::UUID_REGEX, $id) !== 1) || (strlen($id) > self::ID_MAX_LENGTH)) {
            throw new Exception('The user id is not valid');
        }
    }

    public function validateName(string $name): void {        
        if ($name == '') {
            throw new Exception('The user name cannot be empty');
        }

        if (strlen($name) > self::NAME_MAX_LENGTH) {
            throw new Exception('The user name exceeds the max length (Max: ' . self::NAME_MAX_LENGTH . ')');
        }
    }

    public function validateEmail(string $email): void {
        
        if ($email == '') {
            throw new Exception('The user email cannot be empty');
        }

        if (strlen($email) > self::EMAIL_MAX_LENGTH) {
            throw new Exception('The user email exceeds the max length (Max: ' . self::EMAIL_MAX_LENGTH . ')');
        }

        if (!preg_match(self::EMAIL_REGEX, $email)) {
            throw new Exception('The user email is not valid');
        }

        if (User::where('email', $email)->first()) {
            throw new Exception('E-mail already in use');
        }
    }

    public function validatePassword(string $password): void {
        if ($password == '') {
            throw new Exception('The password cannot be empty');
        }

        if (strlen($password) > self::NAME_MAX_LENGTH) {
            throw new Exception('The password exceeds the max length (Max: ' . self::PASSWORD_MAX_LENGTH . ')');
        }
    }
}
