<?php
$heading     = __( 'WP Business Reviews Help', 'wp-business-reviews' );
$description = sprintf(
	/* translators: link to documentation */
	// __( 'Welcome to WP Business Reviews. These introductory videos will help you get up and running in minutes. For more information, visit our %1$sPlugin Documentation%2$s.', 'wp-business-reviews' ),
	__( 'Welcome to WP Business Reviews. These introductory videos will help you get up and running in minutes while we prepare our web documentation for launch.', 'wp-business-reviews' ),
	'<a href="' . admin_url( 'https://wpbusinessreviews.com/' ) . '">',
	'</a>'
);
$videos      = array(
	'video-overview' => array(
		'title' => __( 'Plugin Overview', 'wp-business-reviews' ),
		'id'    => '279699083',
	),
	// 'video-licensing' => array(
	// 	'title' => __( 'Activating Your License', 'wp-business-reviews' ),
	// 	'id'    => '76979871',
	// ),
	// 'video-platform-management' => array(
	// 	'title' => __( 'Platform Management', 'wp-business-reviews' ),
	// 	'id'    => '188715256',
	// ),
	'video-google-places' => array(
		'title' => __( 'Connecting to Google', 'wp-business-reviews' ),
		'id'    => '279553827',
	),
	// 'video-facebook' => array(
	// 	'title' => __( 'Connecting to Facebook', 'wp-business-reviews' ),
	// 	'id'    => '188715256',
	// ),
	'video-yelp' => array(
		'title' => __( 'Connecting to Yelp', 'wp-business-reviews' ),
		'id'    => '279551721',
	),
	'video-yp' => array(
		'title' => __( 'Connecting to YP', 'wp-business-reviews' ),
		'id'    => '279557752',
	),
	// 'video-collections' => array(
	// 	'title' => __( 'Collections', 'wp-business-reviews' ),
	// 	'id'    => '76979871',
	// ),
	// 'video-single-reviews' => array(
	// 	'title' => __( 'Single Reviews', 'wp-business-reviews' ),
	// 	'id'    => '188715256',
	// ),
);
?>

<div id="wpbr-viewer" class="wpbr-viewer wpbr-card">
	<div class="wpbr-viewer__main">
		<div id="wpbr-player" class="wpbr-viewer__player"></div>
	</div>
	<div class="wpbr-viewer__sidebar">
		<div class="wpbr-viewer__description">
			<div class="wpbr-admin-header">
				<h2 class="wpbr-admin-header__heading"><?php echo esc_html( $heading ); ?></h2>
				<p class="wpbr-admin-header__subheading">
					<?php echo wp_kses_post( $description ); ?>
				</p>
			</div>
		</div>
		<div class="wpbr-viewer__nav">
			<ul class="wpbr-subtabs">
				<?php foreach ( $videos as $video_id => $video_atts ) : ?>
					<li class="wpbr-subtabs__item">
						<a
							id="wpbr-subtab-<?php echo esc_attr( $video_id ); ?>"
							class="wpbr-subtabs__link js-wpbr-subtab js-wpbr-video-subtab"
							href="<?php echo esc_url( $video_atts['id'] ); ?>"
							data-wpbr-subtab-id="<?php echo esc_attr( $video_id ); ?>"
							data-wpbr-video-id="<?php echo esc_attr( $video_atts['id'] ); ?>"
							>
							<i class="fas wpbr-icon wpbr-fw wpbr-play-circle"></i>
							<?php echo esc_html( $video_atts['title'] ); ?>
						</a>
					</li>
				<?php endforeach; ?>
			</ul>
		</div>
	</div>
</div>
