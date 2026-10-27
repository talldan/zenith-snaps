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

min_gh_version="2.103.0"
gh_version="$(gh --version | sed -E -n '1s/^gh version ([0-9]+\.[0-9]+(\.[0-9]+)?).*/\1/p')"
if [ -z "$gh_version" ] || ! printf '%s\n%s\n' "$min_gh_version" "$gh_version" | sort -V -C 2>/dev/null; then
	printf 'Error: gh %s or newer is required (found %s). Please upgrade gh (e.g. `brew upgrade gh`).\n' "$min_gh_version" "${gh_version:-unknown}" >&2
	exit 1
fi

from="$1"
to="$2"
range="$from..$to"
data_dir="data"

# GitHub CLI advanced issue search requires explicit OR arguments between author
# qualifiers. Multiple qualifiers without OR are ANDed together.
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
