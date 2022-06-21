<?php

namespace App\Gentree\RawValidators;

use App\Gentree\Dto\ValidationResult;

interface RawValidatorInterface {
    public function isValid(): ValidationResult;
}