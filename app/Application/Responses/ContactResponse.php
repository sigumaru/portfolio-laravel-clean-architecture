<?php

declare(strict_types=1);

namespace App\Application\Responses;

final class ContactResponse
{
    public function __construct(
        public readonly string $id,
        public readonly string $name,
        public readonly string $email,
        public readonly string $subject,
        public readonly string $message,
        public readonly string $createdAt,
        public readonly bool $isRead
    ) {}

    public static function create(
        string $id,
        string $name,
        string $email,
        string $subject,
        string $message,
        string $createdAt,
        bool $isRead
    ): self {
        return new self(
            $id,
            $name,
            $email,
            $subject,
            $message,
            $createdAt,
            $isRead
        );
    }

    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'email' => $this->email,
            'subject' => $this->subject,
            'message' => $this->message,
            'created_at' => $this->createdAt,
            'is_read' => $this->isRead,
        ];
    }
}