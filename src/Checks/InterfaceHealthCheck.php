<?php
namespace Chinkei\LumenHealth\Checks;

/**
 * Interface InterfaceHealthCheck
 * @package Chinkei\LumenHealth\Checks
 */
interface InterfaceHealthCheck
{
    /**
     * Do health check
     *
     * @return boolean
     */
    public function doHealthCheck();

    /**
     * The name of the check
     *
     * @return [type]
     */
    public function name();
}
