<?php
namespace Chinkei\LumenHealth;

use Chinkei\LumenHealth\Checks\InterfaceHealthCheck;
use Chinkei\LumenHealth\Config\Status;

/**
 * Class HealthManager
 * @package Chinkei\LumenHealth
 */
class HealthManager
{
    /**
     * The checks to run the health check.
     *
     * @var  array  $checks
     */
    protected $checks = [
        //
    ];

    /**
     * Constructor.
     *
     * @param array $checks
     *
     * @return void
     */
    public function __construct(array $checks = array())
    {
        foreach ( $checks as $check ) {
            $this->addCheck($check);
        }
    }

    /**
     * add check
     *
     * @param  InterfaceHealthCheck $check
     * @return void
     */
    public function addCheck(InterfaceHealthCheck $check)
    {
        $this->checks[] = $check;
    }

    /**
     * Run the health check
     *
     * @return array
     */
    public function check()
    {
        $status = true;
        $checkResult = array(
            'status' => $status
        );
        /** @var InterfaceHealthCheck $check */
        foreach ($this->checks as $check) {
            try {
                $result = $check->doHealthCheck();
                $checkResult[$check->name()] = $result;
                $status &= ( $result['status'] === Status::UP ? true : false );
            } catch (\Exception $e) {
                $status = false;
                // 写入日志信息
                \Log::error($e->getMessage());

                $checkResult[$check->name()]['status']    = Status::DOWN;

                if ( app('config')['lumen_health.show_exceptions'] ) {
                    $checkResult[$check->name()]['exception'] = $e->getMessage();
                }
            }
        }
        $checkResult['status'] = $status ? Status::UP : Status::DOWN;

        return $checkResult;
    }
}
