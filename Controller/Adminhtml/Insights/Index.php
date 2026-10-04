<?php
namespace Kumar\CommerceIntelligence\Controller\Adminhtml\Insights;
use Magento\Backend\App\Action; use Magento\Backend\App\Action\Context; use Magento\Framework\Controller\ResultFactory; use Magento\Framework\View\Result\Page;
class Index extends Action { public const ADMIN_RESOURCE='Kumar_CommerceIntelligence::insights'; public function execute(): Page { $page=$this->resultFactory->create(ResultFactory::TYPE_PAGE); $page->setActiveMenu('Kumar_CommerceIntelligence::insights'); $page->getConfig()->getTitle()->prepend(__('Insights Intelligence')); return $page; } }
