<?php
namespace App\Http\Controllers\Concerns;
use App\Models\ActivityLog;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
trait LogsActivity
{
    protected function logAction(Request $request, string $action, ?Model $target = null, ?string $targetType = null): void
    { ActivityLog::create(['user_id'=>$request->user()?->id,'action'=>$action,'target_type'=>$targetType ?? ($target ? class_basename($target) : 'System'),'target_id'=>$target?->getKey(),'ip_address'=>$request->ip()]); }
}
