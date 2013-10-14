<?PHP
class Registry
{
	public $cache;
	
	public function __construct()
	{
		$this->cache = array();
	}
	
	public function getEntry($key)
	{
		if (isset($this->cache[$key])) {
			return $this->cache[$key];
		} else {
			throw new Exception('Registry key ('.$key.') does not exist.');
		}
	}
	
	public function setEntry($key, $obj)
	{
		$this->cache[$key] = $obj;
	}
	
	public function isEntry($key)
	{
		return isset($this->cache[$key]);
	}
	
	public static function getInstance()
	{
		static $registry;
		if ($registry == NULL) {
			$registry = new Registry();
		}
		return $registry;
	}
}
?>