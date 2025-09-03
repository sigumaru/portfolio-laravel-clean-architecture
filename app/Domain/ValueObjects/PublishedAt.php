<?php

declare(strict_types=1);

namespace App\Domain\ValueObjects;

use DateTimeImmutable;
use DateTimeInterface;
use InvalidArgumentException;

final class PublishedAt
{
    private DateTimeImmutable $value;

    public function __construct(DateTimeInterface $value)
    {
        if ($value > new DateTimeImmutable()) {
            throw new InvalidArgumentException('Published date cannot be in the future');
        }

        $this->value = DateTimeImmutable::createFromInterface($value);
    }

    public static function now(): self
    {
        return new self(new DateTimeImmutable());
    }

    public static function fromString(string $date): self
    {
        $dateTime = DateTimeImmutable::createFromFormat('Y-m-d H:i:s', $date);
        
        if ($dateTime === false) {
            throw new InvalidArgumentException('Invalid date format. Expected Y-m-d H:i:s');
        }

        return new self($dateTime);
    }

    public function getValue(): DateTimeImmutable
    {
        return $this->value;
    }

    public function format(string $format = 'Y-m-d H:i:s'): string
    {
        return $this->value->format($format);
    }

    public function equals(PublishedAt $other): bool
    {
        return $this->value == $other->value;
    }

    public function isBefore(PublishedAt $other): bool
    {
        return $this->value < $other->value;
    }

    public function isAfter(PublishedAt $other): bool
    {
        return $this->value > $other->value;
    }

    public function __toString(): string
    {
        return $this->format();
    }
}