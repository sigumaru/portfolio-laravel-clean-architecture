<?php

declare(strict_types=1);

namespace App\Domain\Entities;

use InvalidArgumentException;

final class Profile
{
    private string $id;
    private string $name;
    private string $title;
    private string $bio;
    private string $profileImage;
    private array $skills;
    private array $experience;
    private array $education;
    private array $socialLinks;

    public function __construct(
        string $id,
        string $name,
        string $title,
        string $bio,
        string $profileImage = '',
        array $skills = [],
        array $experience = [],
        array $education = [],
        array $socialLinks = []
    ) {
        if (empty(trim($name))) {
            throw new InvalidArgumentException('Name cannot be empty');
        }

        if (empty(trim($title))) {
            throw new InvalidArgumentException('Title cannot be empty');
        }

        $this->id = $id;
        $this->name = $name;
        $this->title = $title;
        $this->bio = $bio;
        $this->profileImage = $profileImage;
        $this->skills = $skills;
        $this->experience = $experience;
        $this->education = $education;
        $this->socialLinks = $socialLinks;
    }

    public static function create(
        string $id,
        string $name,
        string $title,
        string $bio
    ): self {
        return new self($id, $name, $title, $bio);
    }

    public function getId(): string
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    public function getBio(): string
    {
        return $this->bio;
    }

    public function getProfileImage(): string
    {
        return $this->profileImage;
    }

    public function getSkills(): array
    {
        return $this->skills;
    }

    public function getExperience(): array
    {
        return $this->experience;
    }

    public function getEducation(): array
    {
        return $this->education;
    }

    public function getSocialLinks(): array
    {
        return $this->socialLinks;
    }

    public function updateBasicInfo(string $name, string $title, string $bio): void
    {
        if (empty(trim($name))) {
            throw new InvalidArgumentException('Name cannot be empty');
        }

        if (empty(trim($title))) {
            throw new InvalidArgumentException('Title cannot be empty');
        }

        $this->name = $name;
        $this->title = $title;
        $this->bio = $bio;
    }

    public function updateProfileImage(string $profileImage): void
    {
        $this->profileImage = $profileImage;
    }

    public function updateSkills(array $skills): void
    {
        $this->skills = $skills;
    }

    public function addSkill(string $skill): void
    {
        if (!in_array($skill, $this->skills)) {
            $this->skills[] = $skill;
        }
    }

    public function removeSkill(string $skill): void
    {
        $this->skills = array_values(array_filter($this->skills, fn($s) => $s !== $skill));
    }

    public function updateExperience(array $experience): void
    {
        $this->experience = $experience;
    }

    public function updateEducation(array $education): void
    {
        $this->education = $education;
    }

    public function updateSocialLinks(array $socialLinks): void
    {
        $this->socialLinks = $socialLinks;
    }

    public function addSocialLink(string $platform, string $url): void
    {
        $this->socialLinks[$platform] = $url;
    }

    public function removeSocialLink(string $platform): void
    {
        unset($this->socialLinks[$platform]);
    }
}