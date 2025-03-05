<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class NotificationService
{
    private string $notificationEndpoint;
    private string $apiKey;
    public function __construct()
    {
        $this->notificationEndpoint = env('NOTIFICATION_SERVICE');
        $this->apiKey = env('NOTIFICATION_SERVICE_API_KEY');
    }

    public function sendMail(array $dataSet,string $template, string $subject){
        Http::withHeaders([
            'x-api-key'=>$this->apiKey
        ])->post($this->notificationEndpoint.'/mail/send',[
            'data_set'=>$dataSet,
            'template_name'=>$template,
            'subject'=>$subject,
        ]);
    }
}
