<?PHP
class Index extends Controller
{
	function index()
	{
		return $this->view->assign('name', 'John Doe');
	}
	
	function phpinfo()
	{
		phpinfo();
	}
}