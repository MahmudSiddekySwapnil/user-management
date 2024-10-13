<?php
namespace App\Services;

use App\Models\User;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class UserService implements UserServiceInterface
{
    /**
     * Retrieve all users from the database.
     *
     * @return Collection
     */
    public function getAllUsers(): Collection
    {
        return User::all();
    }

    /**
     * Retrieve a specific user by their ID.
     *
     * @param int $id
     * @return mixed
     */
    public function getUserById(int $id)
    {
        return User::find($id);
    }

    /**
     * Create a new user with the provided data, including optional image upload.
     *
     * @param array $data
     * @return User
     */
    public function createUser(array $data)
    {
        $user = new User();
        $user->name = $data['name'];
        $user->email = $data['email'];
        $user->password = Hash::make($data['password']);

        // Handle image upload if provided
        if (isset($data['userImage'])) {
            $imagePath = $data['userImage']->store('user_images', 'public');
            $user->picture = $imagePath;
        }

        $user->save();
        return $user;
    }

    /**
     * Update an existing user's information, including optional image replacement.
     *
     * @param int $id
     * @param array $data
     * @return User|null
     */
    public function updateUser(int $id, array $data)
    {
        $user = User::find($id);

        if (!$user) {
            return null; // User not found
        }

        $user->name = $data['name'];
        $user->email = $data['email'];

        // Update and replace user image if provided
        if (isset($data['image'])) {
            if ($user->picture && Storage::disk('public')->exists($user->picture)) {
                Storage::disk('public')->delete($user->picture); // Delete the old image
            }
            $imagePath = $data['image']->store('user_images', 'public');
            $user->picture = $imagePath;
        }

        $user->save();
        return $user;
    }

    /**
     * Soft delete (mark as deleted) a user by their ID.
     *
     * @param int $id
     * @return bool
     */
    public function softDeleteUser(int $id)
    {
        $user = User::find($id);
        if ($user) {
            $user->delete(); // Soft delete
            return true;
        }
        return false;
    }

    /**
     * Retrieve all users that have been soft deleted (trashed).
     *
     * @return Collection
     */
    public function getTrashedUsers(): Collection
    {
        return User::onlyTrashed()->get();
    }

    /**
     * Restore a soft deleted user by their ID.
     *
     * @param int $id
     * @return bool
     */
    public function restoreUser(int $id)
    {
        $user = User::withTrashed()->find($id);
        if ($user && $user->trashed()) {
            $user->restore(); // Restore the soft deleted user
            return true;
        }
        return false;
    }

    /**
     * Permanently delete a user from the database by their ID.
     *
     * @param int $id
     * @return bool
     */
    public function permanentlyDeleteUser(int $id)
    {
        $user = User::onlyTrashed()->find($id);
        if ($user) {
            $user->forceDelete(); // Permanently delete the user
            return true;
        }
        return false;
    }
}
?>
