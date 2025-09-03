<?php

declare(strict_types=1);

namespace App\Presentation\Http\Presenters;

use App\Application\Contracts\Presenters\ProfilePresenterInterface;
use App\Application\Responses\ProfileResponse;
use App\Domain\Entities\Profile;

final class WebProfilePresenter implements ProfilePresenterInterface
{
    public function present(Profile $profile): ProfileResponse
    {
        return ProfileResponse::create(
            id: $profile->getId(),
            name: $profile->getName(),
            title: $profile->getTitle(),
            bio: $profile->getBio(),
            profileImage: $profile->getProfileImage(),
            skills: $profile->getSkills(),
            experience: $profile->getExperience(),
            education: $profile->getEducation(),
            socialLinks: $profile->getSocialLinks()
        );
    }
}