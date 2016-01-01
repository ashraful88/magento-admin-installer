<?php
// https://github.com/ashraful88/magento-admin-script 

$installer = $this;
$installer->startSetup();

// For creating for a store, comment out if simgle store
$store = Mage::app()->getStore('store_code');

// ===== CMS Static Blocks =====
$data = array(
    'title' => 'Hello World',
    'identifier' => 'hello-world-id',
    'stores' => array(0), // Array with store ID's
    'content' => '<p>Some HTML content for example</p>',
    'is_active' => 1
);

// Check if static block already exists, if yes then update content
$block = Mage::getModel('cms/block')->load($data['identifier']);
if ($block->isObjectNew()) {
    // Create static block
    Mage::getModel('cms/block')->setData($data)->save();
}else{
    // Update Content
    $block->setData('content', $data['content'])->save();
}


// ==== Product Attributes =====

$model =  new Mage_Catalog_Model_Resource_Setup();
$model->addAttribute(Mage_Catalog_Model_Product::ENTITY, 'my_custom_attribute_code', array(
    'group' => 'Prices',
    'type' => 'text',
    'attribute_set' =>  'Default', // Your custom Attribute set
    'backend' => '',
    'frontend' => '',
    'label' => 'My Custom Attribute',
    'input' => 'text',
    'global' => Mage_Catalog_Model_Resource_Eav_Attribute::SCOPE_GLOBAL,
    'visible' => true,
    'required' => false,
    'user_defined' => true,
    'default' => '1',
    'searchable' => false,
    'filterable' => true,
    'comparable' => false,
    'visible_on_front' => true,
    'visible_in_advanced_search' => true,
    'used_in_product_listing' => true,
    'unique' => false,
    'apply_to' => 'simple',  // Apply to simple product type
));

// System Configuraton 
$conf = new Mage_Core_Model_Config();
$address = 'Address Text Here';
$conf->saveConfig('general/store_information/address', $address, 'default', 0);

/* === CMS PAGE === */

$page = Mage::getModel('cms/page');
$page->setStoreId($store->getId());
$page->load('home','identifier');

$cmsPage = Array (
    'title' => 'Home PH',
    'identifier' => 'home',
    'content' => 'page content here',
    'is_active' => 1,
    'stores' => array($store->getId())
);

if ($page->getId()) {
    $page->setContent($cmsPage ['content']);
    $page->setTitle($cmsPage ['title']);
    $page->save();
} else {
    Mage::getModel('cms/page')->setData($cmsPage)->save();
}

/*=== Category Upgrade ====*/
$category = Mage::getModel('catalog/category')->load(79); // enter category id
$category->setDescription('Sample Category description'); // Update category description
$category->setIsAnchor(1); // set category "Is Anchor" yes
$category->save();

$installer->endSetup();
