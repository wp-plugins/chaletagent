<?php

/**
 * Class ChaletAgentAPI
 */
class Chalet_Agent_API
{
	/**
	 * The domain name of ChaletAgent
	 *
	 * @var string
	 *
	 * TODO: Perhaps enable a dev mode?
	 */
	protected $api_url = 'chaletagent.com/api';
	protected $api_protocol = 'https://';

	/**
	 * The ChaletAgent account id
	 *
	 * @var
	 */
	protected $username;

	/**
	 * Constructor method
	 *
	 * @param $username
	 */
	public function __construct ($username)
	{
		$this->username = $username;

		$this->api_url = $this->api_protocol . $username . '.' . $this->api_url;
	}

	/**
	 * Load the availability table from the API
	 *
	 * @param array $attr The array of attributes
	 *
	 * @return string
	 */
	public function get_availability ($attr)
	{
		if (!is_numeric($attr['season']))
		{
			return 'Season ID not specified.';
		}

		$data = $this->call_api("{$this->api_url}/availabilities/{$attr['season']}.html");

		return $data['body'];
	}

	/**
	 * Load the transfers table from the API
	 *
	 * @param array $attr The array of attributes
	 *
	 * @return string
	 */
	public function get_transfers ($attr)
	{
		$data = $this->call_api("{$this->api_url}/transfers/{$attr['season']}.html");

		return $data['body'];
	}

	/**
	 * Load the testimonials list from the API
	 *
	 * @return string
	 */
	public function get_testimonials ()
	{
		$data = $this->call_api("{$this->api_url}/testimonials.html");

		return $data['body'];
	}

	/**
	 * Load the seasons list from the API
	 *
	 * @param array $attr The array of attributes
	 *
	 * @return string
	 */
	public function get_seasons ($attr)
	{
		if (isset($attr['season']))
		{
			$data = $this->call_api("{$this->api_url}/seasons/{$attr['season']}.html");
		}
		else
		{
			$data = $this->call_api("{$this->api_url}/seasons.html");
		}

		return $data['body'];
	}

	/**
	 * Load the properties list from the API
	 *
	 * @param array $attr The array of attributes
	 *
	 * @return string
	 */
	public function get_properties ($attr)
	{
		if (isset($attr['property']))
		{
			$data = $this->call_api("{$this->api_url}/properties/{$attr['property']}.html?list");
		}
		else
		{
			$data = $this->call_api("{$this->api_url}/properties.html");
		}

		return $data['body'];
	}

	/**
	 * Load the lift passes list from the API
	 *
	 * @param array $attr The array of attributes
	 *
	 * @return string
	 */
	public function get_lift_passes ($attr)
	{
		$data = $this->call_api("{$this->api_url}/liftPasses/{$attr['season']}.html");

		return $data['body'];
	}

	/**
	 * Load the lift passes list from the API
	 *
	 * @param array $attr The array of attributes
	 *
	 * @return string
	 */
	public function get_lift_pass_types ($attr)
	{
		$data = $this->call_api("{$this->api_url}/liftPassTypes/{$attr['season']}.html");

		return $data['body'];
	}

	/**
	 * Centralised location to perform the actual API call
	 *
	 * @param string $path
	 *
	 * @return mixed
	 */
	public function call_api ($path)
	{
		return wp_remote_get($path);
	}
}
