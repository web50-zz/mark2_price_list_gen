<?php
/**
*	Интерфейс данных "Утиль ДБ"
*
* @author	9* 2019-12-24
* @package	SBIN Diesel
*/
class di_m2_price_lists_gen extends data_interface
{
	public $title = 'Генератор прайс листов Яндекс гугль';
	/**
	* @var	string	$cfg	Имя конфигурации БД
	*/
	protected $cfg = 'localhost';
	
	/**
	* @var	string	$db	Имя БД
	*/
	protected $db = 'db1';

	public $path_to_storage = 'prices/';

	protected $export_conf = array();
	/**
	* @var	string	$name	Имя таблицы
	*/
	

	protected $cfg_path = 'mark2_price_lists_gen/etc/mark2_price_lists_gen_config.php';
	protected $default_cfg_path = 'mark2_price_lists_gen/var/ui/m2_price_lists_gen/default_config.php';

	public function __construct () {
	    // Call Base Constructor
	    parent::__construct(__CLASS__);
		if(file_exists(INSTANCES_PATH.$this->cfg_path))
		{
			require_once(INSTANCES_PATH.$this->cfg_path);
			$this->export_conf = $mark2_price_lists_gen_config;
		}else{
			if(file_exists(INSTANCES_PATH.$this->default_cfg_path))
			{
				require_once(INSTANCES_PATH.$this->default_cfg_path);
				$this->export_conf = $mark2_price_lists_gen_config;
			}
		}

	}
	/**
	*	Получить путь к хранилищу файлов на файловой системе
	*/
	public function get_path_to_storage()
	{
		return FILE_STORAGE_PATH.$this->path_to_storage;
	}

	//	Возвращает спсиок возможных для выбора  вариантов дампа

	protected function sys_price_list_types()
	{
		global $instances;
		$data = array();
		$types = array();
		$types_list = array(
					array('id'=>'1','title'=>'Yandex Market YML'),
					array('id'=>'2','title'=>'Google Merchant XML RSS2.0'),
				);

		foreach($this->export_conf as $k=>$v)
		{
			$types[] = array('id'=>$v['type'],'title'=>$v['form_title']);
		}
		if(count($types)>0)
		{
			$types_list = $types;
		}
		$data['success'] = 'true';
		$data['records']= $types_list;
		response::send($data, 'json');
	}

	/**
	*	Сохранить данные и вернуть JSON-пакет для ExtJS
	* @access protected
	*/
	protected function sys_set()
	{
		try{
			if(!(count($this->export_conf)>0))
			{
				throw new Exception('Bad config');
			}
			$this->prepare_config();
			$this->get_price_data();
			$this->gen_itself();
		}
		catch (Exception $e)
		{
			response::send(array('success'=>false,'errors'=>$e->getMessage()), 'json');
		}
		$data['success'] = '1';
		$data['data'] = array('msg'=>'Файл записан. Доступен по адресу '.$this->current_conf['site_url'].'/filestorage/'.$this->path_to_storage.$this->current_conf['file_name']);
		response::send($data, 'json');
	}

	protected function prepare_config($id = 0)
	{
		if($id == 0)
		{
			$id = request::get('inst_id');
		}
		if(!($id>0))
		{
			throw new Exception('No id given');
		}
		foreach($this->export_conf as $k=>$v)
		{
			if($id == $v['type'])
			{
				$match = 1;
				$this->current_conf = $v;
			}
		}
		if(!$match)
		{
			throw new Exception('Для этой выгрузки не определена конфигурация');
		}
	}


	protected function get_price_data()
	{
		$di = data_interface::get_instance('m2_item_indexer');
		$sql = "select * from m2_item_indexer where not_available = 0 order by id ASC";
		$this->data = $di->_get($sql)->get_results();
	}

	public function gen_itself()
	{
		$j = 1;

		if(!(count($this->data)>0))
		{
			throw new Exception('no data to export');
		}
		if(!is_dir($this->get_path_to_storage()))
		{
			mkdir($this->get_path_to_storage(),0777,true);
		}
		if(!$this->current_conf['file_name'])
		{
			throw new Exception('Exports file name missed');
		}

		$file_name = $this->current_conf['file_name'];
		$file_path = $this->get_path_to_storage().$file_name;
		$fh = fopen($file_path,"w");
		fwrite($fh,$this->current_conf['header']);
		fwrite($fh,$this->current_conf['titles']);
		if($this->current_conf['type'] == 1)
		{
			// для яндекса делаем категории 
			$cats = $this->make_cats();
			fwrite($fh,$cats);
			unset($cats);
		}
		if($this->current_conf['conf_wrap_tag'] != '')
		{
			fwrite($fh,'<'.$this->current_conf['conf_wrap_tag'].'>');
		}
		foreach($this->data as $k=>$v)
		{
			$decoded = array();
			/*
			if($k < 5984){
				continue;
			}
			if($k >= 5989)
			{
				break;
			}
			*/
			if($k >= 5)
			{
//				break;
			}

			$v = (array)$v;
			$row = array();
			$skip_element  = 0;
			foreach($this->current_conf['conf'] as $k1=>$v1)
			{

				$temp = array();
				$val = '';
				if($v1['type'] == 'as_is')
				{
					$val = $v[$v1['field']];
				}
				if($v1['type'] == 'json')
				{
					if(!array_key_exists($v1['field'],$temp))
					{
						if(array_key_exists($v1['field'],$decoded))
						{
							$temp[$v1['field']] = $decoded[$v1['field']];
						}
						else
						{
							$decoded[$v1['field']] = json_decode($v[$v1['field']]);
							$temp[$v1['field']] = $decoded[$v1['field']];
						}
					}
					if($v1['data_mine_type'] == 'field_by_row')
					{
						if(is_array($temp[$v1['field']])&&count($temp[$v1['field']])>0)
						{
							$r = (array)$temp[$v1['field']][$v1['row_to_get']];
							$val = $r[$v1['field_to_get']];
						}
					}
					if($v1['data_mine_type'] == 'field_by_char_type')
					{
						if(is_array($temp[$v1['field']])&&count($temp[$v1['field']])>0)
						{
							foreach($temp[$v1['field']] as $k2=>$v2)
							{
								$o = (array)$v2;
								if($o[$v1['type_field']] == $v1['type_id'] && $v1['char_type'] == 'variable')
								{
									$val = $o[$v1['field_to_get']];
								}
								if($o[$v1['type_field']] == $v1['type_id'] && $v1['char_type'] == 'fixed')
								{
									$val = $o[$v1['field_to_get']];
								}
							}
						}
					}

				}
				if($v1['type'] == 'fixed')
				{
					$val = $v1['value']; 
				}
				if($v1['evl'] != '')
				{
					$val  = price_export_handlers($v1['evl'],$val); 
				}
				if($val != '')
				{
					if($v1['prefix'] != '')
					{
						$val = $v1['prefix'].$val;
					}
					if($v1['postfix'] != '')
					{
						$val = $val.$v1['postfix'];
					}
					$val = str_replace(array("\r", "\n"), '', $val);
				}
				$val_p = '';
				if($v1['template'] != '')
				{
					$val_p = str_replace('{__val__}',$val,$v1['template']);
				}
				if($v1['no_output'] != true)
				{
					if($val != '')
					{
						if($val == 'skip_item')
						{
							$skip_element = 1;
						}
						elseif($v1['anti_date'] == 1)
						{
							$row[] = ' '.$val_p.' ';
						}
						else
						{
							$row[] = $val_p;
						}
					}else{
//						$row[] = '';
					}
				}else{
					$no_output[$v1['field']] = $val;
				}

			}
				if($skip_element == 1)
				{
					continue;
				}
				if($this->current_conf['conf_element_tag'] != '')
				{
					$id_as_attr = '';
					$pars_str = '';
					$fixed_attrs = '';
					if($this->current_conf['conf_element_fixed_attributes'] != '')
					{
						$fixed_attrs = ' '.$this->current_conf['conf_element_fixed_attributes'];
					}

					if($this->current_conf['conf_element_id_as_attribute'] != '')
					{
						$id_as_attr = ' id="'.$no_output['article'].'"';
					}
					if(is_array($this->current_conf['conf_element_param_as_attribute']))
					{

						if(count($this->current_conf['conf_element_param_as_attribute'])>0)
						{
							foreach($this->current_conf['conf_element_param_as_attribute'] as $k2=>$v2)
							{
								if(array_key_exists('chars_list',$decoded))
								{
								}
								else
								{
									$decoded['chars_list'] = json_decode($v['chars_list']);
								}
								if(is_array($decoded['chars_list']))
								{
									foreach($decoded['chars_list'] as $k7=>$v7)
									{
										if($v7->type_id == $v2['type_id'])
										{
											$par_val = '';
											if($v2['evl'] != '')
											{
												$par_val  = price_export_handlers($v2['evl'],$v7->type_value_str); 
											}
											else
											{
												$par_val = $v7->type_value_str;
											}
											if($par_val != '')
											{
												$pars_str.= ' '.$v2['attribute_title'].'="'.$par_val.'" ';
											}
										}
									}
								}
							}
							
						}
					}
					fwrite($fh,"\r\n".'<'.$this->current_conf['conf_element_tag'].$id_as_attr.$pars_str.$fixed_attrs.'>'."\r\n");
				}
				fwrite($fh,implode("\r\n",array_values($row)));

				if($this->current_conf['conf_element_tag'] != '')
				{
					fwrite($fh,"\r\n".'</'.$this->current_conf['conf_element_tag'].'>');
				}
		}
		if($this->current_conf['conf_wrap_tag'] != '')
		{
			fwrite($fh,'</'.$this->current_conf['conf_wrap_tag'].'>');
		}
		fwrite($fh,$this->current_conf['footer']);
		fclose($fh);
	}

	private function make_cats()
	{
		$di = data_interface::get_instance('m2_category');
		$res = $di->get_all_simple(array('ignore_visibility'=>'1'));
		$parsed = '<categories>';
		$parsed .= "\r\n".'<category id="'.$res['id'].'" parentId="0">'.$res['title'].'"</category>';
		foreach($res['childs'] as $k=>$v)
		{
			$parsed .= $this->get_childs($v);
		}
		$parsed.="\r\n".'</categories>'."\r\n";
		return $parsed;
	}
	private function get_childs($v = array())
	{
		$ret = '';
		if($v['id'] > 0)
		{
				$ret = "\r\n".'<category id="'.$v['id'].'" parentId="'.$v['parent'].'">'.$v['title'].'</category>';
				if(array_key_exists('childs',$v) && count($v['childs'])>0)
				{
					foreach($v['childs'] as $k1=>$v1)
					{
						$ret .= $this->get_childs($v1);
					}
				}
		}
		return $ret;
	}
}
?>
