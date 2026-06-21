<?php

namespace App\Support;

use App\Models\AuditLog;
use Illuminate\Database\Eloquent\Model;

class AuditLogger
{
    public static function record(
        string $action,
        string $tableName,
        ?int $recordId = null,
        ?array $oldValues = null,
        ?array $newValues = null
    ): void {
        if (! auth()->check()) {
            return;
        }

        $user = auth()->user();

        AuditLog::create([
            'user_id' => $user->id,
            'branch_id' => $newValues['branch_id'] ?? $oldValues['branch_id'] ?? $user->branch_id,
            'role' => $user->roles->pluck('name')->first(),
            'action' => $action,
            'table_name' => $tableName,
            'record_id' => $recordId,
            'old_values' => $oldValues,
            'new_values' => $newValues,
            'ip_address' => request()->ip(),
            'user_agent' => request()->userAgent(),
        ]);
    }

    public static function created(Model $model): void
    {
        self::record(
            'create',
            $model->getTable(),
            $model->id,
            null,
            $model->toArray()
        );
    }

    public static function updated(Model $model, array $oldValues): void
    {
        self::record(
            'update',
            $model->getTable(),
            $model->id,
            $oldValues,
            $model->fresh()->toArray()
        );
    }

    public static function deleted(Model $model): void
    {
        self::record(
            'delete',
            $model->getTable(),
            $model->id,
            $model->toArray(),
            null
        );
    }
}
