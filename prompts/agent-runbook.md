# Agent Runbook: Draft Zenith Snaps

You are helping draft a Zenith Team Snaps post.

Your default workflow is agent-driven. Do not ask the human to paste JSON files or prompt text if you can read files and run commands locally.

## Inputs

The human may provide an explicit date range:

```text
Draft Zenith Snaps for YYYY-MM-DD to YYYY-MM-DD using this repo's process.
```

The human may also use a vague request such as:

```text
Generate the Snaps using this repo's process.
```

If explicit dates are provided, use them.

If the human says `last two weeks`, `generate the snaps`, or gives no date range, infer the most recent completed Snaps cycle. The default cycle is Monday two weeks prior through the previous Sunday, inclusive. In practice, find the most recent completed Sunday, then use the Monday 13 days before that Sunday as the start date.

Examples:

- If today is Monday 2026-07-20, the most recent completed Sunday is `2026-07-19`, so use `2026-07-06` through `2026-07-19`.
- If today is Wednesday 2026-07-22, the most recent completed Sunday is still `2026-07-19`, so use `2026-07-06` through `2026-07-19`.

State the inferred date range before running the script. Do not ask for confirmation unless the request conflicts with the default cycle or the date range is genuinely ambiguous.

## Files To Read

Read these files before drafting:

- `SNAPS_PROCESS.md`
- `generate-snaps-data.sh`
- `patterns/README.md` and the PHP headers of the patterns you select.

## Collect Data

Run the data script yourself:

```sh
./generate-snaps-data.sh FROM TO
```

Then read:

- `data/gutenberg_merged.json`
- `data/wordpress-develop_closed.json`

If the command fails because `gh` is missing or unauthenticated, explain the blocker and the exact command the human needs to run, such as `gh auth login`.

## Curation Rules

- Use only the generated JSON and any explicit human notes.
- Do not invent impact, project status, screenshots, or completion details.
- Every highlighted work item must cite at least one source PR link.
- Prefer user-facing, visual, milestone-oriented work.
- Group related PRs into coherent stories rather than listing PRs one by one.
- Aim for 2-4 sections.
- Aim for 1-2 panel-style highlights per section.
- Treat `wordpress-develop` closed PRs cautiously. Include them only when they make a strong highlight and phrase them without overclaiming Core landing details unless completion is clear from the data or human notes.
- Leave uncertain, lower-priority, or omitted work out of the draft. The post is highlights-only.
- Do not add `Needs Review`, `Omitted`, `Lower Priority`, or similar sections.

## Audience And Tone

Write for an intelligent internal audience at a tech company. Readers may include engineers, designers, support, marketing, product, and leadership.

The tone should be product-facing and clear, not beginner-friendly or overly simplified. The post should help readers quickly understand what users can now see, do, or rely on.

Style goals:

- User-facing benefits.
- Clear, product-facing language for an internal tech-company audience.
- Concise wording.
- What changed in the editor experience.
- Why the change matters.
- Terms such as `users`, `site owners`, `designers`, `theme authors`, or `folks` when they accurately describe the audience.

Rewrite guidance:

- Implementation details unless they help explain the benefit.
- Overly technical wording when a product-facing explanation is clearer.
- Overly simplified wording that sounds patronizing or vague.
- Defaulting to `people` as a generic substitute for more accurate terms.
- Package, API, data model, or internal architecture terminology unless it is relevant to the highlight.

When technical terms are useful, keep them, but connect them to the user-facing improvement. Do not remove user-facing WordPress/editor terms such as `Global Styles`, `Media inserter`, `responsive styles`, `block styles`, or `theme` when they describe the feature clearly.

## Panel Selection

For each recommended panel, decide:

- Panel title.
- One short paragraph explaining what shipped and why it matters.
- Source PR links inline around the relevant words.
- Suggested screenshot or demo.

Good panel candidates are usually:

- Visual changes.
- User-facing feature milestones.
- Improvements that connect multiple PRs into one clear story.
- Work with screenshots, videos, or an obvious trunk demo path.

Poor panel candidates are usually:

- Tiny refactors.
- Test-only changes.
- Dependency chores.
- Internal cleanup with no clear external impact.
- Closed `wordpress-develop` PRs that may not have landed.

## Final Output

Write a PHP composition to `snaps.php`, requiring `patterns/render.php` and using `Snaps\pattern()`. Generate `snaps.html` with the commands in `patterns/README.md`. These replace the previous Markdown deliverable; do not overwrite existing `snaps.md` unless explicitly requested.

After rendering and checking the output, respond with a brief summary and paths to `snaps.php` and `snaps.html`. State that destination-editor validation remains for the human. Do not paste the full post back into chat unless asked.

Always finish with copy/paste instructions. On macOS, tell the human to run `pbcopy < snaps.html` from the repository root and paste directly into the **title field of a new, empty WordPress post** in the visual editor. WordPress puts the initial H1 text into the post title and the remaining blocks into the body automatically. Do not copy to the clipboard automatically unless asked. If the human uses Linux, give the appropriate command for their environment: `wl-copy < snaps.html` on Wayland or `xclip -selection clipboard < snaps.html` on X11, when that utility is installed; otherwise suggest opening the file and copying its contents manually.

Use human-readable dates in the title. Prefer the form `July 6th to July 19th`, not `2026-07-06 to 2026-07-19`. If the range crosses months, include both month names, such as `June 30th to July 13th`.

Use inline links around the relevant claim text. Do not add trailing `Source:` or `Sources:` sentences.

```html
Responsive styles now <a href="https://github.com/WordPress/gutenberg/pull/80223">include contrast checking for viewport and pseudo states</a>.
```

Use `post` exactly once for the H1 title, intro, composed sections, and standard footer. Choose `section-single` for one coherent story or `section-two` for two distinct sets in the same project/area. The two columns can hold equal features, major/minor features, or a headline beside several smaller updates. Columns may contain multiple headings and any sequence of paragraphs, images, galleries, lists, and videos. Read each pattern's parameter contract; preserve styles and nesting in the pattern files rather than reproducing them in the composition.

Inspect PR bodies for relevant screenshots and recordings. Follow the selection, URL checking, and provenance guidance in `patterns/README.md`. Use only supplied or source-supported media; never guess URLs, attachment IDs, or VideoPress attributes. If no suitable media is available, use an empty `image` with a concrete `suggestion`. Capture instructions and provenance remain in the PHP composition, never in rendered HTML comments or publishable copy.

Keep the publishable post copy concise. Rendered HTML contains only the post draft, without guidance comments, review notes, or omitted-work commentary. Only WordPress block delimiters are emitted as HTML comments.

## Final Checks

Before returning the draft, verify:

- Each highlighted item has a PR link.
- Links are inline around the text they support, with no trailing `Sources:` sentences.
- The post does not try to include every PR.
- There are no `Needs Review`, `Omitted`, or `Lower Priority` sections.
- The title uses human-readable dates.
- A non-engineering teammate can understand the user-facing value of each panel.
- Each paragraph explains the user-facing improvement before any technical detail.
- Technical terms are omitted or briefly grounded in user impact.
- Suggested media is concrete enough for the human to capture.
- PHP lint and rendering succeed without warnings; output contains no PHP or Markdown formatting.
- The post uses the main pattern, with one H1, an intro, sections containing exactly one or two columns, and the standard footer.
- Block opening/closing comments match, JSON attributes are valid, and HTML nesting is intact. Pattern wrapper styles are preserved.
- Media URLs come from inspected sources; missing media uses empty Image blocks with capture suggestions. No example upload URLs remain.
- The human can paste the output into an empty post's title field to populate the title and body automatically, then review/edit native blocks. Do not claim destination-editor validation without performing it.
