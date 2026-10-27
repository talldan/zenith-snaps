<?php
/**
 * Title: Video demo
 * Slug: zenith/video
 * Description: Native editable Video block for a directly accessible video file.
 * Parameters: $src (HTTP(S) video-file URL), $caption (plain text, optional).
 * Guidance: Use a direct playable file, not a PR page, attachment landing page, or VideoPress embed URL.
 * For unavailable demos use an image placeholder with a recording suggestion; upload via the editor later.
 * Example: pattern( 'video', [ 'src' => 'https://example.com/demo.mp4', 'caption' => 'Switching viewports.' ] );
 */
namespace Snaps;
?>
<!-- wp:video -->
<figure class="wp-block-video"><video controls src="<?= url( $src ) ?>"></video><?php if ( ! empty( $caption ) ) : ?><figcaption class="wp-element-caption"><?= text( $caption ) ?></figcaption><?php endif; ?></figure>
<!-- /wp:video -->
