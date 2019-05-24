# WP Business Reviews

Contributors: kevinwhoffman, dlocc, impressorg
Tags: reviews
Requires at least: 4.8
Tested up to: 5.2
Stable tag: 1.3.0
Requires PHP: 5.4
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
* PHP version 5.4 or greater
* MySQL version 5.0 or greater

## Changelog

## 1.3.0 - 2019-05-21

### Added

- Add Zomato as a review platform specializing in restaurant reviews.
- Add ability to manually refresh reviews within the collection builder.
- Automatically refresh reviews. If the advanced setting for "Automatic Refresh"
is enabled, then the plugin will attempt to add new reviews to existing
collections on a weekly or daily basis per the selected setting. New reviews
respect the collection's settings for order and filters.
- Clarify how many reviews to expect in the "Review Source" section of the
collection builder.
- Improve feedback when an error is detected with a platform API by marking the
platform with a "Needs Attention" status in the plugin settings.
- Add new insights to System Info regarding automatic refresh.

### Changed

- Preview changes to order and filters immediately without requiring a save.
- Refresh Facebook images weekly instead of daily through a background process.
- Include existing reviews in new collections. Previously only the latest remote
reviews appeared in a new collection. Now a combination of new and existing
reviews will appear together to more accurately reflect how the collection will
appear after save.
- Update Facebook logos per new brand guidelines.

### Fixed

- Prevent Facebook image updates from running continuously. Previously the
background process would get stuck in a loop in cases where the page token was
invalidated. Now the background process will end at the first sign of an invalid
or missing page token.
- Preserve platform after quick edit. Previously using quick edit with a single
review would result in the review's platform being reset to Custom. Now the
platform from the quick edit UI is maintained.
- Allow license keys to be deactivated even if the current site is not an active
URL associated with the license. This makes it easier for users to correct any
licensing issues.
