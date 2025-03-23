<?php

namespace App\Domain\Words;

use App\Models\UserFavorite;
use Exception;

class WordsDataValidator {

    public function validateSearch(?string $search): void {        
        if ($search == '') {
            throw new Exception('The search word cannot be empty');
        }
    }

    public function checkIfExistFavorite(string $user_id, string $word) {
        if (UserFavorite::where('user_id', $user_id)->where('word', $word)){
            throw new Exception('Word not found on favorites section');
        }
    }
}
