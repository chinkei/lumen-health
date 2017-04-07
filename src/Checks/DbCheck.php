<?php
namespace Chinkei\LumenHealth\Checks;

use Chinkei\LumenHealth\Config\Status;
use Illuminate\Database\DatabaseManager;

class DbCheck extends AbstractCheck
{
    /**
     * @return boolean
     */
    public function doHealthCheck()
    {
        $default = app('config')['database.default'];
        $dbInfo  = app('config')['database.connections.' . $default];

        try {
            /** @var DatabaseManager $database */
            $database = app('db');
            $checkInfo = [
                'status'   => $database->connection()->select('SELECT 1') ? Status::UP : Status::DOWN,
                'driver'   => $dbInfo['driver'],
                'database' => $dbInfo['database']
            ];
        } finally {
            $database->disconnect();
        }

        return $checkInfo;
    }
}
