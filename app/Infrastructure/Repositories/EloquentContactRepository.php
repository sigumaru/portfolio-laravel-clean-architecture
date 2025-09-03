<?php

declare(strict_types=1);

namespace App\Infrastructure\Repositories;

use App\Domain\Entities\Contact;
use App\Domain\Repositories\ContactRepositoryInterface;
use App\Domain\ValueObjects\Email;
use App\Infrastructure\Models\Contact as ContactModel;
use DateTimeImmutable;

final class EloquentContactRepository implements ContactRepositoryInterface
{
    public function save(Contact $contact): void
    {
        ContactModel::updateOrCreate(
            ['id' => $contact->getId()],
            [
                'name' => $contact->getName(),
                'email' => $contact->getEmail()->getValue(),
                'subject' => $contact->getSubject(),
                'message' => $contact->getMessage(),
                'is_read' => $contact->isRead(),
            ]
        );
    }

    public function findById(string $id): ?Contact
    {
        $model = ContactModel::find($id);
        
        if (!$model) {
            return null;
        }

        return $this->toDomainEntity($model);
    }

    public function findAll(): array
    {
        $models = ContactModel::latest()->get();
        
        return $models->map(fn($model) => $this->toDomainEntity($model))->toArray();
    }

    public function findUnread(): array
    {
        $models = ContactModel::unread()
            ->latest()
            ->get();
        
        return $models->map(fn($model) => $this->toDomainEntity($model))->toArray();
    }

    public function findWithPagination(int $page = 1, int $perPage = 10): array
    {
        $offset = ($page - 1) * $perPage;
        
        $models = ContactModel::latest()
            ->offset($offset)
            ->limit($perPage)
            ->get();
        
        return $models->map(fn($model) => $this->toDomainEntity($model))->toArray();
    }

    public function delete(string $id): void
    {
        ContactModel::destroy($id);
    }

    public function exists(string $id): bool
    {
        return ContactModel::where('id', $id)->exists();
    }

    public function count(): int
    {
        return ContactModel::count();
    }

    public function countUnread(): int
    {
        return ContactModel::unread()->count();
    }

    private function toDomainEntity(ContactModel $model): Contact
    {
        return new Contact(
            id: $model->id,
            name: $model->name,
            email: new Email($model->email),
            subject: $model->subject,
            message: $model->message,
            createdAt: new DateTimeImmutable($model->created_at->toDateTimeString()),
            isRead: $model->is_read
        );
    }
}