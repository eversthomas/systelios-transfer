<?php
/** Start: Wirkungsfamilie-Streifen. */

$ueberschrift = (string) la_start_meta( 'start_familie_ueberschrift' );
$linktext     = (string) la_start_meta( 'start_familie_linktext' );
$mitglieder   = la_wirkungsfamilie();
$ueber        = la_seite_url( 'ueber-uns' );

if ( ! $mitglieder ) {
	return;
}
?>
<section class="section section-tint" style="padding-block:clamp(2rem,4vw,3rem)" aria-labelledby="h-famstrip">
	<div class="wrap family-strip">
		<?php if ( $ueberschrift ) : ?>
			<h2 id="h-famstrip"><?php echo esc_html( $ueberschrift ); ?></h2>
		<?php endif; ?>
		<ul>
			<?php foreach ( $mitglieder as $m ) : ?>
				<?php
				$d = la_wirkungsfamilie_daten( $m );
				$label = $d['rolle'];
				if ( $d['zuschreibung'] ) {
					$label .= ' · ' . $d['zuschreibung'];
				}
				$klasse = $d['wir'] ? 'me' : '';
				$rand   = function_exists( 'la_markenpunkt_rand_klasse' ) ? la_markenpunkt_rand_klasse( $d['hex'] ) : '';
				if ( $rand ) {
					$klasse = trim( $klasse . ' ' . $rand );
				}
				?>
				<li class="<?php echo esc_attr( $klasse ); ?>" style="--fam-c:<?php echo esc_attr( $d['hex'] ); ?>">
					<?php if ( $d['link'] ) : ?>
						<a href="<?php echo esc_url( $d['link'] ); ?>" rel="noopener"><?php echo esc_html( $label ); ?></a>
					<?php else : ?>
						<?php echo esc_html( $label ); ?>
					<?php endif; ?>
				</li>
			<?php endforeach; ?>
		</ul>
		<?php if ( $linktext && $ueber ) : ?>
			<a class="link-arrow" href="<?php echo esc_url( $ueber ); ?>#wirkungsfamilie"><?php echo esc_html( $linktext ); ?> <i class="ph ph-arrow-right" aria-hidden="true"></i></a>
		<?php endif; ?>
	</div>
</section>
