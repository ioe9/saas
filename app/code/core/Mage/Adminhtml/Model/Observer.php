<?php
class Mage_Adminhtml_Model_Observer
{

    public function bindLocale($observer)
    {
        if ($locale=$observer->getEvent()->getLocale()) {
            if ($choosedLocale = Mage::getSingleton('adminhtml/session')->getLocale()) {
                $locale->setLocaleCode($choosedLocale);
            }
        }
        return $this;
    }


    /**
     * Prepare massaction separated data
     *
     * @return Mage_Adminhtml_Model_Observer
     */
    public function massactionPrepareKey()
    {
        $request = Mage::app()->getFrontController()->getRequest();
        if ($key = $request->getPost('massaction_prepare_key')) {
            $value = is_array($request->getPost($key)) ? $request->getPost($key) : explode(',', $request->getPost($key));
            $request->setPost($key, $value ? $value : null);
        }
        return $this;
    }
}
