<?php
namespace Kumar\CommerceIntelligence\Model;
use Magento\Framework\App\Config\ScopeConfigInterface;
use Magento\Store\Model\ScopeInterface;
class Config {
 private const ENABLED='kumar_commerceintelligence/general/enabled'; private const PERIOD='kumar_commerceintelligence/general/default_period';
 public function __construct(private readonly ScopeConfigInterface $scopeConfig){}
 public function isEnabled(?int $storeId=null): bool { return $this->scopeConfig->isSetFlag(self::ENABLED,ScopeInterface::SCOPE_STORE,$storeId); }
 public function getDefaultPeriod(?int $storeId=null): int { return (int)$this->scopeConfig->getValue(self::PERIOD,ScopeInterface::SCOPE_STORE,$storeId) ?: 30; }
}
