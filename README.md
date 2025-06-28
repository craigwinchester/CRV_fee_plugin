# CRV Fee Plugin for WooCommerce

**Adds California Redemption Value (CRV) fees to wine bottles sold in WooCommerce.**

This simple WordPress/WooCommerce plugin automatically applies a \$0.10 CRV fee to each wine bottle (24 oz or larger) shipped to customers in the state of California.

---

## Overview

The **California Redemption Value (CRV)** is a mandatory fee added to beverage containers in California to encourage recycling. This plugin ensures that WooCommerce stores remain compliant by applying a CRV fee per bottle based on shipping address.

* 💵 Applies \$0.10 per bottle (24 oz or larger)
* 🛒 Only applies to orders shipped to **California (CA)**
* 🍷 Designed specifically for wine bottles
* ⚙️ Lightweight and easy to install

---

## How I Use It

I use this plugin on my website: [shop.lofi-wines.com](https://shop.lofi-wines.com). Since I only sell wine, and all bottles are over 24 oz, the logic is kept deliberately simple.

---

## Planned Features

* Support for different CRV rates based on container size (e.g., 5¢ for smaller containers)
* Apply fees based on **Product Category** or **Tags** for more flexibility  <---Now implemented!
* Backend UI for customizing rate and eligibility logic

---

## Background (from Wikipedia)

> "California Redemption Value (CRV), often referred to as the 'bottle deposit', is a fee added to the purchase price of certain beverage containers like aluminum, glass, plastic, and bi-metal. This fee is 5 cents for containers under 24 ounces and 10 cents for containers 24 ounces or larger. Consumers can get a refund of this fee by returning their empty, eligible containers to a certified recycling center or participating retailer."

---

## Installation

1. Download or clone this repository.
2. Upload the plugin folder to your WordPress `/wp-content/plugins/` directory.
3. Activate the plugin in the WordPress **Plugins** menu.
4. No configuration needed if you're selling only wine over 24 oz and ship to California.

---

## Usage Notes

This plugin is best suited for stores with a narrow product focus, like wineries or beverage companies. It currently assumes:

* All eligible containers are 24 oz or larger.
* The CRV applies at \$0.10 per unit.
* CRV only applies when the shipping address is in California.

If your store needs more granular logic, you may want to wait for the upcoming category/tag-based targeting feature.

---

## Contributing

Pull requests are welcome! If you'd like to help expand this plugin (e.g., category-based rules or admin settings panel), feel free to fork and send a PR.

---

## Contact

Made by [Lo-Fi Wines](https://lofi-wines.com)
Have feedback or a feature request? Open an issue or reach out!

---

## 🖼️ Screenshot
![Screenshot](/Screenshot.png)
*Above: Screenshot 
