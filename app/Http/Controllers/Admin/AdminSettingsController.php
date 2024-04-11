<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Response;
use Illuminate\Http\Request;
use App\Services\{SettingService};
use App\Http\Resources\{SettingResource};
use App\Http\Requests\{CreateSettingRequest, UpdateSettingRequest};


class AdminSettingsController extends Controller
{

  
    protected $settingService;

    /**
     * 
     * @param SettingService $settingService
     */
    public function __construct(SettingService $settingService)
    {
        $this->settingService = $settingService;
    }

    public function createSetting(CreateSettingRequest $request)
    {
        $response = $this->settingService->createSetting($request);
        return $this->response(Response::HTTP_OK, new SettingResource($response));
    }

    public function updateSetting(UpdateSettingRequest $request, $id)
    {
        $response = $this->settingService->updateSetting($request, $id);
        return $this->response(Response::HTTP_OK, new SettingResource($response));
    }


    public function settings()
    {
        $settings = $this->settingService->getAllSettings();
        return SettingResource::collection($settings);
    }

    public function singleSetting($id)
    {
        $setting = $this->settingService->getSingleSetting($id);
        return new SettingResource($setting);
    }

    public function deleteSetting($id)
    {
        $this->settingService->deleteSetting($id);
        return $this->response(Response::HTTP_OK);
    }

    public function getSettingCategory($category)
    {
       $setting = $this->settingService->getSettingCategory($category);
       return SettingResource::collection($setting);
    }

    
}
