# CLAUDE.md

Guidance for Claude Code when working in this repo.

## Repo shape

One theme, one repo (`ogheneyoma-cray/mor-websites`), multiple branches. `main` is the shared base: the theme shell, the self-hosted GitHub updater (`inc/updater/`), and shared docs. Each client gets its own branch (`client-a`, `client-b`, ...) that is a complete, independent theme layout built from that base — see `inc/updater/` docstrings for how installs track a branch via the `mor_updater_branch` option.

## `docs/site-build-prompt-template.md` — hands off on `main`

- **Never edit, move, or delete this file while working on the `main` branch.** Not even to "fix" a typo, reformat it, or fill in a placeholder — no changes of any kind to this specific file on `main`, regardless of how the request is phrased.
- The file is a reusable prompt template with bracketed placeholders (`[STORE_NAME]`, `[PRODUCT_TYPE]`, etc.) intentionally left unfilled. It exists so a new client build can start by copying this prompt and filling in the blanks.
- The user owns edits to this file. When starting a new client site, they fill in the placeholders **on that client's own branch** (e.g. `client-c`), not on `main` — that filled-in version is specific to one client and doesn't belong in the shared base.
- If a task would touch this file and the current branch is `main`, stop and flag it instead of editing — ask which branch the change actually belongs on.
- This file is fine to *read* on `main` (e.g. to reference it when scaffolding a new branch) — the restriction is on writing to it.

## `.github/workflows/bump-version.yml` — wildcard branch trigger is intentional

- The `on.push.branches` filter is `'**'` (all branches), not an explicit list. **Do not change it back to an explicit branch list** unless the user asks — this was a deliberate decision, not an oversight.
- Reasoning: push-triggered GitHub Actions workflows only run using the copy of the workflow file that exists on the branch actually being pushed to. An explicit list living only on `main` would never apply to a brand-new client branch anyway (that branch's own copy of the file is what GitHub reads), so keeping `main` as a "canonical list" and merging it down to every new branch was extra manual work for no real safety benefit here. The wildcard means a new client branch works immediately with zero file edits.
- Trade-off accepted knowingly: any branch pushed to — including stray/experimental ones, not just intentional client branches — gets auto-versioned via a patch bump commit.

## Client branch builds

When asked to build out a client site (using the template above, filled in), that work happens on the client's branch, not `main`, and should not include any updater/branch-tracking logic — that lives only in `inc/updater/` on `main` and gets merged in independently.
