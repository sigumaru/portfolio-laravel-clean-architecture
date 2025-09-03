<?php

declare(strict_types=1);

namespace App\Domain\Repositories;

use App\Domain\Entities\Profile;

interface ProfileRepositoryInterface
{
    public function save(Profile $profile): void;

    public function find(): ?Profile;

    public function findById(string $id): ?Profile;

    public function exists(): bool;

    public function existsById(string $id): bool;
}