<?php
namespace App\Services;

use Illuminate\Database\Eloquent\Collection;

interface UserServiceInterface
{
    /**
     * Retrieve all users.
     *
     * @return Collection
     */
    public function getAllUsers(): Collection;

    /**
     * Retrieve a specific user by their ID.
     *
     * @param int $id
     * @return mixed
     */
    public function getUserById(int $id);

    /**
     * Create a new user with the given data.
     *
     * @param array $data
     * @return mixed
     */
    public function createUser(array $data);

    /**
     * Update an existing user with the given data.
     *
     * @param int $id
     * @param array $data
     * @return mixed
     */
    public function updateUser(int $id, array $data);

    /**
     * Soft delete a user by their ID (mark as deleted without removing).
     *
     * @param int $id
     * @return mixed
     */
    public function softDeleteUser(int $id);

    /**
     * Retrieve all users that have been soft deleted (trashed users).
     *
     * @return Collection
     */
    public function getTrashedUsers(): Collection;

    /**
     * Restore a soft deleted user by their ID.
     *
     * @param int $id
     * @return mixed
     */
    public function restoreUser(int $id);

    /**
     * Permanently delete a user from the database by their ID.
     *
     * @param int $id
     * @return mixed
     */
    public function permanentlyDeleteUser(int $id);
}
?>
