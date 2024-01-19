<?php

namespace App\Filters;

use CodeIgniter\Filters\FilterInterface;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;

class Cors implements FilterInterface
{
	public function before(RequestInterface $request, $arguments = null)
	{
		// Setel header CORS sebelum permintaan masuk
		header('Access-Control-Allow-Origin: *');
		header('Access-Control-Allow-Headers: Content-Type');
		header('Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE');

		// Jangan biarkan permintaan CORS OPTIONS mencapai aplikasi Anda
		if ($request->getMethod(true) === 'OPTIONS') {
			return $this->createResponse();
		}

		return $request;
	}

	public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
	{
		// Lakukan sesuatu setelah respons keluar (jika diperlukan)
		return $response;
	}

	private function createResponse()
	{
		return service('response')
			->setStatusCode(200)
			->setHeader('Access-Control-Allow-Origin', '*')
			->setHeader('Access-Control-Allow-Headers', 'Content-Type')
			->setHeader('Access-Control-Allow-Methods', 'GET, POST, OPTIONS, PUT, DELETE')
			->noCache()
			->setJSON([]);
	}
}
