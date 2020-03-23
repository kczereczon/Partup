<?php

use App\Course;
use App\CourseInvitation;
use App\User;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Hash;

class CourseService
{
    public function createNewInvitation($email, Course $course): CourseInvitation
    {
        /** @var CourseInvitation|Builder $invitation */
        $invitation = new CourseInvitation();
        $invitation = $invitation->create([
            'course_id' => $course->id,
            'email' => $email,
            'invite_hash' => md5($email)
        ]);

        return $invitation;
    }


    public function sendInvite(CourseInvitation $courseInvitiation)
    {

}
