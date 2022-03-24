<?php
namespace PhalApi\Restful;

use PhalApi\Response;

interface Handler {

	public function execute(Response $response);
}
