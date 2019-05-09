<?php
/**
 * Page header template part for the site details rendering.
 *
 * @author    Themedelight
 * @package   Themedelight/AdventureTours
 * @version   2.1.2
 */

$need_invert = false;

$url_base = get_site_url();

ob_start();
get_template_part( 'templates/header/social-icons' );
$social_icons_html = ob_get_clean();

/* Insert Crystal Bay logo and Wet Dream Samui logo. */
$contacts_html = '<div class="header__info__item" style="font-size: 10px">';

$contacts_html .= '<a href="https://crystalbaysamui.com" target="_blank"><img src="' . $url_base . '/wp-content/uploads/2019/05/logo-cbg-106x35.png" alt="Logo: Crystal Bay Group" title="Crystal Bay Group"></a>';
$contacts_html .= '<a href="http://wetdreamsamui.com" target="_blank"><img src="' . $url_base . '/wp-content/uploads/2019/05/logo-wds-trim-35h.png" alt="Logo: Wet Dream Tours" title="Wet Dream Tours"></a>';

$contacts_html .= '</div>';

if ( $need_invert ) {
	$left_html = $social_icons_html;
	$right_html = $contacts_html;
} else {
	$left_html = $contacts_html;
	$right_html = $social_icons_html;
}

?>
<div class="header__info">
	<div class="header__info__items-left"><?php echo $left_html; ?></div>

	<div class="header__info__items-right">
		<?php echo $right_html; ?>
		<?php echo do_shortcode('[google-translator]'); //Insert Google Translate flags.?>
		<?php get_template_part( 'templates/header/shop-cart' ); ?>
		<?php get_template_part( 'templates/header/search' ); ?>
	</div>
</div>
