<?php

declare(strict_types=1);

namespace App\Application\DTOs;

final class ProfileData
{
    public function __construct(
        public readonly string $id,
        public readonly string $name,
        public readonly string $title,
        public readonly string $bio,
        public readonly string $profileImage = '',
        public readonly array $skills = [],
        public readonly array $experience = [],
        public readonly array $education = [],
        public readonly array $socialLinks = []
    ) {}

    public static function create(
        string $id,
        string $name,
        string $title,
        string $bio,
        string $profileImage = '',
        array $skills = [],
        array $experience = [],
        array $education = [],
        array $socialLinks = []
    ): self {
        return new self(
            $id,
            $name,
            $title,
            $bio,
            $profileImage,
            $skills,
            $experience,
            $education,
            $socialLinks
        );
    }
}