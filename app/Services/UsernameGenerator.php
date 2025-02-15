<?php

namespace App\Services;

class UsernameGenerator
{
    private static array $adjectives = [
        'Cyber',
        'Neon',
        'Digital',
        'Quantum',
        'Cosmic',
        'Electric',
        'Glitch',
        'Pixel',
        'Solar',
        'Lunar',
        'Stellar',
        'Atomic',
        'Crystal',
        'Shadow',
        'Techno',
        'Synth',
        'Void',
        'Nova',
        'Plasma',
        'Binary'
    ];

    private static array $nouns = [
        'Runner',
        'Hacker',
        'Phantom',
        'Blade',
        'Ghost',
        'Dragon',
        'Phoenix',
        'Warrior',
        'Knight',
        'Hunter',
        'Ninja',
        'Sage',
        'Spirit',
        'Wolf',
        'Raven',
        'Pulse',
        'Storm',
        'Echo',
        'Vector',
        'Nexus'
    ];

    public static function generate(): string
    {
        $adjective = static::$adjectives[array_rand(static::$adjectives)];
        $noun = static::$nouns[array_rand(static::$nouns)];
        $number = rand(1, 9999);

        return $adjective . $noun . $number;
    }

    public static function generateUnique(): string
    {
        do {
            $username = static::generate();
        } while (\App\Models\User::where('username', $username)->exists());

        return $username;
    }
}
