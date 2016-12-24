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
 * Form Class
 *
 * Helper for creating forms with support for creating dynamic form objects.
 *
 * @package   Fuel
 * @category  Core
 */
class Form
{
	/*
	 * @var  Form_Instance  the default form instance
	 */
	protected static $instance;

	/**
	 * When autoloaded this will method will be fired, load once and once only
	 *
	 * @return  void
	 */
	public static function _init()
	{ if (($__am_res = __amock_before(get_called_class(), __CLASS__, __FUNCTION__, array(), true)) !== __AM_CONTINUE__) return $__am_res; 
		\Config::load('form', true);

		static::$instance = static::forge('_default_', \Config::get('form'));
	}

	public static function forge($fieldset = 'default', array $config = array())
	{ if (($__am_res = __amock_before(get_called_class(), __CLASS__, __FUNCTION__, array($fieldset, $config), true)) !== __AM_CONTINUE__) return $__am_res; 
		if (is_string($fieldset))
		{
			($set = \Fieldset::instance($fieldset)) and $fieldset = $set;
		}

		if ($fieldset instanceof Fieldset)
		{
			if ($fieldset->form(false) != null)
			{
				throw new \DomainException('Form instance already exists, cannot be recreated. Use instance() instead of forge() to retrieve the existing instance.');
			}
		}

		return new \Form_Instance($fieldset, $config);
	}

	/**
	 * Returns the 'default' instance of Form
	 *
	 * @param   null|string  $name
	 * @return  Form_Instance
	 */
	public static function instance($name = null)
	{ if (($__am_res = __amock_before(get_called_class(), __CLASS__, __FUNCTION__, array($name), true)) !== __AM_CONTINUE__) return $__am_res; 
		$fieldset = \Fieldset::instance($name);
		return $fieldset === false ? false : $fieldset->form();
	}

	/**
	 * Create a form open tag
	 *
	 * @param   string|array  $attributes  action string or array with more tag attribute settings
	 * @param   array         $hidden
	 * @return  string
	 */
	public static function open($attributes = array(), array $hidden = array())
	{ if (($__am_res = __amock_before(get_called_class(), __CLASS__, __FUNCTION__, array($attributes, $hidden), true)) !== __AM_CONTINUE__) return $__am_res; 
		return static::$instance->open($attributes, $hidden);
	}

	/**
	 * Create a form close tag
	 *
	 * @return  string
	 */
	public static function close()
	{ if (($__am_res = __amock_before(get_called_class(), __CLASS__, __FUNCTION__, array(), true)) !== __AM_CONTINUE__) return $__am_res; 
		return static::$instance->close();
	}

	/**
	 * Create a fieldset open tag
	 *
	 * @param   array   $attributes  array with tag attribute settings
	 * @param   string  $legend  string for the fieldset legend
	 * @return  string
	 */
	public static function fieldset_open($attributes = array(), $legend = null)
	{ if (($__am_res = __amock_before(get_called_class(), __CLASS__, __FUNCTION__, array($attributes, $legend), true)) !== __AM_CONTINUE__) return $__am_res; 
		return static::$instance->fieldset_open($attributes, $legend);
	}

	/**
	 * Create a fieldset close tag
	 *
	 * @return string
	 */
	public static function fieldset_close()
	{ if (($__am_res = __amock_before(get_called_class(), __CLASS__, __FUNCTION__, array(), true)) !== __AM_CONTINUE__) return $__am_res; 
		return static::$instance->fieldset_close();
	}

	/**
	 * Create a form input
	 *
	 * @param   string|array  $field       either fieldname or full attributes array (when array other params are ignored)
	 * @param   string        $value
	 * @param   array         $attributes
	 * @return  string
	 */
	public static function input($field, $value = null, array $attributes = array())
	{ if (($__am_res = __amock_before(get_called_class(), __CLASS__, __FUNCTION__, array($field, $value, $attributes), true)) !== __AM_CONTINUE__) return $__am_res; 
		return static::$instance->input($field, $value, $attributes);
	}

	/**
	 * Create a hidden field
	 *
	 * @param   string|array  $field       either fieldname or full attributes array (when array other params are ignored)
	 * @param   string        $value
	 * @param   array         $attributes
	 * @return  string
	 */
	public static function hidden($field, $value = null, array $attributes = array())
	{ if (($__am_res = __amock_before(get_called_class(), __CLASS__, __FUNCTION__, array($field, $value, $attributes), true)) !== __AM_CONTINUE__) return $__am_res; 
		return static::$instance->hidden($field, $value, $attributes);
	}
	
	/**
	 * Create a CSRF hidden field
	 *
	 * @return string
	 */
	public static function csrf()
	{ if (($__am_res = __amock_before(get_called_class(), __CLASS__, __FUNCTION__, array(), true)) !== __AM_CONTINUE__) return $__am_res; 
		return static::hidden(\Config::get('security.csrf_token_key', 'fuel_csrf_token'), \Security::fetch_token());
	}

	/**
	 * Create a password input field
	 *
	 * @param   string|array  $field       either fieldname or full attributes array (when array other params are ignored)
	 * @param   string        $value
	 * @param   array         $attributes
	 * @return  string
	 */
	public static function password($field, $value = null, array $attributes = array())
	{ if (($__am_res = __amock_before(get_called_class(), __CLASS__, __FUNCTION__, array($field, $value, $attributes), true)) !== __AM_CONTINUE__) return $__am_res; 
		return static::$instance->password($field, $value, $attributes);
	}

	/**
	 * Create a radio button
	 *
	 * @param   string|array  $field       either fieldname or full attributes array (when array other params are ignored)
	 * @param   string        $value
	 * @param   mixed         $checked     either attributes (array) or bool/string to set checked status
	 * @param   array         $attributes
	 * @return  string
	 */
	public static function radio($field, $value = null, $checked = null, array $attributes = array())
	{ if (($__am_res = __amock_before(get_called_class(), __CLASS__, __FUNCTION__, array($field, $value, $checked, $attributes), true)) !== __AM_CONTINUE__) return $__am_res; 
		return static::$instance->radio($field, $value, $checked, $attributes);
	}

	/**
	 * Create a checkbox
	 *
	 * @param   string|array  $field       either fieldname or full attributes array (when array other params are ignored)
	 * @param   string        $value
	 * @param   mixed         $checked     either attributes (array) or bool/string to set checked status
	 * @param   array         $attributes
	 * @return  string
	 */
	public static function checkbox($field, $value = null, $checked = null, array $attributes = array())
	{ if (($__am_res = __amock_before(get_called_class(), __CLASS__, __FUNCTION__, array($field, $value, $checked, $attributes), true)) !== __AM_CONTINUE__) return $__am_res; 
		return static::$instance->checkbox($field, $value, $checked, $attributes);
	}

	/**
	 * Create a file upload input field
	 *
	 * @param   string|array  $field       either fieldname or full attributes array (when array other params are ignored)
	 * @param   array         $attributes
	 * @return  string
	 */
	public static function file($field, array $attributes = array())
	{ if (($__am_res = __amock_before(get_called_class(), __CLASS__, __FUNCTION__, array($field, $attributes), true)) !== __AM_CONTINUE__) return $__am_res; 
		return static::$instance->file($field, $attributes);
	}

	/**
	 * Create a button
	 *
	 * @param   string|array  $field       either fieldname or full attributes array (when array other params are ignored)
	 * @param   string        $value
	 * @param   array         $attributes
	 * @return  string
	 */
	public static function button($field, $value = null, array $attributes = array())
	{ if (($__am_res = __amock_before(get_called_class(), __CLASS__, __FUNCTION__, array($field, $value, $attributes), true)) !== __AM_CONTINUE__) return $__am_res; 
		return static::$instance->button($field, $value, $attributes);
	}

	/**
	 * Create a reset button
	 *
	 * @param   string|array  $field       either fieldname or full attributes array (when array other params are ignored)
	 * @param   string        $value
	 * @param   array         $attributes
	 * @return  string
	 */
	public static function reset($field = 'reset', $value = 'Reset', array $attributes = array())
	{ if (($__am_res = __amock_before(get_called_class(), __CLASS__, __FUNCTION__, array($field, $value, $attributes), true)) !== __AM_CONTINUE__) return $__am_res; 
		return static::$instance->reset($field, $value, $attributes);
	}

	/**
	 * Create a submit button
	 *
	 * @param   string|array  $field       either fieldname or full attributes array (when array other params are ignored)
	 * @param   string        $value
	 * @param   array         $attributes
	 * @return  string
	 */
	public static function submit($field = 'submit', $value = 'Submit', array $attributes = array())
	{ if (($__am_res = __amock_before(get_called_class(), __CLASS__, __FUNCTION__, array($field, $value, $attributes), true)) !== __AM_CONTINUE__) return $__am_res; 
		return static::$instance->submit($field, $value, $attributes);
	}

	/**
	 * Create a textarea field
	 *
	 * @param   string|array  $field       either fieldname or full attributes array (when array other params are ignored)
	 * @param   string        $value
	 * @param   array         $attributes
	 * @return  string
	 */
	public static function textarea($field, $value = null, array $attributes = array())
	{ if (($__am_res = __amock_before(get_called_class(), __CLASS__, __FUNCTION__, array($field, $value, $attributes), true)) !== __AM_CONTINUE__) return $__am_res; 
		return static::$instance->textarea($field, $value, $attributes);
	}

	/**
	 * Select
	 *
	 * Generates a html select element based on the given parameters
	 *
	 * @param   string|array  $field       either fieldname or full attributes array (when array other params are ignored)
	 * @param   string        $values      selected value(s)
	 * @param   array         $options     array of options and option groups
	 * @param   array         $attributes
	 * @return  string
	 */
	public static function select($field, $values = null, array $options = array(), array $attributes = array())
	{ if (($__am_res = __amock_before(get_called_class(), __CLASS__, __FUNCTION__, array($field, $values, $options, $attributes), true)) !== __AM_CONTINUE__) return $__am_res; 
		return static::$instance->select($field, $values, $options, $attributes);
	}

	/**
	 * Create a label field
	 *
	 * @param   string|array  $label       either fieldname or full attributes array (when array other params are ignored)
	 * @param   string        $id
	 * @param   array         $attributes
	 * @return  string
	 */
	public static function label($label, $id = null, array $attributes = array())
	{ if (($__am_res = __amock_before(get_called_class(), __CLASS__, __FUNCTION__, array($label, $id, $attributes), true)) !== __AM_CONTINUE__) return $__am_res; 
		return static::$instance->label($label, $id, $attributes);
	}

	/**
	 * Prep Value
	 *
	 * Prepares the value for display in the form
	 *
	 * @param   string  $value
	 * @return  string
	 */
	public static function prep_value($value)
	{ if (($__am_res = __amock_before(get_called_class(), __CLASS__, __FUNCTION__, array($value), true)) !== __AM_CONTINUE__) return $__am_res; 
		return static::$instance->prep_value($value);
	}

	/**
	 * Attr to String
	 *
	 * Wraps the global attributes function and does some form specific work
	 *
	 * @param   array  $attr
	 * @return  string
	 */
	protected static function attr_to_string($attr)
	{ if (($__am_res = __amock_before(get_called_class(), __CLASS__, __FUNCTION__, array($attr), true)) !== __AM_CONTINUE__) return $__am_res; 
		return static::$instance->attr_to_string($attr);
	}

}
