# Changelog
All notable changes to this project will be documented in this file.

The format is based on [Keep a Changelog](https://keepachangelog.com/en/1.0.0/)
and this project adheres to [Semantic Versioning](https://semver.org/spec/v2.0.0.html).

## [1.3.0] - 2019-05-21

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

## [1.2.0] - 2018-11-16

### Added

- Add support for Facebook recommendations. This new review type does
  not include a star rating and instead displays a positive or negative
  recommendation.
- Add new Order settings for ordering reviews by review date, rating,
  post ID, or menu order.
- Allow reviews to be sorted by rating or review date in the Reviews
  list table.
- Add System Info to the admin submenu so that users can provide context
  about their environment when requesting support.
- Add background database updater which allows users to initiate a
  database update and navigate away while it completes.

### Changed

- Display Facebook recommendations in collections by default.
  Recommendations created prior to v1.2.0 will appear as `Unrated` and
  need manually updated in the single review editor.
- Order all collections by review date from newest to oldest by default.
  This setting may be changed in the Order settings of the collection.
- Base the Minimum Rating setting on a post meta key
  `wpbr_rating_normal` instead of terms in the `wpbr_rating` taxonomy.
- Include unrated reviews in collections by default. These reviews may
  be excluded using the Minimum Rating setting.

### Fixed

- Ensure Facebook reviewer image URLs do not expire. The new URLs will
  always point to the current profile picture of the user.
- Ensure all collections retrieve reviews in reverse chronological order
  by default.
- Prevent fatal error caused by certain WordPress date formats such as
  `j. F Y` when saving a single review.
- Prevent hidden taxonomies such as `wpbr_platform` from getting indexed
  by search engines.
- Improve styling of Dark theme to increase contrast of text and links.
- Prevent zero-star ratings from being displayed in collections. Instead
  unrated reviews will omit the rating altogether.

### Removed

- Removed highlighted preview that appears when a filter is changed.
  Instead, a notice appears to indicate the collection must be saved and
  refreshed.

## [1.1.0] - 2018-09-18

### Added

- Improve ability to add single reviews to an existing collection
  through new sidebar controls in the single review editor.

### Changed

- Disable editing of review dates for single reviews delivered from a
  platform API. Locking the review date helps to prevent duplicate
  reviews from being delivered in the future.

### Fixed

- Improve overall theme compatibility by increasing specificity of
  CSS properties like `margin`, `padding`, and `line-height` that are
	most susceptible to theme conflicts.
- Prevent collections from being cropped when using `Auto Fit` within a
  narrow container.
- Prevent collections from being cropped in themes that did not set
  `box-sizing: border-box;` on the front end.
- Prevent PHP error caused by certain date formats such as `d/m/Y` when
  saving single single reviews.
- Add JS polyfills for older browsers which allow collections to render
  in IE 11 and Safari 10.1.
- Add fallback grid styles for browsers that do not support CSS Grid
  such as IE 11.

## [1.0.1] - 2018-08-17

### Fixed

- Include clear steps to resolve Google API errors `Billing Not Enabled`
  and `Restricted Key Detected`.
- Update Font Awesome to v5.2.0 and improve compatibility with other
  plugins also using Font Awesome.
- Resolve edge case where sites with many taxonomy terms did not save
  the correct terms within a tagged collection.
- Fix issue with back/forward browser navigation causing Plugin Settings
  tabs to stack on top of each other.

## [1.0.0] - 2018-08-01

### Added

- Display collections in a new Carousel format.
- Choose how many slides per view are visible in the Carousel and watch
  it adapt to smaller viewports.
- Search business on Google by Place ID (in case text search fails).

### Fixed

- Prevent 'Invalid Date' from appearing in reviews in Safari.

## [0.2.1] - 2018-07-30

### Fixed

- Ensure upgrade routines get applied to automatic updates in addition
  to fresh installs.

## [0.2.0] - 2018-07-30

### Added

- Connect to Facebook and create collections of reviews from Facebook
  pages managed by the user.
- Organize reviews across all platforms with new review tags.
- Create tagged collections of reviews based on one or more tags.
- Add changelog to record notable changes made to this project.

### Changed

- Change default number of `max_reviews` in a collection from 12 to 24.
  Existing collections are not affected.

### Fixed

- Prevent fatal error when viewing collections or single reviews that
  have been Trashed.

## 0.1.0 - 2018-07-12

### Added

- Release public beta plugin featuring Google, Yelp, and YP (Facebook
  coming soon).
- Build collections of existing reviews via Google, Yelp, and YP APIs.
    - Add Presentation settings.
        - Style
        - Format
        - Maximum Columns
        - Maximum Reviews
        - Maximum Characters
        - Line Breaks
        - Review Components
    - Add Filters.
        - Minimum Rating
        - Blank Reviews
- Publish single reviews manually.
- Embed collections via shortcode or widget.
- Embed single reviews via shortcode.

[1.3.0]: https://github.com/impress-org/wp-business-reviews/compare/v1.2.1...v1.3.0
[1.2.1]: https://github.com/impress-org/wp-business-reviews/compare/v1.2.0...v1.2.1
[1.2.0]: https://github.com/impress-org/wp-business-reviews/compare/v1.1.0...v1.2.0
[1.1.0]: https://github.com/impress-org/wp-business-reviews/compare/v1.0.1...v1.1.0
[1.0.1]: https://github.com/impress-org/wp-business-reviews/compare/v1.0.0...v1.0.1
[1.0.0]: https://github.com/impress-org/wp-business-reviews/compare/v0.2.1...v1.0.0
[0.2.1]: https://github.com/impress-org/wp-business-reviews/compare/v0.2.0...v0.2.1
[0.2.0]: https://github.com/impress-org/wp-business-reviews/compare/v0.1.0...v0.2.0
