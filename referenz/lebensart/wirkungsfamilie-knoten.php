<?php
/** Ein Mitglied der Wirkungsfamilie im Stil der Folie 10. */

$args = is_array( $args ) ? $args : array();
$d    = isset( $args['daten'] ) && is_array( $args['daten'] ) ? $args['daten'] : array();
if ( ! $d ) {
	return;
}

$slots = array( 'klinik', 'akademie', 'beratung', 'thinktank', 'transfer', 'lebensart' );
$slot  = in_array( $d['farbe'], $slots, true ) ? $d['farbe'] : 'extra';
$links = array( 'beratung', 'akademie', 'thinktank', 'lebensart' );
$richtung = in_array( $slot, $links, true ) ? 'links' : 'rechts';

$blobs = array(
	'beratung'  => 'M78,148 C28,92 72,28 158,36 C228,42 248,16 318,42 C388,68 402,148 348,198 C286,246 168,238 108,204 C52,174 42,188 78,148 Z',
	'akademie'  => 'M96,138 C42,72 78,18 156,26 C214,32 236,68 286,52 C348,32 392,96 368,162 C344,228 228,252 146,226 C68,202 38,176 96,138 Z',
	'klinik'    => 'M86,150 C22,78 88,16 176,28 C268,40 348,12 392,78 C432,148 372,236 258,248 C138,260 36,214 28,142 C22,96 48,188 86,150 Z',
	'thinktank' => 'M118,156 C58,118 36,48 128,28 C192,14 224,62 274,40 C342,12 396,86 358,152 C322,216 214,248 136,216 C66,188 76,186 118,156 Z',
	'transfer'  => 'M104,168 C40,128 52,58 142,38 C204,24 252,56 304,34 C372,8 412,102 368,168 C332,228 214,252 136,226 C58,200 48,198 104,168 Z',
	'lebensart' => 'M62,146 C18,88 92,36 172,48 C242,58 258,22 332,48 C402,74 408,158 338,208 C268,252 138,236 78,186 C38,156 28,176 62,146 Z',
	'extra'     => 'M80,140 C30,80 90,30 170,40 C250,50 340,30 370,100 C400,180 300,240 180,230 C80,220 40,180 80,140 Z',
);

$class = 'fam-node fam-node--' . $slot . ' fam-node--' . $richtung;
if ( 'klinik' === $slot ) {
	$class .= ' fam-node--gross';
}
if ( ! empty( $d['wir'] ) ) {
	$class .= ' fam-node--wir';
}
$style = '--fam-c:' . $d['hex'] . ';--fam-fg:' . $d['textfarbe'] . ';';

$logo_html = '';
if ( ! empty( $d['logo'] ) ) {
	$logo_html = wp_get_attachment_image(
		(int) $d['logo'],
		'medium',
		false,
		array(
			'alt' => 'Logo ' . $d['titel'],
		)
	);
}

$aria = $d['titel'] . ' – zur Website';
if ( ! empty( $d['wir'] ) ) {
	$aria .= ', Hier bist Du';
}
$pill_offen  = ! empty( $d['link'] )
	? '<a class="fam-pill fam-pill--logo" href="' . esc_url( $d['link'] ) . '" rel="noopener" aria-label="' . esc_attr( $aria ) . '">'
	: '<span class="fam-pill fam-pill--logo">';
$pill_zu     = ! empty( $d['link'] ) ? '</a>' : '</span>';
$band_html   = '';
if ( $d['zuschreibung'] ) {
	$band_html = '<span class="fam-band"><span class="fam-band__text">' . esc_html( $d['zuschreibung'] ) . '</span></span>';
}
?>
<article class="<?php echo esc_attr( $class ); ?>" style="<?php echo esc_attr( $style ); ?>">
	<svg class="fam-blob" viewBox="0 0 440 270" preserveAspectRatio="xMidYMid meet" aria-hidden="true" focusable="false">
		<path d="<?php echo esc_attr( $blobs[ $slot ] ); ?>" />
	</svg>
	<div class="fam-body">
		<div class="fam-head">
			<?php if ( $d['rolle'] ) : ?>
				<span class="fam-role"><?php echo esc_html( $d['rolle'] ); ?></span>
			<?php endif; ?>
			<span class="fam-stem" aria-hidden="true"></span>
		</div>
		<div class="fam-row">
			<?php
			if ( 'links' === $richtung ) {
				echo $band_html; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- oben escapet
			}
			echo $pill_offen; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- feste Markup-Teile, href/aria escapet
			if ( $logo_html ) {
				echo $logo_html; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- wp_get_attachment_image
			} else {
				echo '<span class="fam-wort"><span class="fam-wort__marke">sysTelios</span><span class="fam-wort__rolle">' . esc_html( $d['rolle'] ) . '</span></span>';
			}
			if ( ! empty( $d['wir'] ) ) {
				echo '<span class="fam-here">Hier bist Du</span>';
			}
			echo $pill_zu; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
			if ( 'rechts' === $richtung ) {
				echo $band_html; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
			}
			?>
		</div>
		<?php if ( $d['kurztext'] ) : ?>
			<span class="fam-sr"><?php echo esc_html( $d['kurztext'] ); ?></span>
		<?php endif; ?>
	</div>
</article>
