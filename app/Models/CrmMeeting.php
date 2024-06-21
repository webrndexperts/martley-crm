<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Jubaer\Zoom\Facades\Zoom;

class CrmMeeting extends Model
{
    use HasFactory;

    public function meeting() {
        return $this->hasOne(CrmSession::class);
    }

    /**
     * Function to create Zoom meeting link.
     * @param title String value,
     * @param start String date time value.
     * 
     * @return Array value of meeting.
     */
    public static function createMeeting($title, $start) {
        $meetings = Zoom::createMeeting([
            "agenda" => $title,
            "topic" => $title,
            "type" => 2, // 1 => instant, 2 => scheduled, 3 => recurring with no fixed time, 8 => recurring with fixed time
            "duration" => 60,
            "timezone" => 'Asia/Delhi',
            "password" => '',
            "start_time" => $start, 
            "template_id" => 'Dv4YdINdTk+Z5RToadh5ug==123', // set your template id  Ex: "Dv4YdINdTk+Z5RToadh5ug==" from https://marketplace.zoom.us/docs/api-reference/zoom-api/meetings/meetingtemplates
            "pre_schedule" => false,  // set true if you want to create a pre-scheduled meeting
            "schedule_for" => '',
            "settings" => [
                'join_before_host' => true,
                'host_video' => false,
                'participant_video' => true,
                'mute_upon_entry' => false,
                'waiting_room' => false, 
                'audio' => 'both',
                'auto_recording' => 'none',
                'approval_type' => 0, // 0 => Automatically Approve, 1 => Manually Approve, 2 => No Registration Required
            ],
        ]);

        return $meetings;
    }

    /**
     * Function to delete Zoom meeting.
     * @param id String value of meeting id,
     * 
     * @return Array value of meeting.
     */
    public static function deleteMeeting($id) {
        $meetings = Zoom::deleteMeeting($id);

        return $meetings;
    }
}
