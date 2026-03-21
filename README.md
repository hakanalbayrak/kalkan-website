# Kalkan Website Repository

This repository is the durable documentation and structure layer for the Kalkan website.

WordPress handles page/content publishing at `kalkan.website`. This repository keeps long-term project memory, implementation rules, and future custom logic in version control.

## Website Purpose

- Acquisition: bring qualified users via search and educational content.
- Trust: provide clear, credible information and transparent policy pages.
- App Store conversion: route relevant users from web intent to app install intent.
- Community-growth support: support reporting and education loops around spam/scam awareness.

## Core Pages

- Home
- Number Lookup
- Blog / Guides
- Privacy Policy
- Terms
- Contact / Support

## Relationship to App and Backend

- The app is the main product surface for protection/reporting workflows.
- The website supports discovery, SEO acquisition, and user education.
- Future number lookup features may use community spam signals from backend-supported systems.

## Repository Folders

- `docs/`: durable documentation and decisions.
- `content/`: content assets/drafts/export-ready source material.
- `theme/kalkan-child/`: child-theme customizations when needed.
- `plugins/kalkan-tools/`: lightweight custom plugin logic when needed.

## Working Approach

- Lightweight WordPress + Blocksy.
- Minimal plugins.
- Mobile-first and SEO-first execution.
- No unnecessary frameworks/build systems.
- Markdown documents in this repo are the durable source of truth, not chat history.
