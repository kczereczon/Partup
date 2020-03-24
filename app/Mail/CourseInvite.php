<?php

namespace App\Mail;

use App\Course;
use App\Group;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class CourseInvite extends Mailable
{
    use Queueable, SerializesModels;

    protected $link;
    protected $group;
    protected $course;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(string $link, Group $group, Course $course)
    {
        $this->link = $link;
        $this->group = $group;
        $this->course = $course;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('mails.courseInvite', [
            'group' => $this->group,
            'course' => $this->course,
            'link' => $this->link
        ]);
    }
}
