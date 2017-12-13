## Changelog

### 1.8.1 ###
* Fix: Prevent customizer title & tagline colors from updating when they are hidden. @props [evanherman](https://github.com/EvanHerman)
* Fix: Update translation files so translations load correctly. @props [evanherman](https://github.com/EvanHerman)
* Fix: Remove HTML markup in search results/author archive page titles. @props [evanherman](https://github.com/EvanHerman)

### 1.8.0 ###
* New: Conditionally wrap site titles to improve SEO. @props [evanherman](https://github.com/EvanHerman), [fjarrett](https://github.com/fjarrett)
* New: Added `sr_RS` (Serbian) translation. @props [lukapaunovic](https://github.com/lukapaunovic)
* Fix: Remove reference to a missing `search.svg` icon. @props [evanherman](https://github.com/EvanHerman)
* Fix: Adjust site title width to prevent overlapping with the mobile menu button. @props [evanherman](https://github.com/EvanHerman)
* Fix: Conditionally load video header for WordPress 4.7 or later. @props [evanherman](https://github.com/EvanHerman), [fjarrett](https://github.com/fjarrett)
* Fix: Added a missing `@version` docblock to the WooCommerce pagination template to prevent out of date template notices. @props [evanherman](https://github.com/EvanHerman)
* Fix: Backward compatibility issue when using [Beaver Builder](https://wordpress.org/plugins/beaver-builder-lite-version/) on PHP 5.3. @props [evanherman](https://github.com/EvanHerman), [fjarrett](https://github.com/fjarrett)
* Fix: Fixed the tertiary sidebar visibility. @props [evanherman](https://github.com/EvanHerman), [fjarrett](https://github.com/fjarrett)

### 1.7.0 ###
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

### 1.6.0 ###
* New: Hero Text widget designed for your site's front page @props [jonathanbardo](https://github.com/jonathanbardo), [fjarrett](https://github.com/fjarrett)
* Tweak: Improved posts pagination design based on core pagination @props [fjarrett](https://github.com/fjarrett), [evanherman](https://github.com/EvanHerman)
* Tweak: The `primer_paging_nav()` function has been deprecated in favor of `primer_pagination()` @props [fjarrett](https://github.com/fjarrett), [evanherman](https://github.com/EvanHerman)
* Tweak: The WooCommerce template overrides directory has been moved to `templates/woocommerce/` @props [fjarrett](https://github.com/fjarrett)
* Fix: Text overlap on WooCommerce Add to Cart buttons in certain languages @props [fjarrett](https://github.com/fjarrett), [evanherman](https://github.com/EvanHerman)
* Fix: WooCommerce menu item appearing on older child themes without styles to support it @props [fjarrett](https://github.com/fjarrett)

### 1.5.1 ###
* Fix: Category and tag list display on posts @props [fjarrett](https://github.com/fjarrett)

### 1.5.0 ###
* New: Full compatibility with the WooCommerce plugin @props [evanherman](https://github.com/EvanHerman), [fjarrett](https://github.com/fjarrett)
* New: Add Front Page Title setting to the Static Front Page section of the Customizer @props [evanherman](https://github.com/EvanHerman)
* New: Added Footer Copyright Text setting to the Site Identity section of the Customizer @props [evanherman](https://github.com/EvanHerman)
* New: Added Author Credit toggle to the Site Identity section of the Customizer @props [evanherman](https://github.com/EvanHerman)
* New: [Developer documentation!](https://godaddy.github.io/wp-primer-theme/) @props [evanherman](https://github.com/EvanHerman)
* Tweak: Added `nofollow` attribute to theme author link in the footer @props [evanherman](https://github.com/EvanHerman)
* Tweak: Use core post navigation function @props [evanherman](https://github.com/EvanHerman)
* Fix: Display glitch when last main menu item is a submenu @props [evanherman](https://github.com/EvanHerman)

### 1.4.2 ###
* Added word-wrap where text was overflowing @props [evanherman](https://github.com/EvanHerman)
* Updated translations @props [jonathanbardo](https://github.com/jonathanbardo)
* Added font-family support for WooCommerce buttons @props [fjarret](https://github.com/fjarrett)

### 1.4.1 ###
* Fixed hero widget font sizes @props [jonathanbardo](https://github.com/jonathanbardo)

### 1.4.0 ###
* Fixed comment meta template @props [wpexplorer](https://github.com/wpexplorer)
* Expose color schemes array @props [evanherman](https://github.com/EvanHerman), [jonathanbardo](https://github.com/jonathanbardo)

### 1.3.0 ###
* Initial release.
