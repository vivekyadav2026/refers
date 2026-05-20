<?php

namespace App\Services;

use Illuminate\Support\Facades\Log;

class SmsService
{
    /**
     * Send SMS to a specific phone number.
     * 
     * @param string $phone
     * @param string $message
     * @return bool
     */
    public function send(string $phone, string $message): bool
    {
        // TODO: Integrate actual SMS Gateway API here (e.g. Twilio, MSG91, Textlocal)
        // Example for MSG91:
        // Http::get('https://api.msg91.com/api/sendhttp.php', [
        //     'authkey' => config('services.msg91.key'),
        //     'mobiles' => $phone,
        //     'message' => $message,
        //     'sender' => 'SKSOLU',
        //     'route' => '4'
        // ]);
        
        Log::info("SMS_GATEWAY: Sending to $phone -> $message");

        return true;
    }

    /**
     * Send OTP SMS.
     */
    public function sendOtp(string $phone, string $otp): bool
    {
        $message = "Your SK Solutions login OTP is $otp. Do not share this with anyone.";
        return $this->send($phone, $message);
    }
}
