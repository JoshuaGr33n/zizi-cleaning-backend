<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Response;
use Illuminate\Http\Request;
use App\Services\{UserProfileService};
use App\Http\Resources\{UserProfileResource};
use App\Http\Requests\{NewStaffRequest};




class AdminStaffController extends Controller
{


    protected $service;

    /**
     * 
     * @param UserProfileService $service
     */
    public function __construct(UserProfileService $service)
    {
        $this->service = $service;
    }

    public function createStaff(NewStaffRequest $request)
    {
        $response = $this->service->createStaff($request->all());
        return $this->response(Response::HTTP_OK, new UserProfileResource($response));
    }

    // public function updateSetting(UpdateSettingRequest $request, $id)
    // {
    //     $response = $this->service->updateSetting($request, $id);
    //     return $this->response(Response::HTTP_OK, new UserProfileResource($response));
    // }


    public function allAdminStaff()
    {
        $users = $this->service->getAdminStaff();

        return UserProfileResource::collection($users);
    }

    public function getUser($id)
    {
        $response = $this->service->getUser($id);
        return new UserProfileResource($response);
    }


    public function toggleUserStatus($id)
    {
        $response = $this->service->toggleUserStatus($id);
        return $this->response(Response::HTTP_OK, $response);
    }

    public function updateRole(Request $request, $id)
    {
        $role = $request->role;
        $response = $this->service->updateRole($role, $id);
        return $this->response(Response::HTTP_OK, $response);
    }

    public function deleteUser($id)
    {
        $this->service->deleteUser($id);
        return $this->response(Response::HTTP_OK);
    }
}
