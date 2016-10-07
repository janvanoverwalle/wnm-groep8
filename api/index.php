<?php

require_once ('./vendor/autoload.php');

use Monolog\Logger as Logger;
use Monolog\Handler\StreamHandler as StreamHdlr;
$log = new Logger('logger');
$log->pushHandler(
new StreamHdlr('test.log',
Logger::WARNING));
$log->addWarning('warning');
echo 'ok';


?>