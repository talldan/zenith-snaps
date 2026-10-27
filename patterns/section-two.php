<?php
/**
 * Title: Two-column section
 * Slug: zenith/section-two
 * Description: Two distinct sets of updates within one project/area, in equal-width columns.
 * Parameters: $title (plain text), $left and $right (callbacks rendering content blocks).
 * Guidance: Use for two equal features, major/minor features, or a headline plus several smaller updates.
 * Each column may contain several headings and any sequence of the content patterns.
 * Example: pattern( 'section-two', [ 'title' => 'Media', 'left' => function () { ... }, 'right' => function () { ... } ] );
 */
namespace Snaps;
$columns = [ $left, $right ];
require __DIR__ . '/section-layout.php';
