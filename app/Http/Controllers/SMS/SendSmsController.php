<?php

namespace App\Http\Controllers\SMS;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class SendSmsController extends Controller
{
    /** Sending SMS */
    public function sendSms()
    {
        $basic  = new \Vonage\Client\Credentials\Basic("37b20754", "1VnQkBaqxIvNqVvs");
        $client = new \Vonage\Client($basic);

        $response = $client->sms()->send(
            new \Vonage\SMS\Message\SMS("201125753904", 'Test laravel project', 'Welcome to my project')
        );
        $message = $response->current();

        /** Just For Test */
        if ($message->getStatus() == 0) {
            echo "The message was sent successfully\n";
        } else {
            echo "The message failed with status: " . $message->getStatus() . "\n";
        }
    }
}
