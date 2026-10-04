<?php
namespace Kumar\CommerceIntelligence\Controller\Adminhtml\Checkout;
use Magento\Backend\App\Action; use Magento\Backend\App\Action\Context; use Magento\Framework\Controller\ResultFactory; use Magento\Framework\View\Result\Page;
class Index extends Action { public const ADMIN_RESOURCE='Kumar_CommerceIntelligence::checkout'; public function execute(): Page { $page=$this->resultFactory->create(ResultFactory::TYPE_PAGE); $page->setActiveMenu('Kumar_CommerceIntelligence::checkout'); $page->getConfig()->getTitle()->prepend(__('Checkout Intelligence')); return $page; } }
