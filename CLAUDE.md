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

## TODO — Next session
- [ ] Verify redirects work (visit /en/home-english/ and /en/how-to-use-kalkan-app/)
- [ ] Test subscribe form on homepage (check contact appears in FluentCRM)
- [ ] Test unsubscribe page (/unsubscribe)
- [ ] Configure FluentCRM email sending (Settings → Email Settings → SMTP/FluentSMTP)
- [ ] Create promo email campaign in FluentCRM
- [ ] Change English "how to use" page slug from how-to-use-kalkan-app to how-to-use-kalkan in WP Admin

## Key files
- `kalkan-child/functions.php` — subscribe/unsubscribe AJAX handlers, 301 redirects
- `kalkan-child/front-page.php` — homepage with subscribe section
- `kalkan-child/page-unsubscribe.php` — unsubscribe page template
- Cleaned mailing list: `~/Downloads/LE_v7_fluentcrm.csv`
