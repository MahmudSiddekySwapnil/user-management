<?php
namespace App\Services;

use App\Models\User;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class UserService implements UserServiceInterface
{
    public function getAllUsers(): Collection
    {
        return User::all();
    }

    public function getUserById(int $id)
    {
        return User::find($id);
    }

    public function createUser(array $data)
    {
        $user = new User();
        $user->name = $data['name'];
        $user->email = $data['email'];
        $user->password = Hash::make($data['password']);

        if (isset($data['userImage'])) {
            $imagePath = $data['userImage']->store('user_images', 'public');
            $user->picture = $imagePath;
        }

        $user->save();
        return $user;
    }

    public function updateUser(int $id, array $data)
    {
        $user = User::find($id);

        if (!$user) {
            return null; // User not found
        }

        $user->name = $data['name'];
        $user->email = $data['email'];

        if (isset($data['image'])) {
            if ($user->picture && Storage::disk('public')->exists($user->picture)) {
                Storage::disk('public')->delete($user->picture);
            }
            $imagePath = $data['image']->store('user_images', 'public');
            $user->picture = $imagePath;
        }

        $user->save();
        return $user;
    }

    public function softDeleteUser(int $id)
    {
        $user = User::find($id);
        if ($user) {
            $user->delete();
            return true;
        }
        return false;
    }

    public function getTrashedUsers(): Collection
    {
        return User::onlyTrashed()->get();
    }

    public function restoreUser(int $id)
    {
        $user = User::withTrashed()->find($id);
        if ($user && $user->trashed()) {
            $user->restore();
            return true;
        }
        return false;
    }

    public function permanentlyDeleteUser(int $id)
    {
        $user = User::onlyTrashed()->find($id);
        if ($user) {
            $user->forceDelete();
            return true;
        }
        return false;
    }
}
?>
