<?php
/**
 * Title: List of smaller updates
 * Slug: zenith/list
 * Description: A short unordered list, useful beside a headline feature.
 * Parameters: $items (nonempty array of trusted inline HTML strings, same contract as paragraph).
 * Guidance: Each highlighted item needs its own inline source link. No nested lists initially.
 * Example: pattern( 'list', [ 'items' => [ 'Improved <a href="https://github.com/...">audio previews</a>.' ] ] );
 */
namespace Snaps;
if ( empty( $items ) ) {
	throw new \InvalidArgumentException( 'A list requires at least one item.' );
}
?>
<!-- wp:list -->
<ul class="wp-block-list"><?php foreach ( $items as $item ) : ?><!-- wp:list-item -->
<li><?= $item ?></li>
<!-- /wp:list-item -->
<?php endforeach; ?></ul>
<!-- /wp:list -->
