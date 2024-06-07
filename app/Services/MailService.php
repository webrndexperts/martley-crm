<?php

namespace App\Services;
use App\Mail\SubmittedForm;
use Mail;

class MailService
{
    public function send(
        $values, $view, $to = 'srdev.rndexperts@gmail.com', $subject = 'Testing', $attachments = [], $cc = null
    ) {
        Mail::send($view, $values, function ($message) use($to, $subject, $attachments, $cc) {
            $message->to($to)->subject($subject);
            if($cc && count($cc) > 0) {
                $message->cc($cc);
            }

            if(count($attachments) > 0) {
                foreach($files as $file) {
                    $message->attach($file);
                }
            }
        });

        return true;
    }  
}