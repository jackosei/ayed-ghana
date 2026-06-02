<?php
/**
 * Section: Mission, Vision, Values, Approach.
 *
 * @package AYED_Ghana
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$tag        = ayed_field( 'mission_tag', 'Our Foundation' );
$title      = ayed_field( 'mission_title', 'Guided by [em]Purpose[/em], Driven by People' );
$quote      = ayed_field( 'mission_quote', 'Young people learn best through active participation. Learning can occur in any environment or scenario. Our role is to create the conditions for it.' );
$quote_attr = ayed_field( 'mission_quote_attr', 'AYED Ghana' );

$cards = ayed_field( 'mission_cards', array(
	array( 'icon' => 'compass', 'title' => 'Our Mission', 'text' => 'To empower young people across Ghana and Africa by providing access to training, mentoring, networks, and strategic opportunities, enabling each individual to achieve their highest potential and contribute meaningfully to society.' ),
	array( 'icon' => 'eye', 'title' => 'Our Vision', 'text' => 'A generation of young Africans who are competent, confident, and empowered to lead in business, industry, politics, and civil life, shaping a prosperous and self-determined continent.' ),
	array( 'icon' => 'heart', 'title' => 'Our Values', 'text' => 'Empowerment. Inclusivity. Activism. Innovation. Community. We believe every young person holds the potential to make a positive impact, and that potential is best unlocked through opportunity, not charity.' ),
	array( 'icon' => 'route', 'title' => 'Our Approach', 'text' => 'We partner with institutions, communities, and global networks to create pathways, from skills training and mentorship to international exchange and sustainable development projects rooted in Ghana\'s heritage.' ),
) );
?>
<section id="mission" class="section section--dark section--mission">
	<div class="section__pattern" aria-hidden="true"></div>
	<div class="container">
		<header class="section-head section-head--light reveal">
			<?php ayed_eyebrow( $tag ); ?>
			<h2 class="section-title"><?php ayed_the_emphasis( $title ); ?></h2>
		</header>

		<div class="mv-grid">
			<?php
			$count = is_array( $cards ) ? count( $cards ) : 0;
			$half  = (int) ceil( $count / 2 );
			foreach ( $cards as $i => $card ) :
				?>
				<article class="mv-card reveal">
					<span class="mv-card__icon"><?php ayed_icon( isset( $card['icon'] ) ? $card['icon'] : 'star', array( 'size' => 28 ) ); ?></span>
					<h3 class="mv-card__title"><?php echo esc_html( isset( $card['title'] ) ? $card['title'] : '' ); ?></h3>
					<p class="mv-card__text"><?php echo esc_html( isset( $card['text'] ) ? $card['text'] : '' ); ?></p>
				</article>

				<?php if ( $quote && ( $i + 1 ) === $half ) : ?>
					<aside class="mv-quote reveal">
						<span class="mv-quote__mark"><?php ayed_icon( 'quote', array( 'size' => 34 ) ); ?></span>
						<blockquote><?php echo esc_html( $quote ); ?></blockquote>
						<?php if ( $quote_attr ) : ?>
							<cite><?php echo esc_html( $quote_attr ); ?></cite>
						<?php endif; ?>
					</aside>
				<?php endif; ?>
			<?php endforeach; ?>
		</div>
	</div>
</section>
