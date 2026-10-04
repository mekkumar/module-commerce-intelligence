<?php
namespace Kumar\CommerceIntelligence\Controller\Adminhtml\Orders;
use Magento\Backend\App\Action; use Magento\Backend\App\Action\Context; use Magento\Framework\Controller\ResultFactory; use Magento\Framework\View\Result\Page;
class Index extends Action { public const ADMIN_RESOURCE='Kumar_CommerceIntelligence::orders'; public function execute(): Page { $page=$this->resultFactory->create(ResultFactory::TYPE_PAGE); $page->setActiveMenu('Kumar_CommerceIntelligence::orders'); $page->getConfig()->getTitle()->prepend(__('Orders Intelligence')); return $page; } }
