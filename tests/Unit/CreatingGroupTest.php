<?php

namespace Tests\Unit;

use App\Group;
use App\User;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\Response;
use Illuminate\Testing\TestResponse;

class CreatingGroupTest extends TestCase
{
    use RefreshDatabase;

    /**
     * A basic unit test example.
     *
     * @return void
     */
    public function testCreatingGroupWithSessionTest()
    {
        $user = factory(User::class)->create();

        /** @var TestResponse $response */
        $response = $this->actingAs($user, 'api')
            ->postJson('/api/groups', ['name' => "group1"]);

        $response->assertStatus(200, $response->status())
            ->assertJson(['created' => true]);
    }

    /**
     * A basic unit test example.
     *
     * @return void
     */
    public function testCreatingGroupWithSessionAndMissingNameTest()
    {
        $user = factory(User::class)->create();

        /** @var TestResponse $response */
        $response = $this->actingAs($user, 'api')
            ->postJson('/api/groups', []);

        $response->assertStatus(422, $response->status());
    }


    /**
     * A basic unit test example.
     *
     * @return void
     */
    public function testCreatingGroupWithSessionAndHigherGroupTest()
    {
        $user = factory(User::class)->create();
        $group = factory(Group::class)->create(['group_id' => null]);

        /** @var TestResponse $response */
        $response = $this->actingAs($user, 'api')
            ->postJson('/api/groups', ['name' => "group1", 'group_id' => $group->id]);

        $response->assertStatus(200, $response->status())
            ->assertJson(['created' => true]);
    }

    /**
     * A basic unit test example.
     *
     * @return void
     */
    public function testCreatingGroupWithoutSessionTest()
    {
        /** @var TestResponse $response */
        $response = $this->postJson('/api/groups', ['name' => "group1"]);

        $this->assertEquals(401, $response->status());
    }

    public function testGetGroupWithSessionTest()
    {
        $user = factory(User::class)->create();
        $group = factory(Group::class)->create(['owner_id' => $user->id]);
        $group1 = factory(Group::class)->create(['owner_id' => $user->id, 'group_id' => $group->id]);
        $group2 = factory(Group::class)->create(['owner_id' => $user->id, 'group_id' => $group1->id]);

        /** @var TestResponse $response */
        $response = $this->actingAs($user, 'api')
            ->getJson("/api/groups");

        $response->assertStatus(200, $response->status());
    }

    public function testDestoryGroupAuthorizedTest()
    {
        $user = factory(User::class)->create();
        $group = factory(Group::class)->create(['owner_id' => $user->id]);
        $group1 = factory(Group::class)->create(['owner_id' => $user->id, 'group_id' => $group->id]);

        /** @var TestResponse $response */
        $response = $this->actingAs($user, 'api')
            ->deleteJson("/api/groups/{$group->id}");

        $response->assertStatus(200, $response->status())->assertJson([
            'destroyed' => true,
        ]);

        $this->assertEmpty(Group::find($group1->id));
    }

    public function testDestoryGroupUnauthorizedTest()
    {
        $user = factory(User::class)->create();
        $user1 = factory(User::class)->create();
        $group = factory(Group::class)->create(['owner_id' => $user1->id]);

        /** @var TestResponse $response */
        $response = $this->actingAs($user, 'api')
            ->deleteJson("/api/groups/{$group->id}");

        $response->assertStatus(401, $response->status());
    }

    public function testUpdateAuthorizedTest()
    {
        $user = factory(User::class)->create();
        $group = factory(Group::class)->create(['owner_id' => $user->id]);

        /** @var TestResponse $response */
        $response = $this->actingAs($user, 'api')
            ->patchJson("/api/groups/{$group->id}", ['name' => "updated"]);

        $response->assertStatus(200, $response->status())->assertJson(['updated' => true]);

        $group = Group::find($group->id);

        $this->assertEquals('updated', $group->name);
    }

    public function testUpdateUnauthorizedTest()
    {
        $user = factory(User::class)->create();
        $user1 = factory(User::class)->create();
        $group = factory(Group::class)->create(['owner_id' => $user1->id]);

        /** @var TestResponse $response */
        $response = $this->actingAs($user, 'api')
            ->patchJson("/api/groups/{$group->id}", ['name' => "updated"]);

        $response->assertStatus(401, $response->status());
    }
}
