<?php

namespace WebWork\Features;

class Mail {
    public static  function send($to, $subject, $message) {
        $message = wordwrap($message, 68);

        $headers = 'From: '.config('MAIL_ADDRESS')."\r\n".
                   'Reply-To: '.config('MAIL_ADDRESS')."\r\n";

        mail($to, $subject, $message, $headers);
    }
}
