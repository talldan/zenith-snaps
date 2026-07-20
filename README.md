# Zenith Snaps Data

Small helper script for collecting candidate PRs for Zenith Team Snaps.

## Usage

```sh
./generate-snaps-data.sh 2026-07-06 2026-07-19
```

The script writes two files in the current directory:

- `gutenberg_merged.json`: merged PRs in `WordPress/gutenberg` authored by Zenith team members during the date range.
- `wordpress-develop_closed.json`: closed PRs in `WordPress/wordpress-develop` authored by Zenith team members during the date range.

The date range is inclusive and uses GitHub search date syntax: `YYYY-MM-DD..YYYY-MM-DD`.

## Notes

- Requires the GitHub CLI: `gh`.
- Run `gh auth login` first if you are not already authenticated.
- `wordpress-develop` PRs are closed when completed and committed separately via SVN, so review those results before including them in Snaps.
- The script intentionally does not generate a draft post yet. Use the JSON files as raw source data for the Snaps draft.
