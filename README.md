# AYED Ghana WordPress Theme

A bespoke, responsive and SEO-optimised theme for **African Youth Empowerment and Development Ghana**, a non-profit organisation. The visual identity is drawn from the official AYED logo: **navy blue (`#143a64`) and orange (`#e1731b`)** on a warm ivory background.

All page content is editable through **Secure Custom Fields**. No emoji or em dashes are used anywhere; iconography is a hand-built inline SVG set and copy uses standard punctuation.

## Requirements

- WordPress 6.4 or newer
- PHP 7.4 or newer
- [Secure Custom Fields](https://wordpress.org/plugins/secure-custom-fields/) (free) for content management

The theme will not fatal if Secure Custom Fields is missing; it falls back to sensible default copy and shows an admin notice prompting installation.

## Setup

1. Activate the theme. The **Programs** post type and rewrite rules register automatically.
2. Install and activate **Secure Custom Fields**.
3. In **Settings > Reading**, set "Your homepage displays" to a static page and choose a page as the homepage. The front page template loads automatically.
4. Upload your logo in **Appearance > Customize > Site Identity** (Custom Logo). If none is set, a text mark is shown.
5. Create menus under **Appearance > Menus** for the `Primary` and `Footer` locations. Without a menu, anchor links to the homepage sections are used.
6. Edit global details (contact info, social links, footer) under **Site Settings** in the admin sidebar.
7. Edit homepage content under the **Front Page Content** panel on the homepage editor. Each section has its own tab.
8. Add programmes under **Programs**. Feature specific ones on the homepage via the Programs tab.
9. Create a **Contact page**: add a new page, set its Template (Page Attributes) to **Contact Page**, then add it to your menu. The form posts to a secure handler; submissions are emailed to the recipient set under Site Settings.
10. Add **Events** under the Events menu. Each event supports a date, location, a photo gallery, videos (paste a YouTube or Vimeo URL), and one or more **Related Programs**. Linked events appear automatically on the related program's page.
11. Create a **News page**: add a page named "News" (leave it blank), then under **Settings > Reading** set "Posts page" to it. Blog posts then list there using the theme's news layout, and the page is added to the default navigation automatically.

## Content management map

| Area | Where to edit |
| --- | --- |
| Brand, contact, social, footer | Admin sidebar > **Site Settings** |
| Homepage sections (hero, about, mission, pillars, approach, programs, get involved) | Homepage editor > **Front Page Content** tabs |
| Individual programmes | **Programs** post type, with a **Program Details** panel |
| Events (photos, videos, related programs) | **Events** post type, with an **Event Details** panel |
| Contact page | A page using the **Contact Page** template |
| News / blog | Standard posts, listed on the page set as **Settings > Reading > Posts page** |
| Interior page eyebrow / subtitle | Any page > **Page Header** panel |

### Highlighting words

In any headline field, wrap a word in `[em]...[/em]` to render it in the orange accent colour, for example `Empowering the [em]Next[/em] Generation`.

## Structure

```
ayed-ghana/
  style.css            Theme header and minimal fallback
  theme.json           Editor palette and typography
  functions.php        Bootstrap, loads inc/ modules
  front-page.php       Homepage, composes template-parts/sections/*
  template-contact.php Contact Page template (selectable per page)
  page.php single.php  Interior templates
  archive-program.php  Programs archive
  single-event.php archive-event.php   Events (gallery, videos, related programs)
  index.php archive.php search.php 404.php searchform.php comments.php
  inc/
    setup.php          Theme supports, menus, Programs CPT and taxonomy
    enqueue.php        Styles and scripts
    icons.php          Inline SVG icon system (replaces emoji)
    scf-fields.php     Secure Custom Fields field groups and options page
    seo.php            Meta description, Open Graph, Twitter, JSON-LD (NGO schema)
    template-functions.php  Helpers (field fallbacks, [em] parser, social links)
    contact.php        Secure AJAX contact form handler
  template-parts/
    sections/*         One file per homepage section
    content/*          Reusable cards, emblem, page header
  assets/
    css/main.css       Full stylesheet (navy/orange brand)
    js/main.js         Header, mobile nav, reveal, back to top, contact form
    images/            Logo
```

## SEO

- `title-tag` support with a branded tail on the homepage
- Meta description, canonical, Open Graph and Twitter Card tags
- JSON-LD `NGO` structured data built from Site Settings
- Semantic landmarks, skip link, descriptive `aria-label`s and alt text
- Defers automatically when Yoast, Rank Math, AIOSEO or SEOPress is active

## Security

The contact form validates a nonce, sanitises every field, uses a honeypot and a per-IP rate limit, and sends via `wp_mail()` without storing data. All template output is escaped.
