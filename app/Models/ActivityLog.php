<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
class ActivityLog extends Model
{
    protected $fillable = ['user_id','action','target_type','target_id','ip_address'];
    public function user(): BelongsTo { return $this->belongsTo(User::class); }
    public function scopeFiltered(Builder $query, array $filters): Builder
    { return $query->when($filters['q'] ?? null, fn($q,$term)=>$q->where('action','like',"%$term%")->orWhere('target_type','like',"%$term%"))->when($filters['from'] ?? null, fn($q,$d)=>$q->whereDate('created_at','>=',$d))->when($filters['to'] ?? null, fn($q,$d)=>$q->whereDate('created_at','<=',$d)); }
}
