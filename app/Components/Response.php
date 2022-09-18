<?php

namespace App\Components;

use App\Exceptions\ViewNotFoundException;

class Response
{
	/**
     * JSON response
     *    
	 * @param bool  $status  
     * @param array $data
	 * @param array $errors
	 * @param array $headers HTTP headers 
     * @return string json response
     */
	public static function json($status=true, $data=[], $errors=[], $headers=[])
	{
		if (count($headers) > 0) {
			self::headers($headers);
		}

		$response = [
			'status' => $status,
		];

		if (! empty($data)) {
			$response = array_merge($response, $data);
		}

		if (! empty($errors)) {
			$response['errors'] = $errors;
		}

		return json_encode($response);
	}

	/**
     * View response
     *    
	 * @param bool $path path to view
	 * @param array $data  
	 * @param array $headers HTTP headers 
     * @return string html response
	 * 
	 * @throws ViewNotFoundException
     */
	public static function view($path, $data=[], $headers=[])
	{	
		if (count($headers) > 0) {
			self::headers($headers);
		}

		$path = implode('/', explode('.', $path));
		
		if (! file_exists($filename = ROOT . '/views/' . $path . '.php')) {
			throw new ViewNotFoundException('View Not Found.');
		}

		extract($data);
		
		ob_start();
		require $filename;
		$response = ob_get_contents();
		ob_end_clean();
	
		return $response;
	}

    /**
     * Set HTTP headers
     *    
	 * @param array $headers HTTP headers  
     * @return void
     */
	public static function headers($headers)
	{
		foreach ($headers as $name => $value) {
			header($name . ':' . $value);
		}
	}
}
