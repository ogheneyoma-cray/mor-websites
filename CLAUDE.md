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

## `.github/workflows/bump-version.yml` — runs on every branch except `main`

- The trigger is `branches-ignore: [main]`, not an explicit allowlist and not `main`-inclusive. **Do not change this** unless the user asks — it encodes two deliberate decisions, not an oversight.
- Reasoning for "all branches, not an explicit list": push-triggered GitHub Actions workflows only run using the copy of the workflow file that exists on the branch actually being pushed to. An explicit list living only on `main` would never apply to a brand-new client branch anyway (that branch's own copy of the file is what GitHub reads), so keeping `main` as a "canonical list" and merging it down to every new branch was extra manual work for no real safety benefit here.
- Reasoning for excluding `main`: **`main` is pinned at `Version: 1.0.0` in `style.css`, permanently.** It's the shared base branch client branches are cut from, not a site anything actually tracks in production, so its version number has no meaning to auto-increment. Earlier, `main` was included in the wildcard and drifted to 1.0.4+ purely from docs/config commits — this caused a real bug: a client branch tracking a lower version number than what `main` had drifted to would fail to show as an update. Excluding `main` from this workflow prevents that class of bug from recurring, on top of just being the correct semantic (main isn't versioned).
- If `main`'s version is ever found to be something other than `1.0.0`, that's a bug — reset it to `1.0.0` rather than treating the drifted number as correct.
- Trade-off accepted knowingly: any *non-main* branch pushed to — including stray/experimental ones, not just intentional client branches — still gets auto-versioned via a patch bump commit.

## Client branch builds

When asked to build out a client site (using the template above, filled in), that work happens on the client's branch, not `main`, and should not include any updater/branch-tracking logic — that lives only in `inc/updater/` on `main` and gets merged in independently.
