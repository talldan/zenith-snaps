# Composing Snaps with PHP patterns

Requires PHP 8.0+ CLI, without WordPress or Composer. Pattern PHP headers document selection rules, parameters, and examples. These are local drafting patterns, not registered theme patterns.

Create `snaps.php` in the repository root:

```php
<?php
require __DIR__ . '/patterns/render.php';

use function Snaps\pattern;

pattern( 'post', [
    'title' => 'Zenith Team Snaps: October 12th to October 25th',
    'intro' => 'Highlights from the latest cycle.',
    'content' => function () {
        pattern( 'section-single', [
            'title' => 'Media',
            'content' => function () {
                pattern( 'heading', [ 'text' => 'A clearer media browser' ] );
                pattern( 'paragraph', [ 'html' => 'Browse the <a href="https://github.com/WordPress/gutenberg/pull/82749">new visual grid</a>.' ] );
                pattern( 'image', [ 'suggestion' => 'Capture the media inserter image grid.' ] );
            },
        ] );
    },
] );
```

Generate the editable block markup:

```sh
php -l snaps.php
php -d display_errors=stderr -d error_reporting=E_ALL snaps.php > snaps.html.tmp && mv snaps.html.tmp snaps.html
```

Check the exit status and stderr: discard output if PHP reports any warning or error. The temporary file keeps a failed run from replacing the last HTML draft. These are local PHP commands, not a build or watcher.

## Structure and selection

```text
post (exactly once)
  H1 title, intro
  section-single                  section-two
    H2 area heading                 H2 area heading
    one column                      left column | right column
      content blocks                content     | content
  attribution, tags
```

- `section-single`: one coherent story about a project/area.
- `section-two`: two distinct sets within an area. Use equal features, major/minor features, or a headline in one column and several smaller updates in the other. Columns have equal widths, not necessarily equal content lengths.
- Inside columns, use `heading`, `paragraph`, `image`, `gallery`, `list`, and `video` in the order that tells the story. A column can contain multiple highlights.
- Section patterns own the column wrappers. Never insert sections inside columns or write layout markup in the composition.
- Preserve the checked-in block attributes, classes, and styles. Change presentation by editing and reviewing a pattern, not by adding arbitrary block-support parameters to a draft.

## Content parameters

- Titles, headings, intro, alt text, and captions are **plain text**, automatically escaped. Do not pre-escape them.
- Paragraph `html` and list `items` are **trusted authored inline HTML**, intentionally preserved so links and emphasis remain editable. Use only text, `a`, `strong`, `em`, and `code`. Escape literal text with `Snaps\text()` when needed. This is not an HTML sanitizer; never pass raw PR descriptions, arbitrary block markup, scripts, or styles.
- Content callbacks print nested patterns. Do not return strings from them.
- Media URLs must be HTTP(S). No guessed WordPress attachment IDs or example upload URLs.

## Media

Inspect the selected PR bodies from the generated JSON for Markdown images, HTML `img` elements, and linked recordings. Read surrounding context to distinguish before/after, prototypes, and final results. Select relevant images, check accessibility and Content-Type (e.g. `curl -I -L URL`), and inspect the image when tooling permits. If HEAD is rejected, try GET: some attachment storage hosts reject HEAD but serve the image normally. Retain the original attachment URL, not a short-lived signed redirect. Do not copy PR HTML wholesale or assume a bare attachment URL is an image/video.

Use `image` for one screenshot and `gallery` for two or more related screenshots. Add accurate alt text and captions; label before/after explicitly. Keep provenance in a PHP comment beside the call. Remote images remain externally hosted; the reviewer can upload copies to P2 for permanence.

When a suitable image is unavailable, omit `src` and supply `suggestion`. This produces an empty native Image block. Capture instructions remain exclusively in `snaps.php`, which serves as the capture checklist. Do not emit guidance comments into HTML: comments between nested blocks become part of the parent block's saved HTML and can cause validation failures. Do not put capture instructions in alt text or publish them as captions.

`video` accepts a direct playable video-file URL. For VideoPress uploads or inaccessible recordings, use an image placeholder with a recording suggestion and replace it through the editor. Do not fabricate VideoPress attributes.

## Review and publishing

1. Review `snaps.php` for copy, sources, media provenance, and layout choices. Regenerate after edits.
2. Verify block delimiters and HTML nesting; compare wrappers with the patterns. Check no PHP diagnostics, instructional tokens, or sample URLs leaked into output.
3. From the repository root on macOS, run `pbcopy < snaps.html` to copy the markup. On Linux, use `wl-copy < snaps.html` on Wayland or `xclip -selection clipboard < snaps.html` on X11 if installed, or open the file and copy its contents manually. The generated document is a block fragment, not a standalone themed HTML page.
4. Paste into the **title field of a new, empty P2 post** in the visual editor. WordPress puts the initial H1 text into the post title and the remaining blocks into the body automatically.
5. Confirm there are no invalid-block warnings and that sections, paragraphs, lists, and media are individually editable. Check the theme's preset colors, spacing, gradient, and shadow match the supplied example.
6. Replace empty images using the suggestions in `snaps.php` and review external media. Proofread and follow `SNAPS_PROCESS.md` before publishing.

Local structural checks cannot prove block save validation against P2's installed versions or plugins. The first use of each pattern needs the destination-editor check above.

## Local checks and example

Run `php tests/patterns.php` for both layouts, media variants, escaping, nested block delimiters, and fixed presentation checks. The test uses no network or WordPress runtime.

`examples/snaps.php` demonstrates composition syntax with placeholder text and example URLs: a headline beside smaller updates and a separate single-column section. It is not an editorial example; follow the runbook for tone and wording. Run `php examples/snaps.php` to inspect its markup, or copy it to `snaps.php` and change its require line to `require __DIR__ . '/patterns/render.php';` before drafting a new cycle. Replace all placeholders and example URLs; the example image URL is illustrative and does not provide an actual screenshot.
