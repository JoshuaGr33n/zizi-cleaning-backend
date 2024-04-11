<?php

namespace App\Services;

use App\Models\Settings;
use App\Repositories\Repository;
use Illuminate\Http\Response;
use Exception;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class SettingService
{
    protected $repository;

    public function __construct(Repository $repository)
    {
        $this->repository = $repository;
        $this->repository->setModel(new Settings());
    }

    public function createSetting(Request $request)
    {
       if ($request->hasFile('image')) {
            $image = $request->file('image');
            $filename = time() . '.' . $image->getClientOriginalExtension();
            $path = Storage::disk('public')->putFileAs(
                'settings',
                $image,
                $filename
            );
            $data['image'] = $path; 
        }
        $data['name'] = $request->get('name');
        $data['tag'] = $request->get('tag');
        $data['desc'] = $request->get('desc');
        $data['url'] = $request->get('url');
        $data['value'] = $request->get('value');
        $data['category'] = $request->get('category');
        return $this->repository->create($data);

        // return False;
    }

    public function updateSetting(Request $request, $id)
    {
        $setting = $this->repository->find($id);
        abort_if(!$setting, Response::HTTP_NOT_FOUND, "Setting not found");
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $filename = time() . '.' . $image->getClientOriginalExtension();
            $path = Storage::disk('public')->putFileAs(
                'settings',
                $image,
                $filename
            );
            $data['image'] = $path; 
        }
        $data['name'] = $request->get('name');
        $data['tag'] = $request->get('tag');
        $data['desc'] = $request->get('desc');
        $data['url'] = $request->get('url');
        $data['value'] = $request->get('value');
        $data['category'] = $request->get('category');
        $this->repository->update($id, $data);
        $setting = $this->repository->find($id);
        return $setting;
    }
    
    public function getAllSettings()
    {
        $settings = $this->repository->getObj();
        abort_if($settings->count() == 0, Response::HTTP_NOT_FOUND, "No setting created");
        return $settings;
    }

    public function getSingleSetting($id)
    {
        $setting = $this->repository->find($id);
        abort_if(!$setting, Response::HTTP_NOT_FOUND, "Setting not found");
        return $setting;
    }

    public function deleteSetting($id)
    {
        $setting = $this->repository->find($id);
        abort_if(!$setting, Response::HTTP_NOT_FOUND, "Setting not found");
        return $this->repository->delete($id);
    }

    public function getSettingCategory($category)
    {
        $settings = $this->repository->setQuery()->where('category', $category)->get();
        abort_if($settings->count() == 0, Response::HTTP_NOT_FOUND, "No $category setting created");
        return $settings;
    }

    
}
