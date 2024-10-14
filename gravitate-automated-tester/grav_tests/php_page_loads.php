<?php

class GRAV_TEST_PHP_PAGE_LOADS
{
	public function type()
	{
		return 'php';
	}

	public function environment()
	{
		return 'all';
	}

	public function group()
	{
		return 'PHP Tests';
	}

	public function label()
	{
		return 'PHP Page Loads';
	}

	public function description()
	{
		return 'Checks to make sure pages load properly.  Expects to see a &lt;/html&gt; tag';
	}

	public function run()
	{
		$urls = GRAV_TESTS::get_general_page_urls();

		$errors = array();
		$none_loaded = true;

		foreach ($urls as $url)
		{
			if($response = wp_remote_get(GRAV_TESTS::url_add_auth($url, $this->id), array('sslverify' => false, 'timeout' => 15)))
			{
				if(is_wp_error($response))
				{
					$error_message = $response->get_error_message();
				   	return array(
						'pass' => null,
						'message' => 'Error loading Pages: '.$response->get_error_message()
					);
				}
				else if(is_array($response) && !empty($response['body']))
				{
					if(empty($response['body']) || (!empty($response['body']) && strpos($response['body'], '</html>') === false))
					{
						$errors[] = array(
							'message' => 'URL failed to load fully.  Missing &lt;/html&gt; tag',
							'location' => $url
						);
					}
					else
					{
						$none_loaded = false;
					}
				}
			}
		}

		if(!empty($errors))
		{
			return array(
				'pass' => false,
				'errors' => $errors,
				'message' => 'There were ('.count($errors).') Pages that did not load properly'
			);
		}

		if($none_loaded)
		{
			return array(
				'pass' => null,
				'message' => 'Error loading Pages'
			);
		}

		return array(
			'pass' => true,
			'message' => '('.count($urls).') Pages Loaded Successfully'
		);
	}
}