<?php

namespace App\Http\Controllers;

use Illuminate\Http\Response;
use Illuminate\Http\Request;
use App\Services\{AppointmentService};
use App\Http\Resources\{ResidentialAppointmentResource, CommercialAppointmentResource};
use App\Http\Requests\{CreateResidentialAppointmentRequest, CreateCommercialAppointmentRequest};


class AppointmentController extends Controller
{


    protected $appointmentService;

    /**
     * 
     * @param AppointmentService $appointmentService
     */
    public function __construct(AppointmentService $appointmentService)
    {
        $this->appointmentService = $appointmentService;
    }

    public function createResidentialRequest(CreateResidentialAppointmentRequest $request)
    {
        $response = $this->appointmentService->createResidentialRequest($request);
        return $this->response(Response::HTTP_OK, new ResidentialAppointmentResource($response));
    }

    public function createCommercialRequest(CreateCommercialAppointmentRequest $request)
    {
        $response = $this->appointmentService->createCommercialRequest($request);
        return $this->response(Response::HTTP_OK, new CommercialAppointmentResource($response));
    }

    public function getAppointment($id)
    {
        $response = $this->appointmentService->getAppointment($id);
        if ($response->flag == 'residential') {
            return new ResidentialAppointmentResource($response);
        } else {
            return new CommercialAppointmentResource($response);
        }
    }


    public function getAppointments($flag)
    {
        $response = $this->appointmentService->getAppointments($flag);
        if ($flag == 'residential') {
            return ResidentialAppointmentResource::collection($response);
        } else {
            return CommercialAppointmentResource::collection($response);
        }
    }

    public function countUnreadAppointments($flag)
    {
        $response = $this->appointmentService->countUnreadAppointments($flag);
        return $response;
    }

    public function toggleRead($id, $tag)
    {
        $response = $this->appointmentService->toggleRead($id, $tag);
        return $this->response(Response::HTTP_OK, $response);
    }

    public function updateStatus(Request $request, $id)
    {
        $status = $request->status;
        $response = $this->appointmentService->updateStatus($status, $id, $request->user());
        return $this->response(Response::HTTP_OK, $response);
    }

    public function updateStatusClient(Request $request, $id)
    {
        $status = $request->status;
        $client = null;
        $response = $this->appointmentService->updateStatus($status, $id, $client);
        return $this->response(Response::HTTP_OK, $response);
    }

    public function deleteAppointment($id)
    {
        $this->appointmentService->deleteAppointment($id);
        return $this->response(Response::HTTP_OK);
    }
    


   


}
