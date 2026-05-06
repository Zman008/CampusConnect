<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\CommunityGroup;
use App\Models\CommunityMessage;
use Tests\TestCase;

class CommunityTest extends TestCase
{
    /**
     * Test that community index page requires authentication
     */
    public function test_community_requires_auth()
    {
        $response = $this->get('/community');
        $response->assertRedirect('/login');
    }

    /**
     * Test authenticated user can view community page
     */
    public function test_authenticated_user_can_view_community()
    {
        $user = User::factory()->create();
        $response = $this->actingAs($user)->get('/community');
        $response->assertStatus(200);
        $response->assertViewHas('groups');
    }

    /**
     * Test user can view a specific group chat
     */
    public function test_user_can_view_group_chat()
    {
        $user = User::factory()->create();
        $group = CommunityGroup::first();
        
        $response = $this->actingAs($user)->get("/community/group/{$group->id}");
        $response->assertStatus(200);
        $response->assertViewHas('group', $group);
    }

    /**
     * Test user can send a message
     */
    public function test_user_can_send_message()
    {
        $user = User::factory()->create();
        $group = CommunityGroup::first();
        
        $response = $this->actingAs($user)->postJson(
            "/community/group/{$group->id}/message",
            ['message' => 'Hello world!']
        );

        $response->assertStatus(200);
        $response->assertJsonStructure(['success', 'message']);
        
        $this->assertDatabaseHas('community_messages', [
            'group_id' => $group->id,
            'user_id' => $user->id,
            'message' => 'Hello world!',
        ]);
    }

    /**
     * Test regular form submissions return to the chat instead of showing JSON
     */
    public function test_regular_message_form_submit_redirects_back_to_chat()
    {
        $user = User::factory()->create();
        $group = CommunityGroup::first();

        $response = $this->actingAs($user)->post(
            "/community/group/{$group->id}/message",
            ['message' => 'Hello from the form!']
        );

        $response->assertRedirect("/community/group/{$group->id}");

        $this->assertDatabaseHas('community_messages', [
            'group_id' => $group->id,
            'user_id' => $user->id,
            'message' => 'Hello from the form!',
        ]);
    }

    /**
     * Test message validation
     */
    public function test_message_validation()
    {
        $user = User::factory()->create();
        $group = CommunityGroup::first();
        
        // Empty message
        $response = $this->actingAs($user)->postJson(
            "/community/group/{$group->id}/message",
            ['message' => '']
        );
        $response->assertStatus(422);
        
        // Message too long
        $response = $this->actingAs($user)->postJson(
            "/community/group/{$group->id}/message",
            ['message' => str_repeat('a', 1001)]
        );
        $response->assertStatus(422);
    }

    /**
     * Test user can retrieve messages
     */
    public function test_user_can_retrieve_messages()
    {
        $user = User::factory()->create();
        $group = CommunityGroup::first();
        
        // Create some messages
        CommunityMessage::create([
            'group_id' => $group->id,
            'user_id' => $user->id,
            'message' => 'Test message 1',
        ]);

        $response = $this->actingAs($user)->getJson(
            "/community/group/{$group->id}/messages"
        );

        $response->assertStatus(200);
        $response->assertJsonStructure(['messages']);
        $this->assertCount(1, $response->json('messages'));
    }

    /**
     * Test retrieving only newer messages
     */
    public function test_user_can_retrieve_messages_after_an_id()
    {
        $user = User::factory()->create();
        $group = CommunityGroup::first();

        $oldMessage = CommunityMessage::create([
            'group_id' => $group->id,
            'user_id' => $user->id,
            'message' => 'Old message',
        ]);

        $newMessage = CommunityMessage::create([
            'group_id' => $group->id,
            'user_id' => $user->id,
            'message' => 'New message',
        ]);

        $response = $this->actingAs($user)->getJson(
            "/community/group/{$group->id}/messages?after_id={$oldMessage->id}"
        );

        $response->assertStatus(200);
        $this->assertCount(1, $response->json('messages'));
        $this->assertSame($newMessage->id, $response->json('messages.0.id'));
    }
}
