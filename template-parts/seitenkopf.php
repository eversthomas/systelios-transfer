<?php
/**
 * Seitenkopf: Brotkrumen, H1 (Seitentitel), Einleitung (Textauszug), optional Bildband (Beitragsbild).
 *
 * Argumente ($args): titel (string), lead (string), bild (int Anhang-ID), krumen (array).
 *
 * @package systelios-transfer
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$titel  = isset( $args['titel'] ) ? (string) $args['titel'] : '';
$lead   = isset( $args['lead'] ) ? (string) $args['lead'] : '';
$bild   = isset( $args['bild'] ) ? (int) $args['bild'] : 0;
$krumen = isset( $args['krumen'] ) && is_array( $args['krumen'] ) ? $args['krumen'] : array();
?>
<header class="seitenkopf">
	<div class="wrap">
		<?php if ( $krumen ) : ?>
			<nav class="brotkrumen" aria-label="<?php esc_attr_e( 'Brotkrumen', 'systelios-transfer' ); ?>">
				<ol>
					<?php foreach ( $krumen as $krume ) : ?>
						<li>
							<?php if ( ! empty( $krume['url'] ) ) : ?>
								<a href="<?php echo esc_url( $krume['url'] ); ?>"><?php echo esc_html( $krume['label'] ); ?></a>
							<?php else : ?>
								<span aria-current="page"><?php echo esc_html( $krume['label'] ); ?></span>
							<?php endif; ?>
						</li>
					<?php endforeach; ?>
				</ol>
			</nav>
		<?php endif; ?>

		<h1 class="seitenkopf__titel"><?php echo esc_html( $titel ); ?></h1>

		<?php if ( '' !== $lead ) : ?>
			<p class="seitenkopf__lead"><?php echo esc_html( $lead ); ?></p>
		<?php endif; ?>

		<?php if ( $bild > 0 ) : ?>
			<div class="seitenkopf__band">
				<?php echo wp_get_attachment_image( $bild, 'stt-band', false, array(
						'sizes'         => '(min-width: 1280px) 1184px, 100vw',
						'loading'       => 'eager',
						'fetchpriority' => 'high',
					) ); ?>
			</div>
		<?php endif; ?>
	</div>
</header>
