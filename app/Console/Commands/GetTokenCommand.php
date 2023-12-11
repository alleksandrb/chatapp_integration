<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class GetTokenCommand extends Command
{

    protected $signature = 'get_token';

    public function handle()
    {
        $client = new \GuzzleHttp\Client();
        try {
            $response = $client->post(
                'https://api.chatapp.online/v1/tokens',
                [
                    'headers' => [
                        'Content-Type' => 'application/json',
                    ],
                    'json' => [
                        'email' => config('chatapp.email'), // email из личного кабинета
                        'password' => config('chatapp.password'), // пароль из личного кабинета
                        'appId' => config('chatapp.appid'), // appId из личного кабинета
                    ],
                ]
            );
            $body = $response->getBody();
            echo '<pre>';
            print_r(json_decode((string)$body));
        } catch (\Exception $e) {
            echo '<pre>';
            print_r([$e->getCode(), $e->getMessage()]);
        }
    }
}
