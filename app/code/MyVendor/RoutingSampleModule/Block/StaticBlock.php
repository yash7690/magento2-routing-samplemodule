<?php

namespace MyVendor\RoutingSampleModule\Block;

class StaticBlock extends \Magento\Framework\View\Element\Template
{
	public function callMyFunction()
    {
        return 'Static Block Function called';
    }
}