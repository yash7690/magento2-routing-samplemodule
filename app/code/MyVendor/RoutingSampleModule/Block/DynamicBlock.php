<?php

namespace MyVendor\RoutingSampleModule\Block;

class DynamicBlock extends \Magento\Framework\View\Element\Template
{
	public function callMyFunction()
    {
        return 'Dynamic Block Function called';
    }
}