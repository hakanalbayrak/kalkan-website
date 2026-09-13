# Kalkan Website Decisions Log

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
