<?PHP
class View
{
	private $assignments;
	
	public function __construct()
	{
		$this->assignments = array();
	}
	
	public function assign($name, $value)
	{
		$this->assignments[$name] = $value;
	}
	
	public function render($view = NULL, $return = TRUE)
	{
		if ($view == NULL) {
			$view = EVO_VIEW;
		}
		
		extract($this->assignments);

		$viewFile = EVO_APPLICATION_DIR.EVO_APPLICATION.DIRECTORY_SEPARATOR.'view'.DIRECTORY_SEPARATOR.$view.'.php';
		if (is_file($viewFile)) {
			if ($return) {
				ob_start();	
			}
			
			INCLUDE($viewFile);
			
			if ($return) {
				$html = ob_get_contents();
				ob_end_clean();	
				
				return $html;	
			}
		} else {
			Error::fatal('View ('.$view.') does not exist.');
		}
	}
	
	public function template($file)
	{
		ob_start();
		extract($this->assignments);
		$file = EVO_APPLICATION_DIR.EVO_APPLICATION.DIRECTORY_SEPARATOR.'template'.DIRECTORY_SEPARATOR.$file.'.php';
		if (is_file($file)) {
			INCLUDE($file);
		} else {
			Error::fatal('Template ('.$file.') does not exist.');
		}
		$html = ob_get_contents();
		ob_end_clean();
		return $html;	
	}
}
?>