<?php
/**
 * Adminhtml permissions variable edit form
 *
 * @category   Mage
 * @package    Mage_Adminhtml
 * @author     Mio Core Team <developer@ioe9.com>
 */
class Mage_Adminhtml_Block_Permissions_Variable_Edit_Form extends Mage_Adminhtml_Block_Widget_Form
{
    /**
     * @return Mage_Adminhtml_Block_Widget_Form
     * @throws Exception
     */
    protected function _prepareForm()
    {
        $block = Mage::getModel('admin/variable')->load((int) $this->getRequest()->getParam('variable_id'));

        $form = new Varien_Data_Form(array(
            'id' => 'edit_form',
            'action' => $this->getUrl(
                '*/*/save',
                array(
                    'variable_id' => (int) $this->getRequest()->getParam('variable_id')
                )
            ),
            'method' => 'post'
        ));
        $fieldset = $form->addFieldset(
            'variable_details', array('legend' => $this->__('Variable Details'))
        );

        $fieldset->addField('variable_name', 'text', array(
            'label' => $this->__('Variable Name'),
            'required' => true,
            'name' => 'variable_name',
        ));


        $yesno = array(
            array(
                'value' => 0,
                'label' => $this->__('No')
            ),
            array(
                'value' => 1,
                'label' => $this->__('Yes')
            ));


        $fieldset->addField('is_allowed', 'select', array(
            'name' => 'is_allowed',
            'label' => $this->__('Is Allowed'),
            'title' => $this->__('Is Allowed'),
            'values' => $yesno,
        ));

        $form->setUseContainer(true);
        $form->setValues($block->getData());
        $this->setForm($form);
        return parent::_prepareForm();
    }
}
