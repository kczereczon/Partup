<?php

namespace Tests\Unit;

use App\Course;
use App\User;
use PHPUnit\Framework\TestCase;
use Faker\Generator;

class CourseTest extends TestCase
{
    /**
     * A basic unit test example.
     *
     * @return void
     */
    public function testExample()
    {
        $this->assertTrue(true);
    }

    public function testCreateCourse()
    {
        $faker = new Generator();

        $user = factory(User::class)->create();

        /** @var TestResponse $response */
        $response = $this->actingAs($user, 'api')
            ->post("/api/v1/course", ['teacher_email' => $faker->email, 'name' => $faker->name]);

        $response->assertStatus(200, $response->status())->assertJson([
            'created' => true,
        ]);
    }
}
