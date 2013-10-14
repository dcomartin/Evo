<?PHP
class SeaSurf
{
	private $hash;
	private $generated;
	
	public function __construct()
	{
		if (!isset($_SESSION)) session_start();
	}
	
	public function generate()
	{
		if (isset($_SESSION['seasurf'])) {
			$this->hash = $_SESSION['seasurf'];
			
			$this->generated = false;
		} else {
			$this->hash = md5(uniqid(rand(), TRUE));
			$_SESSION['seasurf'] = $this->hash;
			
			$this->generated = true;
		}
	}
	
	public function isGenerated()
	{
		if ($this->hash == NULL) {
			return FALSE;
		} else {
			return TRUE;	
		}	
	}
			
	public function validate()
	{
		if ($this->generated == FALSE) {
			if (!isset($_GET['seasurf']) || (isset($_GET['seasurf']) && $_GET['seasurf'] != $this->hash)) {
				throw new Exception('Invalid SeaSurf Hash.');
			}
		}
	}
	
	public function uri($uri)
	{
		return $uri.'/seasurf/'.$this->hash;
	}
	
	public static function getInstance()
	{
		static $instance;
		if ($instance == NULL) {
			$instance = new SeaSurf();
		}
		return $instance;	
	}
}
?>