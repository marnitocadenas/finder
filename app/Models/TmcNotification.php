<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
class TmcNotification extends Model
{
    protected $table = 'notifications';
    protected $fillable = ['user_id','title','message','is_read','type','link'];
    protected $casts = ['is_read'=>'boolean'];
    public function user(): BelongsTo { return $this->belongsTo(User::class); }
}
