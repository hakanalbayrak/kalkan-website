# Kalkan Website Repository

This repository is the infrastructure and documentation foundation for the Kalkan website.

It is intentionally separate from day-to-day WordPress content editing and is designed to stay lightweight, production-safe, and easy to extend over time.

## How This Connects to WordPress

- Live site: `kalkan.website`
- CMS/runtime: WordPress (with Blocksy theme stack)
- Content (pages, posts, media): managed in WordPress admin
- This repo: manages structure, project docs, and future custom logic (child theme/plugin level)

## Repository Folders

- `docs/`: Core documentation and long-term project rules/knowledge.
- `content/`: Structured content assets and export-ready editorial/source files.
- `theme/kalkan-child/`: Child theme area for controlled custom PHP/CSS overrides.
- `plugins/kalkan-tools/`: Custom plugin area for site-specific utility logic.

## Guiding Principle

Markdown documentation in this repository is the persistent source of truth for project intent, structure, and implementation direction.
