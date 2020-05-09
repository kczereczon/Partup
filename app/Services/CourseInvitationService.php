<?php

namespace App\Services;

use App\Course;
use App\Group;
use App\CourseInvitation;
use App\Mail\CourseInvite;
use App\User;
use Exception;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Auth;

class CourseInvitationService
{
    /**
     * This method is simple creates invitation for new user.
     *
     * @param mixed $email
     * @param Course $course
     * @return CourseInvitation
     */
    public function createInvitation($email, Course $course): CourseInvitation
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
        $link = env("APP_URL") . "/#/course-invite?hash=" . $courseInvitiation->invite_hash;
        $course = new Course();
        $course = $course->findOrFail($courseInvitiation->course_id);

        $group = new Group();
        $group = $group->findOrFail($course->group_id);
        try {
            Mail::to($courseInvitiation)->send(new CourseInvite($link, $group, $courseInvitiation->course));
        } catch (Exception $e) {
            Log::error($e);
            return false;
        }
        return true;
    }

    public function acceptInvite(CourseInvitation $courseInvitiation, User $user)
    {
        try {
            Course::where('id', $courseInvitiation->course_id)->update(['teacher_id' => Auth::user()->id]);

            $courseInvitiation->accepted = true;
            $courseInvitiation->save();

            return true;
        } catch (Exception $e) {
            Log::error($e);
            return $e;
        }
    }
}
