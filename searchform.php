<?php
/**
 * Custom search form.
 *
 * @package AYED_Ghana
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$ayed_id = 'search-' . wp_unique_id();
?>
<form role="search" method="get" class="search-form" action="<?php echo esc_url( home_url( '/' ) ); ?>">
	<label for="<?php echo esc_attr( $ayed_id ); ?>" class="screen-reader-text"><?php esc_html_e( 'Search for:', 'ayed-ghana' ); ?></label>
	<input type="search" id="<?php echo esc_attr( $ayed_id ); ?>" class="search-form__field" placeholder="<?php esc_attr_e( 'Search…', 'ayed-ghana' ); ?>" value="<?php echo get_search_query(); ?>" name="s" />
	<button type="submit" class="search-form__submit" aria-label="<?php esc_attr_e( 'Search', 'ayed-ghana' ); ?>">
		<?php ayed_icon( 'arrow-right', array( 'size' => 18 ) ); ?>
	</button>
</form>
