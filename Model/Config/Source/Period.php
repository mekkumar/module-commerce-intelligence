<?php
namespace Kumar\CommerceIntelligence\Model\Config\Source;
use Magento\Framework\Data\OptionSourceInterface;
class Period implements OptionSourceInterface { public function toOptionArray(): array { return [['value'=>7,'label'=>__('Last 7 Days')],['value'=>30,'label'=>__('Last 30 Days')],['value'=>90,'label'=>__('Last 90 Days')],['value'=>365,'label'=>__('Last 365 Days')]]; } }
