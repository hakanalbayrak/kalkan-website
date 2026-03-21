# Kalkan Child Theme

This is the controlled customization layer for `kalkan.website`.

## Parent Theme

- Parent theme slug: `blocksy`
- Child theme directory: `kalkan-child/`

## Files

- `style.css`: WordPress child theme header + lightweight style foundation.
- `functions.php`: child stylesheet enqueue and safe extension point.
- `front-page.php`: code-rendered marketing homepage template.
- `assets/`: homepage visual placeholders (App Store badge, iPhone frame, app screenshot).

## Screenshot Note

WordPress can show a `screenshot.png` in Appearance > Themes.

- Optional file name: `screenshot.png`
- Recommended size: `1200x900`
- Current status: intentionally omitted to keep repository minimal; add when brand artwork is ready.

## Safe Extension Notes

- Add changes incrementally and document major updates in `docs/`.
- Avoid frameworks/build tooling in this theme layer.
- Prefer simple PHP/CSS updates that are easy to review and roll back.
