<?php
/**
 * Title: Paragraph
 * Slug: zenith/paragraph
 * Description: One concise paragraph, with inline source links around claims.
 * Parameters: $html (trusted, authored inline HTML: text, a, strong, em, code).
 * Guidance: Escape literal text/attribute values; never paste raw PR HTML or PHP here.
 * No surrounding p tags, block markup, Markdown, or layout styles.
 * Example: pattern( 'paragraph', [ 'html' => 'Browse the <a href="https://github.com/...">new grid</a>.' ] );
 */
namespace Snaps;
?>
<!-- wp:paragraph -->
<p><?= $html ?></p>
<!-- /wp:paragraph -->
