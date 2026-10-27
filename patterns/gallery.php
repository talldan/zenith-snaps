<?php
/**
 * Title: Screenshot gallery
 * Slug: zenith/gallery
 * Description: Two or more related screenshots (e.g. before/after) within a column.
 * Parameters: $images (array of image parameter arrays), $caption (plain text, optional).
 * Guidance: Label before/after explicitly. If no screenshots exist, prefer one empty image.
 * Example: pattern( 'gallery', [ 'images' => [ [ 'src' => 'https://...', 'alt' => 'Before' ], [ 'src' => 'https://...', 'alt' => 'After' ] ] ] );
 */
namespace Snaps;
if ( count( $images ) < 2 ) {
	throw new \InvalidArgumentException( 'A gallery requires at least two images.' );
}
?>
<!-- wp:gallery {"linkTo":"none","layout":{"type":"flex","flexWrap":null}} -->
<figure class="wp-block-gallery has-nested-images columns-default is-cropped">
<?php foreach ( $images as $image ) { pattern( 'image', $image ); } ?>
<?php if ( ! empty( $caption ) ) : ?><figcaption class="blocks-gallery-caption wp-element-caption"><?= text( $caption ) ?></figcaption><?php endif; ?></figure>
<!-- /wp:gallery -->
