<?php
namespace App\Models;
use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable, SoftDeletes;
    protected $fillable = ['name','email','password','role','student_id','profile_photo'];
    protected $hidden = ['password','remember_token'];
    protected function casts(): array { return ['email_verified_at'=>'datetime','password'=>'hashed','deleted_at'=>'datetime']; }
    public function lostItems(): HasMany { return $this->hasMany(LostItem::class); }
    public function foundItems(): HasMany { return $this->hasMany(FoundItem::class, 'staff_id'); }
    public function claims(): HasMany { return $this->hasMany(Claim::class, 'student_id'); }
    public function notifications(): HasMany { return $this->hasMany(TmcNotification::class); }
    public function activityLogs(): HasMany { return $this->hasMany(ActivityLog::class); }
    public function dashboardRoute(): string { return match ($this->role) {'admin'=>route('admin.dashboard'),'staff'=>route('staff.dashboard'),default=>route('student.dashboard')}; }
}
