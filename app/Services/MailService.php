<?php

namespace App\Services;
use App\Mail\SubmittedForm;
use Mail;

class MailService
{
    public function send(
        $values, $view, $to = '', $subject = '', $attachments = [], $cc = null
    ) {
        if($to) {
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
        }

        return true;
    }  
}