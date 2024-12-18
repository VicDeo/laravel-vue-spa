<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Carbon\Carbon;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    public function tasks()
    {
        return $this->hasMany(Task::class);
    }

    public function tasksSummary($period = null)
    {
       [$start, $end] = match ($period) {
        'today' => [Carbon::now()->startOfDay(), Carbon::now()->endOfDay()],
        'yesterday' => [Carbon::yesterday()->startOfDay(), Carbon::yesterday()->endOfDay()],
        'lastweek', 'last-week' => [Carbon::now()->subWeek()->startOfWeek(), Carbon::now()->subWeek()->endOfWeek()],
        'thismonth', 'this-month' => [Carbon::now()->startOfMonth(), Carbon::now()->endOfMonth()],
        'lastmonth', 'last-month' => [Carbon::now()->startOfMonth()->subMonthNoOverflow(), Carbon::now()->subMonthsNoOverflow()->endOfMonth()],
        default => [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()],
       };

        return $this->tasks()
            ->whereBetween('created_at', [$start, $end])
            ->latest()
            ->get();
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
}
