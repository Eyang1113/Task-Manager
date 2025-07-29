<?php

use App\Models\Task;
use App\Models\User;
use function Pest\Laravel\actingAs;

test('user can create task', function () {
    $user = User::factory()->create();

    actingAs($user)
        ->get(route('addTask'))
        ->assertStatus(200);

    $newTask = [
        'title' => 'Test Task',
        'description' => 'This is a test task.',
        'due_date' => now()->addDay()->format('Y-m-d'),
        'status' => 'todo',
        'priority' => '1',
    ];

    actingAs($user)
        ->post(route('create.task'), $newTask)
        ->assertRedirect(route('dashboard'));

    $latestTask = Task::latest('id')->first();
    expect($latestTask)
        ->title->toBe($newTask['title'])
        ->description->toBe($newTask['description'])
        ->due_date->toBe($newTask['due_date'])
        ->status->toBe($newTask['status'])
        ->priority->toBe($newTask['priority']);
});

test('user can update task', function () {
    $user = User::factory()->create();
    $task = Task::factory()->for($user)->create();

    actingAs($user)
        ->get(route('edit.task', $task))
        ->assertStatus(200);

    $updateTask = [
        'title' => 'Test Task',
        'description' => 'This is a test task.',
        'due_date' => now()->addDay()->format('Y-m-d'),
        'status' => 'todo',
        'priority' => '1',
    ];

    actingAs($user)
        ->put(route('update.task', $task), $updateTask)
        ->assertRedirect(route('dashboard'));

    $updatedTask = Task::find($task->id);
    expect($updatedTask)
        ->title->toBe($updateTask['title'])
        ->description->toBe($updateTask['description'])
        ->due_date->toBe($updateTask['due_date'])
        ->status->toBe($updateTask['status'])
        ->priority->toBe($updateTask['priority']);
});

test('user can delete task', function() {
    $user = User::factory()->create();
    $task = Task::factory()->for($user)->create();

    actingAs($user)
        ->get(route('delete.task', $task))
        ->assertRedirect(route('dashboard'));
});

test('user can only access their own task', function() {
    $user1 = User::factory()->create();
    $user2 = User::factory()->create();
    $task = Task::factory()->for($user2)->create();

    actingAs($user1)
        ->get(route('delete.task', $task))
        ->assertRedirect(route('dashboard'));
});
