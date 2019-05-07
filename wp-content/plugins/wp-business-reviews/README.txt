# WP Business Reviews

Contributors: kevinwhoffman, dlocc, impressorg
Tags: reviews
Requires at least: 4.8
Tested up to: 4.9
Stable tag: 1.2.1
Requires PHP: 5.6
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

A WordPress review plugin for showcasing your best reviews in style.

## Description

WP Business Reviews is a WordPress plugin for showcasing your best reviews in
style. Display reviews from one platform or a collection of reviews from
multiple platforms.

## Installation

To install the plugin, download the zip file from
[your account](https://wpbusinessreviews.com/account/) on the WP Business
Reviews website. Next, log into your WordPress website and navigate to "Plugins
> Add New > Upload Plugin". Finally, select the zip file to upload and then
click activate.

### Minimum Requirements

* WordPress 4.8 or greater
* PHP version 5.6 or greater
* MySQL version 5.0 or greater

## Changelog

## [1.2.1] - 2019-02-12

### Changed

- Following a recent change to the Facebook Open Graph API, update the URL
  format of Facebook reviewer images to prevent empty blank spaces in reviews.
  Facebook reviewer images will now be refreshed over time through a regularly
  scheduled background process.

### Fixed

- Prevent Facebook reviewer images from expiring by automatically refreshing
  URLs on a regular basis via scheduled events.
- Fix scrolling irregularity in carousel navigation that was caused by passing
  string values instead of integers when calculating number of slides.
- Ensure all review strings are translatable, including "via," "Read more," and
  "recommends" (as seen in Facebook recommendations).
- Use the date format from WordPress settings when rendering the review date.
- Ensure a placeholder reviewer image is displayed if the provided image URL
  does not return a valid image for any reason.
- Clarify OAuth errors returned by Facebook so that user is directed to
  reconnect to Facebook as a potential resolution.
- When editing media, ensure the "Edit more details" link is not redirected to
  the collection builder screen, resulting in a fatal error.
- Remove overreaching CSS ruleset from Hint.css tooltips that was causing
  pseudo-elements in some plugins such as Shortcodes Ultimate to be hidden.
- Improve consistency of font sizes in reviews across all themes.

### Removed

- Remove the date-fns JavaScript dependency since the review date is now
  determined in PHP using the WordPress date format.
