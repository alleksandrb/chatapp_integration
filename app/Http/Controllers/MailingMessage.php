<?php

namespace App\Http\Controllers;

use App\Jobs\StartSendingMessages;
use App\Models\LogMessage;
use App\Models\Message;
use App\Models\Recipient;
use App\Models\Token;
use Illuminate\Http\Request;

class MailingMessage extends Controller
{
    public function index(Request $request)
    {
        if (!self::checkAndRefreshToken()) {
            throw new \Exception("Ошибка обновления токена");
        }

        $data = $request->all();

        $message = Message::create([
            'text' => $data['textMessage'],
        ])->text;

        $numbers = array_filter($data['phoneNumber'], function ($item) {
            return $item;
        });

        if (!empty($numbers)) {
            $recipients = [];
            foreach ($numbers as $phone) {
                $phone = preg_replace("/[^0-9]/", "", $phone);
                $recipients[] = Recipient::firstOrCreate([
                    'phone' => $phone,
                ]);
            }
        }

        if ($data['useoldphone'] == 0) {
            foreach ($recipients as $recipient) {
                dispatch(new StartSendingMessages($recipient->phone, $message));
                // ->delay(now()->addSeconds(random_int(5, 50)));
            }
        }

        if ($data['useoldphone'] == 1) {
            $recipients = Recipient::all();
            foreach ($recipients as $recipient) {
                dispatch(new StartSendingMessages($recipient->phone, $message))
                    ->delay(now()->addSeconds(random_int(5, 50)));
            }
        }

        return redirect()->route('status');
    }


    public static function checkAndRefreshToken()
    {

        $client = new \GuzzleHttp\Client();
        $url = 'https://api.chatapp.online/v1/tokens/check';

        $response = $client->get(
            $url,
            [
                'headers' => [
                    'Authorization' => Token::latest()->get()->value('access_token'),
                ],
            ]
        );
        $body = json_decode((string) $response->getBody());
        if ($body->success) {
            return true;
        } else {

            $url = 'https://api.chatapp.online/v1/tokens/refresh';
            $response = $client->post(
                $url,
                [
                    'headers' => [
                        'Refresh' => Token::latest()->get()->value('refresh_token'),
                    ],
                ]
            );

            $body = json_decode((string) $response->getBody());
            if ($body->success) {
                $data = $body->data;
                $a = Token::create([
                    'access_token' => $data->accessToken,
                    'access_token_end_time' => $data->accessTokenEndTime,
                    'refresh_token' => $data->refreshToken,
                    'refresh_token_end_time' => $data->refreshTokenEndTime,
                    'is_active' => 1,
                ]);
                if ($a) return true;
            }
        }
        return false;
    }

    public function logMessageStatus(Request $request)
    {
        $data = $request->all();
        dump($request);
        // if ($data['phone']) {
        // $lm = LogMessage::where('phone', $data['phone'])->get();
        // dd($lm);
        // $lm->status = $lm->status
        // }
    }
}
