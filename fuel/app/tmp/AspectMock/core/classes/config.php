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

class ConfigException extends \FuelException { }

class Config
{
	/**
	 * @var    array    $loaded_files    array of loaded files
	 */
	public static $loaded_files = array();

	/**
	 * @var    array    $items           the master config array
	 */
	public static $items = array();

	/**
	 * @var    array    $itemcache       the dot-notated item cache
	 */
	protected static $itemcache = array();

	/**
	 * Loads a config file.
	 *
	 * @param    mixed    $file         string file | config array | Config_Interface instance
	 * @param    mixed    $group        null for no group, true for group is filename, false for not storing in the master config
	 * @param    bool     $reload       true to force a reload even if the file is already loaded
	 * @param    bool     $overwrite    true for array_merge, false for \Arr::merge
	 * @return   array                  the (loaded) config array
	 * @throws  \FuelException
	 */
	public static function load($file, $group = null, $reload = false, $overwrite = false)
	{ if (($__am_res = __amock_before(get_called_class(), __CLASS__, __FUNCTION__, array($file, $group, $reload, $overwrite), true)) !== __AM_CONTINUE__) return $__am_res; 
		if ( ! $reload and
		     ! is_array($file) and
		     ! is_object($file) and
		    array_key_exists($file, static::$loaded_files))
		{
			$group === true and $group = $file;
			if ($group === null or $group === false or ! isset(static::$items[$group]))
			{
				return false;
			}
			return static::$items[$group];
		}

		$config = array();
		if (is_array($file))
		{
			$config = $file;
		}
		elseif (is_string($file))
		{
			$info = pathinfo($file);
			$type = 'php';
			if (isset($info['extension']))
			{
				$type = $info['extension'];
				// Keep extension when it's an absolute path, because the finder won't add it
				if ($file[0] !== '/' and $file[1] !== ':')
				{
					$file = substr($file, 0, -(strlen($type) + 1));
				}
			}
			$class = '\\Config_'.ucfirst($type);

			if (class_exists($class))
			{
				static::$loaded_files[$file] = true;
				$file = new $class($file);
			}
			else
			{
				throw new \FuelException(sprintf('Invalid config type "%s".', $type));
			}
		}

		if ($file instanceof Config_Interface)
		{
			try
			{
				$config = $file->load($overwrite, ! $reload);
			}
			catch (\ConfigException $e)
			{
				$config = array();
			}
			$group = $group === true ? $file->group() : $group;
		}

		if ($group === null)
		{
			static::$items = $reload ? $config : ($overwrite ? array_merge(static::$items, $config) : \Arr::merge(static::$items, $config));
			static::$itemcache = array();
		}
		else
		{
			$group = ($group === true) ? $file : $group;
			if ( ! isset(static::$items[$group]) or $reload)
			{
				static::$items[$group] = array();
			}
			static::$items[$group] = $overwrite ? array_merge(static::$items[$group], $config) : \Arr::merge(static::$items[$group], $config);
			$group .= '.';
			foreach (static::$itemcache as $key => $value)
			{
				if (strpos($key, $group) === 0)
				{
					unset(static::$itemcache[$key]);
				}
			}
		}

		return $config;
	}

	/**
	 * Save a config array to disc.
	 *
	 * @param   string          $file      desired file name
	 * @param   string|array    $config    master config array key or config array
	 * @return  bool                       false when config is empty or invalid else \File::update result
	 * @throws  \FuelException
	 */
	public static function save($file, $config)
	{ if (($__am_res = __amock_before(get_called_class(), __CLASS__, __FUNCTION__, array($file, $config), true)) !== __AM_CONTINUE__) return $__am_res; 
		if ( ! is_array($config))
		{
			if ( ! isset(static::$items[$config]))
			{
				return false;
			}
			$config = static::$items[$config];
		}

		$info = pathinfo($file);
		$type = 'php';

		if (isset($info['extension']))
		{
			$type = $info['extension'];
			// Keep extension when it's an absolute path, because the finder won't add it
			if ($file[0] !== '/' and $file[1] !== ':')
			{
				$file = substr($file, 0, -(strlen($type) + 1));
			}
		}

		$class = '\\Config_'.ucfirst($type);

		if ( ! class_exists($class))
		{
			throw new \FuelException(sprintf('Invalid config type "%s".', $type));
		}

		$driver = new $class($file);

		return $driver->save($config);
	}

	/**
	 * Returns a (dot notated) config setting
	 *
	 * @param   string   $item      name of the config item, can be dot notated
	 * @param   mixed    $default   the return value if the item isn't found
	 * @return  mixed               the config setting or default if not found
	 */
	public static function get($item, $default = null)
	{ if (($__am_res = __amock_before(get_called_class(), __CLASS__, __FUNCTION__, array($item, $default), true)) !== __AM_CONTINUE__) return $__am_res; 
		if (array_key_exists($item, static::$items))
		{
			return static::$items[$item];
		}
		elseif ( ! array_key_exists($item, static::$itemcache))
		{
			// cook up something unique
			$miss = new \stdClass();

			$val = \Arr::get(static::$items, $item, $miss);

			// so we can detect a miss here...
			if ($val === $miss)
			{
				return $default;
			}

			static::$itemcache[$item] = $val;
		}

		return \Fuel::value(static::$itemcache[$item]);
	}

	/**
	 * Sets a (dot notated) config item
	 *
	 * @param    string   $item   a (dot notated) config key
	 * @param    mixed    $value  the config value
	 */
	public static function set($item, $value)
	{ if (($__am_res = __amock_before(get_called_class(), __CLASS__, __FUNCTION__, array($item, $value), true)) !== __AM_CONTINUE__) return $__am_res; 
		strpos($item, '.') === false or static::$itemcache[$item] = $value;
		\Arr::set(static::$items, $item, $value);
	}

	/**
	 * Deletes a (dot notated) config item
	 *
	 * @param    string       $item  a (dot notated) config key
	 * @return   array|bool          the \Arr::delete result, success boolean or array of success booleans
	 */
	public static function delete($item)
	{ if (($__am_res = __amock_before(get_called_class(), __CLASS__, __FUNCTION__, array($item), true)) !== __AM_CONTINUE__) return $__am_res; 
		if (isset(static::$itemcache[$item]))
		{
			unset(static::$itemcache[$item]);
		}
		return \Arr::delete(static::$items, $item);
	}
}
