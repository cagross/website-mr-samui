<?php
$platform = str_replace( '_', '-', $this->platform );
$class    = 'wpbr-builder__inspector wpbr-builder__inspector--' . $platform;
?>

<div id="wpbr-builder-inspector" class="<?php echo esc_attr( $class ); ?>">
	<?php
	wp_nonce_field( 'wpbr_collection_save', 'wpbr_collection_nonce', false );
	wp_nonce_field( 'wpbr_review_source_save', 'wpbr_review_source_nonce', false );
	wp_nonce_field( 'wpbr_review_save', 'wpbr_review_nonce', false );
	wp_referer_field();
	?>
	<input id="wpbr-control-action" type="hidden" name="action" value="wpbr_collection_save">
	<input id="wpbr-control-review-source" type="hidden" name="wpbr_review_source">
	<input id="wpbr-control-review" type="hidden" name="wpbr_review">
	<input
		id="wpbr-control-post-id"
		type="hidden"
		name="wpbr_collection[post_id]"
		value="<?php echo esc_attr( $this->post_id ); ?>"
		>
	<input
		id="wpbr-control-platform"
		type="hidden"
		name="wpbr_collection[platform]"
		value="<?php echo esc_attr( $this->platform ); ?>"
		>
	<?php foreach ( $this->config as $section_id => $section ) : ?>
		<div
			id="wpbr-section-<?php echo esc_attr( $section_id ); ?>"
			class="wpbr-builder__section js-wpbr-section"
			data-wpbr-section-id="<?php echo esc_attr( $section_id ); ?>"
		>
			<div class="wpbr-builder__section-header wpbr-builder__section-header--closed js-wpbr-section-header">
				<button class="wpbr-builder__section-toggle js-wpbr-section-toggle" aria-expanded="true">
					<span class="screen-reader-text">Toggle section: <?php esc_html_e( $section['name'] ); ?></span>
					<span class="dashicons dashicons-arrow-right js-wpbr-section-toggle-icon" aria-hidden="true"></span>
				</button>
				<h3 class="wpbr-builder__section-title">
					<i class="<?php echo esc_attr( $section['icon'] ); ?>"></i>
					<?php esc_html_e( $section['name'] ); ?>
				</h3>
			</div>
			<div class="wpbr-builder__section-body wpbr-u-hidden js-wpbr-section-body">
				<?php
				foreach ( $section['fields'] as $field_id => $field_args ) {
					// Render the field object that matches the field ID present in the config.
					$field_object = $this->field_repository->get( $field_id )->render();
				}
				?>
			</div>
		</div>
	<?php endforeach; ?>
</div>
