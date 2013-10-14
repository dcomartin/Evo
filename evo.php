<?PHP
define('EVO_HOME', 				dirname(__FILE__).DIRECTORY_SEPARATOR);
define('EVO_HOME_DIR',			dirname(__FILE__).DIRECTORY_SEPARATOR);
define('EVO_APPLICATION_DIR', 	EVO_HOME.'application'.DIRECTORY_SEPARATOR);
define('EVO_CONF_DIR', 			EVO_HOME.'conf'.DIRECTORY_SEPARATOR);
define('EVO_ERROR_DIR', 		EVO_HOME.'error'.DIRECTORY_SEPARATOR);
define('EVO_LIB_DIR', 			EVO_HOME.'lib'.DIRECTORY_SEPARATOR);
define('EVO_PUBLIC_DIR', 		EVO_HOME.'public'.DIRECTORY_SEPARATOR);
define('EVO_TMP_DIR', 			EVO_HOME.'tmp'.DIRECTORY_SEPARATOR);

define('EVO_PUBLIC_URL',		dirname(substr($_SERVER['SCRIPT_NAME'], 0, strpos($_SERVER['SCRIPT_NAME'], '.php') + 4)).'/public/');
define('EVO_URL', 				substr($_SERVER['SCRIPT_NAME'], 0, strpos($_SERVER['SCRIPT_NAME'], '.php') + 4));
define('EVO_HOME_URL',			dirname(EVO_URL).'/');

// INI Settings
ini_set('include_path', 			EVO_LIB_DIR);
ini_set('zlib.output_compression', 	'Off');
ini_set('url_rewriter.tags', 		'');
ini_set('session.gc_maxlifetime', 	1860);
ini_set('date.timezone', 			'America/Toronto');
ini_set('display_errors',			1);
ini_set('default_charset',			'ISO-8859-1');
ini_set('session.save_path',		EVO_HOME_DIR.'/tmp/session/');

header('P3P: CP="CAO PSA OUR"');

REQUIRE_ONCE(EVO_LIB_DIR.'Factory.php');
REQUIRE_ONCE(EVO_LIB_DIR.'Error.php');
REQUIRE_ONCE(EVO_LIB_DIR.'Controller.php');
REQUIRE_ONCE(EVO_LIB_DIR.'Model.php');
REQUIRE_ONCE(EVO_LIB_DIR.'Loader.php');
REQUIRE_ONCE(EVO_LIB_DIR.'Registry.php');
REQUIRE_ONCE(EVO_LIB_DIR.'Uri.php');

error_reporting(E_ALL);
set_error_handler(array('Error', 'phpError'));
set_exception_handler(array('Error', 'phpException'));

if (isset($_SERVER['ORIG_PATH_INFO'])) {
	$_SERVER['PATH_INFO'] = $_SERVER['ORIG_PATH_INFO'];
}

if (isset($_SERVER['PATH_INFO'])) {

	$pathinfo = explode('/', $_SERVER['PATH_INFO']);
	array_shift($pathinfo);
		
	if (!isset($pathinfo[0]) || (isset($pathinfo[0]) && $pathinfo[0] == '')) $pathinfo[0] = 'index';
	
	if (is_dir(EVO_APPLICATION_DIR.$pathinfo[0].DIRECTORY_SEPARATOR)) {
		define('EVO_APPLICATION', $pathinfo[0]);
		define('EVO_REQUEST_DIR', EVO_APPLICATION_DIR.EVO_APPLICATION.DIRECTORY_SEPARATOR);
		
		if (!isset($pathinfo[1]) || (isset($pathinfo[1]) && $pathinfo[1] == '')) $pathinfo[1] = 'index';
		define('EVO_CONTROLLER', $pathinfo[1]);
		$evo_controller = EVO_CONTROLLER;
			
		if (!isset($pathinfo[2]) || (isset($pathinfo[2]) && $pathinfo[2] == '')) $pathinfo[2] = 'index';
		define('EVO_VIEW', $pathinfo[2]);
		$evo_view = EVO_VIEW;

		// $_GET		
		$oldGet = $_GET;
		$_GET = array();
		if (isset($pathinfo[3])) {
			$getArray = $pathinfo;
			for($x=3; $x < count($pathinfo); $x = $x + 2) {
				if (!isset($pathinfo[$x + 1])) {
					$pathinfo[$x + 1] = '';
				}
				$_GET[$pathinfo[$x]] = $pathinfo[$x + 1];
			}
		}
		$_GET = array_merge($_GET, $oldGet);
		
		// Query String
		$queryString = '';
		foreach($_GET as $key => $val) {
			$queryString .= $key.'/'.$val.'/';
		}
		$queryString = substr($queryString, 0, -1);
		define('EVO_QUERY_STRING', $queryString);
		
		$controllerFile = EVO_APPLICATION_DIR.EVO_APPLICATION.DIRECTORY_SEPARATOR.'controller'.DIRECTORY_SEPARATOR.ucwords(EVO_CONTROLLER).'.php';
		if (!is_file($controllerFile)) {
			$handle = opendir(dirname($controllerFile));
			while($file = readdir($handle)) {
				if ($file != '.' && $file != '..' && strtolower($file) == strtolower(EVO_CONTROLLER).'.php') {
					$controllerFile = EVO_APPLICATION_DIR.EVO_APPLICATION.DIRECTORY_SEPARATOR.'controller'.DIRECTORY_SEPARATOR.$file;	
				}
			}
			closedir($handle);
		}
		
		if (is_file($controllerFile)) {
			REQUIRE_ONCE($controllerFile);
			
			$controller = new $evo_controller();
			
			if (method_exists($controller, EVO_VIEW)) {
				
				if (isset($_SERVER['CONTENT_TYPE']) && $_SERVER['CONTENT_TYPE'] == 'application/x-evo-xhr') {
					$result = $controller->xhr->dispatch();	
				} else {
					$view = EVO_VIEW;
					$result = $controller->$view();
				}
								
				if ($result) {
					echo $result;	
				}
				
			} else {
				Error::http404('View specified does not exist.');
				exit;
			}
		} else {
			Error::http404('Controller specified ('.$controllerFile.') does not exist.');
			exit;
		}
	} else {
		Error::http404('Application specified does not exist.');	
		exit;
	}
} else {
	Error::fatal('No application specified.');
	exit;
}
?>