<?php
/**
*	 
*
* @author	 9* 2019-12-24
* @access	public
* @package	SBIN Diesel
*/
class ui_m2_price_lists_gen extends user_interface
{
	public $title = 'Генератор прайсов во внешние магазины(Ynadex Google и.т.д)';
	public $deps = array('main' => array(
			'm2_price_lists_gen.dump_form'
			)
	);

        public function __construct () {
		parent::__construct(__CLASS__);
        }
	
	/**
	*       Main applications JS
	*/
	protected function sys_main()
	{
		$tmpl = new tmpl($this->pwd() . 'main.js');
		response::send($tmpl->parse($this), 'js');
	}
	
	protected function sys_dump_form()
	{
		$tmpl = new tmpl($this->pwd() . 'dump_form.js');
		response::send($tmpl->parse($this), 'js');
	}
}
?>
