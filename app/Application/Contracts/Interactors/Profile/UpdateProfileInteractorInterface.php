<?php

declare(strict_types=1);

namespace App\Application\Contracts\Interactors\Profile;

use App\Application\DTOs\ProfileData;
use App\Application\Responses\ProfileResponse;

interface UpdateProfileInteractorInterface
{
    /**
     * プロフィール情報を更新する
     * プロフィールが存在しない場合は新規作成し、存在する場合は更新する
     *
     * @param ProfileData $data プロフィールデータ
     * @return ProfileResponse 更新されたプロフィールのレスポンス
     */
    public function execute(ProfileData $data): ProfileResponse;
}