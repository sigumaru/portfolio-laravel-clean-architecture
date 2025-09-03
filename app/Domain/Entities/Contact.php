<?php

declare(strict_types=1);

namespace App\Domain\Entities;

use App\Domain\ValueObjects\Email;
use DateTimeImmutable;
use InvalidArgumentException;

final class Contact
{
    private string $id;
    private string $name;
    private Email $email;
    private string $subject;
    private string $message;
    private DateTimeImmutable $createdAt;
    private bool $isRead;

    public function __construct(
        string $id,
        string $name,
        Email $email,
        string $subject,
        string $message,
        ?DateTimeImmutable $createdAt = null,
        bool $isRead = false
    ) {
        if (empty(trim($name))) {
            throw new InvalidArgumentException('Name cannot be empty');
        }

        if (empty(trim($subject))) {
            throw new InvalidArgumentException('Subject cannot be empty');
        }

        if (empty(trim($message))) {
            throw new InvalidArgumentException('Message cannot be empty');
        }

        $this->id = $id;
        $this->name = $name;
        $this->email = $email;
        $this->subject = $subject;
        $this->message = $message;
        $this->createdAt = $createdAt ?? new DateTimeImmutable();
        $this->isRead = $isRead;
    }

    public static function create(
        string $id,
        string $name,
        string $email,
        string $subject,
        string $message
    ): self {
        return new self(
            $id,
            $name,
            new Email($email),
            $subject,
            $message
        );
    }

    public function getId(): string
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getEmail(): Email
    {
        return $this->email;
    }

    public function getSubject(): string
    {
        return $this->subject;
    }

    public function getMessage(): string
    {
        return $this->message;
    }

    public function getCreatedAt(): DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function isRead(): bool
    {
        return $this->isRead;
    }

    public function markAsRead(): void
    {
        $this->isRead = true;
    }

    public function markAsUnread(): void
    {
        $this->isRead = false;
    }
}