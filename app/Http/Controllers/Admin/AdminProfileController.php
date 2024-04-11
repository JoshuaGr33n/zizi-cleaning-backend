<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Response;
use Illuminate\Http\Request;
use App\Services\{UserProfileService};
use App\Http\Resources\{ImageResource};
use App\Http\Requests\{UserRequest, ChangePasswordRequest, ImageUploadRequest};


class AdminProfileController extends Controller
{

    protected $UserProfileService;


    /**
     * AdminProfileController constructor.
     * @param UserProfileService $UserProfileService

     */
    public function __construct(UserProfileService $UserProfileService)
    {
        $this->UserProfileService = $UserProfileService;
    }

    public function updateProfile(UserRequest $request)
    {
        // $this->UserProfileService->updateProfile($request->except(["user_id", "is_published", "published_at", "event_code"]), $id, session("user_id"), $companyID);
        $this->UserProfileService->updateProfile($request->user()->id, $request->all());
        return $this->response(Response::HTTP_OK);
    }

    public function changePassword(ChangePasswordRequest $request)
    {
        $response = $this->UserProfileService->changePassword($request->user(), $request->all());
        if ($response == False) {
            return response()->json(['error' => 'The provided password does not match your current password.'], 403);
        }
        return $this->response(Response::HTTP_OK);
    }

    public function uploadImage(ImageUploadRequest $request)
    {
        $response = $this->UserProfileService->uploadImage($request->user(), $request);
        if ($response == False) {
            return response()->json(['error' => 'Image upload failed.'], 500);
        }
        return $this->response(Response::HTTP_OK, new ImageResource($response));
    }
}
