=== Primer ===
Contributors:      godaddy, fjarrett, jonathanbardo, eherman24
Tags:              custom-background, custom-colors, custom-header, custom-menu, editor-style, featured-images, flexible-header, left-sidebar, one-column, right-sidebar, rtl-language-support, sticky-post, threaded-comments, three-columns, translation-ready, two-columns
Requires at least: 4.4
Tested up to:      5.0
Requires PHP:      5.6.0
Stable tag:        1.8.7
License:           GPL-2.0
License URI:       https://www.gnu.org/licenses/gpl-2.0.html

Primer is a powerful theme that brings clarity to your content in a fresh design. This is the parent for all themes in the GoDaddy Primer theme family.

== Description ==

**Features**

* Responsive Layout
* Color Scheme Presets
* Customize Colors
* Customize Fonts
* One, Two, and Three Column Layouts
* Fixed & Fluid Widths
* Header Image Widget Area
* Social Links Menu
* WooCommerce-Ready
* Available in 29 Languages
* RTL Language Support

**Contributing**

You can fork and contribute back to Primer by visiting [our public repo on GitHub](https://github.com/godaddy/wp-primer-theme).

== Installation ==

1. In your admin panel, navigate to **Appearance > Themes** and click the **Add New** button.
2. Type **Primer** in the search form and press the **Enter** key on your keyboard.
3. Click the **Activate** button to begin using Primer on your website.
4. In your admin panel, navigate to **Appearance > Customize**.
5. Put the finishing touches on your website by adding a logo, header image, and custom colors.

== Copyright ==

Primer WordPress theme, Copyright 2017 GoDaddy Operating Company, LLC.
Primer is distributed under the terms of the GNU GPL.

This program is free software: you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation, either version 2 of the License, or
(at your option) any later version.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
GNU General Public License for more details.

Primer bundles the following third-party resources:

Genericons icon font, Copyright 2013 Automattic, Inc.
License: GPL-2.0 (or later)
Source: https://genericons.com/

Stock photography, Unsplash
License: Creative Commons Zero
Source: https://unsplash.com/photos/v4ZUGlrdVAA

== Changelog ==

= 1.8.7 =
* New: Introduce compatibility for Google Accelerated Mobile Pages. @props [westonruter](https://github.com/westonruter)
* Tweak: Introduce editor styles for Coblocks Form block. @props [richtabor](https://github.com/richtabor)
* Tweak: Introduce ability to add fullwidth alignment to blocks. @props [richtabor](https://github.com/richtabor)

= 1.8.6 =
* Tweak: Adjust shorthand array syntax to ensure backwards compatibility with PHP < 5.6. @props [evanherman](https://github.com/EvanHerman)

= 1.8.5 =
* New: Introduce styles for Gutenberg compatibility. @props [evanherman](https://github.com/EvanHerman)
* Tweak: Update navigation script to fix left side menu item click bug. @props [evanherman](https://github.com/EvanHerman)

= 1.8.4 =
* New: Introduce accessibility controls & styles for tab navigation through the main nav. @props [evanherman](https://github.com/EvanHerman)
* Tweak: Add default value of `1` to theme_mod `use_featured_hero_image`. @props [evanherman](https://github.com/EvanHerman)

= 1.8.3 =
* New: Introduce a privacy policy link in the footer, when set. @props [evanherman](https://github.com/EvanHerman)
* New: Introduce `primer_privacy_policy_link` filter to enable/disable the privacy policy link in footer. @props [evanherman](https://github.com/EvanHerman)
* New: Add styles for privacy policy link and cookie comment checkbox & label. @props [evanherman](https://github.com/EvanHerman)
* New: Add font previews to the customizer when selecting a font. @props [evanherman](https://github.com/EvanHerman)
* Tweak: Update `primer_wc_shop_columns()` to reference the shop page ID. @props [evanherman](https://github.com/EvanHerman)

= 1.8.2 =
* Fix: Comment counts showing an extra character. @props [evanherman](https://github.com/EvanHerman)
* Fix: Bump WooCommerce pagination template to 3.3.1. @props [evanherman](https://github.com/EvanHerman)
* Fix: WooCommerce pagination padding. @props [evanherman](https://github.com/EvanHerman)

= 1.8.1 =
* Fix: Prevent customizer title & tagline colors from updating when they are hidden. @props [evanherman](https://github.com/EvanHerman)
* Fix: Update translation files so translations load correctly. @props [evanherman](https://github.com/EvanHerman)
* Fix: Remove HTML markup in search results/author archive page titles. @props [evanherman](https://github.com/EvanHerman)

= 1.8.0 =
* New: Conditionally wrap site titles to improve SEO. @props [evanherman](https://github.com/EvanHerman), [fjarrett](https://github.com/fjarrett)
* New: Added `sr_RS` (Serbian) translation. @props [lukapaunovic](https://github.com/lukapaunovic)
* Fix: Remove reference to a missing `search.svg` icon. @props [evanherman](https://github.com/EvanHerman)
* Fix: Adjust site title width to prevent overlapping with the mobile menu button. @props [evanherman](https://github.com/EvanHerman)
* Fix: Conditionally load video header for WordPress 4.7 or later. @props [evanherman](https://github.com/EvanHerman), [fjarrett](https://github.com/fjarrett)
* Fix: Added a missing `@version` docblock to the WooCommerce pagination template to prevent out of date template notices. @props [evanherman](https://github.com/EvanHerman)
* Fix: Backward compatibility issue when using [Beaver Builder](https://wordpress.org/plugins/beaver-builder-lite-version/) on PHP 5.3. @props [evanherman](https://github.com/EvanHerman), [fjarrett](https://github.com/fjarrett)
* Fix: Fixed the tertiary sidebar visibility. @props [evanherman](https://github.com/EvanHerman), [fjarrett](https://github.com/fjarrett)

= 1.7.0 =
* New: Enabled video headers and introduced styles to accommodate full width video headers. @props [evanherman](https://github.com/EvanHerman)
* New: Introduced new `primer_pre_hero` action. @props [evanherman](https://github.com/EvanHerman)
* New: Added aria labels on the 'Continue Reading' links for `a11y` improvements. @props [evanherman](https://github.com/EvanHerman)
* New: Introduced `primer_wc_product_header_image` filter. @props [evanherman](https://github.com/EvanHerman)
* Tweak: Improved WooCommerce styles. @props [evanherman](https://github.com/EvanHerman)
* Tweak: Tweak i18n functions, added translator comments. @props [evanherman](https://github.com/EvanHerman)
* Tweak: Introduced Ninja Form response message styles. @props [evanherman](https://github.com/EvanHerman)
* Fix: Ensure color schemes work with custom Primer child themes. @props [evanherman](https://github.com/EvanHerman)
* Fix: Tweaked the WooCommerce product template title. @props [evanherman](https://github.com/EvanHerman)
* Fix: Prevent WooCommerce single product images from hijacking the header image. @props [evanherman](https://github.com/EvanHerman)

= 1.6.0 =
* New: Hero Text widget designed for your site's front page @props [jonathanbardo](https://github.com/jonathanbardo), [fjarrett](https://github.com/fjarrett)
* Tweak: Improved posts pagination design based on core pagination @props [fjarrett](https://github.com/fjarrett), [evanherman](https://github.com/EvanHerman)
* Tweak: The `primer_paging_nav()` function has been deprecated in favor of `primer_pagination()` @props [fjarrett](https://github.com/fjarrett), [evanherman](https://github.com/EvanHerman)
* Tweak: The WooCommerce template overrides directory has been moved to `templates/woocommerce/` @props [fjarrett](https://github.com/fjarrett)
* Fix: Text overlap on WooCommerce Add to Cart buttons in certain languages @props [fjarrett](https://github.com/fjarrett), [evanherman](https://github.com/EvanHerman)
* Fix: WooCommerce menu item appearing on older child themes without styles to support it @props [fjarrett](https://github.com/fjarrett)

= 1.5.1 =
* Fix: Category and tag list display on posts @props [fjarrett](https://github.com/fjarrett)

= 1.5.0 =
* New: Full compatibility with the WooCommerce plugin @props [evanherman](https://github.com/EvanHerman), [fjarrett](https://github.com/fjarrett)
* New: Add Front Page Title setting to the Static Front Page section of the Customizer @props [evanherman](https://github.com/EvanHerman)
* New: Added Footer Copyright Text setting to the Site Identity section of the Customizer @props [evanherman](https://github.com/EvanHerman)
* New: Added Author Credit toggle to the Site Identity section of the Customizer @props [evanherman](https://github.com/EvanHerman)
* New: [Developer documentation!](https://godaddy.github.io/wp-primer-theme/) @props [evanherman](https://github.com/EvanHerman)
* Tweak: Added `nofollow` attribute to theme author link in the footer @props [evanherman](https://github.com/EvanHerman)
* Tweak: Use core post navigation function @props [evanherman](https://github.com/EvanHerman)
* Fix: Display glitch when last main menu item is a submenu @props [evanherman](https://github.com/EvanHerman)

= 1.4.2 =
* Added word-wrap where text was overflowing @props [evanherman](https://github.com/EvanHerman)
* Updated translations @props [jonathanbardo](https://github.com/jonathanbardo)
* Added font-family support for WooCommerce buttons @props [fjarret](https://github.com/fjarrett)

= 1.4.1 =
* Fixed hero widget font sizes @props [jonathanbardo](https://github.com/jonathanbardo)

= 1.4.0 =
* Fixed comment meta template @props [wpexplorer](https://github.com/wpexplorer)
* Expose color schemes array @props [evanherman](https://github.com/EvanHerman), [jonathanbardo](https://github.com/jonathanbardo)

= 1.3.0 =
* Initial release.
