<?PHP
class Factory
{
	public static function conf($name)
	{
		$registry = Registry::getInstance();
				
		if ($registry->isEntry($name)) {
			$conf = $registry->getEntry($name);
		} else {
			if (defined('EVO_APPLICATION')) {
				$appConf = EVO_APPLICATION_DIR.EVO_APPLICATION.DIRECTORY_SEPARATOR.'conf'.DIRECTORY_SEPARATOR.$name.'.php';
			} else {
				$appConf = NULL;	
			}
			
			if (is_file($appConf)) {
				REQUIRE_ONCE($appConf);
			} elseif(is_file(EVO_CONF_DIR.$name.'.php')) {
				REQUIRE_ONCE(EVO_CONF_DIR.$name.'.php');
			} else {
				Error::fatal('Cannot load configuration ('.$name.').  Configuration file does not exist.');	
			}
			$registry->setEntry($name, $conf);	
		}
		
		return $conf;
	}
	
	public static function library($class, $args = NULL)
	{
		$registry = Registry::getInstance();
		if ($registry->isEntry($class)) {
			$obj = $registry->getEntry($class);
		} else {
			
			$classFile = str_replace('_', DIRECTORY_SEPARATOR, $class);
			$class = str_replace('/', '_', $class);
			
			$appLib = EVO_APPLICATION_DIR.EVO_APPLICATION.DIRECTORY_SEPARATOR.'lib'.DIRECTORY_SEPARATOR.$classFile.'.php';
			if (is_file($appLib)) {
				REQUIRE_ONCE($appLib);
			} else {
			
				if (substr($class, 0, 4) == 'Evo_') {
					$classFile = substr($class, 4);
				}
				
				if (is_file(EVO_LIB_DIR.$classFile.'.php')) {
					REQUIRE_ONCE(EVO_LIB_DIR.$classFile.'.php');
				} else {
					Error::fatal('Cannot load library ('.$class.').  Class does not exist.');
				}
				
			}
			
			if (method_exists($class, 'getInstance')) {
				$obj = call_user_func(array($class, 'getInstance'));	
			} else {
				if (is_array($args)) {
					$eval = '$obj = new $class(';
					for($x=0; $x < count($args); $x++) {
						$eval .= '$args['.$x.'], ';	
					}
					$eval = substr($eval, 0, -2);
					$eval .= ');';
					
					eval($eval);
				} else {
					$obj = new $class();	
				}
			}
			
			$registry->setEntry($class, $obj);
		}
		
		return $obj;
	}
	
	public static function model($model)
	{
		$registry = Registry::getInstance();
		if ($registry->isEntry($model)) {
			$obj = $registry->getEntry($model);
		} else {
			$classFile = str_replace('_', DIRECTORY_SEPARATOR, $model);
			
			$appModel = EVO_APPLICATION_DIR.EVO_APPLICATION.DIRECTORY_SEPARATOR.'model'.DIRECTORY_SEPARATOR.$classFile.'.php';
			if (is_file($appModel)) {
				REQUIRE_ONCE($appModel);
			} else {
				Error::fatal('Cannot load model ('.$model.').  Model does not exist.');
			}
						
			$obj = new $model();
			
			$registry->setEntry($model, $obj);			
		}
		
		return $obj;		
	}
}
?>