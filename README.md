# Kumar Commerce Intelligence

Magento 2 business intelligence dashboard module.

## V1 UI
- Commerce Intelligence admin menu
- Dashboard
- KPI cards
- Revenue trend UI
- Payment distribution UI
- Hero products UI
- Peak hours UI
- Inventory risk UI
- Business insights UI
- Dedicated section menu entries
- Configuration with enable/disable and feature toggles
- No Magento core `.phtml` modification

## Install
```bash
mkdir -p app/code/Kumar/CommerceIntelligence
cp -R Kumar_CommerceIntelligence/* app/code/Kumar/CommerceIntelligence/
php bin/magento module:enable Kumar_CommerceIntelligence
php bin/magento setup:upgrade
php bin/magento cache:flush
```

Configuration: `Stores > Configuration > Kumar > Commerce Intelligence`.

The V1 intentionally provides the UI/module architecture first. The next phase should replace dashboard demo values with aggregated Magento data and cron-backed analytics tables. Frontend traffic/funnel metrics should be collected only through an explicit event collector rather than invented from order data.

## Analytics enhancements
- SVG-based responsive daily revenue line chart with date/revenue tooltips and adaptive date labels.
- Current-period vs immediately previous-period comparison for revenue, order count and AOV.
- Customer checkout mix: registered-customer orders, guest orders and repeat purchasers within the selected period.
- Order status distribution, including cancelled orders (the headline sales KPIs continue to exclude cancelled orders).
- Correct selected state for the 365-day period filter.

## Data scope and limitations
- Revenue and AOV currently use order grand totals for non-cancelled orders, matching the existing dashboard calculation. Refunds are displayed separately and are not subtracted from revenue.
- Repeat purchasers means registered customers with more than one order inside the selected period; it is not a lifetime returning-customer metric.
- Profit/margin requires reliable product cost and tax/shipping treatment. Inventory risk requires the store's inventory source (including MSI configuration). Marketing conversion metrics require web analytics/session events. These are not inferred from order data and are intentionally not presented as measured values yet.
