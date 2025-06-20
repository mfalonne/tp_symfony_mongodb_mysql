<?php

namespace App\Service\User;

use App\Entity\User;
interface UserManagerInterface
{
    public function create(User $user, string $plainPassword): User;
    public function update(User $user): User;
    public function delete(User $user): void;
    public function findAll(): array;
}
