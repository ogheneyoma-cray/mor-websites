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

## WooCommerce integration pitfalls hit on the `digitaldrum-networks` build

These are recurring WooCommerce/theme-integration bugs discovered while building that client branch — not `main`-specific code, but worth checking for on every future WooCommerce client branch since the root causes are generic to "classic PHP theme + WooCommerce" and easy to reintroduce.

- **Shop/product grid squeeze**: if `ul.products` is styled `display: grid` for a custom card layout, WooCommerce's own stylesheet still puts a float-era clearfix on it (`::before`/`::after { content: ""; display: table; }`) — those pseudo-elements become real grid items once the parent is `display: grid`, shifting every actual product one column over. Cancel them explicitly (`content: none; display: none;`). Separately, WooCommerce's default `li.product` still carries its own percentage `width`/`float`/`margin` (sized for the old float grid) which nests inside your grid track's own percentage width and compounds into a squeeze — reset `width: auto; float: none; margin: 0;` on `li.product` explicitly rather than assuming `display: grid` on the parent is enough.
- **Cart page silently on the block editor**: WooCommerce creates the **Cart** page using the block-based cart by default — only **Checkout** needs to be explicitly forced to the classic `[woocommerce_cart]`/`[woocommerce_checkout]` shortcodes (checkout already gets this via `mor_force_classic_checkout()` in `inc/woocommerce-support.php`, for payment-gateway-plugin compatibility). Any custom CSS written against classic cart markup (`table.cart`, `.cart_totals`, etc.) silently does nothing if the Cart page is still block-based — add the equivalent `mor_force_classic_cart()` guard alongside the checkout one on every WooCommerce client branch, not just this one.
- **Checkout's `.col2-set` two-column layout getting scrambled**: WordPress loads block-library CSS globally regardless of whether the active theme is a block theme, and something in that global cascade can set its own `grid-template-rows` on elements shaped like `.col2-set` (billing/order-review two-column checkout), scrambling grid auto-placement — one column ends up in the other's track, and the second column wraps below instead of beside. Don't rely on grid auto-placement for this element; pin `grid-column`/`grid-row` explicitly on `.col-1`/`.col-2` rather than fighting cascade order.
- **`wp_page_for_privacy_policy` placeholder**: WordPress auto-creates a "Privacy Policy" page on every fresh install as a **draft**, pre-filled with WordPress's own generic "Suggested text:" boilerplate (GDPR/comments/Gravatar language, not specific to the business). A content importer that does `get_page_by_path( 'privacy-policy' )` and skips if found will treat that draft as "already imported" and leave WordPress's placeholder live forever, never writing the real policy. Check the found page's content for a marker string unique to your real copy before deciding to skip vs. overwrite+publish, on every future client branch that ships its own Privacy Policy content.
- **`get_theme_mod()` default only applies when the mod was never set** — if the Customizer field for something like `company_phone` is ever saved blank, `get_theme_mod( 'company_phone', $fallback )` returns `''` forever, not `$fallback`, since the mod now exists with an empty value. Any template printing that value (a `tel:` link, an address line) should check for emptiness and hide the row rather than assume the coded default always shows.
