# Contributing to Digimia

Digimia is a WordPress Full Site Editing block theme focused on an Easy Digital Downloads-first digital storefront. This file covers local setup and the expectations for both human and AI contributors.

Read these first:

1. `AGENTS.md` — canonical rules.
2. `docs/ai/README.md` — project map and conventions.
3. `docs/ai/security.md` — secret handling. Non-negotiable.
4. `docs/ai/task-playbooks.md` — workflows.
5. `docs/developer/` — feature docs.

## Requirements

- Node 20+ (verified on 22.15.0) and **Yarn 1** (the repo uses a Yarn 1 `yarn.lock`). If `yarn` on your machine is a newer Yarn through Corepack, run Yarn 1 with `npx -y -p yarn@1.22.22 yarn …`.
- PHP 7.4+ (verified on 8.4.6) and Composer 2 (verified on 2.8.8).

## Setup

```bash
yarn install --frozen-lockfile
composer install            # needed for PHP lint/WPCS
git config core.hooksPath .githooks   # enables the secret-scanning pre-commit hook
cp .env.example .env        # only for yarn test:visual
```

`.env` is gitignored. Never commit it.

## Where To Work

| Task | Location |
| --- | --- |
| Design tokens, palettes, block defaults | `theme.json` |
| Style variations | `styles/` |
| Page and section layouts | `patterns/` (PHP files with pattern headers) |
| Templates and template parts | `templates/`, `parts/` — keep them thin |
| Global Sass | `src/scss/` → `style.css` |
| Block Sass | `src/scss/blocks/_core-*.scss` → `assets/styles/` |
| JS | `src/js/` (vanilla front-end) and `src/extensions/` (editor) |
| PHP behavior | `functions.php`, `inc/`, `blocks/` |
| EDD integration | Follow the ladder in the `edd-integration` skill |

### Theme or plugin?

Put it in the **theme** if the free demo uses it, or it is presentation every Digimia site needs. Data or behavior that must outlive the theme (CPTs, taxonomies, shortcodes, REST routes, cron, EDD data hooks, checkout logic) belongs in a plugin. The theme never depends on Digimia Pro.

Edit `src/` first, then rebuild. Generated assets in `assets/` and root `style.css` are tracked; do not hand-edit them.

## Commands

| Task | Command |
| --- | --- |
| Watch Sass/JS | `yarn dev` |
| Production build | `yarn build` |
| Development build | `yarn build:dev` |
| Pattern translation pass | `yarn translate:patterns` |
| PHP syntax lint | `composer run lint` |
| WPCS scan / fix | `composer run wpcs:scan` / `composer run wpcs:fix` |

## Versions and commits

Versions follow [Semantic Versioning](https://semver.org): in `1.2.3`, raise the last number for a fix, the middle one for a new feature (the last goes back to 0), and the first for a change that breaks existing sites, such as a removed pattern or a renamed block style (the other two go back to 0). The version lives in `style.css` (`Version`), with a changelog entry for each release in `readme.txt`; `docs/developer/release-checklist.md` has the release steps.

Commit messages follow [Conventional Commits](https://www.conventionalcommits.org):

```
fix(patterns): keep the space before a bold word

A body, wrapped at 72 characters, that says what changed and why.
```

- The subject is `type(scope): summary`, 72 characters at most, in the imperative ("add", not "added"), lowercase after the colon, with no period.
- Types: `feat` (a new feature), `fix` (a bug fix), `refactor` (same behavior, better code), `perf`, `docs`, `style` (formatting only), `build` (build tools and dependencies), `ci`, `test`, and `chore`.
- The scope names the area: `patterns`, `styles`, `blocks`, `edd`, `tools`, `docs`, and so on. It is optional.
- A breaking change adds `!` after the type (`feat(patterns)!: …`) and says what breaks in the body.
- One logical change per commit.

## Pull Requests

- Keep changes scoped. One concern per PR.
- Stage explicit paths. Do not use `git add .`.
- Include rebuilt assets when you changed `src/`.
- Update `docs/developer/` when behavior changes.
- Verify per the `verification` skill; state what you ran and what you could not.

## AI Contributors

- The project uses Claude Code. Rules: `AGENTS.md` (loaded through `CLAUDE.md`).
- Skills: `.claude/skills/`.

Start Claude Code from this directory so the project instructions and skills load. The WordPress root is not a git repository.

## Secrets

If you ever see a credential in a tracked file, stop and follow `docs/ai/security.md`. Rotating the credential is always required, even if the file is deleted in the same commit.
