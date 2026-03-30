# Kalkan Website — Project Status

## Last updated: 2026-03-30

## Completed
- Cleaned 67K mailing list → 53,824 valid contacts, uploaded to FluentCRM
- Newsletter subscribe section on homepage (email + KVKK/Privacy consent + "Abone Ol" button)
- Unsubscribe page live at /unsubscribe (template assigned)
- 301 redirects: /en/home-english/ → /en/, /en/how-to-use-kalkan-app/ → /en/how-to-use-kalkan/
- Polylang front page checkbox enabled
- GSC "Validate Fix" triggered for crawled-not-indexed pages
- Homepage vertical padding compacted
- Brevo SMTP configured in FluentSMTP, domain authenticated
- Promo email HTML template ready (kalkan-child/email-templates/kalkan-promo-tr.html)
- Mail-tester score: 9.2/10

## TODO — Next session
- [ ] Send first promo batch (start with 50 contacts, increase daily)
- [ ] Test subscribe form on homepage (check contact appears in FluentCRM)
- [ ] Test unsubscribe page (/unsubscribe)
- [ ] Verify redirects work (/en/home-english/ and /en/how-to-use-kalkan-app/)
- [ ] Change English "how to use" page slug from how-to-use-kalkan-app to how-to-use-kalkan in WP Admin
- [ ] Monitor iCloud spam delivery — ask contacts to mark "Not Junk" to build reputation
- [ ] Plan: migrate from Brevo to Amazon SES for full 54K list (Android launch)

## Email campaign notes
- Sending via Brevo free tier (300/day limit)
- Warm-up schedule: 50 → 150 → 300/day to build domain reputation
- Plain text version should be added alongside HTML in FluentCRM
- 2,249 confirmed iOS users for first campaign

## Key files
- `kalkan-child/functions.php` — subscribe/unsubscribe AJAX handlers, 301 redirects
- `kalkan-child/front-page.php` — homepage with subscribe section
- `kalkan-child/page-unsubscribe.php` — unsubscribe page template
- `kalkan-child/email-templates/kalkan-promo-tr.html` — promo email template
- Cleaned mailing list: `~/Downloads/LE_v7_fluentcrm.csv`
