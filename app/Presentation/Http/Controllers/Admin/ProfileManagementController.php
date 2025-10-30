<?php

declare(strict_types=1);

namespace App\Presentation\Http\Controllers\Admin;

use App\Application\Contracts\Interactors\Profile\UpdateProfileInteractorInterface;
use App\Application\DTOs\ProfileData;
use App\Domain\Repositories\ProfileRepositoryInterface;
use App\Presentation\Http\Requests\UpdateProfileRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use Ramsey\Uuid\Uuid;

final class ProfileManagementController
{
    public function __construct(
        private UpdateProfileInteractorInterface $updateProfileInteractor,
        private ProfileRepositoryInterface $profileRepository
    ) {}

    public function index(): View
    {
        $profile = $this->profileRepository->find();

        return view('admin.profile.index', [
            'profile' => $profile
        ]);
    }

    public function edit(): View
    {
        $profile = $this->profileRepository->find();

        return view('admin.profile.edit', [
            'profile' => $profile
        ]);
    }

    public function update(UpdateProfileRequest $request): RedirectResponse
    {
        $profile = $this->profileRepository->find();
        $profileId = $profile?->getId() ?? Uuid::uuid4()->toString();

        $profileData = ProfileData::create(
            id: $profileId,
            name: $request->validated('name'),
            title: $request->validated('title'),
            bio: $request->validated('bio'),
            profileImage: $request->validated('profile_image', ''),
            skills: $request->validated('skills', []),
            experience: $request->validated('experience', []),
            education: $request->validated('education', []),
            socialLinks: $request->validated('social_links', [])
        );

        try {
            $this->updateProfileInteractor->execute($profileData);

            return redirect()->route('admin.profile.index')
                ->with('success', 'Profile updated successfully!');
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Error updating profile: ' . $e->getMessage())
                ->withInput();
        }
    }
}