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
data_dir="data"

# Repeated `author:` qualifiers are ORed together. They must not be joined with
# an explicit `OR`, which GitHub rejects because logical operators apply only to
# text, not to qualifiers. Note that repeating gh's `--author` flag instead would
# silently keep only the last author.
author_query=(
	author:tellthemachines
	author:talldan
	author:andrewserong
	author:ramonjd
	author:aaronrobertshaw
)

json_fields='title,url,author,closedAt,labels,number,repository,state,body'

mkdir -p "$data_dir"
rm -f "$data_dir"/*.json

printf 'Fetching merged Gutenberg PRs for %s...\n' "$range" >&2
gh search prs \
	--repo WordPress/gutenberg \
	--merged \
	--merged-at "$range" \
	--json "$json_fields" \
	--limit 1000 \
	"${author_query[@]}" \
	> "$data_dir/gutenberg_merged.json"

# GitHub's `closed:` qualifier misses PRs it has itself indexed with a closed_at
# inside the range, so search on `updated` (always >= closedAt) and narrow to the
# real closed date locally. The filter runs through gh's built-in jq, so this
# needs no external jq.
printf 'Fetching closed wordpress-develop PRs for %s...\n' "$range" >&2
gh search prs \
	--repo WordPress/wordpress-develop \
	--state closed \
	--updated ">=$from" \
	--json "$json_fields" \
	--limit 1000 \
	"${author_query[@]}" \
	--jq "map(select(.closedAt >= \"$from\" and .closedAt <= \"${to}T23:59:59Z\"))" \
	> "$data_dir/wordpress-develop_closed.json"

cat >&2 <<'DONE'
Wrote:
  data/gutenberg_merged.json
  data/wordpress-develop_closed.json
DONE
