<?php

namespace Kumar\CommerceIntelligence\Block\Adminhtml;

use Magento\Backend\Block\Template;
use Magento\Backend\Block\Template\Context;
use Magento\Sales\Model\ResourceModel\Order\CollectionFactory as OrderCollectionFactory;
use Magento\Store\Model\StoreManagerInterface;

class Dashboard extends Template
{
    private const ALLOWED_PERIODS = [7, 30, 90, 365];

    private OrderCollectionFactory $orderCollectionFactory;
    private StoreManagerInterface $storeManager;

    private ?array $orders = null;
    private ?array $stats = null;
    private ?array $comparisonStats = null;

    public function __construct(
        Context $context,
        OrderCollectionFactory $orderCollectionFactory,
        StoreManagerInterface $storeManager,
        array $data = []
    ) {
        $this->orderCollectionFactory = $orderCollectionFactory;
        $this->storeManager = $storeManager;

        parent::__construct($context, $data);
    }

    public function getPeriod(): int
    {
        $period = (int)$this->getRequest()->getParam('period', 30);

        if (!in_array($period, self::ALLOWED_PERIODS, true)) {
            $period = 30;
        }

        return $period;
    }

    public function getDateFrom(): string
    {
        $date = new \DateTime('now');
        $date->modify('-' . ($this->getPeriod() - 1) . ' days');

        return $date->format('Y-m-d 00:00:00');
    }

    public function getDateTo(): string
    {
        return (new \DateTime('now'))->format('Y-m-d 23:59:59');
    }

    private function getOrders(): array
    {
        if ($this->orders !== null) {
            return $this->orders;
        }

        $collection = $this->orderCollectionFactory->create();

        $collection->addFieldToFilter(
            'created_at',
            [
                'from' => $this->getDateFrom(),
                'to' => $this->getDateTo()
            ]
        );

        $collection->addFieldToFilter(
            'state',
            [
                'neq' => 'canceled'
            ]
        );

        $collection->setOrder('created_at', 'DESC');

        $this->orders = $collection->getItems();

        return $this->orders;
    }

    public function getStats(): array
    {
        if ($this->stats !== null) {
            return $this->stats;
        }

        $orders = $this->getOrders();

        $revenue = 0.0;
        $refunds = 0.0;
        $discounts = 0.0;

        $customerIds = [];
        $customerOrderCounts = [];
        $guestOrders = 0;
        $paymentTotals = [];
        $productStats = [];
        $peakHours = [];

        for ($hour = 0; $hour < 24; $hour++) {
            $peakHours[$hour] = 0;
        }

        foreach ($orders as $order) {
            $revenue += (float)$order->getGrandTotal();
            $refunds += (float)$order->getTotalRefunded();
            $discounts += abs((float)$order->getDiscountAmount());

            $customerId = (int)$order->getCustomerId();

            if ($customerId > 0) {
                $customerIds[$customerId] = true;
                $customerOrderCounts[$customerId] = ($customerOrderCounts[$customerId] ?? 0) + 1;
            } else {
                $guestOrders++;
            }

            /*
             * Payment
             */
            $payment = $order->getPayment();

            if ($payment) {
                $paymentCode = (string)$payment->getMethod();

                if ($paymentCode === '') {
                    $paymentCode = 'other';
                }

                if (!isset($paymentTotals[$paymentCode])) {
                    $paymentTotals[$paymentCode] = 0.0;
                }

                $paymentTotals[$paymentCode] += (float)$order->getGrandTotal();
            }

            /*
             * Peak hours
             */
            $createdAt = $order->getCreatedAt();

            if ($createdAt) {
                $hour = (int)date('G', strtotime($createdAt));

                if (isset($peakHours[$hour])) {
                    $peakHours[$hour]++;
                }
            }

            /*
             * Products
             */
            foreach ($order->getAllVisibleItems() as $item) {
                $sku = (string)$item->getSku();

                if ($sku === '') {
                    continue;
                }

                if (!isset($productStats[$sku])) {
                    $productStats[$sku] = [
                        'name' => (string)$item->getName(),
                        'sku' => $sku,
                        'orders' => 0,
                        'qty' => 0.0,
                        'revenue' => 0.0
                    ];
                }

                $productStats[$sku]['orders']++;
                $productStats[$sku]['qty'] += (float)$item->getQtyOrdered();
                $productStats[$sku]['revenue'] += (float)$item->getRowTotal();
            }
        }

        /*
         * Products by revenue
         */
        usort(
            $productStats,
            static function (array $a, array $b): int {
                return $b['revenue'] <=> $a['revenue'];
            }
        );

        $heroProducts = array_slice($productStats, 0, 5);

        /*
         * Payment distribution
         */
        $paymentDistribution = [];

        foreach ($paymentTotals as $method => $amount) {
            $paymentDistribution[$method] = [
                'amount' => $amount,
                'percentage' => $revenue > 0
                    ? ($amount / $revenue) * 100
                    : 0
            ];
        }

        uasort(
            $paymentDistribution,
            static function (array $a, array $b): int {
                return $b['amount'] <=> $a['amount'];
            }
        );

        $orderCount = count($orders);
        $repeatCustomers = count(array_filter($customerOrderCounts, static function (int $count): bool {
            return $count > 1;
        }));

        $this->stats = [
            'revenue' => $revenue,
            'orders' => $orderCount,
            'aov' => $orderCount > 0
                ? $revenue / $orderCount
                : 0.0,
            'customers' => count($customerIds),
            'registered_orders' => $orderCount - $guestOrders,
            'guest_orders' => $guestOrders,
            'repeat_customers' => $repeatCustomers,
            'order_statuses' => $this->getOrderStatusDistribution(),
            'comparison' => $this->getComparisonStats(),
            'refunds' => $refunds,
            'discounts' => $discounts,
            'payment_distribution' => $paymentDistribution,
            'hero_products' => $heroProducts,
            'peak_hours' => $peakHours,
            'revenue_trend' => $this->buildRevenueTrend($orders)
        ];

        return $this->stats;
    }

    private function getComparisonStats(): array
    {
        if ($this->comparisonStats !== null) {
            return $this->comparisonStats;
        }

        $period = $this->getPeriod();
        $currentStart = new \DateTime($this->getDateFrom());
        $previousEnd = (clone $currentStart)->modify('-1 second');
        $previousStart = (clone $previousEnd)->modify('-' . ($period - 1) . ' days')->setTime(0, 0, 0);

        $collection = $this->orderCollectionFactory->create();
        $collection->addFieldToFilter('created_at', [
            'from' => $previousStart->format('Y-m-d H:i:s'),
            'to' => $previousEnd->format('Y-m-d H:i:s')
        ]);
        $collection->addFieldToFilter('state', ['neq' => 'canceled']);

        $revenue = 0.0;
        $count = 0;
        foreach ($collection as $order) {
            $revenue += (float)$order->getGrandTotal();
            $count++;
        }

        return $this->comparisonStats = [
            'revenue' => $revenue,
            'orders' => $count,
            'aov' => $count > 0 ? $revenue / $count : 0.0,
            'from' => $previousStart->format('Y-m-d'),
            'to' => $previousEnd->format('Y-m-d')
        ];
    }

    private function getOrderStatusDistribution(): array
    {
        $collection = $this->orderCollectionFactory->create();
        $collection->addFieldToFilter('created_at', [
            'from' => $this->getDateFrom(),
            'to' => $this->getDateTo()
        ]);
        $collection->addFieldToSelect('status');

        $statuses = [];
        foreach ($collection as $order) {
            $status = (string)$order->getStatus();
            $statuses[$status] = ($statuses[$status] ?? 0) + 1;
        }

        arsort($statuses);
        return $statuses;
    }

    public function getPercentageChange(float $current, float $previous): ?float
    {
        if ($previous == 0.0) {
            return $current > 0.0 ? null : 0.0;
        }

        return (($current - $previous) / abs($previous)) * 100;
    }

    public function getStatusLabel(string $status): string
    {
        return ucwords(str_replace(['_', '-'], ' ', $status));
    }

    private function buildRevenueTrend(array $orders): array
    {
        $trend = [];

        $start = new \DateTime($this->getDateFrom());
        $end = new \DateTime($this->getDateTo());

        for (
            $date = clone $start;
            $date <= $end;
            $date->modify('+1 day')
        ) {
            $key = $date->format('Y-m-d');

            $trend[$key] = [
                'date' => $key,
                'label' => $date->format('d M'),
                'revenue' => 0.0,
                'orders' => 0
            ];
        }

        foreach ($orders as $order) {
            $createdAt = $order->getCreatedAt();

            if (!$createdAt) {
                continue;
            }

            $key = date('Y-m-d', strtotime($createdAt));

            if (!isset($trend[$key])) {
                continue;
            }

            $trend[$key]['revenue'] += (float)$order->getGrandTotal();
            $trend[$key]['orders']++;
        }

        return array_values($trend);
    }

    public function formatPrice(float $amount): string
    {
        return $this->storeManager
            ->getStore()
            ->getCurrentCurrency()
            ->format($amount, [], false);
    }

    public function getPaymentLabel(string $code): string
    {
        $labels = [
            'cashondelivery' => 'Cash On Delivery',
            'paypal_express' => 'PayPal',
            'paypal' => 'PayPal',
            'checkmo' => 'Check / Money Order',
            'banktransfer' => 'Bank Transfer',
            'purchaseorder' => 'Purchase Order',
            'pay_in_store' => 'Pay In Store',
            'mpgs_hostedcheckout' => 'Credit Card',
            'mpgs_direct' => 'Credit Card',
            'cc_on_delivery' => 'Visa on Delivery',
            'valu' => 'Pay Later - Valu'
        ];

        return $labels[$code]
            ?? ucwords(str_replace(['_', '-'], ' ', $code));
    }

    public function getMaxTrendRevenue(): float
    {
        $max = 0.0;

        foreach ($this->getStats()['revenue_trend'] as $item) {
            $max = max($max, (float)$item['revenue']);
        }

        return $max;
    }

    public function getMaxPeakOrders(): int
    {
        $peakHours = $this->getStats()['peak_hours'];

        if (!$peakHours) {
            return 1;
        }

        return max($peakHours) ?: 1;
    }
}