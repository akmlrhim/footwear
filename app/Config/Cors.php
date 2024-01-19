<?php

namespace Config;

use CodeIgniter\Config\BaseConfig;

class Cors extends BaseConfig
{
	public $allowedOrigins = ['http://localhost:8100'];
	public $allowedHeaders = ['*'];
	public $allowedMethods = ['GET', 'POST', 'OPTIONS', 'PUT', 'DELETE'];
	public $exposedHeaders = [];
	public $maxAge = 0;
	public $supportsCredentials = false;
}
