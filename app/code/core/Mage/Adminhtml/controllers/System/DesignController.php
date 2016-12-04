<?php



class Mage_Adminhtml_System_DesignController extends Mage_Adminhtml_Controller_Action
{
    public function indexAction()
    {
        $this->_title($this->__('System'))->_title($this->__('Design'));

        $this->loadLayout();
        $this->_setActiveMenu('system');
        $this->_addContent($this->getLayout()->createBlock('adminhtml/system_design'));
        $this->renderLayout();
    }

    public function gridAction()
    {
        $this->getResponse()->setBody($this->getLayout()->createBlock('adminhtml/system_design_grid')->toHtml());
    }

    public function newAction()
    {
        $this->_forward('edit');
    }

    public function editAction()
    {
        $this->_title($this->__('System'))->_title($this->__('Design'));

        $this->loadLayout();
        $this->_setActiveMenu('system');
        $this->getLayout()->getBlock('head')->setCanLoadExtJs(true);

        $id  = (int) $this->getRequest()->getParam('id');
        $design    = Mage::getModel('core/design');

        if ($id) {
            $design->load($id);
        }

        $this->_title($design->getId() ? $this->__('Edit Design Change') : $this->__('New Design Change'));

        Mage::register('design', $design);

        $this->_addContent($this->getLayout()->createBlock('adminhtml/system_design_edit'));
        $this->_addLeft($this->getLayout()->createBlock('adminhtml/system_design_edit_tabs', 'design_tabs'));

        $this->renderLayout();
    }

    public function saveAction()
    {
        if ($data = $this->getRequest()->getPost()) {
            if (!empty($data['design'])) {
                $data['design'] = $this->_filterDates($data['design'], array('date_from', 'date_to'));
            }

            $id = (int) $this->getRequest()->getParam('id');

            $design = Mage::getModel('core/design');
            if ($id) {
                $design->load($id);
            }

            $design->setData($data['design']);
            if ($id) {
                $design->setId($id);
            }
            try {
                $design->save();

                Mage::getSingleton('adminhtml/session')->addSuccess($this->__('The design change has been saved.'));
            } catch (Exception $e){
                Mage::getSingleton('adminhtml/session')
                    ->addError($e->getMessage())
                    ->setDesignData($data);
                $this->_redirect('*/*/edit', array('id'=>$design->getId()));
                return;
            }
        }

        $this->_redirect('*/*/');
    }

    public function deleteAction()
    {
        if ($id = $this->getRequest()->getParam('id')) {
            $design = Mage::getModel('core/design')->load($id);

            try {
                $design->delete();

                Mage::getSingleton('adminhtml/session')
                    ->addSuccess($this->__('The design change has been deleted.'));
            } catch (Mage_Exception $e) {
                Mage::getSingleton('adminhtml/session')
                    ->addError($e->getMessage());
            } catch (Exception $e) {
                Mage::getSingleton('adminhtml/session')
                    ->addException($e, $this->__("Cannot delete the design change."));
            }
        }
        $this->getResponse()->setRedirect($this->getUrl('*/*/'));
    }

    protected function _isAllowed()
    {
        return Mage::getSingleton('admin/session')->isAllowed('system/design');
    }
}
