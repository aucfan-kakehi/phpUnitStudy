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

/**
 * Template Controller class
 *
 * A base controller for easily creating templated output.
 *
 * @package   Fuel
 * @category  Core
 * @author    Fuel Development Team
 */
abstract class Controller_Template extends \Controller
{
	/**
	* @var string page template
	*/
	public $template = 'template';

	/**
	 * Load the template and create the $this->template object
	 */
	public function before()
	{ if (($__am_res = __amock_before($this, __CLASS__, __FUNCTION__, array(), false)) !== __AM_CONTINUE__) return $__am_res; 
		if ( ! empty($this->template) and is_string($this->template))
		{
			// Load the template
			$this->template = \View::forge($this->template);
		}

		return parent::before();
	}

	/**
	 * After controller method has run output the template
	 *
	 * @param  Response  $response
	 */
	public function after($response)
	{ if (($__am_res = __amock_before($this, __CLASS__, __FUNCTION__, array($response), false)) !== __AM_CONTINUE__) return $__am_res; 
		// If nothing was returned default to the template
		if ($response === null)
		{
			$response = $this->template;
		}

		return parent::after($response);
	}

}
