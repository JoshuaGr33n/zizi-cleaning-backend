<?php

namespace App\Services;

use App\Models\User;
use App\Repositories\Repository;
use Illuminate\Http\Response;
use Exception;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Mail;
use App\Mail\{NewStaffLoginCredentials};


class UserProfileService
{
    protected $repository;

    public function __construct(Repository $repository)
    {
        $this->repository = $repository;
        $this->repository->setModel(new User());
    }
    private function generateUniqueUsername($firstName)
    {
        do {
            $username = $firstName . rand(100000, 999999); // Generate a random string
            // Check if the username already exists in the users table
        } while (User::where('username', $username)->exists());

        return $username;
    }

    public function updateProfile($id, array $data)
    {
        try {
            return $this->repository->update($id, $data);
        } catch (Exception $e) {
            throw $e;
        }
    }

    public function changePassword($user, array $password)
    {
        try {
            if (!Hash::check($password['oldPassword'], $user->password)) {
                return False;
            }
            $password['password'] = Hash::make($password['newPassword']);
            return $this->repository->update($user->id, $password);
        } catch (Exception $e) {
            throw $e;
        }
    }

    public function uploadImage($user, Request $request)
    {
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $filename = time() . '.' . $image->getClientOriginalExtension();
            $path = Storage::disk('public')->putFileAs(
                'images',
                $image,
                $filename
            );
            $file['image'] = $path;
            return $this->repository->update($user->id, $file);
        }

        return False;
    }

    public function getAdminStaff()
    {
        $admins = $this->repository->setQuery()->whereIn('role', ['Admin', 'Staff', 'SubAdmin'])->get();
        abort_if($admins->count() == 0, Response::HTTP_NOT_FOUND, "No Admin or staff");
        return $admins;
    }

    public function getUser($id)
    {
        $user = $this->repository->find($id);
        abort_if(!$user, Response::HTTP_NOT_FOUND, "User not found");
        abort_if($user->role == 'Admin', Response::HTTP_NOT_ACCEPTABLE, "Error");
        return $user;
    }


    public function toggleUserStatus($id)
    {
        $user = $this->repository->find($id);
        abort_if(!$user, Response::HTTP_NOT_FOUND, "User not found");
        abort_if($user->role == 'Admin', Response::HTTP_NOT_ACCEPTABLE, "Error");

        $user->is_active = !$user->is_active;
        $user->save();

        return response()->json([
            'success' => true,
            'message' => 'User status updated successfully.',
            'user_status' => $user->is_active,
        ]);
    }

    public function createStaff($data)
    {
        $randomString = Str::random(10);
        $password = Hash::make($randomString);
        $data['password'] = $password;
        $data['username'] = $this->generateUniqueUsername($data['first_name']);
        $create = $this->repository->create($data);

        if($create){
            Mail::to($create->email)->send(new NewStaffLoginCredentials($create, $randomString, $create->username, $create->email, $create->first_name));
        }
        
        return $create;
    }

    public function updateRole($role, $id)
    {

        abort_if($role == "", Response::HTTP_UNPROCESSABLE_ENTITY, "Role can not be empty");
        $user = $this->repository->find($id);
        abort_if(!$user, Response::HTTP_NOT_FOUND, "User not found");
        abort_if($user->role == 'Admin', Response::HTTP_NOT_ACCEPTABLE, "Error");
        $user->role = ucfirst($role);
        $user->save();

        return response()->json([
            'success' => true,
            'message' => 'Role updated successfully to ' . $role,
            'status' => $role,
        ]);
    }
    public function deleteUser($id)
    {
        $user = $this->repository->find($id);
        abort_if(!$user, Response::HTTP_NOT_FOUND, "User not found");
        abort_if($user->role == 'Admin', Response::HTTP_NOT_ACCEPTABLE, "Error");
        return $this->repository->delete($id);
    }
}
