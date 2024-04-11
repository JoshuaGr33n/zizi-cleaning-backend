<?php

namespace App\Services;

use App\Models\{User, Appointment, Settings};
use App\Repositories\{Repository, UserRepository};
use App\Services\{SettingService};
use Illuminate\Http\Response;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;


use Illuminate\Support\Facades\Mail;
use App\Mail\{AppointmentBooked, AppointmentBookedResidential, AppointmentBookedCommercialAdmin, AppointmentBookedResidentialAdmin};


class AppointmentService
{
    protected $repository;
    protected $user;

    protected $settings;

    public function __construct(Repository $repository, UserRepository $user, SettingService $settingService)
    {
        $this->repository = $repository;
        $this->repository->setModel(new Appointment());
        $this->user = $user;
        $this->user->setModel(new User());
        $this->settings = $settingService;
    }

    private function generateUniqueReference()
    {
        do {
            $refNumber = 'ref' . rand(10000000, 99999999); // Generate a random string
            // Check if the reference already exists in the database
        } while (Appointment::where('reference_number', $refNumber)->exists());

        return $refNumber;
    }

    public function createResidentialRequest(Request $request)
    {
        $imagePaths = [];
        if ($request->hasfile('image_paths')) {
            foreach ($request->file('image_paths') as $image) {
                $path = $image->store('public/requests_images');
                $imagePaths[] = $path;
            }
        }
        $address = [
            'street1' => $request->input('address.street1'),
            'street2' => $request->input('address.street2'),
            'city' => $request->input('address.city'),
            'province' => $request->input('address.province'),
            'postal_code' => $request->input('address.postal_code'),
        ];

        $service_details = [
            'home_size' => $request->input('service_details.home_size'),
            'bathrooms' => $request->input('service_details.bathrooms'),
        ];

        $availability = [
            'primary_date' => $request->input('availability.primary_date'),
            'secondary_date' => $request->input('availability.secondary_date'),
            'time_preferences' => $request->input('availability.time_preferences', []),
        ];

        $extras_2 = [
            'entry_method' => $request->input('extras_2.entry_method'),
            'home_status' => $request->input('extras_2.home_status'),
            'pets' => $request->input('extras_2.pets'),
            'basement' => $request->input('extras_2.basement'),
        ];

        $uniqueRef = $this->generateUniqueReference();

        $data['flag'] = 'residential';
        $data['reference_number'] = $uniqueRef;
        $data['image_paths'] = $imagePaths;
        $data['first_name'] = $request->get('first_name');
        $data['last_name'] = $request->get('last_name');
        $data['phone'] = $request->get('phone');
        $data['email'] = $request->get('email');
        $data['address'] = $address;
        $data['service_details'] = $service_details;
        $data['availability'] = $availability;
        $data['extras'] = $request->input('extras', []);
        $data['extras_2'] = $extras_2;
        $data['additional_instructions'] = $request->get('additional_instructions');

        $result = $this->repository->create($data);

        $extrasMapping = [
            'fridge' => 'Inside Fridge',
            'oven' => 'Inside Oven',
            'windows' => 'Inside Windows',
            'walls' => 'Walls',
            'baseboard' => 'Baseboard Cleaning',
            'doors' => 'Doors, door frames & door knobs',
            'fans' => 'Ceiling Fans',
            'moveInOut' => 'Move in/Move Out Cleaning',
            'deepClean' => 'Deep Cleaning Service',
            'extremeDeepClean' => 'Extreme Deep Clean',
            'blinds' => 'Blinds',
            'heavyDuty' => 'Heavy-duty Cleaning',
            'bathroomCabinets' => 'Inside Bathroom Cabinets',
            'dishes' => 'Dishes (per load)',
        ];


        $entryMethodMapping = [
            'beHome' => "I will be home",
            'leaveKey' => "I will leave a key",
            'doorOpen' => "I will leave the door open",
            'frontDesk' => "Front Desk Access",
            'doorCode' => "Door Code",
        ];

        $homeStatusOptions = [
            'empty' => "Empty",
            'occupied' => "Occupied",
        ];

        $petsStatusOptions = [
            'yes' => "Yes",
            'no' => "No",
        ];

        $basementCleaningStatusOptions = [
            'yes' => "Yes",
            'no' => "No",
        ];

        $admins = $this->user->setQuery()->where('role', 'Admin')->get();
        $requestEmails = $this->settings->getSettingCategory('RequestEmail');
        if ($result) {
            try {
                foreach ($requestEmails as $value) {
                    Mail::to($value->value)->send(new AppointmentBookedResidentialAdmin($result, $extrasMapping, $entryMethodMapping, $homeStatusOptions, $petsStatusOptions, $basementCleaningStatusOptions));
                }
                foreach ($admins as $admin) {
                    Mail::to($admin->email)->send(new AppointmentBookedResidentialAdmin($result, $extrasMapping, $entryMethodMapping, $homeStatusOptions, $petsStatusOptions, $basementCleaningStatusOptions));
                }
                Mail::to($result->email)->send(new AppointmentBookedResidential($result, $extrasMapping, $entryMethodMapping, $homeStatusOptions, $petsStatusOptions, $basementCleaningStatusOptions));
            } catch (\Exception $e) {
                // Log error
                Log::error('Email sending failed: ' . $e->getMessage());
            }
        }
        return $result;
    }

    public function createCommercialRequest(Request $request)
    {
        $imagePaths = [];
        if ($request->hasfile('image_paths')) {
            foreach ($request->file('image_paths') as $image) {
                $path = $image->store('public/requests_images');
                $imagePaths[] = $path;
            }
        }
        $address = [
            'street1' => $request->input('address.street1'),
            'street2' => $request->input('address.street2'),
            'city' => $request->input('address.city'),
            'province' => $request->input('address.province'),
            'postal_code' => $request->input('address.postal_code'),
        ];

        $service_details = [
            'information' => $request->input('service_details.information'),
        ];

        $availability = [
            'primary_date' => $request->input('availability.primary_date'),
            'secondary_date' => $request->input('availability.secondary_date'),
            'time_preferences' => $request->input('availability.time_preferences', []),
        ];


        $uniqueRef = $this->generateUniqueReference();

        $data['flag'] = 'commercial';
        $data['reference_number'] = $uniqueRef;
        $data['image_paths'] = $imagePaths;
        $data['first_name'] = $request->get('first_name');
        $data['last_name'] = $request->get('last_name');
        $data['company_name'] = $request->get('company_name');
        $data['phone'] = $request->get('phone');
        $data['email'] = $request->get('email');
        $data['address'] = $address;
        $data['service_details'] = $service_details;
        $data['availability'] = $availability;
        $data['additional_instructions'] = $request->get('additional_instructions');
        $result = $this->repository->create($data);

        if ($result) {

            $admins = $this->user->setQuery()->where('role', 'Admin')->get();
            $requestEmails = $this->settings->getSettingCategory('RequestEmail');
            try {
                foreach ($requestEmails as $value) {
                    Mail::to($value->value)->send(new AppointmentBookedCommercialAdmin($result));
                }
                foreach ($admins as $admin) {
                    Mail::to($admin->email)->send(new AppointmentBookedCommercialAdmin($result));
                }
                Mail::to($result->email)->send(new AppointmentBooked($result));
            } catch (\Exception $e) {
                //Log error
                Log::error('Email sending failed: ' . $e->getMessage());
            }
        }

        return $result;
    }
    public function toggleRead($id, $tag)
    {
        $appointment = $this->repository->find($id);
        abort_if(!$appointment, Response::HTTP_NOT_FOUND, "Appointment not found");
        if ($tag == 'inside') {
            $appointment->read = true;
        } else {
            $appointment->read = !$appointment->read;
        }
        $appointment->save();

        // Return a response
        return response()->json([
            'success' => true,
            'message' => 'Read status updated successfully.',
            'read_status' => $appointment->read,
        ]);
    }

    public function updateStatus($status, $id, $user)
    {

        abort_if($status == "", Response::HTTP_UNPROCESSABLE_ENTITY, "Status can not be empty");
        $appointment = $this->repository->find($id);
        abort_if(!$appointment, Response::HTTP_NOT_FOUND, "Appointment not found");
        $appointment->status = strtolower($status);
        $appointment->updated_by = $user->id ?? null;
        $appointment->save();

        return response()->json([
            'success' => true,
            'message' => 'Status updated successfully to ' . $status,
            'status' => $status,
        ]);
    }



    public function getAppointment($id)
    {
        $appointment = $this->repository->find($id);
        abort_if(!$appointment, Response::HTTP_NOT_FOUND, "Appointment not found");
        return $appointment;
    }

    public function getAppointments($flag)
    {
        $appointments = $this->repository->setQuery()->where('flag', $flag)->orderBy('created_at', 'desc')->get();
        abort_if($appointments->count() == 0, Response::HTTP_NOT_FOUND, "No $flag appointment created");
        return $appointments;
    }

    public function countUnreadAppointments($flag)
    {
        $appointments = $this->repository->setQuery()->where([['flag', $flag], ['read', false]])->get();
        return $appointments->count();
    }

    public function deleteAppointment($id)
    {
        $appointment = $this->repository->find($id);
        abort_if(!$appointment, Response::HTTP_NOT_FOUND, "Appointment not found");
        return $this->repository->delete($id);
    }














    
}
