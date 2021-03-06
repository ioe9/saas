<?php
/**
 * Urlrewrites edit form
 *
 * @category   Mage
 * @package    Mage_Adminhtml
 * @author      Mio Core Team <developer@ioe9.com>
 */
class Mage_Adminhtml_Block_Urlrewrite_Edit_Form extends Mage_Adminhtml_Block_Widget_Form
{
    /**
     * Set form id and title
     *
     */
    public function __construct()
    {
        parent::__construct();
        $this->setId('urlrewrite_form');
        $this->setTitle(Mage::helper('adminhtml')->__('Block Information'));
    }

    /**
     * Prepare the form layout
     *
     * @return Mage_Adminhtml_Block_Urlrewrite_Edit_Form
     */
    protected function _prepareForm()
    {
        $model    = Mage::registry('current_urlrewrite');
        $product  = Mage::registry('current_product');
        $category = Mage::registry('current_category');

        $form = new Varien_Data_Form(
            array(
                'id' => 'edit_form',
                'action' => $this->getData('action'),
                'method' => 'post'
            )
        );

        // set form data either from model values or from session
        $formValues = array(
            'id_path'      => $model->getIdPath(),
            'request_path' => $model->getRequestPath(),
            'target_path'  => $model->getTargetPath(),
            'options'      => $model->getOptions(),
            'description'  => $model->getDescription(),
        );
        if ($sessionData = Mage::getSingleton('adminhtml/session')->getData('urlrewrite_data', true)) {
            foreach ($formValues as $key => $value) {
                if (isset($sessionData[$key])) {
                    $formValues[$key] = $sessionData[$key];
                }
            }
        }

        $fieldset = $form->addFieldset('base_fieldset', array(
            'legend'    => Mage::helper('adminhtml')->__('URL Rewrite Information')
        ));

        $fieldset->addField('is_system', 'select', array(
            'label'     => Mage::helper('adminhtml')->__('Type'),
            'title'     => Mage::helper('adminhtml')->__('Type'),
            'name'      => 'is_system',
            'required'  => true,
            'options'   => array(
                1 => Mage::helper('adminhtml')->__('System'),
                0 => Mage::helper('adminhtml')->__('Custom')
            ),
            'disabled'  => true,
            'value'     => $model->getIsSystem()
        ));

        $idPath = $fieldset->addField('id_path', 'text', array(
            'label'     => Mage::helper('adminhtml')->__('ID Path'),
            'title'     => Mage::helper('adminhtml')->__('ID Path'),
            'name'      => 'id_path',
            'required'  => true,
            'disabled'  => true,
            'value'     => $formValues['id_path']
        ));

        $requestPath = $fieldset->addField('request_path', 'text', array(
            'label'     => Mage::helper('adminhtml')->__('Request Path'),
            'title'     => Mage::helper('adminhtml')->__('Request Path'),
            'name'      => 'request_path',
            'required'  => true,
            'value'     => $formValues['request_path']
        ));

        $targetPath = $fieldset->addField('target_path', 'text', array(
            'label'     => Mage::helper('adminhtml')->__('Target Path'),
            'title'     => Mage::helper('adminhtml')->__('Target Path'),
            'name'      => 'target_path',
            'required'  => true,
            'disabled'  => true,
            'value'     => $formValues['target_path'],
        ));

        // auto-generate paths for new url rewrites
        if (!$model->getId()) {
            $_product  = null;
            $_category = null;
            if ($category->getId() || $product->getId()) {
                $_category = $category;
            }

            if ($product->getId()) {
                $_product = $product;
            }

            if ($_category || $_product) {
                $catalogUrlModel = Mage::getSingleton('catalog/url');
                $idPath->setValue($catalogUrlModel->generatePath('id', $_product, $_category));
                if (!isset($sessionData['request_path'])) {
                    $requestPath->setValue($catalogUrlModel->generatePath('request', $_product, $_category, ''));
                }
                $targetPath->setValue($catalogUrlModel->generatePath('target', $_product, $_category));
            } else {
                $idPath->unsetData('disabled');
                $targetPath->unsetData('disabled');
            }
        } else {
            if (!$model->getProductId() && !$model->getCategoryId()) {
                $idPath->unsetData('disabled');
                $targetPath->unsetData('disabled');
            }
        }

        $fieldset->addField('options', 'select', array(
            'label'     => Mage::helper('adminhtml')->__('Redirect'),
            'title'     => Mage::helper('adminhtml')->__('Redirect'),
            'name'      => 'options',
            'options'   => array(
                ''   => Mage::helper('adminhtml')->__('No'),
                'R'  => Mage::helper('adminhtml')->__('Temporary (302)'),
                'RP' => Mage::helper('adminhtml')->__('Permanent (301)'),
            ),
            'value'     => $formValues['options']
        ));

        $fieldset->addField('description', 'textarea', array(
            'label'     => Mage::helper('adminhtml')->__('Description'),
            'title'     => Mage::helper('adminhtml')->__('Description'),
            'name'      => 'description',
            'cols'      => 20,
            'rows'      => 5,
            'value'     => $formValues['description'],
            'wrap'      => 'soft'
        ));

        $form->setUseContainer(true);
        $form->setAction(Mage::helper('adminhtml')->getUrl('*/*/save', array(
            'id'       => $model->getId(),
            'product'  => $product->getId(),
            'category' => $category->getId(),
        )));
        $this->setForm($form);

        return parent::_prepareForm();
    }
}
