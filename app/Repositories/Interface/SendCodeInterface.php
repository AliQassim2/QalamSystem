<?php

namespace App\Repositories\Interface;

interface SendCodeInterface
{
    public function sendLoginCode(string $login): bool;
}
