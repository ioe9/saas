<?php
class Mage_Core_Model_Encryption
{
    /**
     * @var Varien_Crypt_Mcrypt
     */
    protected $_crypt;
    /**
     * @var Mage_Core_Helper_Data
     */
    protected $_helper;

    /**
     * Set helper instance
     *
     * @param Mage_Core_Helper_Data $helper
     * @return Mage_Core_Model_Encryption
     */
    public function setHelper($helper)
    {
        $this->_helper = $helper;
        return $this;
    }

    /**
     * Generate a [salted] hash.
     *
     * $salt can be:
     * false - a random will be generated
     * integer - a random with specified length will be generated
     * string
     *
     * @param string $password
     * @param mixed $salt
     * @return string
     */
    public function getHash($password, $salt = false)
    {
        if (is_integer($salt)) {
            $salt = $this->_helper->getRandomString($salt);
        }
        return $salt === false ? $this->hash($password) : $this->hash($salt . $password) . ':' . $salt;
    }

    /**
     * Hash a string
     *
     * @param string $data
     * @return string
     */
    public function hash($data)
    {
        return md5($data);
    }

    /**
     * Validate hash against hashing method (with or without salt)
     *
     * @param string $password
     * @param string $hash
     * @return bool
     * @throws Exception
     */
    public function validateHash($password, $hash)
    {
        $hashArr = explode(':', $hash);
        switch (count($hashArr)) {
            case 1:
                return $this->hash($password) === $hash;
            case 2:
                return $this->hash($hashArr[1] . $password) === $hashArr[0];
        }
        Mage::throwException('Invalid hash.');
    }

    /**
     * Instantiate crypt model
     *
     * @param string $key
     * @return Varien_Crypt_Mcrypt
     */
    protected function _getCrypt($key = null)
    {
        if (!$this->_crypt) {
            if (null === $key) {
                $key = (string)Mage::getConfig()->getNode('global/crypt/key');
            }
            $this->_crypt = Varien_Crypt::factory()->init($key);
        }
        return $this->_crypt;
    }

    /**
     * Encrypt a string
     *
     * @param string $data
     * @return string
     */
    public function encrypt($data)
    {
        return base64_encode($this->_getCrypt()->encrypt((string)$data));
    }

    /**
     * Decrypt a string
     *
     * @param string $data
     * @return string
     */
    public function decrypt($data)
    {
        return str_replace("\x0", '', trim($this->_getCrypt()->decrypt(base64_decode((string)$data))));
    }

    /**
     * Return crypt model, instantiate if it is empty
     *
     * @param string $key
     * @return Varien_Crypt_Mcrypt
     */
    public function validateKey($key)
    {
        return $this->_getCrypt($key);
    }
}
