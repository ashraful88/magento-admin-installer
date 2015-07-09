<?php
$installer = $this;
$installer->startSetup();

// For creating a block for a store
//$store = Mage::app()->getStore('store_code');

$data = array(
    'title' => 'Hello World',
    'identifier' => 'hello-world-id',
    'stores' => array(0), // Array with store ID's
    'content' => '<p>Some HTML content for example</p>',
    'is_active' => 1
);

// Check if static block already exists:
$block = Mage::app()->getLayout()->createBlock('cms/block')->setBlockId($data['identifier']);

if ($block->getId() == false) {
    // Create static block:
    Mage::getModel('cms/block')->setData($data)->save();
}

$installer->endSetup();