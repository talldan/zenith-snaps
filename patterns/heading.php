<?php
/**
 * Title: Column heading
 * Slug: zenith/heading
 * Description: Introduce a feature or a smaller update inside a column; repeat as needed.
 * Parameters: $text (plain text). Always H3; post and sections own H1/H2.
 * Example: pattern( 'heading', [ 'text' => 'A clearer media browser' ] );
 */
namespace Snaps;
?>
<!-- wp:heading {"level":3,"style":{"spacing":{"margin":{"top":"0"}}}} -->
<h3 class="wp-block-heading" style="margin-top:0"><?= text( $text ) ?></h3>
<!-- /wp:heading -->
