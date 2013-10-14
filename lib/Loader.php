<?PHP
class Loader
{
	private $objRegistryKey;
		
	public function __construct($objRegistryKey)
	{
		$this->objRegistryKey = $objRegistryKey;
	}
	
	private function getObj()
	{
		$registry = Registry::getInstance();
		return $registry->getEntry($this->objRegistryKey);
	}
		
	public function library($class, $name = NULL, $args = NULL)
	{
		if ($name == NULL) {
			$name = $class;
			$name = str_replace('/', '_', $name);
		}
		$name = strtolower($name);
		
		$obj = $this->getObj();
		$obj->$name = Factory::library($class, $args);
	}
	
	public function model($model, $name = NULL)
	{
		if ($name == NULL) {
			$name = $model;	
		}
		$name = strtolower($name);
		
		$obj = $this->getObj();
		$obj->$name = Factory::model($model);
	}
	
	public function conf($name)
	{	
		$obj = $this->getObj();
		$obj->conf[$name] = Factory::conf($name);
	}
	
	public function view($view = NULL, $args = NULL)
	{
		if ($view == NULL) {
			$view = EVO_VIEW;
		}
		
		$viewFile = EVO_APPLICATION_DIR.EVO_APPLICATION.DIRECTORY_SEPARATOR.'view'.DIRECTORY_SEPARATOR.$view.'.php';
		if (is_file($viewFile)) {
			if ($args != NULL) extract($args);
			INCLUDE($viewFile);
		} else {
			Error::fatal('View ('.$view.') does not exist.');
		}	
	}
	
	public function session()
	{
		if (!isset($_SESSION)) {
			
			if (is_dir(EVO_APPLICATION_DIR.EVO_APPLICATION.DIRECTORY_SEPARATOR.'session')) {
				session_save_path(EVO_APPLICATION_DIR.EVO_APPLICATION.DIRECTORY_SEPARATOR.'session');
			}
			
			$session = Factory::conf('session');
			foreach($session as $name => $value) {
				ini_set('session.'.$name, $value);	
			}
					
			session_start();
		}
	}
}
?>