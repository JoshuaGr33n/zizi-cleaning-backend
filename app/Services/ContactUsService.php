<?php

namespace App\Services;

use App\Models\{ContactForm};
use App\Repositories\{Repository, UserRepository};
use App\Services\{SettingService};
use Illuminate\Http\Response;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;


use Illuminate\Support\Facades\Mail;
use App\Mail\ContactFormMail;


class ContactUsService
{
    protected $repository;
  
    protected $settings;

    public function __construct(Repository $repository, SettingService $settingService)
    {
        $this->repository = $repository;
        $this->repository->setModel(new ContactForm());
        $this->settings = $settingService;
    }

    public function sendMessage(array $data)
    {
        $result = $this->repository->create($data);
        $Emails = $this->settings->getSettingCategory('Email');
        if ($result) {
            try {
                foreach ($Emails as $value) {
                    Mail::to($value->value)->send(new ContactFormMail($result));
                }
            } catch (\Exception $e) {
                // Log error
                Log::error('Email sending failed: ' . $e->getMessage());
            }
        }
        return $result;
    }

    public function toggleRead($id, $tag)
    {
        $message = $this->repository->find($id);
        abort_if(!$message, Response::HTTP_NOT_FOUND, "Message not found");
        if ($tag == 'inside') {
            $message->read_unread = true;
        }
         else {
            $message->read_unread = !$message->read_unread;
        }
        $message->save();

        return response()->json([
            'success' => true,
            'message' => 'Read status updated successfully.',
            'read_status' => $message->read_unread,
        ]);
    }

    public function getMessage($id)
    {
        $message = $this->repository->find($id);
        abort_if(!$message, Response::HTTP_NOT_FOUND, "Message not found");
        return $message;
    }

    public function getMessages()
    {
        $messages = $this->repository->setQuery()->orderBy('created_at', 'desc')->get();
        abort_if($messages->count() == 0, Response::HTTP_NOT_FOUND, "No messages created");
        return $messages;
    }

    public function countUnreadMessages()
    {
        $appointments = $this->repository->setQuery()->where([['read_unread', false]])->get();
        return $appointments->count();
    }

    public function deleteMessage($id)
    {
        $message = $this->repository->find($id);
        abort_if(!$message, Response::HTTP_NOT_FOUND, "Message not found");
        return $this->repository->delete($id);
    }
    
}
