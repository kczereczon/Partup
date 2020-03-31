<?php

namespace App\Services;

use App\Homework;

class DiscordNotificationService
{
    protected $content;

    public function generateHomeworkMessage(Homework $homework)
    {
        $message = json_encode([
            // Username
            "username" => "Zadankowy BOT",

            "embeds" => [
                [
                    // Embed Title
                    "title" => "Homework",

                    // Embed Type
                    "type" => "rich",

                    // Embed Description
                    //"description" => "User just has been added you a new homework, see below for more details. ",

                    // Embed Description
                    "description" => $homework->name,


                    // Embed left border color in HEX
                    "color" => hexdec("3366ff"),

                    // Footer
                    // "footer" => [
                    //     "text" => "GitHub.com/Mo45",
                    //     "icon_url" => "https://ru.gravatar.com/userimage/28503754/1168e2bddca84fec2a63addb348c571d.jpg?size=375"
                    // ],

                    // // Image to send
                    // "image" => [
                    //     "url" => "https://ru.gravatar.com/userimage/28503754/1168e2bddca84fec2a63addb348c571d.jpg?size=600"
                    // ],

                    // Thumbnail
                    //"thumbnail" => [
                    //    "url" => "https://ru.gravatar.com/userimage/28503754/1168e2bddca84fec2a63addb348c571d.jpg?size=400"
                    //],

                    // Author
                    "author" => [
                        "name" => "krzysztof.czereczon",
                    ],
                    // Additional Fields array
                    "fields" => [
                        [
                            "name" => "Course",
                            "value" => $homework->course->name,
                            "inline" => false
                        ],
                        [
                            "name" => "Description",
                            "value" => "$homework->description",
                            "inline" => true
                        ],
                        [
                            "name" => "Requirements",
                            "value" => "$homework->requirements",
                            "inline" => true
                        ],
                        [
                            "name" => "Deadline",
                            "value" => $homework->deadline,
                            "inline" => false
                        ],
                        [
                            "name" => "Where send",
                            "value" => $homework->where_send,
                            "inline" => false
                        ]
                    ]
                ]
            ]

        ], JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);

        $this->content = $message;

        return $this;
    }

    public function generateExamMessage(Exam $exam)
    {
        $message = json_encode([
            // Username
            "username" => "Egzaminowy BOT",

            "embeds" => [
                [
                    // Embed Title
                    "title" => "Exam",

                    // Embed Type
                    "type" => "rich",

                    // Embed Description
                    //"description" => "User just has been added you a new homework, see below for more details. ",

                    // Embed Description
                    "description" => $exam->name,


                    // Embed left border color in HEX
                    "color" => hexdec("3366ff"),

                    // Footer
                    // "footer" => [
                    //     "text" => "GitHub.com/Mo45",
                    //     "icon_url" => "https://ru.gravatar.com/userimage/28503754/1168e2bddca84fec2a63addb348c571d.jpg?size=375"
                    // ],

                    // // Image to send
                    // "image" => [
                    //     "url" => "https://ru.gravatar.com/userimage/28503754/1168e2bddca84fec2a63addb348c571d.jpg?size=600"
                    // ],

                    // Thumbnail
                    //"thumbnail" => [
                    //    "url" => "https://ru.gravatar.com/userimage/28503754/1168e2bddca84fec2a63addb348c571d.jpg?size=400"
                    //],

                    // Author
                    "author" => [
                        "name" => "krzysztof.czereczon",
                    ],
                    // Additional Fields array
                    "fields" => [
                        [
                            "name" => "Course",
                            "value" => $exam->course->name,
                            "inline" => false
                        ],
                        [
                            "name" => "Description",
                            "value" => "$exam->description",
                            "inline" => true
                        ],
                        [
                            "name" => "Range of knowlage",
                            "value" => "$exam->range_of_knowlage",
                            "inline" => true
                        ],
                        [
                            "name" => "Place",
                            "value" => $exam->place,
                            "inline" => true
                        ],
                        [
                            "name" => "Time",
                            "value" => $exam->time,
                            "inline" => true
                        ]
                    ]
                ]
            ]

        ], JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);

        $this->content = $message;

        return $this;
    }

    public function generateNewsMessage(News $news)
    {
        $message = json_encode([
            // Username
            "username" => "Wiadomościowy BOT",

            "embeds" => [
                [
                    // Embed Title
                    "title" => "News",

                    // Embed Type
                    "type" => "rich",

                    // Embed Description
                    "description" => $news->title,


                    // Embed left border color in HEX
                    "color" => hexdec("3366ff"),

                    // Footer
                    // "footer" => [
                    //     "text" => "GitHub.com/Mo45",
                    //     "icon_url" => "https://ru.gravatar.com/userimage/28503754/1168e2bddca84fec2a63addb348c571d.jpg?size=375"
                    // ],

                    // // Image to send
                    // "image" => [
                    //     "url" => "https://ru.gravatar.com/userimage/28503754/1168e2bddca84fec2a63addb348c571d.jpg?size=600"
                    // ],

                    // Thumbnail
                    //"thumbnail" => [
                    //    "url" => "https://ru.gravatar.com/userimage/28503754/1168e2bddca84fec2a63addb348c571d.jpg?size=400"
                    //],

                    // Author
                    "author" => [
                        "name" => "krzysztof.czereczon",
                    ],
                    // Additional Fields array
                    "fields" => [
                        [
                            "name" => "Course",
                            "value" => $news->course->name,
                            "inline" => false
                        ],
                        [
                            "name" => "Message",
                            "value" => "$news->message",
                            "inline" => false
                        ]
                    ]
                ]
            ]

        ], JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);

        $this->content = $message;

        return $this;
    }

    public function send(array $webhooks)
    {
        foreach ($webhooks as $key => $webhookurl) {
            $ch = curl_init($webhookurl);
            curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-type: application/json'));
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $this->content);
            curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
            curl_setopt($ch, CURLOPT_HEADER, 0);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

            $response = curl_exec($ch);
            // If you need to debug, or find out why you can't send message uncomment line below, and execute script.
            // echo $response;
            curl_close($ch);
        }
    }
}
