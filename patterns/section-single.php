<?php
/**
 * Title: Single-column section
 * Slug: zenith/section-single
 * Description: One coherent story about a project/area, in one full-width column.
 * Parameters: $title (plain text), $content (callback rendering content blocks).
 * Guidance: Any sequence of heading, paragraph, image, gallery, list, video; no column wrappers in the callback.
 * Example: pattern( 'section-single', [ 'title' => 'Media', 'content' => function () { ... } ] );
 */
namespace Snaps;
$columns = [ $content ];
require __DIR__ . '/section-layout.php';
