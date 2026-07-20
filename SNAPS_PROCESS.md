# Zenith Snaps Process

Zenith Snaps are a short, visual update on the most important work the team shipped during a two-week cycle.

The process is date-based rather than board-based. The rota owner does not need previous sprints or project board items to be tidy before drafting Snaps.

## Quick Start

Ask an agentic AI tool that can read files and run commands:

```text
Generate the Snaps using this repo's process.
```

The agent should read `prompts/agent-runbook.md`, run `./generate-snaps-data.sh FROM TO`, inspect the generated JSON files, and write Markdown copy for a P2 post to `snaps.md`.

If no dates are provided, the agent should use the most recent completed Snaps cycle: Monday two weeks prior through the previous Sunday, inclusive.

## Source Data

The data collection script gathers candidate work from GitHub:

- `WordPress/gutenberg`: merged PRs authored by Zenith team members during the date range.
- `WordPress/wordpress-develop`: closed PRs authored by Zenith team members during the date range.

Generated data is written to:

- `data/gutenberg_merged.json`
- `data/wordpress-develop_closed.json`

`wordpress-develop` PRs are closed when completed and committed separately via SVN, so those items need human verification before publishing.

## Editorial Goals

- Keep the post short and skimmable.
- Do not list every PR.
- Prefer user-facing, visual, milestone-oriented work.
- Group related PRs into sections such as `Media Enhancements`, `Design tools`, or another coherent project area.
- Aim for 2-4 sections with 1-2 panel-style highlights per section.
- Include source PR links for each highlighted item.
- Include screenshot or short demo suggestions for each panel.
- Leave uncertain items out of the post rather than adding review or omitted-work sections.

## Human Review

Before publishing, the rota owner should:

- Confirm any included `wordpress-develop` closed PRs were completed and committed.
- Gather screenshots or short videos for the selected panels.
- Add team updates that GitHub cannot know about, such as AFKs or focus changes.
- Remove anything too small, noisy, uncertain, or not useful for a broader audience.
- Share the draft in `#zenith` or `#zenith-private` for a quick proofread.

## Publishing

- Create a new post on `zenithp2.wordpress.com`.
- Use the existing Zenith Snaps pattern if helpful.
- Paste the AI-generated Markdown copy into the post and make visual/layout adjustments manually.
- Tag the post with `#snaps`, `#zenithsnaps`, and `+snapsp2`.
- Mention whoever is running the division's Thursday Updates.

## Optional Board Cleanup

Project board cleanup can still happen when useful, but it is not required for generating the next Snaps post.
