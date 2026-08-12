#!/usr/bin/env bash
set -e
cd "$(dirname "$0")/.."
for f in tests/test-*.php; do
	echo "############################################"
	echo "# $f"
	echo "############################################"
	php "$f"
	echo
done
echo "All test suites passed."
