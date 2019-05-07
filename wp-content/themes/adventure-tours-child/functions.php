<?php

/**
 * Includes 'style.css'.
 * Disable this filter if you don't use child style.css file.
 *
 * @param  assoc $default_set set of styles that will be loaded to the page
 * @return assoc
 */
function filter_adventure_tours_get_theme_styles( $default_set ) {
	$default_set['child-style'] = get_stylesheet_uri();
	return $default_set;
}
add_filter( 'get-theme-styles', 'filter_adventure_tours_get_theme_styles' );

// This locks down my entire site to non-registered users.
if (preg_match('/build/', ABSPATH)) {// Lock down the site only on the remote site (which has a path containing the string 'build')
	add_action( 'template_redirect', 'redirect_func' );
}
function redirect_func() {
 if( ! is_user_logged_in() && !( $GLOBALS['pagenow'] === 'wp-login.php') ) { if ( ! is_public_page_post() ) { auth_redirect(); } }
}
// This opens up a page/post of my choice to the public.  Mark page with a custom field of "show" and a value of 1.
function is_public_page_post() {
    if ( ! ( is_single() || is_page () ) ) : return false; endif;// If you want to open up the blog page, comment out this line.
    $id = get_the_ID();
    $hide = get_post_meta ($id, 'show', true);
    if ( $hide == 1 ): return true; endif;
    return false;
}
// add_action( 'template_redirect', 'redirect_func' );

// This function displays the name of the template used at the bottom of the page.
function show_template() {
    if( is_super_admin() ){
        global $template;
        print_r($template);
    }
}
add_action('wp_footer', 'show_template');


add_filter( 'avatar_defaults', 'new_default_avatar' );
function new_default_avatar ( $avatar_defaults ) {
		//Set the URL where the image file for your avatar is located

        $new_avatar_url = "https://mrsamui.test/wp-content/uploads/2019/05/logo-ms-250.png";
        // $new_avatar_url = get_stylesheet_directory_uri() . "/images/logo-ms-250.png";
        // $new_avatar_url = "https://kabultec.org/wp-content/uploads/2019/05/logo-ms-250.png";


         

        
		//Set the text that will appear to the right of your avatar in Settings>>Discussion
		$avatar_defaults[$new_avatar_url] = 'Your New Default Avatar';
		return $avatar_defaults;
}