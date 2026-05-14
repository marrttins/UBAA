<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'title',
        'first_name',
        'middle_name',
        'last_name',
        'name',
        'email',
        'password',
        'degree',
        'graduation_year',
        'job_title',
        'company',
        'location',
        'linkedin_url',
        'facebook_url',
        'twitter_url',
        'instagram_url',
        'alumni_id',
        'membership_type',
        'alumni_level',
        'receive_notifications',
        'connections_count',
        'avatar_url',
        'matric_number',
        'phone',
        'date_of_birth',
        'bio',
        'role'
    ];

    /**
     * Calculate Alumni Level dynamically
     */
    public function calculateAlumniLevel()
    {
        $minGradYear = $this->degrees()->min('graduation_year') ?? $this->graduation_year ?? date('Y');
        $yearsOut = date('Y') - (int)$minGradYear;

        if ($yearsOut < 3) return 'Neo-Alumni';
        if ($yearsOut <= 10) return 'Associate';
        if ($yearsOut <= 20) return 'Venerable';
        if ($yearsOut <= 30) return 'Legacy';
        if ($yearsOut <= 40) return 'Pioneer';
        return 'Ancestor';
    }

    /**
     * Route notifications for the mail channel.
     */
    public function routeNotificationForMail($notification)
    {
        return $this->receive_notifications ? $this->email : null;
    }

    /**
     * Get the user's degrees.
     */
    public function degrees()
    {
        return $this->hasMany(UserDegree::class);
    }

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

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
}
