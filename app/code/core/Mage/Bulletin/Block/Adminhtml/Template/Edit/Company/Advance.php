<?php
class Mage_Bulletin_Block_Adminhtml_Template_Edit_Company_Advance extends Mage_Adminhtml_Block_Widget_Form
{
    /**
     * Define Form settings
     *
     */
    public function __construct()
    {
        parent::__construct();
        
    }
    protected function _prepareLayout()
    {
        parent::_prepareLayout();
    }
    
    protected function _prepareForm()
    {
        $form   = new Varien_Data_Form(array(
            'id'        => 'edit_form',
            'action'    => $this->getData('action'),
            'method'    => 'post',
            'enctype' => 'multipart/form-data'
        ));
		$model = Mage::registry('current_company');
		$data = $model->getData();
		$data['id'] = $model->getId();
        $fieldset   = $form->addFieldset('base_fieldset', array(
            'legend'    => ('高级设置'),
            'class'    => 'fieldset-wide',
        ));
        $collection = Mage::getResourceModel('bulletin/company_attr_collection')
        	->setOrder('position','desc');
        foreach ($collection as $_attr) {
        	if ($_attr->getData('attr_type')=='select') {
        		$tmpArr = array('--请选择--');
        		$options = $_attr->getChildrenOption();
        		foreach ($options as $_option) {
        			//array_push($tmpArr,);
        			$tmpArr[$_option->getId()] = $_option->getValue();
        		}
        		//echo $options->getSelect();
        		$fieldset->addField('attr['.$_attr->getId().']', 'select', array(
		            'name'      => 'attr['.$_attr->getId().']',
		            'label'     => $_attr['name'],
		            'title'     => $_attr['name'],
		            'required'  => false,
		            'options'   => $tmpArr,
		        ));
        	} else {
        		$type = 'text';
        		if ($_attr->getData('attr_type')=='textarea') {
        			$fieldset->addField('attr['.$_attr->getId().']', 'textarea', array(
			            'name'      => 'attr['.$_attr->getId().']',
			            'label'     => $_attr['name'],
			            'title'     => $_attr['name'],
			            'required'  => false,
			            'style' => 'height:100px',
	
			        ));
        		} else {
        			$fieldset->addField('attr['.$_attr->getId().']', 'text', array(
			            'name'      => 'attr['.$_attr->getId().']',
			            'label'     => $_attr['name'],
			            'title'     => $_attr['name'],
			            'required'  => false,
	
			        ));
        		}
        		
        	}
        	
        }
        if ($model->getId()) {
        	$values = Mage::getResourceModel('bulletin/company_attr_value_collection')
				->addFieldToFilter('company_id',$model->getId());
			foreach ($values as $_value) {
				$data['attr['.$_value->getAttrId().']'] = $_value->getValue();
			}
        }
			
       
        $form->setValues($data);
        $form->setAction($this->getUrl('*/*/save'));
        $form->setUseContainer(false);
        $this->setForm($form);

    }
}
