<?php

namespace Database\Factories;

use App\Models\Team;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Laravel\Jetstream\Features;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\User>
 */
class UserFactory extends Factory
{
    /**
     * The current password being used by the factory.
     */
    protected static ?string $password;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => fake()->name(),
            'username' => fake()->unique()->userName(),
            'email' => fake()->unique()->safeEmail(),
            'email_verified_at' => now(),
            'password' => static::$password ??= Hash::make('password'),
            'two_factor_secret' => null,
            'two_factor_recovery_codes' => null,
            'remember_token' => Str::random(10),
            'profile_photo_path' => $this->generateProfilePhoto(),
            'current_team_id' => null,
            'created_at' => fake()->dateTimeBetween('-1 year', 'now'),
            'updated_at' => fake()->dateTimeBetween('-1 year', 'now'),
        ];
    }

    /**
     * Generate and save a profile photo.
     */
    protected function generateProfilePhoto(): ?string
    {
        try {
            $seed = fake()->unique()->name();

            Log::info('Generating avatar', [
                'seed' => $seed,
                'endpoint' => config('services.avatar.endpoint')
            ]);

            $response = Http::post(config('services.avatar.endpoint'), [
                'seed' => $seed
            ]);

            if (!$response->successful()) {
                Log::warning('Avatar generation request failed', [
                    'status' => $response->status(),
                    'body' => $response->body(),
                    'seed' => $seed
                ]);
                throw new \Exception('Failed to generate avatar: ' . $response->body());
            }

            $svg = $response->body();
            $filename = 'profile-photos/auto-generated/' . Str::random(20) . '.svg';

            Log::info('Storing avatar', [
                'filename' => $filename,
                'size' => strlen($svg)
            ]);

            Storage::disk('s3')->put($filename, $svg);

            Log::info('Avatar generated and stored successfully', [
                'filename' => $filename
            ]);

            return $filename;
        } catch (\Exception $e) {
            Log::error('Avatar generation failed', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
                'seed' => $seed ?? null
            ]);
            return null;
        }
    }

    /**
     * Indicate that the model's email address should be unverified.
     */
    public function unverified(): static
    {
        return $this->state(fn(array $attributes) => [
            'email_verified_at' => null,
        ]);
    }

    /**
     * Indicate that the user should have a personal team.
     */
    public function withPersonalTeam(?callable $callback = null): static
    {
        if (! Features::hasTeamFeatures()) {
            return $this->state([]);
        }

        return $this->has(
            Team::factory()
                ->state(fn(array $attributes, User $user) => [
                    'name' => $user->name . '\'s Team',
                    'user_id' => $user->id,
                    'personal_team' => true,
                ])
                ->when(is_callable($callback), $callback),
            'ownedTeams'
        );
    }
}
