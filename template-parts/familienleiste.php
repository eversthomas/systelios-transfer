<?php
/**
 * Familienleiste: ein Punkt je Haus in der Hausfarbe, das eigene Haus ist markiert, Häuser ohne Website stehen als Text.
 *
 * Argumente ($args): haeuser (array aus stt_familie_daten()).
 *
 * @package systelios-transfer
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$haeuser = isset( $args['haeuser'] ) && is_array( $args['haeuser'] ) ? $args['haeuser'] : array();
if ( ! $haeuser ) {
	return;
}
?>
<nav class="familienleiste" aria-label="<?php esc_attr_e( 'Wirkungsfamilie', 'systelios-transfer' ); ?>">
	<ul>
		<?php foreach ( $haeuser as $haus ) : ?>
			<?php
			$farbe   = sanitize_hex_color( $haus['hex'] );
			$beschr  = $haus['rolle'] . ( '' !== $haus['zuschreibung'] ? ' · ' . $haus['zuschreibung'] : '' );
			$logo_id = (int) $haus['logo'];
			$klasse  = trim( ( ! empty( $haus['wir'] ) ? 'wir ' : '' ) . ( $logo_id ? 'mit-logo' : '' ) );
			$stil    = $farbe ? '--fam-c:' . $farbe : '';
			?>
			<li<?php echo '' !== $klasse ? ' class="' . esc_attr( $klasse ) . '"' : ''; ?><?php echo '' !== $stil ? ' style="' . esc_attr( $stil ) . '"' : ''; ?>>
				<?php if ( ! empty( $haus['link'] ) ) : ?>
					<a href="<?php echo esc_url( $haus['link'] ); ?>" rel="noopener"><?php echo $logo_id ? wp_get_attachment_image( $logo_id, 'medium', false, array( 'class' => 'familienleiste__logo', 'alt' => $beschr, 'loading' => 'lazy' ) ) : esc_html( $beschr ); // phpcs:ignore WordPress.Security.EscapeOutput ?></a>
				<?php else : ?>
					<span><?php echo $logo_id ? wp_get_attachment_image( $logo_id, 'medium', false, array( 'class' => 'familienleiste__logo', 'alt' => $beschr, 'loading' => 'lazy' ) ) : esc_html( $beschr ); // phpcs:ignore WordPress.Security.EscapeOutput ?></span>
				<?php endif; ?>
				<?php if ( ! empty( $haus['wir'] ) ) : ?>
					<span class="sr"><?php esc_html_e( '(Sie sind hier)', 'systelios-transfer' ); ?></span>
				<?php endif; ?>
			</li>
		<?php endforeach; ?>
	</ul>
</nav>
