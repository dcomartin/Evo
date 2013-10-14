<?PHP
class Error
{
	static public function fatal($message = 'Unspecified fatal has occured.  Please try again.')
	{
		if (defined('EVO_APPLICATION') && is_file(EVO_APPLICATION_DIR.EVO_APPLICATION.DIRECTORY_SEPARATOR.'errors'.DIRECTORY_SEPARATOR.'fatal.php')) {
			REQUIRE_ONCE(EVO_APPLICATION_DIR.EVO_APPLICATION.DIRECTORY_SEPARATOR.'errors'.DIRECTORY_SEPARATOR.'fatal.php');
		} else {
			REQUIRE_ONCE(EVO_ERROR_DIR.'fatal.php');
		}
		exit;
	}
	
	static public function http404($message = 'File could not be found.  Please try again.')
	{
		if (defined('EVO_APPLICATION') && is_file(EVO_APPLICATION_DIR.EVO_APPLICATION.DIRECTORY_SEPARATOR.'errors'.DIRECTORY_SEPARATOR.'404.php')) {
			REQUIRE_ONCE(EVO_APPLICATION_DIR.EVO_APPLICATION.DIRECTORY_SEPARATOR.'errors'.DIRECTORY_SEPARATOR.'404.php');
		} else {
			REQUIRE_ONCE(EVO_ERROR_DIR.'404.php');
		}
	}
	
	static public function phpError($errno, $errstr, $errfile, $errline)
	{
		if (defined('EVO_APPLICATION') && is_file(EVO_APPLICATION_DIR.EVO_APPLICATION.DIRECTORY_SEPARATOR.'errors'.DIRECTORY_SEPARATOR.'phpError.php')) {
			REQUIRE_ONCE(EVO_APPLICATION_DIR.EVO_APPLICATION.DIRECTORY_SEPARATOR.'errors'.DIRECTORY_SEPARATOR.'phpError.php');
		} else {
			REQUIRE_ONCE(EVO_ERROR_DIR.'phpError.php');
		}
	}
	
	static public function phpException($exception)
	{
		if (defined('EVO_APPLICATION') && is_file(EVO_APPLICATION_DIR.EVO_APPLICATION.DIRECTORY_SEPARATOR.'errors'.DIRECTORY_SEPARATOR.'phpException.php')) {
			REQUIRE_ONCE(EVO_APPLICATION_DIR.EVO_APPLICATION.DIRECTORY_SEPARATOR.'errors'.DIRECTORY_SEPARATOR.'phpException.php');
		} else {
			REQUIRE_ONCE(EVO_ERROR_DIR.'phpException.php');
		}
		exit;
	}
}
?>