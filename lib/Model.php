<?PHP
class Model
{
	public $load;
	
	function __construct()
	{
		Registry::getInstance()->setEntry(get_class($this), $this);
		$this->load = new Loader(get_class($this));
	}
}
?>