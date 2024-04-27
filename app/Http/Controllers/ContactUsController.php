<?php

namespace App\Http\Controllers;

use Illuminate\Http\Response;
use Illuminate\Http\Request;
use App\Services\{ContactUsService};
use App\Http\Resources\{ContactMessageResource};
use App\Http\Requests\{ContactUsSendMessageRequest};


class ContactUsController extends Controller
{


    protected $contactUsService;

    /**
     * 
     * @param ContactUsService $contactUsService
     */
    public function __construct(ContactUsService $contactUsService)
    {
        $this->contactUsService = $contactUsService;
    }

    public function sendMessage(ContactUsSendMessageRequest $request)
    {
        $response = $this->contactUsService->sendMessage($request->all());
        return $this->response(Response::HTTP_OK, new ContactMessageResource($response));
    }

    public function getMessage($id)
    {
        $response = $this->contactUsService->getMessage($id);
        return new ContactMessageResource($response);
    }


    public function getMessages()
    {
        $response = $this->contactUsService->getMessages();
        return ContactMessageResource::collection($response);
    }

    public function countUnreadMessages()
    {
        $response = $this->contactUsService->countUnreadMessages();
        return $response;
    }

    public function toggleReadStatus($id, $tag)
    {
        $response = $this->contactUsService->toggleRead($id, $tag);
        return $this->response(Response::HTTP_OK, $response);
    }

    public function deleteMessage($id)
    {
        $this->contactUsService->deleteMessage($id);
        return $this->response(Response::HTTP_OK);
    }
}
