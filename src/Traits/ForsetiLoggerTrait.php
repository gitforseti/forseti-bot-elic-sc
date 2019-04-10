<?php
/**
 * Created by PhpStorm.
 * User: joaosilva
 * Date: 14/02/19
 * Time: 09:18
 */

namespace Forseti\Carga\ElicSC\Traits;


use Forseti\Logger\Logger;
use Psr\Log\LoggerTrait;

trait ForsetiLoggerTrait
{
    use LoggerTrait;

    public function log($level, $message, array $context = array())
    {
        return (new Logger(get_class($this)))->log($level, $message, $context);
    }
}