<?php
namespace Chinkei\LumenHealth\Checks;

/**
 * Class AbstractCheck
 * @package Chinkei\LumenHealth\Checks
 */
abstract class AbstractCheck implements InterfaceHealthCheck
{
    /**
     * @var string
     */
    protected $_name;

    /**
     * AbstractCheck constructor.
     * @param null $name
     */
    public function __construct($name = null)
    {
        if ( $name ) {
            $this->_name = lcfirst($name);
        }
    }

    /**
     * @return string
     */
    public function name()
    {
        if ( !$this->_name ) {

            $class = get_class($this);
            $name  = substr($class, strrpos($class, '\\') + 1, -5);

            $this->_name = lcfirst($name);
        }

        return $this->_name;
    }
}
