<?php

declare(strict_types=1);

namespace App\Domain\Repositories;

use App\Domain\Entities\Contact;

interface ContactRepositoryInterface
{
    public function save(Contact $contact): void;

    public function findById(string $id): ?Contact;

    public function findAll(): array;

    public function findUnread(): array;

    public function findWithPagination(int $page = 1, int $perPage = 10): array;

    public function delete(string $id): void;

    public function exists(string $id): bool;

    public function count(): int;

    public function countUnread(): int;
}