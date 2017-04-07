<?php
namespace Chinkei\LumenHealth\Checks;

use Chinkei\LumenHealth\Config\Status;

/**
 * Class DiskSpaceCheck
 * @package Chinkei\LumenHealth\Checks
 */
class DiskSpaceCheck extends AbstractCheck
{
    const MIN_FREE_SPACE = 2; // min fee space

    /**
     * @return boolean
     */
    public function doHealthCheck()
    {
        $disk      = '/';
        $total     = disk_total_space($disk);
        $fee       = disk_free_space($disk);
        $threshold = ceil($total * ( self::MIN_FREE_SPACE / 100 ));

        return [
            'status'    => ( $fee > $threshold ) ? Status::UP : Status::DOWN,
            'total'     => $total,
            'fee'       => $fee,
            'threshold' => $threshold
        ];
    }
}
