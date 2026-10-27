# Zenith Snaps

Data collection, block patterns, and agent instructions for composing editable Zenith Team Snaps posts.

## Agent-Assisted Drafting

Ask an agentic AI tool that can read files and run commands:

```text
Generate the Snaps using this repo's process.
```

The agent should read `SNAPS_PROCESS.md` and `prompts/agent-runbook.md`, run the data script, inspect the generated JSON files, and compose `snaps.php` using the documented [PHP patterns](patterns/README.md). Running the composition produces `snaps.html`, editable block markup ready to paste into the title field of an empty WordPress post.

If your AI tool cannot run commands or read local files, run the data script manually and supply the generated JSON files, `SNAPS_PROCESS.md`, `prompts/agent-runbook.md`, and the `patterns/` directory. Save its composition as `snaps.php` in the repository root and run the PHP commands below locally to generate the HTML.

## Usage

You can also run the data collection script directly:

```sh
./generate-snaps-data.sh 2026-07-06 2026-07-19
```

The script writes two files in the `data` directory:

- `data/gutenberg_merged.json`: merged PRs in `WordPress/gutenberg` authored by Zenith team members during the date range.
- `data/wordpress-develop_closed.json`: closed PRs in `WordPress/wordpress-develop` authored by Zenith team members during the date range.

The date range is inclusive and uses GitHub search date syntax: `YYYY-MM-DD..YYYY-MM-DD`.
Each run removes the previous generated JSON files before writing fresh data.

### Compose and render

The data script only collects candidates. The agent curates those results and writes `snaps.php`; PHP then renders the composition into `snaps.html`:

```sh
php -l snaps.php
php -d display_errors=stderr -d error_reporting=E_ALL snaps.php > snaps.html.tmp && mv snaps.html.tmp snaps.html
```

Check for PHP warnings or errors before using the output. See [the pattern documentation](patterns/README.md) for composition examples and review checks. Generated drafts are ignored by Git.

### Copy into WordPress

On macOS, copy the rendered markup from the repository root:

```sh
pbcopy < snaps.html
```

Paste into the **title field of a new, empty post** in the visual editor. WordPress puts the initial H1 text into the post title and the remaining blocks into the post body automatically.

Review the editable blocks, sources, and media before publishing. Replace empty Image blocks using the capture suggestions in `snaps.php`. See [the publishing process](SNAPS_PROCESS.md#publishing) and [Linux clipboard commands](patterns/README.md#review-and-publishing).

## Notes

- Requires GitHub CLI 2.103.0+ and PHP 8.0+ CLI for composing posts. No WordPress installation or Composer dependencies are needed locally.
- Run `gh auth login` first if you are not already authenticated.
- `wordpress-develop` PRs are closed when completed and committed separately via SVN, so review those results before including them in Snaps.
- The data script collects candidates; agents curate the JSON using `prompts/agent-runbook.md` and compose the post with `patterns/`. Generated drafts are ignored by Git.
- The post pattern includes an H1 title so pasting into an empty post's title field populates both the title and body.
