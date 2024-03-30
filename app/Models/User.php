<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Fortify\TwoFactorAuthenticatable;
use Laravel\Jetstream\HasProfilePhoto;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;
use App\Models\Control;
use App\Models\RiskProject;
use Illuminate\Database\Eloquent\SoftDeletes; 
		  

class User extends Authenticatable
{
    use HasApiTokens;
    use HasFactory,SoftDeletes;
    use HasProfilePhoto;
    use Notifiable;
    use TwoFactorAuthenticatable;
    use HasRoles;
    

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'last_name',
        'email',
        'password',
        'password_date',
        'active',
        'reset',
        'playlists',
        'channel_id'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
        'two_factor_recovery_codes',
        'two_factor_secret',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * The accessors to append to the model's array form.
     *
     * @var array
     */
    protected $appends = [
        'profile_photo_url',
    ];


    public function isAdmin(){
        return $this->hasRole('Admin');
    }

    /**
     * The responsible persons that belong to the task.
     */
    public function tasks()
    {
        return $this->belongsToMany(Task::class, 'task_has_responsible_persons', 'responsible_person_id', 'task_id');
    }

    public function controls()
    {
        return $this->belongsToMany(Control::class, 'control_histories', 'control_id', 'status_id', 'user_id');
    }


    public function responsibleForRiskProjects(){
        // 2 stands for "Send for approval"
        return $this->belongsToMany(RiskProject::class, 'risk_project_has_responsible_persons', 'responsible_person_id', 'risk_project_id');
        // ->wherePivot('status_id', 2);
    }

    public function accountableForRiskProjects(){
        // 2 stands for "Send for approval"
        return $this->hasMany(RiskProject::class, 'accountable_id');
    }

    public function allRiskProjects(){
        return $this->responsibleForRiskProjects->merge($this->accountableForRiskProjects);
    }

    public function role(){

        return $this->belongsTo(Role::class,'model_has_roles','role_id', 'model_id');
    }

    public function seenComment(){

        return $this->belongsToMany(Comment::class,'seen_comments','user_id', 'comment_id')->withTimestamps();
        
    }

}
