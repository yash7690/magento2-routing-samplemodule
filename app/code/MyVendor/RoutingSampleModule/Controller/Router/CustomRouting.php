<?php

namespace MyVendor\RoutingSampleModule\Controller\Router;

use Magento\Framework\App\Config\ScopeConfigInterface;
use Magento\Store\Model\ScopeInterface;

class CustomRouting implements \Magento\Framework\App\RouterInterface
{
    protected $actionFactory;
	protected $_response;
	protected $storeManager;

    public function __construct(
        \Magento\Framework\App\ActionFactory $actionFactory,
        \Magento\Framework\App\ResponseInterface $response,
        ScopeConfigInterface $scopeConfig
    ) {
        $this->actionFactory = $actionFactory;
        $this->_response = $response;
        $this->scopeConfig = $scopeConfig;
    }

    public function match(\Magento\Framework\App\RequestInterface $request)
    {        
        $identifier = $request->getOriginalPathInfo();
        
        $condition = new \Magento\Framework\DataObject(['identifier' => $identifier, 'continue' => true]);
        $identifier = $condition->getIdentifier();

        if ($condition->getRedirectUrl()) {
            $this->_response->setRedirect($condition->getRedirectUrl());
            $request->setDispatched(true);
            return $this->actionFactory->create('Magento\Framework\App\Action\Redirect');
        }

        if (!$condition->getContinue()) {
            return null;
        }

        $link_url = $this->scopeConfig->getValue(
        	'routingsamplemodule/general/link_url',
        	ScopeInterface::SCOPE_STORE
        );

        $identifier = trim($identifier, '/');

        if($link_url && $identifier == $link_url)
        {
            $request->setModuleName('hello-world')->setControllerName('dynamic')->setActionName('index');
            $request->setAlias(\Magento\Framework\Url::REWRITE_REQUEST_PATH_ALIAS, $identifier);
            return $this->actionFactory->create('Magento\Framework\App\Action\Forward');
        }

        return null;
    }
}