# Security Action Required — Gaurikrit Website

## .env file previously tracked

The repository previously tracked a `.env` file containing the
`DATABASE_URL` (a local SQLite path — not a network credential). This file
has been untracked and added to `.gitignore`. No secrets should be reproduced
in this document.

## Action required by the repository owner

If any credential may have been committed publicly (e.g. SMTP passwords,
API keys, database credentials), **rotate it immediately**:

1. Change any SMTP password that may have appeared in git history.
2. Change any database password that may have appeared.
3. Check `git log --all -p` for any credential leaks if concerned.

## Current state

- `.env` is gitignored (not tracked).
- `config.php` is gitignored (not tracked). Only `config.example.php` (with
  empty values) is committed.
- SMTP credentials must be configured ONLY on the production server
  (Hostinger) by editing `config.php` directly. They are never in the repo.
- The `.htaccess` denies access to `config.php`, `config.example.php`, `.env`,
  and all `.log` files.

## Confirm

- [x] `.env` ignored
- [x] `config.php` ignored
- [x] Credentials only configured on production server
- [x] `.htaccess` denies access to config and log files
- [x] No secrets in this document
