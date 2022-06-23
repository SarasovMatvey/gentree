<?php

namespace App\Gentree\RawValidators;

use App\Gentree\Dto\ValidationResult;

/**
 * Interface for checking that input data is valid
 */
interface RawValidatorInterface {

    /**
     * @return ValidationResult
     */
    public function isValid(): ValidationResult;
}