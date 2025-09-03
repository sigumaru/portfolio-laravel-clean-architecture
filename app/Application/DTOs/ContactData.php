<?php

declare(strict_types=1);

namespace App\Application\DTOs;

final class ContactData
{
    public function __construct(
        public readonly string $id,
        public readonly string $name,
        public readonly string $email,
        public readonly string $subject,
        public readonly string $message
    ) {}

    public static function create(
        string $id,
        string $name,
        string $email,
        string $subject,
        string $message
    ): self {
        return new self($id, $name, $email, $subject, $message);
    }
}