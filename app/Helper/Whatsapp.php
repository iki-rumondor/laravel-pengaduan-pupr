<?php

namespace App\Helper;

use Twilio\Rest\Client;

class Whatsapp
{

    public static function sendMessage($phoneNum, $body)
    {

        $sid    = env("TWILIO_SID");
        $token = env("TWILIO_AUTH_TOKEN");
        $twilioNum = env("TWILIO_WHATSAPP_NUMBER");

        $twilio = new Client($sid, $token);

        $message = $twilio->messages
            ->create(
                "whatsapp:$phoneNum",
                array(
                    "from" => "whatsapp:$twilioNum",
                    "body" => $body
                )
            );
        return $message;
    }

    public static function formatNomorHP($nomorHP) {
        $nomorHP = preg_replace('/[^0-9]/', '', $nomorHP);
        if (strlen($nomorHP) > 0) {
            if ($nomorHP[0] === '0') {
                $nomorHP = '+62' . substr($nomorHP, 1);
            } elseif (substr($nomorHP, 0, 2) !== '62') {
                $nomorHP = '+62' . $nomorHP;
            }
        }
        return $nomorHP;
    }
}
