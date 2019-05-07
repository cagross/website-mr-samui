<?php
/**
 * Page header template part for the site details rendering.
 *
 * @author    Themedelight
 * @package   Themedelight/AdventureTours
 * @version   2.1.2
 */

$need_invert = false;

// $contacts_html = '';
// $contact_phone = adventure_tours_get_option( 'contact_phone' );
// $contact_time = adventure_tours_get_option( 'contact_time' );

// if ( $contact_phone ) {
// 	$contacts_html .= sprintf( '<div class="header__info__item header__info__item--phone%s"><i class="fa fa-phone"></i>%s</div>',
// 		$contact_time ? '' : ' header__info__item--delimiter',
// 		esc_html( $contact_phone ) );
// }

if ( $contact_time ) {
	$contacts_html .= sprintf( '<div class="header__info__item header__info__item--clock%s"><i class="fa fa-clock-o"></i>%s</div>',
		$need_invert ? ' header__info__item--delimiter' : '',
		esc_html( $contact_time ) );
}

$url_base = get_site_url();

ob_start();
get_template_part( 'templates/header/social-icons' );
$social_icons_html = ob_get_clean();

/* Insert Crystal Bay logos. */
$contacts_html = '<div class="header__info__item" style="font-size: 10px">';
// $contacts_html .= '<img src="' . $url_base . '/wp-content/uploads/2019/05/logo-cbg-48h.png" alt="Logo: Tours">';
// $contacts_html .= '<img src="' . $url_base . '/wp-content/uploads/2019/05/logo-cbg-35h.png" alt="Logo: Tours">';

$contacts_html .= '<img src="' . $url_base . '/wp-content/uploads/2019/05/logo-cbg-106x35.png" alt="Logo: Tours">';

// $contacts_html .= '<span style="font-size: 18px;color: #9e9e9e";>  |  </span>';
// $contacts_html .= '<img src="' . $url_base . '/wp-content/uploads/2019/05/logo-wds-trim-48h.png" alt="Logo: Tours">';
$contacts_html .= '<img src="' . $url_base . '/wp-content/uploads/2019/05/logo-wds-trim-35h.png" alt="Logo: Tours">';

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
