<?php

namespace App\Gentree\Dto;

class ValidationResult
{
    /**
     * @var bool
     */
    public $isValid;

    /**
     * @var string|null
     */
    public $errorMessage = null;

    /**
     * @param bool $isValid
     * @param string|null $errorMessage
     */
    public function __construct(bool $isValid, ?string $errorMessage = null)
    {
        $this->isValid = $isValid;
        $this->errorMessage = $errorMessage;
    }


}