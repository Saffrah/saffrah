<?php

namespace App\Http\Services;

use App\Http\Repositories\MessageRepository;
use App\Notifications\SendPushNotification;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Auth;

use App\Models\Company;
use App\Models\User;

class MessageService
{
    private $message_repository;

    public function __construct(MessageRepository $message_repository = null) 
    {
        $this->message_repository = $message_repository;
    }

    public function getAll() 
    {
        return $this->message_repository->all();    
    }

    public function save($request) 
    {
        if($request['type'] == 'companies') {
            $users = Company::all();
        }
        else {
            $users = User::all();
        }

        Notification::send($users, new SendPushNotification($request['title'], $request['message']));

        return $this->message_repository->create($request);
    }

    public function updatePercentage($input) 
    {
        return $this->message_repository->update($input['message_id'], ['percentage' => $input['percentage']]);
    }

    public function delete($request) 
    {
        return $this->message_repository->delete($request['message_id']);
    }

}
