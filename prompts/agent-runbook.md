# Agent Runbook: Draft Zenith Snaps

You are helping draft a Zenith Team Snaps post.

Your default workflow is agent-driven. Do not ask the human to paste JSON files or prompt text if you can read files and run commands locally.

## Inputs

The human should provide or imply a date range, usually in this form:

```text
Draft Zenith Snaps for YYYY-MM-DD to YYYY-MM-DD using this repo's process.
```

If the date range is missing or ambiguous, ask one short clarification question before continuing.

## Files To Read

Read these files before drafting:

- `SNAPS_PROCESS.md`
- `generate-snaps-data.sh`

## Collect Data

Run the data script yourself:

```sh
./generate-snaps-data.sh FROM TO
```

Then read:

- `gutenberg_merged.json`
- `wordpress-develop_closed.json`

If the command fails because `gh` is missing or unauthenticated, explain the blocker and the exact command the human needs to run, such as `gh auth login`.

## Curation Rules

- Use only the generated JSON and any explicit human notes.
- Do not invent impact, project status, screenshots, or completion details.
- Every highlighted work item must cite at least one source PR link.
- Prefer user-facing, visual, milestone-oriented work.
- Group related PRs into coherent stories rather than listing PRs one by one.
- Aim for 2-4 sections.
- Aim for 1-2 panel-style highlights per section.
- Treat `wordpress-develop` closed PRs as candidates that need verification unless the data clearly proves completion.
- Put uncertain work in `Needs Review` instead of presenting it as final.
- Include lower-priority or omitted items separately so the human can override your judgment.

## Panel Selection

For each recommended panel, decide:

- Panel title.
- One short paragraph explaining what shipped and why it matters.
- Source PR links.
- Suggested screenshot or demo.
- Whether the panel is ready to publish or needs human verification.

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

Return Markdown copy suitable for a WordPress P2 post. The human will paste it into the Zenith Snaps pattern and adjust styling/media manually.

Use this structure:

```markdown
# Zenith Team Snaps: YYYY-MM-DD to YYYY-MM-DD

<!-- Suggested media checklist:
- Section: panel title - screenshot/demo suggestion.
-->

## Section Title

### Panel Title

Short, impact-focused copy with [source PR links](https://github.com/...).

### Panel Title

Short, impact-focused copy with [source PR links](https://github.com/...).

## Needs Review

- Items that need human verification before publishing.

## Omitted Or Lower Priority

- Notable candidates you intentionally left out, with brief reasons.
```

Keep the publishable post copy concise. Supporting review notes can be brief, but they should be separate from the main post copy.

## Final Checks

Before returning the draft, verify:

- Each highlighted item has a PR link.
- The post does not try to include every PR.
- `wordpress-develop` closed PRs are marked for verification when needed.
- Suggested media is concrete enough for the human to capture.
