# Zenith Snaps Data

Small helper script and agent instructions for drafting Zenith Team Snaps.

## Agent-Assisted Drafting

Ask an agentic AI tool that can read files and run commands:

```text
Generate the Snaps using this repo's process.
```

The agent should read `SNAPS_PROCESS.md` and `prompts/agent-runbook.md`, run the data script, inspect the generated JSON files, and return Markdown copy for a WordPress P2 post.

If your AI tool cannot run commands or read local files, run the script manually and upload or paste the generated JSON files plus `prompts/agent-runbook.md`.

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

## Notes

- Requires the GitHub CLI: `gh`.
- Run `gh auth login` first if you are not already authenticated.
- `wordpress-develop` PRs are closed when completed and committed separately via SVN, so review those results before including them in Snaps.
- The script intentionally does not generate a draft post itself. Agents should use the JSON files with `prompts/agent-runbook.md` to draft Markdown copy.
