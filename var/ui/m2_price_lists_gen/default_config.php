<?php
/**
*	Конфигурационные параметры для экспорта 
*
* @author	9* <9@u9.ru>
*/
$mark2_price_lists_gen_config = array(
	array(
		'type'=>'1',
		'title'=>'yandex',
		'form_title'=>'Yandex Market YML',
		'file_name'=>'yandex.yml',
		'header'=>'<?xml version="1.0" encoding="UTF-8"?><yml_catalog date="'.date('Y-m-d H:i:s').'"><shop>',
		'footer'=> '</shop></yml_catalog>',
		'site_url'=>'https://napitki.ru',
		'titles'=>'
			<name>Напитки Ру</name>
			<company>Напитки Ру</company>
			<url>https://napitki.ru</url>
			<platform>Sbin Diesel</platform>
		        <version>9.0</version>
			<email>napitki.ru@inbox.ru</email>
			<currencies>
				<currency id="RUR" rate="1"/>
			</currencies>
			',
		'conf_wrap_tag'=>'offers',
		'conf_element_tag'=>'offer',
		'conf_element_id_as_attribute'=>true,
		'conf_element_fixed_attributes'=>' bid="1" ',
		'conf_element_param_as_attribute'=>array(
							array(
								'type_id'=>'94',
								'attribute_title'=>'available',
								'evl'=>'8',
							),
						),
		'conf' => array(
				array(//0
					'field'=>'article',
					'type'=>'as_is',
					'title'=>'Артикул',
					'no_output'=>true,
					'template'=>'',
				),
				array(//1
					'field'=>'category_list',
					'type'=>'json',
					'data_mine_type'=>'field_by_row',
					'field_to_get'=>'category_id',
					'row_to_get'=>'0',
					'title'=>'Категория ID',
					'evl'=>5,
					'template'=>'<categoryId>{__val__}</categoryId>',
				),
				array(//1
					'field'=>'category_list',
					'type'=>'json',
					'data_mine_type'=>'field_by_row',
					'field_to_get'=>'title',
					'row_to_get'=>'0',
					'title'=>'Описание',
					'template'=>'<description>{__val__}</description>',
				),
				array(//3
					'field'=>'title',
					'type'=>'as_is',
					'title'=>'Название',
					'template'=>'<name><![CDATA[{__val__}]]></name>',
				),
				array(//3
					'field'=>'title',
					'type'=>'as_is',
					'title'=>'Модель',
					'template'=>'<model><![CDATA[{__val__}]]></model>',
				),

				array(//4
					'field'=>'manufacturers_list',
					'type'=>'json',
					'data_mine_type'=>'field_by_row',
					'field_to_get'=>'title',
					'row_to_get'=>'0',// производитель
					'title'=>'Производитель',
					'template'=>'<vendor><![CDATA[{__val__}]]></vendor>',
				),
				array(//5
					'field'=>'chars_list',
					'type'=>'json',
					'data_mine_type'=>'field_by_char_type',
					'char_type'=>'variable',
					'field_to_get'=>'variable_value',
					'type_field'=>'type_id',
					'type_id'=>'112', //Литраж
					'title'=>'Литраж',
					'template'=>'<param name="Литраж">{__val__}</param>',
				),
				array(//7
					'field'=>'chars_list',
					'type'=>'json',
					'data_mine_type'=>'field_by_char_type',
					'char_type'=>'fixed',
					'field_to_get'=>'type_value_str',
					'type_field'=>'type_id',
					'type_id'=>'141',  //
					'title'=>'Штук в упаковке',
					'template'=>'<param name="Штук в упаковке">{__val__}</param>',
				),
				array(//8
					'field'=>'chars_list',
					'type'=>'json',
					'data_mine_type'=>'field_by_char_type',
					'char_type'=>'fixed',
					'field_to_get'=>'type_value_str',
					'type_field'=>'type_id',
					'type_id'=>'114',  // тип упаковки
					'title'=>'Тип упаковки',
					'template'=>'<param name="Тип упаковки">{__val__}</param>',
				),
				array(//9
					'field'=>'chars_list',
					'type'=>'json',
					'data_mine_type'=>'field_by_char_type',
					'char_type'=>'variable',
					'field_to_get'=>'variable_value',
					'type_field'=>'type_id',
					'type_id'=>'128',  //скидка
					'title'=>'Скидка',
					'template'=>'<param name="Скидка">{__val__}</param>',
				),
				array(//12
					'field'=>'prices_list',
					'type'=>'json',
					'data_mine_type'=>'field_by_char_type',
					'char_type'=>'variable',
					'field_to_get'=>'price_value',
					'type_field'=>'type',
					'type_id'=>'11',  //Старая цена за упаковку
					'evl'=>3,
					'title'=>'Старая цена за упаковку',
					'template'=>'<oldprice>{__val__}</oldprice>',
				),
				array(//13
					'field'=>'prices_list',
					'type'=>'json',
					'data_mine_type'=>'field_by_char_type',
					'char_type'=>'variable',
					'field_to_get'=>'price_value',
					'type_field'=>'type',
					'type_id'=>'5',  //цена за упаковку
					'title'=>'Цена за упаковку',
					'evl'=>2,
					'template'=>'<price>{__val__}</price>',
				),
				array(//14
					'field'=>'chars_list',
					'type'=>'json',
					'data_mine_type'=>'field_by_char_type',
					'char_type'=>'fixed',
					'field_to_get'=>'type_value_str',
					'type_field'=>'type_id',
					'type_id'=>'133',  //Вид 
					'title'=>'Вид',
					'template'=>'<param name="Вид">{__val__}</param>',
				),
				array(//15
					'field'=>'chars_list',
					'type'=>'json',
					'data_mine_type'=>'field_by_char_type',
					'char_type'=>'fixed',
					'field_to_get'=>'type_value_str',
					'type_field'=>'type_id',
					'type_id'=>'145',  //фасовка 
					'title'=>'Вкус/Цвет',
					'template'=>'<param name="Вкус/Цвет">{__val__}</param>',
				),
				array(//18
					'field'=>'files_list',
					'type'=>'json',
					'data_mine_type'=>'field_by_row',
					'field_to_get'=>'real_name',
					'row_to_get'=>'0',
					'title'=>'Изображение',
					'prefix'=>'https://napitki.ru/filestorage/mark2/m2_item_files/thomb-',
					'evl'=>1,
					'template'=>'<picture>{__val__}</picture>'
				),
				array(//19
					'field'=>'name',
					'type'=>'as_is',
					'title'=>'Адрес',
					'prefix'=>'https://napitki.ru/catalog/items/',
					'postfix'=>'/',
					'template'=>'<url>{__val__}</url>',
				),
				array(//20
					'field'=>'chars_list',
					'type'=>'json',
					'data_mine_type'=>'field_by_char_type',
					'char_type'=>'variable',
					'field_to_get'=>'variable_value',
					'type_field'=>'type_id',
					'type_id'=>'603',  //Штрихкод
					'title'=>'Штрихкод',
					'template'=>'<barcode>{__val__}</barcode>',
				),
				array(//21
					'field'=>'chars_list',
					'type'=>'json',
					'data_mine_type'=>'field_by_char_type',
					'char_type'=>'fixed',
					'field_to_get'=>'type_value_str',
					'type_field'=>'type_id',
					'type_id'=>'604',  // Страна
					'title'=>'Страна',
					'evl'=>4,
					'template'=>'<country_of_origin>{__val__}</country_of_origin>',
				),
				array(//22
					'field'=>'chars_list',
					'type'=>'json',
					'data_mine_type'=>'field_by_char_type',
					'char_type'=>'variable',
					'field_to_get'=>'variable_value',
					'type_field'=>'type_id',
					'type_id'=>'144',  //вес одной упаковки 
					'title'=>'Вес одной упаковки в кг',
					'template'=>'<param name="Вес упаковки">{__val__}</param>',
				),

				array(//0
					'type'=>'fixed',
					'title'=>'Идентификатор Валюты',//фиксировано так как RUB'
					'value'=>'RUB',
					'template'=>'<currencyId>{__val__}</currencyId>',
				),
				array(//0
					'type'=>'fixed',
					'title'=>'Самовывоз',//фиксировано так как самовывоза нет'
					'value'=>'false',
					'template'=>'<pickup>false</pickup>',
				),
				array(//0
					'type'=>'fixed',
					'title'=>'Салес нотес',//фиксировано так как берется из реестра'
					'value'=>1,
					'evl'=>7,
					'template'=>'<sales_notes>{__val__}</sales_notes>',
				),
				array(//0
					'type'=>'fixed',
					'title'=>'курьерская дотсавка',//фиксировано'
					'value'=>'true',
					'template'=>'<delivery>{__val__}</delivery>',
				),
				array(//0
					'type'=>'fixed',
					'title'=>'Возможность купить без предварительного заказа',//фиксировано'
					'value'=>'false',
					'template'=>'<store>{__val__}</store>',
				),
				array(//22
					'field'=>'chars_list',
					'type'=>'json',
					'data_mine_type'=>'field_by_char_type',
					'char_type'=>'variable',
					'field_to_get'=>'variable_value',
					'type_field'=>'type_id',
					'type_id'=>'144',  //вес одной упаковки 
					'title'=>'Вес одной упаковки в кг',
					'template'=>'<weight>{__val__}</weight>',
				),

			)
	),
	// google merchant feeed
	array(
		'type'=>'2',
		'title'=>'google',
		'form_title'=>'Google Merchant XML RSS2.0',
		'file_name'=>'products.xml',
		'header'=>'<?xml version="1.0"?><rss version="2.0" xmlns:g="http://base.google.com/ns/1.0"><channel>',
		'footer'=> '</channel></rss>',
		'site_url'=>'https://napitki.ru',
		'titles'=>'
			<title>Напитки РУ</title>
			<link>https://napitki.ru</link>
			<description>Интернет магазин</description>
			',
		'conf_wrap_tag'=>'',
		'conf_element_tag'=>'item',
		'conf' => array(
				array(//0
					'field'=>'article',
					'type'=>'as_is',
					'title'=>'Артикул',
					'template'=>'<g:id>{__val__}</g:id>',
				),
				array(//3
					'field'=>'title',
					'type'=>'as_is',
					'title'=>'Название',
					'template'=>'<g:title><![CDATA[{__val__}]]></g:title>',
				),
				array(//19
					'field'=>'name',
					'type'=>'as_is',
					'title'=>'Адрес',
					'prefix'=>'https://napitki.ru/catalog/items/',
					'postfix'=>'/',
					'template'=>'<g:link>{__val__}</g:link>',
				),
				array(//3
					'field'=>'title',
					'type'=>'as_is',
					'title'=>'Описание',
					'template'=>'<g:description><![CDATA[{__val__}]]></g:description>',
				),
				array(//4
					'field'=>'manufacturers_list',
					'type'=>'json',
					'data_mine_type'=>'field_by_row',
					'field_to_get'=>'title',
					'row_to_get'=>'0',// производитель
					'title'=>'Производитель',
					'template'=>'<g:brand><![CDATA[{__val__}]]></g:brand>',
				),

				array(//20
					'field'=>'chars_list',
					'type'=>'json',
					'data_mine_type'=>'field_by_char_type',
					'char_type'=>'variable',
					'field_to_get'=>'variable_value',
					'type_field'=>'type_id',
					'type_id'=>'603',  //Штрихкод
					'title'=>'Штрихкод',
					'evl'=>9,
					'template'=>'<g:mpn>{__val__}</g:mpn>',
				),

				array(//18
					'field'=>'files_list',
					'type'=>'json',
					'data_mine_type'=>'field_by_row',
					'field_to_get'=>'real_name',
					'row_to_get'=>'0',
					'title'=>'Изображение',
					'evl'=>10,
					'template'=>'<g:image_link>{__val__}</g:image_link>'
				),
				array(//13
					'field'=>'prices_list',
					'type'=>'json',
					'data_mine_type'=>'field_by_char_type',
					'char_type'=>'variable',
					'field_to_get'=>'price_value',
					'type_field'=>'type',
					'type_id'=>'5',  //цена за упаковку
					'title'=>'Цена за упаковку',
					'template'=>'<g:price>{__val__} RUB</g:price>',
				),
				array(//21
					'field'=>'chars_list',
					'type'=>'json',
					'data_mine_type'=>'field_by_char_type',
					'char_type'=>'fixed',
					'field_to_get'=>'type_value_str',
					'type_field'=>'type_id',
					'type_id'=>'94',  //Доступность 
					'title'=>'Страна',
					'evl'=>6,
					'template'=>'<g:availability>{__val__}</g:availability>',
				),

				/*
				array(//4
					'field'=>'manufacturers_list',
					'type'=>'json',
					'data_mine_type'=>'field_by_row',
					'field_to_get'=>'title',
					'row_to_get'=>'0',// производитель
					'title'=>'Производитель',
					'template'=>'<g:brand>{__val__}</g:brand>',
				),
				*/
			)
	)

);


function price_export_handlers($in,$val)
{
	if($in == 1)
	{
		if($val)
		{
			return $val;
		}
		return '';
//		return substr($val,0,-4).'.png';
	}
	if($in == 2)
	{
		if($val == '0.00')
		{
			return 'skip_item';
		}
		return $val;
	}
	if($in == 3)
	{
		if($val == '0.00')
		{
			return '';
		}
	}
	if($in == 4)
	{
		if($val == 'Чешская Республика')
		{
			return 'Чехия';
		}
		return $val;
	}
	if($in == 5)
	{
		if($val == '')
		{
			return 'skip_item';
		}
		return $val;
	}
	if($in == 6)
	{
		if($val == 'В наличии')
		{
			return 'in_stock';
		}
		else
		{
			return 'preorder';
		}
		return $val;
	}

	if($in == 7)
	{
		$sn = 0;
		$sn = glob::get('sales_notes');
		if(!$sn)
		{
		  $sn = registry::get('sales_notes');
		}
		return $sn;
	}
	if($in == 8)
	{
		if($val == 'В наличии')
		{
			return 'true';
		}
		return 'false';
	}
	if($in == 9)
	{
		if($val == '0')
		{
			return '';
		}
		return $val;
	}
	if($in == 10)
	{
		if($val)
		{
			return 'https://napitki.ru/filestorage/mark2/m2_item_files/'.$val;
		}
		return 'https://napitki.ru/themes/termt/img/nophoto.png';
	}

}



?>
