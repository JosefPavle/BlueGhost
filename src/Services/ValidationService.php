<?php

namespace App\Services;

use App\Entity\Person;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class ValidationService
{
    private ValidatorInterface $validator;

    public function __construct(ValidatorInterface $validator)
    {
        $this->validator = $validator;
    }

    public function ValidateData(Person $person):bool
    {
        $isEmailValid = $this->ValidateEmail($person->getEmail());

        if ($isEmailValid){
            return true;
        }

        return false;
    }

    private function ValidateEmail(string $email):bool
    {
        $emailConstraint = new Assert\Email();

        $errors = $this->validator->validate(
            $email,
            $emailConstraint
        );

        if (!$errors->count()) {
            return true;
        }

        return false;
    }
}