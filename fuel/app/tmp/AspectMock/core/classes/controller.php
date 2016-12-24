<?php
/**
 * Part of the Fuel framework.
 *
 * @package    Fuel
 * @version    1.8
 * @author     Fuel Development Team
 * @license    MIT License
 * @copyright  2010 - 2016 Fuel Development Team
 * @link       http://fuelphp.com
 */

namespace Fuel\Core;

abstract class Controller
{
	/**
	 * @var  Request  The current Request object
	 */
	public $request;

	/**
	 * @var  Integer  The default response status
	 */
	public $response_status = 200;

	/**
	 * Sets the controller request object.
	 *
	 * @param   \Request $request  The current request object
	 */
	public function __construct(\Request $request)
	{ if (($__am_res = __amock_before($this, __CLASS__, __FUNCTION__, array($request), false)) !== __AM_CONTINUE__) return $__am_res; 
		$this->request = $request;
	}

	/**
	 * This method gets called before the action is called
	 */
	public function before() { if (($__am_res = __amock_before($this, __CLASS__, __FUNCTION__, array(), false)) !== __AM_CONTINUE__) return $__am_res; }

	/**
	 * This method gets called after the action is called
	 * @param \Response|string $response
	 * @return \Response
	 */
	public function after($response)
	{ if (($__am_res = __amock_before($this, __CLASS__, __FUNCTION__, array($response), false)) !== __AM_CONTINUE__) return $__am_res; 
		// Make sure the $response is a Response object
		if ( ! $response instanceof Response)
		{
			$response = \Response::forge($response, $this->response_status);
		}

		return $response;
	}

	/**
	 * This method returns the named parameter requested, or all of them
	 * if no parameter is given.
	 *
	 * @param   string  $param    The name of the parameter
	 * @param   mixed   $default  Default value
	 * @return  mixed
	 */
	public function param($param, $default = null)
	{ if (($__am_res = __amock_before($this, __CLASS__, __FUNCTION__, array($param, $default), false)) !== __AM_CONTINUE__) return $__am_res; 
		return $this->request->param($param, $default);
	}

	/**
	 * This method returns all of the named parameters.
	 *
	 * @return  array
	 */
	public function params()
	{ if (($__am_res = __amock_before($this, __CLASS__, __FUNCTION__, array(), false)) !== __AM_CONTINUE__) return $__am_res; 
		return $this->request->params();
	}
}
