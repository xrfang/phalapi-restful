<?php
/**
 * RESTFUL API
 */

$di->request = new PhalApi\Restful\RestfulRequest();
$di->fastRoute = new PhalApi\Restful\Lite();
$di->fastRoute->dispatch();