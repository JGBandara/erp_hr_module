<?php

namespace App\Services;

use App\Models\SysLog;

class SysLogService
{
    public static function log(int $userId, int $locationId, string $remark){
        SysLog::create([
            'user_id'=>$userId,
            'location_id'=>$locationId,
            'remark'=>$remark,
        ]);
    }
}
