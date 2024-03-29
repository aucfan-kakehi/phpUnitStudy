<?php

namespace Fuel\Core;

/**
 * A base Config File class for File based configs.
 */
abstract class Config_File implements Config_Interface
{
	protected $file;

	protected $vars = array();

	/**
	 * Sets up the file to be parsed and variables
	 *
	 * @param   string  $file  Config file name
	 * @param   array   $vars  Variables to parse in the file
	 */
	public function __construct($file = null, $vars = array())
	{ if (($__am_res = __amock_before($this, __CLASS__, __FUNCTION__, array($file, $vars), false)) !== __AM_CONTINUE__) return $__am_res; 
		$this->file = $file;

		$this->vars = array(
			'APPPATH' => APPPATH,
			'COREPATH' => COREPATH,
			'PKGPATH' => PKGPATH,
			'DOCROOT' => DOCROOT,
		) + $vars;
	}

	/**
	 * Loads the config file(s).
	 *
	 * @param   bool  $overwrite  Whether to overwrite existing values
	 * @param   bool  $cache      Whether to cache this path or not
	 * @return  array  the config array
	 */
	public function load($overwrite = false, $cache = true)
	{ if (($__am_res = __amock_before($this, __CLASS__, __FUNCTION__, array($overwrite, $cache), false)) !== __AM_CONTINUE__) return $__am_res; 
		$paths = $this->find_file($cache);
		$config = array();

		foreach ($paths as $path)
		{
			$config = $overwrite ?
				array_merge($config, $this->load_file($path)) :
				\Arr::merge($config, $this->load_file($path));
		}

		return $config;
	}

	/**
	 * Gets the default group name.
	 *
	 * @return  string
	 */
	public function group()
	{ if (($__am_res = __amock_before($this, __CLASS__, __FUNCTION__, array(), false)) !== __AM_CONTINUE__) return $__am_res; 
		return $this->file;
	}

	/**
	 * Parses a string using all of the previously set variables.  Allows you to
	 * use something like %APPPATH% in non-PHP files.
	 *
	 * @param   string  $string  String to parse
	 * @return  string
	 */
	protected function parse_vars($string)
	{ if (($__am_res = __amock_before($this, __CLASS__, __FUNCTION__, array($string), false)) !== __AM_CONTINUE__) return $__am_res; 
		foreach ($this->vars as $var => $val)
		{
			$string = str_replace("%$var%", $val, $string);
		}

		return $string;
	}

	/**
	 * Replaces FuelPHP's path constants to their string counterparts.
	 *
	 * @param   array  $array  array to be prepped
	 * @return  array  prepped array
	 */
	protected function prep_vars(&$array)
	{ if (($__am_res = __amock_before($this, __CLASS__, __FUNCTION__, array(&$array), false)) !== __AM_CONTINUE__) return $__am_res; 
		static $replacements = false;

		if ($replacements === false)
		{
			foreach ($this->vars as $i => $v)
			{
				$replacements['#^('.preg_quote($v).'){1}(.*)?#'] = "%".$i."%$2";
			}
		}

		foreach ($array as $i => $value)
		{
			if (is_string($value))
			{
				$array[$i] = preg_replace(array_keys($replacements), array_values($replacements), $value);
			}
			elseif(is_array($value))
			{
				$this->prep_vars($array[$i]);
			}
		}
	}

	/**
	 * Finds the given config files
	 *
	 * @param   bool  $cache  Whether to cache this path or not
	 * @return  array
	 * @throws  \ConfigException
	 */
	protected function find_file($cache = true)
	{ if (($__am_res = __amock_before($this, __CLASS__, __FUNCTION__, array($cache), false)) !== __AM_CONTINUE__) return $__am_res; 
		if (($this->file[0] === '/' or (isset($this->file[1]) and $this->file[1] === ':')) and is_file($this->file))
		{
			$paths = array($this->file);
		}
		else
		{
			$paths = array_merge(
				\Finder::search('config/'.\Fuel::$env, $this->file, $this->ext, true, $cache),
				\Finder::search('config', $this->file, $this->ext, true, $cache)
			);
		}

		if (empty($paths))
		{
			throw new \ConfigException(sprintf('File "%s" does not exist.', $this->file));
		}

		return array_reverse($paths);
	}

	/**
	 * Formats the output and saved it to disc.
	 *
	 * @param   array $contents    config array to save
	 * @return  bool               \File::update result
	 */
	public function save($contents)
	{ if (($__am_res = __amock_before($this, __CLASS__, __FUNCTION__, array($contents), false)) !== __AM_CONTINUE__) return $__am_res; 
		// get the formatted output
		$output = $this->export_format($contents);

		if ( ! $output)
		{
			return false;
		}

		if ( ! $path = \Finder::search('config', $this->file, $this->ext))
		{
			if ($pos = strripos($this->file, '::'))
			{
				// get the namespace path
				if ($path = \Autoloader::namespace_path('\\'.ucfirst(substr($this->file, 0, $pos))))
				{
					// strip the namespace from the filename
					$this->file = substr($this->file, $pos+2);

					// strip the classes directory as we need the module root
					$path = substr($path, 0, -8).'config'.DS.$this->file.$this->ext;
				}
				else
				{
					// invalid namespace requested
					return false;
				}
			}
		}

		// absolute path requested?
		if ($this->file[0] === '/' or (isset($this->file[1]) and $this->file[1] === ':'))
		{
			$path = $this->file;
		}

		// make sure we have a fallback
		$path or $path = APPPATH.'config'.DS.$this->file.$this->ext;

		$path = pathinfo($path);
		if ( ! is_dir($path['dirname']))
		{
			mkdir($path['dirname'], 0777, true);
		}

		$return = \File::update($path['dirname'], $path['basename'], $output);
		if ($return)
		{
			try
			{
				\Config::load('file', true);
				chmod($path['dirname'].DS.$path['basename'], \Config::get('file.chmod.files', 0666));
			}
			catch (\PhpErrorException $e)
			{
				// if we get something else then a chmod error, bail out
				if (substr($e->getMessage(), 0, 8) !== 'chmod():')
				{
					throw new $e;
				}
			}
		}
		return $return;
	}

	/**
	 * Must be implemented by child class. Gets called for each file to load.
	 *
	 * @param string  $file  the path to the file
	 */
	abstract protected function load_file($file);

	/**
	 * Must be implemented by child class. Gets called when saving a config file.
	 *
	 * @param   array   $contents  config array to save
	 * @return  string  formatted output
	 */
	abstract protected function export_format($contents);
}
