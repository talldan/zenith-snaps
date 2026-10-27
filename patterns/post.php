<?php
/**
 * Title: Zenith Snaps post
 * Slug: zenith/post
 * Description: Required entry point; renders title, intro, sections, attribution, tags.
 * Parameters: $title (plain text), $intro (plain text), $content (callback rendering sections).
 * Guidance: Always use once. Paste into an empty post's title field to populate the title and body automatically.
 * Example: pattern( 'post', [ 'title' => 'Zenith Team Snaps: ...', 'intro' => 'This cycle...', 'content' => function () { ... } ] );
 */
namespace Snaps;
if ( trim( $title ) === '' || trim( $intro ) === '' || ! is_callable( $content ) ) {
	throw new \InvalidArgumentException( 'A post requires a title, intro, and content callback.' );
}
?>
<!-- wp:heading {"level":1} -->
<h1 class="wp-block-heading"><?= text( $title ) ?></h1>
<!-- /wp:heading -->

<!-- wp:paragraph -->
<p><?= text( $intro ) ?></p>
<!-- /wp:paragraph -->

<?php $content(); ?>

<!-- wp:paragraph -->
<p>This post was drafted using <a href="https://github.com/talldan/zenith-snaps">this AI-assisted drafting tool</a> for generating Zenith snaps.</p>
<!-- /wp:paragraph -->

<!-- wp:paragraph -->
<p>#zenithsnaps #snaps +snapsp2</p>
<!-- /wp:paragraph -->
