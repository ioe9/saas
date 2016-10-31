<?php
/***
 * LIKE
 * LIKE %...%
 * #NOT LIKE
 * =
 * !=
 * REGEXP
 * REGEXP ^...$
 * #NOT REGEXP
 * IN (...)
 * #NOT IN (...)
 * #BETWEEN
 * #NOT BETWEEN
 * #IS NULL
 * #IS NOT NULL
 */
class Mage_Edm_Helper_Client_Rule extends Mage_Core_Helper_Abstract
{
	public function getRuleConfig()
	{
		$helper = Mage::helper('edm');
		$commOperator = array('==' => ('is'),'()' => ('is one of'));
		$valueInput = array('type' => 'input');
		$config = array(
			array(
				'label' => '基本',
				'data' => array(
					array ('label' => ('URL 地址'),
						'code' => 'url',
						'operator' => array(
							'SPH_MATCH_ALL' => ('匹配所有的词（无顺序）'),
							'SPH_MATCH_ANY' => ('匹配其中一个词'),
							'SPH_MATCH_PHRASE' => ('匹配短语（全匹配）'),
							'SPH_MATCH_BOOLEAN' => ('使用布尔表达式匹配'),
							'SPH_MATCH_EXTENDED' => '高级表达式匹配'
						),
						'value' => array(
							'type' => 'input',
						),
					),
				)
			),
			array(
				'label' => '文本标签',
				'data' => array(
					array ('label' => ('H1 标签文本'),
						'code' => 'page_tag_h1',
						'operator' => array(
							'SPH_MATCH_ALL' => ('匹配所有的词（无顺序）'),
							'SPH_MATCH_ANY' => ('匹配其中一个词'),
							'SPH_MATCH_PHRASE' => ('匹配短语（全匹配）'),
							'SPH_MATCH_BOOLEAN' => ('使用布尔表达式匹配'),
							'SPH_MATCH_EXTENDED' => '高级表达式匹配'
						),
						'value' => array(
							'type' => 'input',
						),
					),
					array ('label' => ('H2 标签文本'),
						'code' => 'page_tag_h2',
						'operator' => array(
							'=' => ('等于'),
							'SPH_MATCH_ALL' => ('匹配所有的词（无顺序）'),
							'SPH_MATCH_ANY' => ('匹配其中一个词'),
							'SPH_MATCH_PHRASE' => ('匹配短语（全匹配）'),
							'SPH_MATCH_BOOLEAN' => ('使用布尔表达式匹配'),
							'SPH_MATCH_EXTENDED' => '高级表达式匹配'
						),
						'value' => array(
							'type' => 'input',
						),
					),
					array ('label' => ('H3 标签文本'),
						'code' => 'page_tag_h3',
						'operator' => array(
							'=' => ('等于'),
							'SPH_MATCH_ALL' => ('匹配所有的词（无顺序）'),
							'SPH_MATCH_ANY' => ('匹配其中一个词'),
							'SPH_MATCH_PHRASE' => ('匹配短语（全匹配）'),
							'SPH_MATCH_BOOLEAN' => ('使用布尔表达式匹配'),
							'SPH_MATCH_EXTENDED' => '高级表达式匹配'
						),
						'value' => array(
							'type' => 'input',
						),
					)
				)
			),
			array(
				'label' => 'SEO Meta',
				'data' => array(
					array ('label' => ('Meta Title'),
						'code' => 'meta_title',
						'operator' => array(
							'SPH_MATCH_ALL' => ('匹配所有的词（无顺序）'),
							'SPH_MATCH_ANY' => ('匹配其中一个词'),
							'SPH_MATCH_PHRASE' => ('匹配短语（全匹配）'),
							'SPH_MATCH_BOOLEAN' => ('使用布尔表达式匹配'),
							'SPH_MATCH_EXTENDED' => '高级表达式匹配'
						),
						'value' => array(
							'type' => 'input',
						),
					),
					array ('label' => ('Meta Keywords'),
						'code' => 'meta_keyword',
						'operator' => array(
							'SPH_MATCH_ALL' => ('匹配所有的词（无顺序）'),
							'SPH_MATCH_ANY' => ('匹配其中一个词'),
							'SPH_MATCH_PHRASE' => ('匹配短语（全匹配）'),
							'SPH_MATCH_BOOLEAN' => ('使用布尔表达式匹配'),
							'SPH_MATCH_EXTENDED' => '高级表达式匹配'
						),
						'value' => array(
							'type' => 'input',
						),
					),
					array ('label' => ('Meta Description'),
						'code' => 'meta_description',
						'operator' => array(
							'SPH_MATCH_ALL' => ('匹配所有的词（无顺序）'),
							'SPH_MATCH_ANY' => ('匹配其中一个词'),
							'SPH_MATCH_PHRASE' => ('匹配短语（全匹配）'),
							'SPH_MATCH_BOOLEAN' => ('使用布尔表达式匹配'),
							'SPH_MATCH_EXTENDED' => '高级表达式匹配'
						),
						'value' => array(
							'type' => 'input',
						),
					),
					
				)
			),
			array(
				'label' => '文本txt内容',
				'data' => array(
					array ('label' => ('全文'),
						'code' => 'page_txt',
						'operator' => array(
							'SPH_MATCH_ALL' => ('匹配所有的词（无顺序）'),
							'SPH_MATCH_ANY' => ('匹配其中一个词'),
							'SPH_MATCH_PHRASE' => ('匹配短语（全匹配）'),
							'SPH_MATCH_BOOLEAN' => ('使用布尔表达式匹配'),
							'SPH_MATCH_EXTENDED' => '高级表达式匹配'
						),
						'value' => array(
							'type' => 'input',
						),
					),
					/*
					array ('label' => ('段落'),
						'code' => 'page_txt_p',
						'operator' => array(
							'CONTAINS' => ('CONTAINS'),
						),
						'value' => array(
							'type' => 'input',
						),
					),
					array ('label' => ('单句'),
						'code' => 'page_txt_u',
						'operator' => array(
							'CONTAINS' => (''),
							'CONTAINS_ONE' => (''),
						),
						'value' => array(
							'type' => 'input',
						),
					),
					array ('label' => ('单词'),
						'code' => 'page_txt_w',
						'operator' => array(
							'CONTAINS' => ('CONTAINS'),
						),
						'value' => array(
							'type' => 'input',
						),
					),*/
				)
			),
			
		);
		return $config;
	}
	
	public function getActionType() {
		$clientAttrs = Mage::getResourceModel('edm/client_attr_collection');
		$arr = array(
			'update_client_attr' => array(
				'name' => '更新客户属性',
				//'attr' => $clientAttrs->toOptionArray()
			),
			'apply_category_relate' => array(
				'name' => '关联产品分类',
				//'attr' => $clientAttrs->toOptionArray()
			)
		
		);
		echo "<xmp>";var_dump($arr); echo "</xmp>";
		return $arr;
	}
}
?>
