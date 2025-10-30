<?php

declare(strict_types=1);

namespace App\Application\Contracts\Interactors\Contact;

use App\Application\DTOs\ContactData;
use App\Application\Responses\ContactResponse;

interface SendContactInteractorInterface
{
    /**
     * お問い合わせを送信し、管理者に通知メールを送る
     *
     * @param ContactData $data お問い合わせデータ
     * @return ContactResponse 送信されたお問い合わせのレスポンス
     */
    public function execute(ContactData $data): ContactResponse;
}