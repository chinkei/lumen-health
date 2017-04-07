<?php
namespace Chinkei\LumenHealth\Checks;

use Chinkei\LumenHealth\Config\Status;
use Illuminate\Redis\Database;

class RedisCheck extends AbstractCheck
{


    /**
     * @return boolean
     */
    public function doHealthCheck()
    {
        /** @var Database $redisDs */
        $redisDs = app('redis');

        try {
            $redisDs->connection()->connect();
            $checkInfo = [
                'status'   => $redisDs->connection()->isConnected() ? Status::UP : Status::DOWN,
                // 'version'  => $redisDs->command('--version')
            ];
        } finally {
            $redisDs->connection()->disconnect();
        }

        return $checkInfo;
    }
}
