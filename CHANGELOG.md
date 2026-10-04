# Changelog

All notable changes to Kumar Commerce Intelligence are documented in this file.

## [1.0.0] - 2026-10-04

### Added

* Initial release of Kumar Commerce Intelligence.
* Dedicated Commerce Intelligence admin menu.
* Centralized Magento Admin dashboard.
* KPI cards for business performance indicators.
* Daily revenue trend visualization using SVG.
* Interactive date and revenue tooltips.
* Adaptive revenue chart date labels.
* Payment distribution analytics section.
* Hero products section.
* Peak hours analytics section.
* Inventory risk dashboard section.
* Business insights section.
* Dedicated analytics section navigation.
* Module configuration under Kumar > Commerce Intelligence.
* Module enable/disable configuration.
* Individual dashboard feature toggles.
* Current-period and previous-period comparisons.
* Revenue, order count and AOV comparison.
* Customer checkout mix.
* Registered-customer and guest order segmentation.
* Repeat purchaser calculation within the selected period.
* Order status distribution, including cancelled orders.
* 365-day reporting period selection.
* Responsive dashboard presentation.

### Analytics Definitions

* Revenue and AOV use non-cancelled order grand totals.
* Refunds are displayed separately and are not deducted from revenue.
* Cancelled orders are excluded from headline sales KPIs.
* Repeat purchasers are registered customers with multiple orders within the selected period.

### Architecture

* Independent Magento 2 module integration.
* Dedicated admin menu and configuration.
* No Magento core `.phtml` template modifications.

### Notes

Some dashboard sections currently use demonstration values. Refer to the README for the exact data scope and calculation limitations.
