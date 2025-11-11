<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Str;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'user_code',
        'student_id',
        'office_id',
        'first_name',
        'middle_name',
        'last_name',
        'name_suffix',
        'email',
        'role',
        'last_activity',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected static function booted()
    {
        static::creating(function ($request) {
            $date = now()->format('ymd');
            $attempt = 0;

            do {
                $random = strtoupper(Str::random(3));
                $suffix = $attempt > 0 ? '-'.str_pad($attempt, 2, '0', STR_PAD_LEFT) : '';
                $code = "USR-{$date}-{$random}{$suffix}";
                $attempt++;
            } while (self::where('user_code', $code)->exists());

            $request->user_code = $code;
        });
    }

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    /**
     * Get the user's initials
     */
    public function initials(): string
    {
        $parts = array_filter([
            $this->first_name,
            $this->middle_name,
            $this->last_name,
        ]);

        // Get the first letter of each part
        $initials = collect($parts)
            ->map(fn ($part) => Str::of($part)->substr(0, 1)->upper())
            ->implode('');

        return $initials;
    }

    public function getNameAttribute()
    {
        $parts = array_filter([
            $this->first_name,
            $this->middle_name,
            $this->last_name,
            $this->name_suffix,
        ]);

        return implode(' ', $parts);
    }

    /**
     * Relationship: User belongs to an Office.
     */
    public function office()
    {
        return $this->belongsTo(Office::class, 'office_id');
    }

    /**
     * Get all users sorted by last name.
     */
    public static function allUsers()
    {
        return self::orderBy('last_name')->get();
    }

    /**
     * Get all admin users sorted by last name.
     */
    public static function admins()
    {
        return self::where('role', 'admin')
            ->orderBy('last_name')
            ->get();
    }

    /**
     * Get all head users sorted by last name.
     */
    public static function heads()
    {
        return self::where('role', 'head')
            ->orderBy('last_name')
            ->get();
    }

    /**
     * Get all staff users sorted by last name.
     */
    public static function staffs()
    {
        return self::where('role', 'staff')
            ->orderBy('last_name')
            ->get();
    }

    /**
     * Get all student users sorted by last name.
     */
    public static function students()
    {
        return self::where('role', 'student')
            ->orderBy('last_name')
            ->get();
    }

    /**
     * Get all alumni users sorted by last name.
     */
    public static function alumni()
    {
        return self::where('role', 'alumni')
            ->orderBy('last_name')
            ->get();
    }
}
