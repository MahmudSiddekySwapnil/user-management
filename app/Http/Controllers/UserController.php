<?php

namespace App\Http\Controllers;
use App\Events\UserSaved;
use App\Services\UserServiceInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Exception;
use Illuminate\Support\Facades\Log;

class UserController extends Controller
{
    protected $userService;

    public function __construct(UserServiceInterface $userService)
    {
        $this->userService = $userService;
    }

    public function index()
    {
        return view('users.user-list');
    }

    public function getUserlist(Request $request)
    {
        $users = $this->userService->getAllUsers();
        return response()->json(['data' => $users]);
    }

    public function getUserDetails(Request $request)
    {
        $request->validate(['id' => 'required|integer|exists:users,id']);
        $user = $this->userService->getUserById($request->id);

        $response = [
            'id' => $user->id,
            'name' => $user->name,
            'email' => $user->email,
            'image' => $user->picture ? Storage::url($user->picture) : null, // Include public URL
        ];

        // Return a JSON response
        return response()->json($response);
    }

    public function updateUser(Request $request)
    {
        $request->validate([
            'id' => 'required|integer|exists:users,id',
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        try {
            $user = $this->userService->updateUser($request->id, $request->all());
            event(new UserSaved($user));
            return response()->json(['message' => 'User updated successfully', 'user' => $user], 200);
        } catch (Exception $e) {
            Log::error('User update failed: ' . $e->getMessage());
            return response()->json(['error' => 'Failed to update user'], 500);
        }
    }

    public function createUser(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8',
            'userImage' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        try {
            $user = $this->userService->createUser($request->all());
            // Trigger the event after saving the user
            event(new UserSaved($user));
            return response()->json(['message' => 'User created successfully!', 'user' => $user], 201);
        } catch (Exception $e) {
            Log::error('User creation failed: ' . $e->getMessage());
            return response()->json(['error' => 'Failed to create user'], 500);
        }
    }

    public function softDeleteUser(Request $request)
    {
        $validated = $request->validate(['id' => 'required|exists:users,id']);
        if ($this->userService->softDeleteUser($validated['id'])) {
            return response()->json(['message' => 'User soft deleted successfully.']);
        }
        return response()->json(['message' => 'User not found.'], 404);
    }
    public function getTrashedUser(Request $request)
    {
        return view('users.trashed-user');

    }
    public function getTrashedUserList(Request $request)
    {
        $trashed_users = $this->userService->getTrashedUsers();
        return response()->json(['data' => $trashed_users]);
    }

    public function reactivateUser($id)
    {
        if ($this->userService->restoreUser($id)) {
            return response()->json(['message' => 'User restored successfully.']);
        }
        return response()->json(['message' => 'User is not soft-deleted and cannot be restored.'], 400);
    }

    public function permanentlyDeleteUser($id)
    {
        if ($this->userService->permanentlyDeleteUser($id)) {
            return response()->json(['message' => 'User deleted permanently.']);
        }
        return response()->json(['message' => 'User not found or already permanently deleted.'], 404);
    }
}

