# Bright Today Foundation — Website & Admin Panel

Core PHP + MySQL (production) / PostgreSQL (local dev) + TailwindCSS. See
`C:\Users\USER\.claude\plans\velvet-bubbling-unicorn.md` for the original build plan.

## Project Layout

```
app/            Core PHP application (never web-accessible)
  core/         Database, Auth, Csrf, Session, Router, Uploader, Sanitizer, RateLimiter, View, Mailer
  models/       One class per database table
  views/        public/ (site pages), admin/ (admin panel), partials/ (layout, header, footer)
database/       schema.sql + seed.sql (MySQL/production), schema.pgsql.sql + seed.pgsql.sql (local dev)
public_html/    Web root — point your domain/vhost here
  admin/        Admin panel (login-protected)
  assets/       Compiled CSS, self-hosted fonts, JS, images/logo/favicons
  uploads/      User-uploaded images & PDFs (team photos, blog images, gallery, legal docs)
storage/logs/   PHP error log + local dev mail log
tailwind-src/   Dev-only Tailwind CLI project — never uploaded to the server
router.php      Dev-only router for `php -S` (mimics the .htaccess rewrite locally)
```

## Local Development

Requires PHP 8.1+, and either PostgreSQL (recommended for local dev) or MySQL.

1. Copy `.env.example` to `.env` and fill in DB credentials. `DB_DRIVER` accepts `pgsql` or `mysql`.
2. Create the database and load the schema + seed data:
   - **Postgres**: `psql -U <user> -c "CREATE DATABASE brighttoday_dev;"` then
     `psql -U <user> -d brighttoday_dev -f database/schema.pgsql.sql` and `... -f database/seed.pgsql.sql`
   - **MySQL**: create a DB via your client, then import `database/schema.sql` and `database/seed.sql`
3. Build the CSS once (or `npm run watch:css` while working on styles):
   ```
   cd tailwind-src && npm install && npm run build:css
   ```
4. Start the dev server from the project root:
   ```
   php -S 127.0.0.1:8000 -t public_html router.php
   ```
   The `-t public_html` is required so PHP's built-in server serves static
   assets and other PHP files (e.g. `/admin/login.php`) from `public_html`
   when `router.php` returns `false` — without it, the server falls back to
   the project root and every non-`/` request 404s.
5. Visit `http://localhost:8000/` and `http://localhost:8000/admin/login.php`.

**Default admin login** (seeded by `seed.sql`/`seed.pgsql.sql`): username `admin`, password
`BrightToday@2026`. **Change this password immediately** via Admin → Profile after first login,
in every environment including production.

> Note: `database/schema.pgsql.sql` / `seed.pgsql.sql` exist only to make local development easy
> without installing MySQL. Production always uses `schema.sql` / `seed.sql` (MySQL) per the
> client's cPanel hosting requirement — keep both pairs of files in sync when the schema changes.

## Content Already Loaded

The seed data includes the foundation's real content extracted from their source documents:
org info, PAN/12A/80G registration numbers, the 3 focus areas, founder & co-founder bios, and
the 12A/80G PDF certificates (copied into `public_html/uploads/legal/`). Everything is editable
from the admin panel afterwards (Page Content, Focus Areas, Team, Site Settings, Legal Documents).

**Known gap to fill in before launch:**
- Donation bank account / UPI details are blank in Site Settings → fill in before going live.
- The Trust Deed scan (in the original source folder) was deliberately **not** uploaded as a
  public legal document — it shows the founder's full Aadhaar number. If it should ever be shown
  publicly, redact the Aadhaar number first.
- No real program photography or blog posts are seeded yet — add via Admin → Gallery / Blog.
- Google Analytics ID, Maps embed, and social links are blank — fill in via Site Settings.

## Deploying to cPanel (Production)

1. **Database**: cPanel → MySQL Databases → create a database and a DB user with a strong
   password; assign the user to the database (avoid "ALL PRIVILEGES" if the host allows scoping).
2. **Import schema**: phpMyAdmin → select the DB → Import → `database/schema.sql`, then
   `database/seed.sql`. Log in immediately and change the seeded admin password.
3. **Upload files**: Put `public_html/*` into the account's `public_html`. Put `app/`, `database/`,
   `storage/` **above** `public_html` (in the account root) if your host allows it — this is the
   safest layout. If your host only exposes a single `public_html` root, move those three folders
   inside `public_html` instead; their `.htaccess` files (`Require all denied`) already block
   direct web access as a fallback.
4. **Configure environment**: since there's no `.env` support needed in the simple config loader,
   either create a real `.env` file next to `app/` (outside webroot, same rules as above) with
   `DB_DRIVER=mysql` and real credentials, or edit `app/config/config.php` defaults directly.
   Verify `.env` is not web-accessible by requesting it directly — it must 403/404.
5. **Permissions**: directories `755`, files `644`. `public_html/uploads/*` and `storage/logs`
   must be writable by the PHP process (755 is normally sufficient on cPanel).
6. **PHP version**: cPanel → MultiPHP Manager → PHP 8.1+ for the domain. Confirm `pdo_mysql`,
   `mbstring`, `fileinfo`, `gd`, `openssl` extensions are enabled.
7. **SSL**: cPanel → SSL/TLS Status → run AutoSSL. Then uncomment the HTTPS-redirect and HSTS
   lines in `public_html/.htaccess`.
8. **Email**: contact/volunteer/donation notifications currently just log to
   `storage/logs/mail.log` outside production. In production, `Mailer` uses PHP's `mail()` via
   the server's local MTA — confirm outbound mail works, and consider adding SPF/DKIM records in
   cPanel's Zone Editor so notifications don't land in spam.
9. **Smoke test**: click every page, submit every form (Contact, Volunteer/Partner, Donate
   pledge), log into `/admin`, confirm `.env`/`app/`/`database/` are not publicly downloadable,
   and confirm the legal PDFs on `/transparency` open correctly.

## Deploying to Hostinger Cloud (Startup plan)

Hostinger Cloud uses **hPanel** (not cPanel) on a LiteSpeed web server. LiteSpeed reads the same
`.htaccess` syntax already in `public_html/.htaccess` (RewriteEngine, Header directives, etc.), so
nothing needs to change there. Cloud plans include SSH access and a phpMyAdmin-based database
manager, which makes this close to the generic cPanel steps above with different menu names.

1. **Point the domain**: if the domain isn't already on Hostinger, add it in hPanel → **Websites**
   and either change the domain's nameservers to Hostinger's or add Hostinger's IP as an A record
   at your registrar. Skip this if you're deploying to a domain already managed by Hostinger.
2. **Create the database**: hPanel → **Databases → MySQL Databases** → create a new database and
   a database user with a strong password, then attach the user to the database. Note the DB name,
   username, password, and host (Hostinger normally uses `localhost`).
3. **Import schema**: hPanel → **Databases → phpMyAdmin** → open the new database → **Import** →
   upload `database/schema.sql`, then import `database/seed.sql` the same way.
4. **Enable SSH** (recommended): hPanel → **Advanced → SSH Access** → toggle it on and note the
   host/port/username it gives you. This makes upload and permissions much faster than the File
   Manager for a project with this many files.
5. **Find your site's home path**: SSH in and run `pwd` from your home directory, or check hPanel
   → **Files → File Manager**. Hostinger's layout is normally
   `/home/u<account-id>/domains/yourdomain.com/`, with `public_html` as a subfolder of that.
6. **Upload the files**:
   - Via SSH: `scp -r` or `rsync` the project up, or `git clone` it directly on the server if the
     repo is in git. Put `public_html/*` inside the existing `.../domains/yourdomain.com/public_html`,
     and put `app/`, `database/`, `storage/` as siblings of `public_html` (i.e. directly under
     `.../domains/yourdomain.com/`) — this is the safe "preferred layout" from the plan, and
     Hostinger Cloud's home-directory structure supports it.
   - Via File Manager (no SSH): zip the project locally (exclude `tailwind-src/node_modules`,
     `.git`, and your real `.env`), upload the zip, then use File Manager's **Extract** action —
     much faster than uploading hundreds of files individually.
   - Either way, do **not** upload `tailwind-src/` or `.git/` — they're dev-only.
7. **Create the real `.env`**: place it at `.../domains/yourdomain.com/.env` (next to `app/`,
   `database/`, `public_html/`, `storage/`), with:
   ```
   APP_ENV=production
   APP_URL=https://yourdomain.com
   DB_DRIVER=mysql
   DB_HOST=localhost
   DB_PORT=3306
   DB_NAME=<from step 2>
   DB_USER=<from step 2>
   DB_PASS=<from step 2>
   ```
   Because `.env` sits outside `public_html`, it's not web-reachable at all under this layout —
   no extra `.htaccess` rule needed, but it doesn't hurt to confirm `https://yourdomain.com/.env`
   returns a 404.
8. **PHP version & extensions**: hPanel → **Advanced → PHP Configuration** → select PHP 8.1+ and
   confirm `pdo_mysql`, `mbstring`, `fileinfo`, `gd`, `openssl` are enabled (Hostinger ships these
   enabled by default on Cloud plans, but double-check).
9. **Permissions** (via SSH): `find . -type d -exec chmod 755 {} \;` and
   `find . -type f -exec chmod 644 {} \;` from the project root, then confirm
   `public_html/uploads/` and `storage/logs/` are writable by the site (Hostinger's PHP runs as
   your account user, so 755 on those directories is normally enough — avoid `777`).
10. **SSL**: hPanel → **Security → SSL** (or the SSL card on the website's dashboard) — Hostinger
    auto-issues a free Let's Encrypt certificate once the domain resolves correctly; this can take
    a few minutes to a few hours after DNS propagates. Once it's active, uncomment the HTTPS
    redirect and HSTS lines in `public_html/.htaccess`.
11. **Cron (optional)**: hPanel → **Advanced → Cron Jobs**, for periodic cleanup of old
    `login_attempts` rows or log rotation.
12. **Smoke test**: same checklist as the cPanel section above — every page loads, every form
    submits, `/admin` login works and the default password gets changed immediately, legal PDFs
    open from `/transparency`, and `.env`/`app`/`database` are not publicly reachable.

## Payment Gateway (Future)

The Donate page currently shows bank/UPI details plus an "I've Donated" pledge form
(`donation_pledges` table). The schema already includes nullable columns
(`is_gateway_payment`, `payment_gateway`, `gateway_order_id`, `gateway_payment_id`,
`gateway_signature`, `gateway_status`) so a real gateway (e.g. Razorpay) can be wired in later
without restructuring — add the gateway checkout flow to `public_html/routes.php`'s `/donate`
handler and populate those columns on successful payment.
