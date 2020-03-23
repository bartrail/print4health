<?php

declare(strict_types=1);

namespace App\Dto;

class RequesterIn
{
    public string $email;
    public string $password;
    public string $name;
    public ?string $streetAddress = null;
    public ?string $postalCode = null;
    public ?string $addressCity = null;
    public ?string $addressState = null;
}
