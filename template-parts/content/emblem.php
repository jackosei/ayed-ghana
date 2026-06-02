<?php
/**
 * Brand emblem, inspired by the AYED logo: an orange embracing arc cradling a
 * light centre on navy, ringed by the organisation name.
 *
 * @package AYED_Ghana
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
?>
<svg class="emblem" viewBox="0 0 300 300" role="img" aria-label="<?php esc_attr_e( 'African Youth Empowerment and Development Ghana emblem', 'ayed-ghana' ); ?>" xmlns="http://www.w3.org/2000/svg">
	<defs>
		<path id="ayedTopArc" d="M 56 150 A 94 94 0 0 1 244 150" />
		<path id="ayedBotArc" d="M 244 150 A 94 94 0 0 1 56 150" />
	</defs>

	<!-- Navy field -->
	<circle cx="150" cy="150" r="148" fill="#143a64" />
	<circle cx="150" cy="150" r="120" fill="none" stroke="#1f4f80" stroke-width="1" />

	<!-- Curved name ring -->
	<text font-family="Poppins, sans-serif" font-size="13" font-weight="600" letter-spacing="2.5" fill="#f7f5f1" text-anchor="middle">
		<textPath href="#ayedTopArc" startOffset="50%">AFRICAN YOUTH EMPOWERMENT</textPath>
	</text>
	<text font-family="Poppins, sans-serif" font-size="13" font-weight="600" letter-spacing="2.5" fill="#f7f5f1" text-anchor="middle">
		<textPath href="#ayedBotArc" startOffset="50%">AND DEVELOPMENT . GHANA</textPath>
	</text>

	<!-- Orange embracing arc -->
	<path d="M150 78
	         C 96 78 86 120 86 150
	         C 86 196 114 222 150 222
	         C 186 222 214 196 214 150
	         C 214 120 204 78 150 78
	         Z
	         M150 96
	         C 188 96 196 126 196 150
	         C 196 186 176 204 150 204
	         C 124 204 104 186 104 150
	         C 104 126 112 96 150 96 Z"
	      fill="#e1731b" fill-rule="evenodd" />

	<!-- Light cradle -->
	<ellipse cx="150" cy="150" rx="40" ry="52" fill="#f7f5f1" />

	<!-- Three rising figures (youth) -->
	<g fill="#143a64">
		<circle cx="135" cy="132" r="6" />
		<circle cx="150" cy="124" r="6.5" />
		<circle cx="165" cy="132" r="6" />
		<path d="M150 132 L150 162 M150 142 L136 150 M150 142 L164 150 M150 162 L142 178 M150 162 L158 178" stroke="#143a64" stroke-width="5" stroke-linecap="round" fill="none" />
		<path d="M135 140 L135 160 M135 146 L126 152 M135 160 L130 172" stroke="#e1731b" stroke-width="4.5" stroke-linecap="round" fill="none" />
		<path d="M165 140 L165 160 M165 146 L174 152 M165 160 L170 172" stroke="#e1731b" stroke-width="4.5" stroke-linecap="round" fill="none" />
	</g>
</svg>
