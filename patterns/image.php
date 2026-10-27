<?php
/**
 * Title: Image or empty image placeholder
 * Slug: zenith/image
 * Description: A relevant PR screenshot, supplied image, or editable upload placeholder.
 * Parameters: $src (HTTP(S) URL, optional), $alt (plain text, default empty),
 * $caption (plain text, optional), $suggestion (plain text, optional; required without src).
 * Capture suggestions stay in the PHP composition and are never emitted into block markup.
 * Guidance: No invented attachment IDs. External images stay external until uploaded to P2.
 * Example: pattern( 'image', [ 'suggestion' => 'Capture the viewport selector in mobile mode.' ] );
 */
namespace Snaps;
$src = $src ?? '';
$caption = $caption ?? '';
$suggestion = $suggestion ?? '';
if ( $src === '' && trim( $suggestion ) === '' ) {
	throw new \InvalidArgumentException( 'An empty image needs a capture suggestion.' );
}
?>
<!-- wp:image {"sizeSlug":"large","linkDestination":"none"} -->
<figure class="wp-block-image size-large"><img<?= $src !== '' ? ' src="' . url( $src ) . '"' : '' ?> alt="<?= text( $alt ?? '' ) ?>"/><?php if ( $caption !== '' ) : ?><figcaption class="wp-element-caption"><?= text( $caption ) ?></figcaption><?php endif; ?></figure>
<!-- /wp:image -->
