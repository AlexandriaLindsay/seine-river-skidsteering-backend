# Backend

Small Node/Express service with one job: receive the website's form submissions
and email them to `cal@srskidsteering.ca`. Not Laravel, not a CMS — just a mailer.

## Local development

```bash
npm install
cp .env.example .env   # leave SMTP_HOST unset for now — see below
npm run dev
```

With `SMTP_HOST` unset, it sends through a temporary [Ethereal](https://ethereal.email)
test inbox instead of real email, and logs a preview link for each submission —
useful for testing the form without needing real credentials yet.

## Setting up real email delivery on SiteGround

1. **Create the mailbox.** In SiteGround Site Tools → Email → Accounts, create
   `cal@srskidsteering.ca`.
2. **Get the SMTP settings.** Site Tools → Email → Email Programs → find that
   account → "Manually Configure" shows the outgoing (SMTP) host, port, and
   whether it's SSL. Typically `mail.srskidsteering.ca`, port `465`, SSL on.
3. **Fill in `.env`** (or the Node app's environment variables panel if deploying
   via SiteGround's Node.js App Manager) with those values — see `.env.example`.
4. Restart the app. Submissions will now actually arrive at the mailbox instead
   of going to the Ethereal test inbox.

## Deploying on SiteGround

SiteGround's Node.js hosting runs this as a standard Node app (Site Tools →
Devs → Node.js App Manager): point it at this `backend/` folder, set the
environment variables from `.env.example`, and it starts `npm start`.

Also set `CORS_ORIGIN` to the deployed frontend's URL (e.g.
`https://srskidsteering.ca`) once that's live, so only your own site can call
this API.

## Frontend wiring

The frontend reads the backend's URL from `VITE_API_URL` (see
`frontend/.env.example`). Point it at wherever this backend ends up running.
