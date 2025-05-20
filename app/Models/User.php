<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasFactory, Notifiable,HasApiTokens;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'phone_number',
        'c',
        'block',
        'facebook',
        'twitter',
        'linked in',
        'google',
        'image',
        'fcm_token'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
        'block',
        'image'
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
    public function posts()
    {
        return $this->hasMany(Post::class);
    }
    public function Report()
    {
        return $this->hasMany(Report::class);
    }
    public function comments()
    {
        return $this->hasMany(Comment::class);
    }
    public function postsRatings()
    {
        return $this->belongsToMany(Post::class, 'ratings')->withPivot('type')->withTimestamps();
    }
    public function messages()
    {
        return $this->hasMany(ChMessage::class, 'to_id');
    }
    public function commentsRatings()
    {
        return $this->belongsToMany(Comment::class, 'ratings')->withPivot('type')->withTimestamps();
    }

    public function followers()
    {
        return $this->belongsToMany(User::class, 'followers',  'following_id','follower_id');
    }

    public function followings()
    {
        return $this->belongsToMany(User::class, 'followers', 'follower_id','following_id');

    }
    public function role()
    {
        return $this->belongsTo(Role::class);
    }
    public function groups()
    {
        return $this->belongsToMany(Group::class)->withPivot('is_admin');
    }


}
