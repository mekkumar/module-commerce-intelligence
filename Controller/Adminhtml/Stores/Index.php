<?php
namespace Kumar\CommerceIntelligence\Controller\Adminhtml\Stores;
use Magento\Backend\App\Action; use Magento\Backend\App\Action\Context; use Magento\Framework\Controller\ResultFactory; use Magento\Framework\View\Result\Page;
class Index extends Action { public const ADMIN_RESOURCE='Kumar_CommerceIntelligence::stores'; public function execute(): Page { $page=$this->resultFactory->create(ResultFactory::TYPE_PAGE); $page->setActiveMenu('Kumar_CommerceIntelligence::stores'); $page->getConfig()->getTitle()->prepend(__('Stores Intelligence')); return $page; } }
