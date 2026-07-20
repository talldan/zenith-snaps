#!/usr/bin/env bash

set -euo pipefail

if [ "$#" -ne 2 ]; then
	cat >&2 <<'USAGE'
Usage: ./generate-snaps-data.sh FROM TO

Example:
  ./generate-snaps-data.sh 2026-07-06 2026-07-19
USAGE
	exit 1
fi

if ! command -v gh >/dev/null 2>&1; then
	printf 'Error: gh is required. Install GitHub CLI and authenticate with `gh auth login`.\n' >&2
	exit 1
fi

from="$1"
to="$2"
range="$from..$to"

author_query=(
	author:tellthemachines
	OR
	author:talldan
	OR
	author:andrewserong
	OR
	author:ramonjd
	OR
	author:aaronrobertshaw
)

json_fields='title,url,author,closedAt,labels,number,repository,state,body'

printf 'Fetching merged Gutenberg PRs for %s...\n' "$range" >&2
gh search prs \
	--repo WordPress/gutenberg \
	--merged \
	--merged-at "$range" \
	--json "$json_fields" \
	--limit 1000 \
	"${author_query[@]}" \
	> gutenberg_merged.json

printf 'Fetching closed wordpress-develop PRs for %s...\n' "$range" >&2
gh search prs \
	--repo WordPress/wordpress-develop \
	--closed "$range" \
	--json "$json_fields" \
	--limit 1000 \
	"${author_query[@]}" \
	> wordpress-develop_closed.json

cat >&2 <<'DONE'
Wrote:
  gutenberg_merged.json
  wordpress-develop_closed.json
DONE
