<?php
/** Run with: php tests/patterns.php. No network or WordPress runtime required. */
require __DIR__ . '/../patterns/render.php';

use function Snaps\pattern;

function check( bool $condition, string $message ): void {
	if ( ! $condition ) {
		throw new RuntimeException( $message );
	}
}

// Rendering warnings are failures, rather than silently leaking into HTML.
set_error_handler( static function ( int $severity, string $message ): void {
	throw new ErrorException( $message, 0, $severity );
} );

ob_start();
pattern( 'post', [
	'title' => 'Snaps <title> & "quotes"',
	'intro' => 'Intro <script> & text',
	'content' => function () {
		pattern( 'section-single', [
			'title' => 'Single & section',
			'content' => function () {
				pattern( 'heading', [ 'text' => '<Heading>' ] );
				pattern( 'paragraph', [ 'html' => 'An <a href="https://github.com/WordPress/gutenberg/pull/82749">inline source</a>.' ] );
				pattern( 'image', [ 'suggestion' => 'Capture --> <script> & viewport' ] );
			},
		] );
		pattern( 'section-two', [
			'title' => 'Two columns',
			'left' => function () {
				pattern( 'gallery', [
					'images' => [
						[ 'src' => 'https://example.com/before.png?a=1&b=2', 'alt' => 'Before "quotes"' ],
						[ 'src' => 'https://example.com/after.png', 'alt' => 'After', 'caption' => 'Image <caption>' ],
					],
					'caption' => 'Before & after',
				] );
			},
			'right' => function () {
				pattern( 'heading', [ 'text' => 'One feature' ] );
				pattern( 'video', [ 'src' => 'https://example.com/demo.mp4', 'caption' => '<Demo>' ] );
				pattern( 'heading', [ 'text' => 'Other changes' ] );
				pattern( 'list', [ 'items' => [ '<strong>One</strong> update', 'Another update' ] ] );
			},
		] );
	},
] );
$html = ob_get_clean();

check( str_contains( $html, 'Snaps &lt;title&gt; &amp; &quot;quotes&quot;' ), 'Title is escaped.' );
check( ! str_contains( $html, '<script>' ), 'Plain text cannot inject markup.' );
check( ! str_contains( $html, 'Capture' ), 'Capture suggestions stay out of rendered markup.' );
preg_match_all( '/<!--(.*?)-->/s', $html, $comments );
foreach ( $comments[1] as $comment ) {
	check( preg_match( '/^\s*\/?wp:[\w-]+(?:\s|$)/', $comment ) === 1, 'Only block delimiters appear as HTML comments.' );
}
check( str_contains( $html, '<a href="https://github.com/' ), 'Inline links survive.' );
check( str_contains( $html, '<img alt=""/>' ), 'An empty Image block has no source or invented link.' );
check( str_contains( $html, 'before.png?a=1&amp;b=2' ), 'Media URL attributes are escaped.' );
check( str_contains( $html, 'Before &quot;quotes&quot;' ), 'Alt text is escaped.' );
check( str_contains( $html, '&lt;Demo&gt;' ), 'Video captions are escaped.' );
check( substr_count( $html, '<h1 ' ) === 1, 'There is one post title.' );
check( substr_count( $html, '<h2 ' ) === 2, 'Both section headings render.' );
check( substr_count( $html, 'class="wp-block-column has-background"' ) === 3, 'Single/two sections render one/two columns.' );
check( str_ends_with( trim( $html ), '<!-- /wp:paragraph -->' ) && str_contains( $html, '#zenithsnaps #snaps +snapsp2' ), 'Standard footer renders.' );

// Validate nested block delimiters and parse every attributes object.
preg_match_all( '/<!-- (\/?)wp:([\w-]+)(?: (\{.*?\}))? -->/', $html, $blocks, PREG_SET_ORDER );
$stack = [];
foreach ( $blocks as $block ) {
	if ( $block[1] === '/' ) {
		check( array_pop( $stack ) === $block[2], 'Block delimiters are correctly nested.' );
	} else {
		$stack[] = $block[2];
		if ( isset( $block[3] ) ) {
			json_decode( $block[3], true, 512, JSON_THROW_ON_ERROR );
		}
	}
}
check( $stack === [], 'Every block is closed.' );

preg_match_all( '/<(\/?)(h[1-3]|p|div|figure|figcaption|ul|li|video|a|strong)\b[^>]*>/', $html, $tags, PREG_SET_ORDER );
foreach ( $tags as $tag ) {
	if ( $tag[1] === '/' ) {
		check( array_pop( $stack ) === $tag[2], 'HTML container tags are correctly nested.' );
	} else {
		$stack[] = $tag[2];
	}
}
check( $stack === [], 'Every HTML container is closed.' );

// Presentation invariants taken from the supplied editor export.
foreach ( [
	'has-pale-ocean-gradient-background has-background',
	'box-shadow:var(--wp--preset--shadow--sharp)',
	'background-color:#abb7c245;padding-top:var(--wp--preset--spacing--40)',
	'has-white-color has-black-background-color has-text-color has-background has-link-color',
] as $presentation ) {
	check( str_contains( $html, $presentation ), 'Exported section presentation is preserved.' );
}

foreach ( [ 'javascript:alert(1)', 'file:///tmp/image.png', 'not-a-url' ] as $invalid_url ) {
	try {
		Snaps\url( $invalid_url );
		throw new RuntimeException( 'Invalid media URL was accepted.' );
	} catch ( InvalidArgumentException $expected ) {
		// Expected rejection before any media attribute is emitted.
	}
}
try {
	pattern( '../post', [] );
	throw new RuntimeException( 'An unknown pattern was accepted.' );
} catch ( InvalidArgumentException $expected ) {
}

echo "Pattern checks passed: layouts, nesting, attributes, escaping, media, footer.\n";
