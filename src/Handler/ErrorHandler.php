<?php
namespace PhalApi\Restful\Handler;

use PhalApi\Restful\Handler;
use PhalApi\Response;

class ErrorHandler implements Handler {

	public function execute(Response $response) {
		$response->output();
		exit(0);
	}
}
