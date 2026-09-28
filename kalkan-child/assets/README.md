# Kalkan Theme Assets

This directory contains visual assets used by the code-rendered homepage.

## Paths

- `assets/badges/app-store-badge-tr.svg`
- `assets/badges/app-store-badge-en.svg`
- `assets/images/iphone-frame.svg`
- `assets/images/app-screenshot-home.svg`
- `assets/images/app-screens/`: localized, optimized screenshots used by the homepage phone mockups.

## Notes

- Localized App Store badges are the official Apple Marketing Tools SVG assets,
  served locally to avoid a third-party render-path request.
- Do not add Google Play badge assets unless a real Android listing exists.
- Keep the `app-screens` TR and EN sets aligned with the screenshots currently shown on the App Store product page.
- Each localized app screen keeps the 720px source plus 400px and 480px
  responsive derivatives. Update all three sizes together.
