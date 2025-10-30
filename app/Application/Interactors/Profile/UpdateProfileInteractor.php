<?php

declare(strict_types=1);

namespace App\Application\Interactors\Profile;

use App\Application\Contracts\Interactors\Profile\UpdateProfileInteractorInterface;
use App\Application\DTOs\ProfileData;
use App\Application\Responses\ProfileResponse;
use App\Application\Contracts\Presenters\ProfilePresenterInterface;
use App\Domain\Entities\Profile;
use App\Domain\Repositories\ProfileRepositoryInterface;

final class UpdateProfileInteractor implements UpdateProfileInteractorInterface
{
    public function __construct(
        private ProfileRepositoryInterface $repository,
        private ProfilePresenterInterface $presenter
    ) {}

    public function execute(ProfileData $data): ProfileResponse
    {
        $profile = $this->repository->find();

        if (!$profile) {
            $profile = Profile::create(
                $data->id,
                $data->name,
                $data->title,
                $data->bio
            );
        } else {
            $profile->updateBasicInfo($data->name, $data->title, $data->bio);
        }

        if (!empty($data->profileImage)) {
            $profile->updateProfileImage($data->profileImage);
        }

        if (!empty($data->skills)) {
            $profile->updateSkills($data->skills);
        }

        if (!empty($data->experience)) {
            $profile->updateExperience($data->experience);
        }

        if (!empty($data->education)) {
            $profile->updateEducation($data->education);
        }

        if (!empty($data->socialLinks)) {
            $profile->updateSocialLinks($data->socialLinks);
        }

        $this->repository->save($profile);

        return $this->presenter->present($profile);
    }
}