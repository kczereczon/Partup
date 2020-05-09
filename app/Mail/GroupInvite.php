<?php

namespace App\Mail;

use App\Course;
use App\Group;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class GroupInvite extends Mailable
{
    use Queueable, SerializesModels;

    protected $link;
    protected $group;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(string $link, Group $group)
    {
        $this->link = $link;
        $this->group = $group;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('mails.groupInvite', [
            'group' => $this->group,
            'link' => $this->link
        ]);
    }
}
