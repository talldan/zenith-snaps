<?php
/**
 * Structural example only. Replace all placeholder content when drafting.
 * Follow the runbook for editorial tone; this example demonstrates composition syntax.
 * From the repository root: php examples/snaps.php > snaps.html
 * For the normal drafting workflow, copy this to root snaps.php and adjust require.
 */
require __DIR__ . '/../patterns/render.php';

use function Snaps\pattern;

pattern( 'post', [
	'title' => 'Zenith Team Snaps: [Start date] to [End date]',
	'intro' => '[Intro paragraph]',
	'content' => function () {
		pattern( 'section-two', [
			'title' => '[Project or area A]',
			'left' => function () {
				pattern( 'heading', [ 'text' => '[Headline feature]' ] );
				pattern( 'paragraph', [ 'html' => '[Paragraph with an <a href="https://example.com/source-pr">inline source link</a>.]' ] );
				// Replace with a verified image URL and record its source PR here.
				pattern( 'image', [
					'src' => 'https://example.com/screenshot.png',
					'alt' => '[Screenshot description]',
					'caption' => '[Screenshot caption]',
				] );
			},
			'right' => function () {
				pattern( 'heading', [ 'text' => '[Smaller updates]' ] );
				pattern( 'list', [ 'items' => [
					'[Update with an <a href="https://example.com/source-pr-a">inline source link</a>.]',
					'[Update with an <a href="https://example.com/source-pr-b">inline source link</a>.]',
				] ] );
				pattern( 'image', [ 'suggestion' => '[Screenshot or demo capture instructions]' ] );
			},
		] );
		pattern( 'section-single', [
			'title' => '[Project or area B]',
			'content' => function () {
				pattern( 'heading', [ 'text' => '[Feature heading]' ] );
				pattern( 'paragraph', [ 'html' => '[Paragraph with an <a href="https://example.com/source-pr">inline source link</a>.]' ] );
				pattern( 'image', [ 'suggestion' => '[Screenshot or demo capture instructions]' ] );
			},
		] );
	},
] );
