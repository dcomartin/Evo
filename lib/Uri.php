<?PHP
class Uri
{
	public static function view($view = 'index', $seasurfURL = TRUE)
	{		
		$return = EVO_URL.'/'.EVO_APPLICATION.'/'.EVO_CONTROLLER.'/'.$view;
		
		$seasurf = Factory::library('SeaSurf');
		if ($seasurf->isGenerated() && $seasurfURL) {		
			$return = $seasurf->uri($return);
		}
		
		return $return;
	}
	
	public static function controller($controller = 'index', $view = 'index', $seasurfURL = TRUE)
	{
		$return = EVO_URL.'/'.EVO_APPLICATION.'/'.$controller.'/'.$view;
		
		$seasurf = Factory::library('SeaSurf');
		if ($seasurf->isGenerated() && $seasurfURL) {		
			$return = $seasurf->uri($return);
		}
		
		return $return;	
	}
	
	public static function application($application = 'index', $controller = 'index', $view = 'index', $seasurfURL = TRUE)
	{
		$return = EVO_URL.'/'.$application.'/'.$controller.'/'.$view;	
		
		$seasurf = Factory::library('SeaSurf');
		if ($seasurf->isGenerated() && $seasurfURL) {		
			$return = $seasurf->uri($return);
		}
			
		return $return;
	}
		
	public static function evo($str = NULL)
	{
		return EVO_URL.'/'.$str;
	}
	
	public static function evoPublic()
	{
		return EVO_PUBLIC_URL;
	}
	
	public static function applicationPublic()
	{
		return EVO_HOME_URL.'application/'.EVO_APPLICATION.'/public/';	
	}
}
?>