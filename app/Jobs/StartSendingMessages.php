<?php

namespace App\Jobs;

use App\Models\LogMessage;
use App\Models\Token;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class StartSendingMessages implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $phone;
    public $message;

    public function __construct($phone, $message)
    {
        $this->phone = $phone;
        $this->message = $message;
    }

    public function handle(): void
    {
        $client = new \GuzzleHttp\Client();
        $licenseId = config('chatapp.licenseid');
        $messengerType = 'grWhatsApp';
        $chatId = $this->phone; // phone or chatId
        $accessToken = Token::latest()->get()->value('access_token');
        try {
            $client->post(
                "https://api.chatapp.online/v1/licenses/$licenseId/messengers/$messengerType/chats/$chatId/messages/text",
                [
                    'headers' => [
                        'Authorization' => $accessToken,
                    ],
                    'json' => [
                        'text' => $this->message,
                    ],
                ]
            );

            dispatch(new LogMessageJob($this->phone, $this->message));
        } catch (\Exception $e) {
            echo '<pre>';
            print_r([$e->getCode(), $e->getMessage()]);
        }
    }
}
