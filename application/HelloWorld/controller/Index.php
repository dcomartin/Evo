<?PHP
class Index extends Controller
{
	function __construct()
	{
		parent::__construct();
	}
	
	function index()
	{
		$this->load->library('View');
		$this->view->assign('name', 'John Doe');
		return $this->view->render('Index_index');
	}
	
	function getDate()
	{
		return json_encode(date('Y-m-d H:i:s'));
	}
	
	function phpinfo()
	{
		phpinfo();
	}
}