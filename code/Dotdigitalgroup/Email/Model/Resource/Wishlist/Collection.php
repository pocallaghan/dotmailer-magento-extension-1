<?php

class Dotdigitalgroup_Email_Model_Resource_Wishlist_Collection
    extends Mage_Core_Model_Resource_Db_Collection_Abstract
{

    /**
     * constructor.
     */
    public function _construct()
    {
        parent::_construct();
        $this->_init('ddg_automation/wishlist');
    }
}