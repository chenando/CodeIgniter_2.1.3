
<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Zend {
    public function __construct($class = NULL)
	{
 				
		ini_set('include_path',
		ini_get('include_path') . PATH_SEPARATOR . BASEPATH . 'libraries');
 
		if ($class)
		{
			require_once (string) $class . EXT;
			log_message('debug', "Zend Class $class Loaded");
		}
		else
		{
			log_message('debug', "Zend Class Initialized");
		}
	}
 
	public function load($class)
	{
		require_once (string) $class . EXT;
		log_message('debug', "Zend Class $class Loaded");
	}
}

?>
