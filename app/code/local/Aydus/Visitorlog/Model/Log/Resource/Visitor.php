<?php

/**
 * Add additional info to log visitor
 *
 * @category   Aydus
 * @package	   Aydus_Visitorlog
 * @author     Aydus Consulting <davidt@aydus.com>
 */

class Aydus_Visitorlog_Model_Log_Resource_Visitor extends Mage_Log_Model_Resource_Visitor
{
	/**
	 * Add visitor and customer info
	 *
	 * @param Varien_Object $object
	 * @return Mage_Core_Model_Resource_Db_Abstract
	 */
	protected function _afterLoad(Mage_Core_Model_Abstract $object)
	{
		parent::_afterLoad($object);

		$adapter = $this->_getReadAdapter();
		$select = $adapter->select()->from($this->getTable('log/visitor_info'), '*')
		->where('visitor_id = ?', $object->getId())->limit(1);
		
		$result = $adapter->query($select)->fetch();
		if (isset($result['visitor_id']) && $result['visitor_id'] == $object->getId()) {
			
			$data = array_merge($object->getData(),$result);
			$object->setData($data);
		}
		
		$customerSelect = $adapter->select()->from($this->getTable('log/customer'), array('customer_id', 'login_at', 'logout_at'))
		->where('visitor_id = ?', $object->getId())->limit(1);
		
		$customerResult = $adapter->query($customerSelect)->fetch();
		if (count($customerResult)> 0 && (int)$customerResult['customer_id']) {
			
			$customerId = $customerResult['customer_id'];
			$customer = Mage::getModel('customer/customer')->load($customerId);
			$customerResult['customer_name'] = $customer->getName();
			$customerResult['customer_email'] = $customer->getEmail();
				
			$data = array_merge($object->getData(),$customerResult);
			$object->setData($data);
		}
				
		return $this;
	}	
}
