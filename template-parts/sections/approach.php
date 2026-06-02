<?php
/**
 * Section: Approach / Programme framework.
 *
 * @package AYED_Ghana
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$tag   = ayed_field( 'approach_tag', 'How We Work' );
$title = ayed_field( 'approach_title', 'Our Four-Point [em]Programme Framework[/em]' );

$items = ayed_field( 'approach_items', array(
	array( 'title' => 'Training', 'text' => 'Structured skills development programmes in entrepreneurship, technology, leadership, and vocational trades, preparing young people for the world of work and self-employment.' ),
	array( 'title' => 'Mentoring', 'text' => 'Guided relationships with experienced professionals across industries who help young people navigate careers, build confidence, and access networks they could not reach alone.' ),
	array( 'title' => 'Networking', 'text' => 'Curated events, forums, and international exchanges that connect young Ghanaians with peers, partners, and opportunities across Africa and the world.' ),
	array( 'title' => 'Strategic Alliances', 'text' => 'Institutional partnerships with universities, government bodies, international organisations, and private sector leaders that amplify our reach and deepen our impact.' ),
) );
?>
<section id="approach" class="section section--approach">
	<div class="container">
		<header class="section-head reveal">
			<?php ayed_eyebrow( $tag ); ?>
			<h2 class="section-title"><?php ayed_the_emphasis( $title ); ?></h2>
		</header>

		<div class="approach-grid">
			<?php foreach ( $items as $i => $item ) : ?>
				<article class="approach-item reveal">
					<span class="approach-item__num"><?php echo esc_html( str_pad( (string) ( $i + 1 ), 2, '0', STR_PAD_LEFT ) ); ?></span>
					<h3 class="approach-item__title"><?php echo esc_html( isset( $item['title'] ) ? $item['title'] : '' ); ?></h3>
					<p class="approach-item__text"><?php echo esc_html( isset( $item['text'] ) ? $item['text'] : '' ); ?></p>
				</article>
			<?php endforeach; ?>
		</div>
	</div>
</section>
