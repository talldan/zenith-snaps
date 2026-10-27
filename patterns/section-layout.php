<?php
/** Shared markup for the two section patterns; not called directly by compositions. */
namespace Snaps;
foreach ( $columns as $column ) {
	if ( ! is_callable( $column ) ) {
		throw new \InvalidArgumentException( 'Section columns must be content callbacks.' );
	}
}
?>
<!-- wp:group {"metadata":{"name":"Zenith snaps section","categories":["zenith"]},"align":"wide","style":{"spacing":{"padding":{"top":"0","bottom":"0","left":"0","right":"0"},"margin":{"bottom":"var:preset|spacing|60"}},"shadow":"var:preset|shadow|sharp"},"gradient":"pale-ocean","layout":{"type":"default"}} -->
<div class="wp-block-group alignwide has-pale-ocean-gradient-background has-background" style="margin-bottom:var(--wp--preset--spacing--60);padding-top:0;padding-right:0;padding-bottom:0;padding-left:0;box-shadow:var(--wp--preset--shadow--sharp)"><!-- wp:heading {"style":{"elements":{"link":{"color":{"text":"var:preset|color|white"}}},"spacing":{"padding":{"top":"var:preset|spacing|30","bottom":"var:preset|spacing|30","left":"var:preset|spacing|50","right":"var:preset|spacing|50"},"margin":{"top":"0","bottom":"0","left":"0","right":"0"}}},"backgroundColor":"black","textColor":"white"} -->
<h2 class="wp-block-heading has-white-color has-black-background-color has-text-color has-background has-link-color" style="margin-top:0;margin-right:0;margin-bottom:0;margin-left:0;padding-top:var(--wp--preset--spacing--30);padding-right:var(--wp--preset--spacing--50);padding-bottom:var(--wp--preset--spacing--30);padding-left:var(--wp--preset--spacing--50)"><?= text( $title ) ?></h2>
<!-- /wp:heading -->

<!-- wp:columns {"style":{"spacing":{"padding":{"right":"var:preset|spacing|50","left":"var:preset|spacing|50","top":"var:preset|spacing|50","bottom":"var:preset|spacing|50"},"margin":{"top":"0","bottom":"0"}}}} -->
<div class="wp-block-columns" style="margin-top:0;margin-bottom:0;padding-top:var(--wp--preset--spacing--50);padding-right:var(--wp--preset--spacing--50);padding-bottom:var(--wp--preset--spacing--50);padding-left:var(--wp--preset--spacing--50)">
<?php foreach ( $columns as $column ) : ?>
<!-- wp:column {"style":{"color":{"background":"#abb7c245"},"spacing":{"padding":{"top":"var:preset|spacing|40","bottom":"var:preset|spacing|40","left":"var:preset|spacing|40","right":"var:preset|spacing|40"}}}} -->
<div class="wp-block-column has-background" style="background-color:#abb7c245;padding-top:var(--wp--preset--spacing--40);padding-right:var(--wp--preset--spacing--40);padding-bottom:var(--wp--preset--spacing--40);padding-left:var(--wp--preset--spacing--40)">
<?php $column(); ?>
</div>
<!-- /wp:column -->
<?php endforeach; ?>
</div>
<!-- /wp:columns --></div>
<!-- /wp:group -->
