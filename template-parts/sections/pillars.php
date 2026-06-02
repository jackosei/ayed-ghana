<?php
/**
 * Section: Pillars / Areas of impact.
 *
 * @package AYED_Ghana
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$tag   = ayed_field( 'pillars_tag', 'Areas of Impact' );
$title = ayed_field( 'pillars_title', 'Five Pillars of [em]Youth Development[/em]' );
$intro = ayed_field( 'pillars_intro', 'Our comprehensive service model addresses the full spectrum of a young person\'s development, from individual skills to global citizenship, ensuring no opportunity is out of reach.' );

$pillars = ayed_field( 'pillars', array(
	array( 'icon' => 'book', 'title' => 'Education', 'text' => 'Access to quality learning, scholarships, and knowledge-sharing programmes that open doors.' ),
	array( 'icon' => 'pulse', 'title' => 'Health and Wellbeing', 'text' => 'Health literacy, community wellness initiatives, and support for a thriving youth population.' ),
	array( 'icon' => 'briefcase', 'title' => 'Employment', 'text' => 'Skills training, entrepreneurship support, and pathways to dignified, sustainable livelihoods.' ),
	array( 'icon' => 'globe', 'title' => 'International Relations', 'text' => 'Cross-border partnerships, exchange programmes, and global platforms for young Ghanaian voices.' ),
	array( 'icon' => 'landmark', 'title' => 'Diplomacy and Leadership', 'text' => 'Developing the next generation of political leaders, diplomats, and civic champions.' ),
) );
?>
<section id="pillars" class="section section--pillars">
	<div class="container">
		<div class="pillars-intro reveal">
			<header class="section-head">
				<?php ayed_eyebrow( $tag ); ?>
				<h2 class="section-title"><?php ayed_the_emphasis( $title ); ?></h2>
			</header>
			<?php if ( $intro ) : ?>
				<p class="pillars-intro__text"><?php echo esc_html( $intro ); ?></p>
			<?php endif; ?>
		</div>

		<div class="pillars-grid reveal">
			<?php foreach ( $pillars as $pillar ) : ?>
				<article class="pillar">
					<span class="pillar__icon"><?php ayed_icon( isset( $pillar['icon'] ) ? $pillar['icon'] : 'star', array( 'size' => 30 ) ); ?></span>
					<h3 class="pillar__title"><?php echo esc_html( isset( $pillar['title'] ) ? $pillar['title'] : '' ); ?></h3>
					<p class="pillar__text"><?php echo esc_html( isset( $pillar['text'] ) ? $pillar['text'] : '' ); ?></p>
				</article>
			<?php endforeach; ?>
		</div>
	</div>
</section>
