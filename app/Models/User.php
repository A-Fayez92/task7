<?php

namespace App\Models;

use App\Models\Post;
use App\Models\Country;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'age',
        'posts',
        'country',
        'gender',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function country()
    {
        return $this->belongsTo(Country::class);
    }
    
    public function posts()
    {
        return $this->hasMany(Post::class);
    }

    public function scopeAge($query, $comp , $val , $rel)
    {
        if ($rel == 'and')
        {
            return $query->where('age', $comp , $val);
        }
        elseif($rel == 'or')
        {
            return $query->orWhere('age', $comp , $val);
        }
        
    }
    public function scopeName($query, $comp , $val , $rel)
    {
        // if contains
        if ($comp == "contains")
        {
            $val = '%'.$val.'%';
        }
       
        //if start with
        if ($comp == "startWith")
        {
            $val = $val.'%';
        }

        //if End with
        if ($comp == "endWith")
        {
            $val = '%'.$val;
        }
        $comp = 'like';
        if ($rel == 'and')
        {
            return $query->where('name', $comp , $val);
        }
        elseif($rel == 'or')
        {
            return $query->orWhere('name', $comp , $val);
        }
        
    }

    public function scopeGender($query, $comp , $val , $rel)
    {
        if ($rel == 'and')
        {
            return $query->where('gender', $comp , $val);
        }
        elseif($rel == 'or')
        {
            return $query->orWhere('gender', $comp , $val);
        }
        
    }

    public function scopePostNumber($query, $comp , $val , $rel)
    {
        if ($rel == 'and')
        {
            return $query->has('posts', $comp , $val);
        }
        elseif($rel == 'or')
        {
            return $query->orHas('posts', $comp , $val);
        }
        
    }


    public function scopeCountryName($query, $comp , $val , $rel)
    {
        // if contains
        if ($comp == "contains")
        {
            $val = '%'.$val.'%';
        }
       
        //if start with
        if ($comp == "startWith")
        {
            $val = $val.'%';
        }

        //if End with
        if ($comp == "endWith")
        {
            $val = '%'.$val;
        }
        $comp = 'like';

        
        if ($rel == 'and')
        {
            return $query->whereHas('country', function ($query) use ($comp , $val) {
                $query->where('name', $comp , $val);
            });
        }
        elseif($rel == 'or')
        {
            return $query->orWhereHas('country', function ($query) use ($comp , $val) {
                $query->where('name', $comp , $val);
            });
        }
        
    }

}
