<?php

namespace Kumar\CommerceIntelligence\Controller\Adminhtml\Dashboard;

use Magento\Backend\App\Action;
use Magento\Framework\Controller\ResultFactory;
use Magento\Framework\View\Result\Page;

class Index extends Action
{
    public const ADMIN_RESOURCE = 'Kumar_CommerceIntelligence::commerceintelligence';

    public function execute(): Page
    {
        $page = $this->resultFactory->create(
            ResultFactory::TYPE_PAGE
        );

        $page->setActiveMenu(
            'Kumar_CommerceIntelligence::commerceintelligence'
        );

        $page->getConfig()
            ->getTitle()
            ->prepend(__('Commerce Intelligence'));

        return $page;
    }
}