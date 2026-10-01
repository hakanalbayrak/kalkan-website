# Kalkan Website Decisions Log

## 2026-09-27 — Turkey search-intent content architecture

- Broad `numara sorgulama` intent is assigned to the category hub; the detailed guide uses the unique `/numara-sorgulama-ucretsiz/` slug so it no longer collides with a category archive.
- The duplicate `/numara-sorgulama-rehberi/` archive is consolidated into `/numara-sorgulama/` with preserved post assignments and a permanent redirect.
- Core articles target distinct intents: free number lookup, `bu numara kime ait`, `spam arama ne demek / engelleme`, and `telefon dolandırıcılığı nasıl anlaşılır`.
- Public copy must distinguish open-source signals from proof of identity, explain caller-ID spoofing and number reassignment, and avoid presenting Kalkan as a private-person reverse directory.
- Fraud reporting copy follows official EGM guidance: preserve available evidence and contact law enforcement or the public prosecutor; use 112 for an immediate emergency. The obsolete `BTK 137` claim was removed.
- Homepage and archive hubs provide descriptive internal links to the four core guides. Visible article FAQs have matching FAQPage structured data.

This file records durable website/growth decisions.

## Decision 001

- Short title: Documentation is durable memory
- Date or commit reference: 2026-03-21
- Decision: Markdown docs in this repository are the persistent source of truth for website/growth direction.
- Rationale: Chat context is transient; versioned docs keep institutional memory reliable.

## Decision 002

- Short title: Lightweight WordPress approach
- Date or commit reference: 2026-03-21
- Decision: Use lightweight WordPress + Blocksy with minimal plugins and no unnecessary frameworks/build tooling.
- Rationale: Reduces complexity and maintenance risk while keeping extension paths open.

## Decision 003

- Short title: Core pages baseline
- Date or commit reference: 2026-03-21
- Decision: Core pages are Home, Number Lookup, Blog / Guides, Privacy Policy, Terms, and Contact / Support.
- Rationale: Covers acquisition, trust, compliance, support, and conversion fundamentals.

## Decision 004

- Short title: Website-app-backend role split
- Date or commit reference: 2026-03-21
- Decision: App remains primary protection/reporting surface; website focuses on discovery/education; future web lookup may use community spam signals.
- Rationale: Keeps product roles clear while preserving a path for future community-informed lookup capabilities.

## Decision 005

- Short title: Homepage V1 trust + App Store conversion structure
- Date or commit reference: 2026-03-21
- Decision: Adopt a seven-section homepage order (Hero, How It Works, Core Features, Communication Reporting, Trust and Privacy, App Store CTA, FAQ Preview) with simple non-technical copy and clear reporting messaging.
- Rationale: Supports growth, trust, and App Store conversion goals while staying lightweight and easy to implement in WordPress + Blocksy.

## Decision 006

- Short title: Premium-accurate growth messaging
- Date or commit reference: 2026-07-25
- Decision: Website copy must state that General Protection and Communication Reporting are free, while only Extra Protection requires Kalkan Premium. Avoid hard-coded subscription pricing on the website; Apple remains the source of current price and trial eligibility.
- Rationale: Prevents marketing drift from the live StoreKit configuration and reduces future maintenance.

## Decision 007

- Short title: Measure App Store intent without new analytics dependencies
- Date or commit reference: 2026-07-25
- Decision: Reuse the existing GA4 setup to record `app_store_click` events and keep the destination URL centrally configurable for a future App Store Connect campaign link.
- Rationale: Adds useful conversion-funnel evidence without another plugin, SDK, or tracking service.

## Decision 008

- Short title: Keep website mockups aligned with live App Store visuals
- Date or commit reference: 2026-09-07
- Decision: Use the current localized App Store screen sequence (active protection, incoming caller ID, recent calls, Premium, and settings) inside the homepage phone mockups. Serve optimized WebP files at the real iPhone screen ratio and provide a reduced-motion fallback instead of maintaining separate promotional videos.
- Rationale: Prevents the website from drifting behind the released app, removes screenshot-to-frame cropping, and keeps the homepage lightweight and accessible.

## Decision 009

- Short title: Relationship-intent content without keyword cannibalization
- Date or commit reference: 2026-09-13
- Decision: Publish standalone guides only for distinct high-intent questions such as blocking an ex-partner or former employer. Expand existing child, family, and unknown-caller guides when a proposed topic overlaps their search intent. Keep “suspicious” language neutral and distinguish known spam, user reports, and institutional matches.
- Rationale: Captures natural Turkish search demand without creating thin duplicate pages or implying that Kalkan identifies private relationships, guarantees caller identity, or offers manual person lookup.

## Decision 010

- Short title: Keep iOS version history aligned with public App Store releases
- Date or commit reference: 2026-09-17
- Decision: Seed the verified 1.0.7 and 1.0.8 release notes, then check Apple's public Turkish storefront lookup daily at 16:59 Türkiye time. Add a new version to the bilingual version-history pages only when both Turkish and English public lookup results match the Kalkan app ID, bundle ID, version, and release date. Do not show App Review approvals or Pending Developer Release versions as released. Persist only newly observed versions in a WordPress option; the daily check does not write when unchanged.
- Rationale: Prevents the website from claiming a release before users can download it, and removes repetitive manual edits without App Store Connect credentials or a new plugin. WordPress Cron is traffic-driven, so an otherwise idle site may run the check after 16:59 rather than exactly then.

## Decision 011

- Short title: Competitor-intent content without keyword stuffing
- Date or commit reference: 2026-09-22
- Decision: Address searches for Getcontact and similar products through factual, date-stamped comparison guides based on each product's official public documentation. Do not add competitor names to global homepage copy or obsolete meta-keywords fields, imply feature parity, or make unsupported superiority claims.
- Rationale: Satisfies genuine comparison intent and creates a useful organic landing page while protecting accuracy, brand trust, and maintainable SEO.

## Decision 012

- Short title: Keep the homepage critical path first-party and responsive
- Date or commit reference: 2026-09-28
- Decision: Inline the small shared UI stylesheet on the homepage, exclude the header icon from lazy loading, serve responsive phone screenshots, and load AdSense only when a real article ad slot approaches the viewport. Keep official localized App Store badges as local static assets.
- Rationale: Removes the measured render-blocking request and homepage advertising payload, improves mobile image delivery, and preserves article ad revenue without adding a framework or plugin.

## Decision 013

- Short title: Editorial transparency and low-value-content consolidation
- Date or commit reference: 2026-10-01
- Decision: Publish a bilingual editorial policy, show publication/update and editorial-team attribution on every article, and document the primary-source-first review and corrections process. Consolidate the two obsolete thin posts into the maintained spam guide and version history with permanent redirects. Keep useful topic categories indexable while excluding search, author, date, tag, and attachment utility surfaces.
- Rationale: Gives readers and quality reviewers a verifiable content method, avoids word-count padding, preserves useful focused guides, and removes two genuinely thin duplicate pages from the indexable surface.
