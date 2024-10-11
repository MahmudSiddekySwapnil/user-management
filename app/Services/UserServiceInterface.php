<?php
namespace App\Services;

use Illuminate\Database\Eloquent\Collection;

interface UserServiceInterface
{
    public function getAllUsers(): Collection;

    public function getUserById(int $id);

    public function createUser(array $data);

    public function updateUser(int $id, array $data);

    public function softDeleteUser(int $id);

    public function getTrashedUsers(): Collection;

    public function restoreUser(int $id);

    public function permanentlyDeleteUser(int $id);
}

?>
