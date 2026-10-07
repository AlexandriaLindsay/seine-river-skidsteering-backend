# Backend

Node/Express service that does two things:

1. Serves the built frontend (`public/`) as static files, so the whole site
   runs as one app on one domain — no separate static hosting needed.
2. Handles `POST /api/contact`, emailing submissions to `cal@srskidsteering.ca`.

This is the deploy repo — it's a subtree split of `backend/` from the main
[seine-river-skidsteering](https://github.com/AlexandriaLindsay/seine-river-skidsteering)
repo, kept separate so `package.json` sits at the root (required by
SiteGround's Node.js App Manager git import).

## Local development

```bash
npm install
cp .env.example .env   # leave SMTP_HOST unset for now — see below
npm run dev
```

With `SMTP_HOST` unset, it sends through a temporary [Ethereal](https://ethereal.email)
test inbox instead of real email, and logs a preview link for each submission —
useful for testing the form without needing real credentials yet.

## Rebuilding after a frontend change

The `public/` folder is a committed build artifact, not generated on
SiteGround. After changing anything in `frontend/`, from the main monorepo:

```bash
cd frontend && npm run build
rm -rf ../backend/public && cp -r dist ../backend/public
```

Then re-split and push to this deploy repo (from the main monorepo root):

```bash
git add backend/ && git commit -m "..."
git subtree split --prefix=backend -b backend-only
git push https://github.com/AlexandriaLindsay/seine-river-skidsteering-backend.git backend-only:main
git branch -D backend-only
```

SiteGround auto-deploys on push if that's enabled on the Node app.

## Setting up real email delivery on SiteGround

1. **Create the mailbox.** In SiteGround Site Tools → Email → Accounts, create
   `cal@srskidsteering.ca`.
2. **Get the SMTP settings.** Site Tools → Email → Email Programs → find that
   account → "Manually Configure" shows the outgoing (SMTP) host, port, and
   whether it's SSL. Typically `mail.srskidsteering.ca`, port `465`, SSL on.
3. **Fill in the Node app's environment variables** (Node.js App Manager →
   this app → environment variables) with those values — see `.env.example`
   for the full list.
4. Restart the app. Submissions will now actually arrive at the mailbox
   instead of going to the Ethereal test inbox.

## Domain

Point `srskidsteering.ca` itself at this Node app (not a subdomain) — it
serves the whole site. `CORS_ORIGIN` only matters if something *other* than
this app's own frontend calls the API, so `*` is fine to leave as-is here.
