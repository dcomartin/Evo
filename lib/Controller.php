<?PHP
class Controller
{
	public $load;

	function __construct()
	{
		Registry::getInstance()->setEntry('controller', $this);

		// Loader		
		$this->load = new Loader('controller');
		
		// Session
		$this->load->conf('session');
		if (isset($this->conf['session']['autoload']) && $this->conf['session']['autoload']) {
			$this->load->session();	
		}
		
		// SeaSurf
		$this->load->conf('seasurf');
		if (isset($this->conf['seasurf']['autoload']) && $this->conf['seasurf']['autoload']) {
			$this->load->library('SeaSurf');
			$this->seasurf->generate();
		}
	}
	
	public function index()
	{
		Error::http404();	
	}
}
?>