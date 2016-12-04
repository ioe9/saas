<?php
/**
 * Admin Roles Model
 *
 * @method Mage_Admin_Model_Resource_Roles _getResource()
 * @method Mage_Admin_Model_Resource_Roles getResource()
 * @method int getParentId()
 * @method Mage_Admin_Model_Roles setParentId(int $value)
 * @method int getTreeLevel()
 * @method Mage_Admin_Model_Roles setTreeLevel(int $value)
 * @method int getSortOrder()
 * @method Mage_Admin_Model_Roles setSortOrder(int $value)
 * @method string getRoleType()
 * @method Mage_Admin_Model_Roles setRoleType(string $value)
 * @method int getUserId()
 * @method Mage_Admin_Model_Roles setUserId(int $value)
 * @method string getRoleName()
 * @method Mage_Admin_Model_Roles setRoleName(string $value)
 *
 * @category    Mage
 * @package     Mage_Admin
 * @author      Mio Core Team <developer@ioe9.com>
 */
class Mage_Admin_Model_Roles extends Mage_Core_Model_Abstract
{
    /**
     * @var string
     */
    protected $_eventPrefix = 'admin_roles';

    /**
     * Constructor
     */
    protected function _construct()
    {
        $this->_init('admin/roles');
    }

    /**
     * Update object into database
     *
     * @return Mage_Admin_Model_Roles
     */
    public function update()
    {
        $this->getResource()->update($this);
        return $this;
    }

    /**
     * Retrieve users collection
     *
     * @return Mage_Admin_Model_Resource_Roles_User_Collection
     */
    public function getUsersCollection()
    {
        return Mage::getResourceModel('admin/roles_user_collection');
    }

    /**
     * Return tree of acl resources
     *
     * @return array|null|Varien_Simplexml_Element
     */
    public function getResourcesTree()
    {
        return $this->_buildResourcesArray(null, null, null, null, true);
    }

    /**
     * Return list of acl resources
     *
     * @return array|null|Varien_Simplexml_Element
     */
    public function getResourcesList()
    {
        return $this->_buildResourcesArray();
    }

    /**
     * Return list of acl resources in 2D format
     *
     * @return array|null|Varien_Simplexml_Element
     */
    public function getResourcesList2D()
    {
        return $this->_buildResourcesArray(null, null, null, true);
    }

    /**
     * Return users for role
     *
     * @return array|false
     */
    public function getRoleUsers()
    {
        return $this->getResource()->getRoleUsers($this);
    }

    /**
     * Build resources array process
     *
     * @param  null|Varien_Simplexml_Element $resource
     * @param  null $parentName
     * @param  int $level
     * @param  null $represent2Darray
     * @param  bool $rawNodes
     * @param  string $module
     * @return array|null|Varien_Simplexml_Element
     */
    protected function _buildResourcesArray(Varien_Simplexml_Element $resource = null,
        $parentName = null, $level = 0, $represent2Darray = null, $rawNodes = false, $module = 'adminhtml')
    {
        static $result;
        if (is_null($resource)) {
            $resource = Mage::getSingleton('admin/config')->getAdminhtmlConfig()->getNode('acl/resources');
            $resourceName = null;
            $level = -1;
        } else {
            $resourceName = $parentName;
            if (!in_array($resource->getName(), array('title', 'sort_order', 'children', 'disabled'))) {
                $resourceName = (is_null($parentName) ? '' : $parentName . '/') . $resource->getName();

                //assigning module for its' children nodes
                if ($resource->getAttribute('module')) {
                    $module = (string)$resource->getAttribute('module');
                }

                if ($rawNodes) {
                    $resource->addAttribute("aclpath", $resourceName);
                    $resource->addAttribute("module_c", $module);
                }

                if ( is_null($represent2Darray) ) {
                    $result[$resourceName]['name']  = Mage::helper($module)->__((string)$resource->title);
                    $result[$resourceName]['level'] = $level;
                } else {
                    $result[] = $resourceName;
                }
            }
        }

        //check children and run recursion if they exists
        $children = $resource->children();
        foreach ($children as $key => $child) {
            if (1 == $child->disabled) {
                $resource->{$key} = null;
                continue;
            }
            $this->_buildResourcesArray($child, $resourceName, $level + 1, $represent2Darray, $rawNodes, $module);
        }

        if ($rawNodes) {
            return $resource;
        } else {
            return $result;
        }
    }
}
