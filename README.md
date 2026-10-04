# Kumar Commerce Intelligence

### Magento 2 Business Intelligence Dashboard

A modern Magento 2 admin dashboard designed to provide a centralized view of eCommerce business performance through KPI cards, revenue analytics, payment distribution, product insights, customer activity and operational indicators.

Kumar Commerce Intelligence brings multiple business analytics sections together within the Magento Admin Panel, offering a structured and visually engaging dashboard experience.

---

## Dashboard Preview

<img width="1190" height="1322" alt="Commerce Intelligence Dashboard" src="https://github.com/user-attachments/assets/1a2f1d78-6917-49d6-bf68-29364c14acc5" />


*Commerce Intelligence — Magento Admin Dashboard*

---

## Overview

Managing an eCommerce store involves understanding multiple business indicators, including revenue, orders, customer activity, payment preferences and product performance.

Kumar Commerce Intelligence provides a dedicated dashboard interface to organize these business indicators into accessible analytics sections.

The module focuses on:

* Centralized business analytics.
* Modern admin dashboard UI.
* Clear KPI presentation.
* Interactive data visualization.
* Dedicated analytics navigation.
* Configurable dashboard features.
* Independent Magento module architecture.

---

## Features

### 1. Commerce Intelligence Dashboard

A dedicated dashboard available directly inside the Magento Admin Panel.

The dashboard provides a centralized interface for viewing important business indicators and analytics sections.

### 2. KPI Cards

A card-based interface for displaying key business performance indicators.

Dashboard KPI categories include:

* Revenue
* Orders
* Average Order Value (AOV)

The cards provide a quick overview of store performance within the selected reporting period.

### 3. Revenue Analytics

A responsive SVG-based daily revenue line chart.

Features include:

* Daily revenue visualization.
* Interactive date and revenue tooltips.
* Adaptive date labels.
* Responsive chart layout.
* Reporting-period selection.
* Current-period versus previous-period comparison.

### 4. Payment Distribution

A dedicated analytics section for visualizing order distribution across different payment methods.

This provides a structured overview of payment preferences within the store.

### 5. Hero Products

A dedicated section for highlighting top-performing products and presenting product-related business information.

### 6. Peak Hours

An analytics section for presenting order activity across different hours of the day.

The visualization helps administrators understand order activity patterns.

### 7. Inventory Risk

A dedicated inventory analytics section within the dashboard interface.

Inventory risk calculations depend on reliable Magento inventory information and the applicable inventory source configuration.

### 8. Business Insights

A dedicated section for presenting business insights in a structured dashboard format.

### 9. Dedicated Analytics Navigation

Individual admin menu entries provide access to dedicated Commerce Intelligence sections.

This keeps the analytics interface organized and accessible within Magento Admin.

### 10. Configuration & Feature Toggles

The module provides configuration options within Magento Admin.

Available configuration categories include:

* Enable/Disable Commerce Intelligence.
* Individual analytics feature toggles.
* Dashboard feature visibility controls.

Configuration location:

`Stores > Configuration > Kumar > Commerce Intelligence`

---

## Analytics Capabilities

### Revenue Trend Chart

The revenue visualization uses SVG-based rendering.

Supported functionality:

* Daily revenue line chart.
* Interactive date and revenue tooltips.
* Adaptive date labels.
* Responsive chart rendering.
* Selected reporting-period visualization.

### Period Comparison

The dashboard supports comparison between the selected reporting period and the immediately preceding period.

| Business Metric     | Comparison                 |
| ------------------- | -------------------------- |
| Revenue             | Current vs Previous Period |
| Order Count         | Current vs Previous Period |
| Average Order Value | Current vs Previous Period |

### Customer Checkout Mix

The dashboard provides customer order segmentation through:

* Registered-customer orders.
* Guest orders.
* Repeat purchasers within the selected reporting period.

Repeat purchasers are defined as registered customers with more than one order within the selected period.

This is a period-based metric, not a lifetime returning-customer measurement.

### Order Status Distribution

Order status analytics include different order statuses, including cancelled orders.

This provides visibility into the overall order status distribution.

Cancelled orders are excluded from headline sales KPIs.

### Reporting Period Selection

The dashboard includes reporting-period filters, including a 365-day period.

The selected state is correctly reflected in the period filter interface.

---

## Revenue & Analytics Calculation Rules

Commerce Intelligence uses explicit calculation rules to maintain transparency in business reporting.

### Revenue

Revenue currently uses Magento order grand totals for non-cancelled orders.

### Average Order Value (AOV)

AOV uses the same non-cancelled order totals and eligible order count for the selected reporting period.

### Order Count

Cancelled orders are excluded from headline sales KPIs.

### Refunds

Refunds are displayed separately and are not subtracted from the displayed revenue.

### Repeat Purchasers

Repeat purchasers represent registered customers with more than one order within the selected reporting period.

### Order Status

Order status distribution is presented separately and includes cancelled orders.

---

## Data Scope & Limitations

The current V1 implementation provides the dashboard UI, module architecture and analytics presentation.

Some sections contain demonstration values rather than fully aggregated live Magento analytics.

The following distinctions are important:

**Revenue and AOV**

Use order grand totals for non-cancelled orders. Refunds are displayed separately and are not deducted from revenue.

**Profit and Margin**

Reliable profit and margin calculations require product cost information and appropriate tax and shipping treatment. These values are not inferred from order grand totals.

**Inventory Risk**

Accurate inventory risk calculations require integration with the store's inventory source, including MSI configuration where applicable.

**Marketing and Conversion Metrics**

Traffic, sessions, funnel and conversion metrics require actual web analytics or collected session events. These values are not invented or inferred from order data.

---

## Magento Architecture

Kumar Commerce Intelligence is implemented as an independent Magento 2 module.

The module provides its own admin integration, navigation, configuration and dashboard resources.

Key architectural characteristics:

* Independent Magento module registration.
* Dedicated admin menu integration.
* Admin routing and access-control architecture.
* Module-level configuration.
* Dedicated dashboard sections.
* Admin-side CSS and JavaScript assets.
* SVG-based revenue visualization.
* No Magento core `.phtml` template modifications.

The implementation is designed to integrate through Magento's module architecture without directly modifying Magento core templates.

---

## Installation

### Requirements

* Magento 2 installation.
* Compatible PHP version for the Magento installation.
* Magento Admin access.
* Access to the Magento application root directory.

### Step 1: Create the Module Directory

From your Magento root directory:

```bash
mkdir -p app/code/Kumar/CommerceIntelligence
```

### Step 2: Copy Module Files

```bash
cp -R Kumar_CommerceIntelligence/* \
app/code/Kumar/CommerceIntelligence/
```

### Step 3: Enable the Module

```bash
php bin/magento module:enable Kumar_CommerceIntelligence
```

### Step 4: Run Setup Upgrade

```bash
php bin/magento setup:upgrade
```

### Step 5: Flush Cache

```bash
php bin/magento cache:flush
```

### Step 6: Verify Module Status

```bash
php bin/magento module:status Kumar_CommerceIntelligence
```

---

## Configuration

After installation, navigate to:

`Stores > Configuration > Kumar > Commerce Intelligence`

The configuration section provides module availability and supported dashboard feature toggles.

---

## Project Structure

The module follows Magento's standard module organization.

```text
Kumar_CommerceIntelligence/
├── Block/
├── Controller/
├── Helper/
├── Model/
├── etc/
│   ├── adminhtml/
│   ├── acl.xml
│   └── module.xml
├── view/
│   └── adminhtml/
│       ├── layout/
│       ├── templates/
│       └── web/
├── registration.php
└── composer.json
```

*The structure above is illustrative; actual directories depend on the files included in the published module.*

---

## Privacy & Data Handling

Commerce Intelligence is designed for use within the Magento Admin Panel.

When working with store analytics, administrators should ensure that:

* Customer information is appropriately protected.
* Admin permissions are configured correctly.
* Sensitive information is not exposed in dashboard screenshots.
* Store data is handled according to applicable privacy requirements.
* No external data transmission occurs without explicit implementation and authorization.

---

## Compatibility

Developed for Magento 2 using its standard module architecture.

Exact Magento and PHP compatibility should be verified against the target installation.

---

## Contributing

Contributions, suggestions and improvements are welcome.

To contribute:

1. Fork the repository.
2. Create a separate feature branch.
3. Implement your changes.
4. Test against a compatible Magento installation.
5. Submit a pull request with a clear description.

---

## Reporting Issues

If you encounter an issue, please open a GitHub issue with:

* Magento version.
* PHP version.
* Steps to reproduce.
* Expected behaviour.
* Actual behaviour.
* Relevant error messages.

Please remove credentials, customer information and other sensitive data before sharing logs.

---

## License

See the [LICENSE](LICENSE) file for licensing information.

---

## Author

**Kunal Kumar**

Magento 2 Developer | eCommerce Technology | Frontend Engineering

GitHub: [@mekkumar](https://github.com/mekkumar)

---

**Kumar Commerce Intelligence**

*Making Magento business analytics more accessible through a centralized admin experience.*
