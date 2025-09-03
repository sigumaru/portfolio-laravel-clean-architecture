<?php

declare(strict_types=1);

namespace App\Infrastructure\Repositories;

use App\Domain\Entities\Profile;
use App\Domain\Repositories\ProfileRepositoryInterface;
use App\Infrastructure\Models\Profile as ProfileModel;

final class EloquentProfileRepository implements ProfileRepositoryInterface
{
    public function save(Profile $profile): void
    {
        ProfileModel::updateOrCreate(
            ['id' => $profile->getId()],
            [
                'name' => $profile->getName(),
                'title' => $profile->getTitle(),
                'bio' => $profile->getBio(),
                'profile_image' => $profile->getProfileImage(),
                'skills' => $profile->getSkills(),
                'experience' => $profile->getExperience(),
                'education' => $profile->getEducation(),
                'social_links' => $profile->getSocialLinks(),
            ]
        );
    }

    public function find(): ?Profile
    {
        $model = ProfileModel::first();
        
        if (!$model) {
            return null;
        }

        return $this->toDomainEntity($model);
    }

    public function findById(string $id): ?Profile
    {
        $model = ProfileModel::find($id);
        
        if (!$model) {
            return null;
        }

        return $this->toDomainEntity($model);
    }

    public function exists(): bool
    {
        return ProfileModel::exists();
    }

    public function existsById(string $id): bool
    {
        return ProfileModel::where('id', $id)->exists();
    }

    private function toDomainEntity(ProfileModel $model): Profile
    {
        return new Profile(
            id: $model->id,
            name: $model->name,
            title: $model->title,
            bio: $model->bio,
            profileImage: $model->profile_image ?? '',
            skills: $model->skills ?? [],
            experience: $model->experience ?? [],
            education: $model->education ?? [],
            socialLinks: $model->social_links ?? []
        );
    }
}