# Kalkan Website — Project Status

## Last updated: 2026-03-31

## Completed
- Cleaned 67K mailing list → 53,824 valid contacts, uploaded to FluentCRM
- Newsletter subscribe section on homepage (email + KVKK/Privacy consent + "Abone Ol" button)
- Unsubscribe page live at /unsubscribe (template assigned)
- 301 redirects: /en/home-english/ → /en/, /en/how-to-use-kalkan-app/ → /en/how-to-use-kalkan/
- 301 redirects for wrong English slugs: gizlilik-politikasi, iletisim, blog-2
- Polylang front page checkbox enabled
- GSC "Validate Fix" triggered for crawled-not-indexed pages
- Homepage vertical padding compacted
- Brevo SMTP configured in FluentSMTP, domain authenticated
- Promo email HTML template ready (kalkan-child/email-templates/kalkan-promo-tr.html)
- Mail-tester score: 9.2/10
- Sitemap verified working (sitemap.xml, 3 sub-sitemaps)

## TODO — Next session (WP Admin tasks)
- [ ] Fix English page slugs in WP Admin:
  - /en/gizlilik-politikasi/ → change slug to `privacy-policy`
  - /en/iletisim/ → change slug to `contact`
  - /en/blog-2/ → change slug to `blog`
  - /en/how-to-use-kalkan-app/ → change slug to `how-to-use-kalkan`
- [ ] GSC: delete old sitemap submission → resubmit `sitemap.xml`
- [ ] Send first promo batch (start with 50 contacts, increase daily)
- [ ] Test subscribe form on homepage (check contact appears in FluentCRM)
- [ ] Test unsubscribe page (/unsubscribe)
- [ ] Verify redirects work (/en/home-english/ and /en/how-to-use-kalkan-app/)
- [ ] Monitor iCloud spam delivery — ask contacts to mark "Not Junk" to build reputation
- [ ] Plan: migrate from Brevo to Amazon SES for full 54K list (Android launch)

## X/Twitter Marketing Plan (April 2026)

### Strategy: X Ads App Install Campaign + Organic Content

**Why not full automation:** X bans automated engagement (likes/replies/follows). Account suspension risk is high. Instead: use X Ads for paid reach, manual engagement for organic growth.

### Step 1 — Profile Setup (Today, 30 min, free)
- [ ] Set @KalkanApp profile picture: app logo
- [ ] Create header banner: app screenshots + "Spam aramaları engelle" + App Store badge
- [ ] Bio: "Kalkan — iPhone'unuzu spam aramalardan korur. Ücretsiz indir 👇" + App Store link
- [ ] Pin one strong tweet: app demo/screenshots + download link

### Step 2 — X Ads App Install Campaign (Tomorrow, $5/day)
- [ ] Go to ads.x.com → Create campaign → "App Installs"
- [ ] Target: Turkey, iOS users, Turkish language, age 25-55
- [ ] Budget: $5/day to start
- [ ] Creative: best tweet with app video/screenshots
- [ ] Track: cost per install, click-through rate

### Step 3 — Daily Organic Routine (20 min/day, free)
- [ ] Post 1 tweet/day (batch-create weekly content in advance)
- [ ] 15 min genuine replies in Turkish tech/telecom conversations
- [ ] 80/20 rule: 80% value content, 20% app promotion
- [ ] Use X's built-in scheduler to queue posts

### Content Ideas (first week)
- Thread: "Türkiye'de spam arama sorunu ve çözümü"
- Tip: "iPhone'unuzda bilinmeyen aramaları nasıl engellersiniz?"
- Stats: "Türkiye'de günde X spam arama yapılıyor"
- User story: "Kalkan kullanıcıları ne diyor?"
- Behind the scenes: app development story

### Growth Milestones
- Week 1-2: Profile setup + ads running, ~10-50 organic followers
- Month 1: 100-300 followers with daily effort
- 500+ followers: organic posts start getting natural reach
- Then consider: Grok Premium, influencer collabs, increased ad budget

### Budget
- Start: $5/day X Ads = ~$150/month
- Scale when CPI (cost per install) data proves ROI
- Future: consider Amazon SES for email + X Ads combo

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
