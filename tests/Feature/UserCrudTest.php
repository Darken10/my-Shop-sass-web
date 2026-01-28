<?php

use App\Models\User;

describe('User CRUD', function () {
    beforeEach(function () {
        $this->user = User::factory()->create();
    });

    describe('Index', function () {
        test('user can view users list', function () {
            $response = $this->actingAs($this->user)->get(route('users.index'));
            $response->assertStatus(200);
            $response->assertViewIs('users.index');
        });

        test('users list shows user data', function () {
            $users = User::factory()->count(3)->create();
            $response = $this->actingAs($this->user)->get(route('users.index'));
            $response->assertStatus(200);
            $response->assertSeeInOrder([
                $users[0]->email,
                $users[1]->email,
                $users[2]->email,
            ]);
        });

        test('unauthenticated user cannot view users list', function () {
            $response = $this->get(route('users.index'));
            $response->assertRedirect(route('login'));
        });
    });

    describe('Create', function () {
        test('user can view create form', function () {
            $response = $this->actingAs($this->user)->get(route('users.create'));
            $response->assertStatus(200);
            $response->assertViewIs('users.create');
        });

        test('user can create a new user', function () {
            $userData = [
                'name' => 'John Doe',
                'email' => 'john@example.com',
                'password' => 'password123',
                'first_name' => 'John',
                'last_name' => 'Doe',
                'phone' => '+1234567890',
                'country' => 'France',
                'city' => 'Paris',
                'address' => '123 Rue de la Paix',
            ];

            $response = $this->actingAs($this->user)->post(route('users.store'), $userData);

            expect(User::where('email', 'john@example.com')->exists())->toBeTrue();
            $createdUser = User::where('email', 'john@example.com')->first();
            expect($createdUser->name)->toBe('John Doe');
            expect($createdUser->first_name)->toBe('John');
            expect($createdUser->last_name)->toBe('Doe');
            expect($createdUser->phone)->toBe('+1234567890');
            expect($createdUser->country)->toBe('France');
            expect($createdUser->city)->toBe('Paris');
            expect($createdUser->address)->toBe('123 Rue de la Paix');
            expect($createdUser->created_by)->toBe($this->user->id);
            expect($createdUser->created_mode)->toBe('manual');

            $response->assertRedirect(route('users.show', $createdUser));
        });

        test('validation fails with invalid email', function () {
            $userData = [
                'name' => 'John Doe',
                'email' => 'invalid-email',
                'password' => 'password123',
            ];

            $response = $this->actingAs($this->user)->post(route('users.store'), $userData);
            $response->assertSessionHasErrors('email');
        });

        test('validation fails with short password', function () {
            $userData = [
                'name' => 'John Doe',
                'email' => 'john@example.com',
                'password' => 'short',
            ];

            $response = $this->actingAs($this->user)->post(route('users.store'), $userData);
            $response->assertSessionHasErrors('password');
        });
    });

    describe('Show', function () {
        test('user can view user details', function () {
            $testUser = User::factory()->create([
                'first_name' => 'Jane',
                'last_name' => 'Smith',
                'phone' => '+1234567890',
                'city' => 'Paris',
            ]);

            $response = $this->actingAs($this->user)->get(route('users.show', $testUser));
            $response->assertStatus(200);
            $response->assertViewIs('users.show');
            $response->assertSee('Jane');
            $response->assertSee('Smith');
            $response->assertSee('+1234567890');
        });
    });

    describe('Edit', function () {
        test('user can view edit form', function () {
            $testUser = User::factory()->create();
            $response = $this->actingAs($this->user)->get(route('users.edit', $testUser));
            $response->assertStatus(200);
            $response->assertViewIs('users.edit');
        });

        test('user can update user profile', function () {
            $testUser = User::factory()->create();

            $updateData = [
                'first_name' => 'Updated First',
                'last_name' => 'Updated Last',
                'phone' => '+9876543210',
                'country' => 'USA',
                'city' => 'New York',
                'address' => '456 New Street',
            ];

            $response = $this->actingAs($this->user)->put(route('users.update', $testUser), $updateData);

            $testUser->refresh();
            expect($testUser->first_name)->toBe('Updated First');
            expect($testUser->last_name)->toBe('Updated Last');
            expect($testUser->phone)->toBe('+9876543210');
            expect($testUser->country)->toBe('USA');
            expect($testUser->city)->toBe('New York');
            expect($testUser->address)->toBe('456 New Street');
            expect($testUser->updated_by)->toBe($this->user->id);

            $response->assertRedirect(route('users.show', $testUser));
        });
    });

    describe('Delete', function () {
        test('user can soft delete a user', function () {
            $testUser = User::factory()->create();

            $response = $this->actingAs($this->user)->delete(route('users.destroy', $testUser));

            $testUser->refresh();
            expect($testUser->trashed())->toBeTrue();
            $response->assertRedirect(route('users.index'));
        });

        test('user can restore a soft deleted user', function () {
            $testUser = User::factory()->create();
            $testUser->delete();

            $response = $this->actingAs($this->user)->post(route('users.restore', $testUser->id));

            $testUser->refresh();
            expect($testUser->trashed())->toBeFalse();
            $response->assertRedirect(route('users.show', $testUser));
        });

        test('user can permanently delete a soft deleted user', function () {
            $testUser = User::factory()->create();
            $testUser->delete();

            $response = $this->actingAs($this->user)->delete(route('users.force-delete', $testUser->id));

            expect(User::withTrashed()->find($testUser->id))->toBeNull();
            $response->assertRedirect(route('users.index'));
        });
    });
});
