# Estatein WordPress theme

A classic WordPress theme built from the Figma community file "Real Estate Business Website UI Template – Dark Theme" (Produce UI). It covers the six pages in the design: Home, About Us, Properties, Property Details, Services and Contact.

## Development process

The theme was built with an AI coding assistant (Claude Code), directed page by page by me. The steps were:

1. **Read the design from Figma.** The assistant connected to the Figma file through Figma's MCP server and pulled each section's layout, text, colours, images and icons.
2. **Build the Home page and the shared parts first**: header, footer, call-to-action band, colour and type tokens, buttons, cards and carousels.
3. **Add the Properties and Property Details pages**, again from Figma data, along with the property fields, search filters and inquiry form.
4. **Add Services, Contact and About Us from exported screenshots.** The Figma MCP call limit on the Starter plan ran out before these pages could be read, so I exported the frames as images and the pages were built from those.
5. **Check each page in a browser** at 1920 and 390 pixels wide against the design, and at 1440 for some pages. PHP files were syntax-checked with `php -l` and the script with `node --check`.

### What this means for accuracy

- **Home, Properties, Property Details**: built from real Figma data. At 1920 wide, section positions and sizes match the Figma frames to within a few pixels. They use the design's own images and icons.
- **Services, Contact, About Us**: built from low-resolution screenshots. Layout and copy follow the design, but spacing is estimated, some icons are stand-ins reused from other pages, and photo areas (Contact gallery, About Us hero image, team portraits) are empty placeholder boxes.
- **Laptop (1440) and mobile (390) layouts**: only the Home page mobile frame was looked at, and only as a screenshot. Every other responsive layout is scaled down from the desktop design, not matched to its Figma frame.

## Theme development choices

- **Classic PHP theme, not a block theme.** The design is a fixed, custom layout, and PHP templates reproduce it more directly than block markup. The trade-off is that pages are not editable in the Site Editor.
- **No build step.** One `style.css`, one `assets/js/main.js`, no Sass, bundler or CSS framework. The Figma output was Tailwind/React and was rewritten as plain CSS and PHP.
- **Design tokens as CSS variables.** Colours come from the Figma variables (Grey/08, Grey/10, Grey/15, Grey/60, Purple/60, Purple/75). Type and spacing scale with `clamp()` between mobile and 1920.
- **Custom post types for real content.**
  - `property`: listings, with a "Property details" box in the editor for price, location, type, bedrooms, bathrooms, area, build year, tagline, key features and pricing details.
  - `testimonial` and `faq`: feed the Home page carousels.
  - `inquiry`: stores form submissions so they appear in the admin.
- **Sample content fallback.** When no properties, testimonials or FAQs exist, the carousels show the sample items from the design so a fresh install is not empty.
- **Working interactions, written in plain JavaScript**: dismissible banner, mobile menu, carousels with page counter, property photo gallery, search filters on the Properties page, office tabs on the Contact page.
- **Forms.** The inquiry forms post to `admin-post.php`, are protected by a nonce and a honeypot field, save an Inquiry post and send an email to the site admin with `wp_mail`.
- **Page templates by slug.** `page-about-us.php`, `page-services.php` and `page-contact.php` apply to pages with the slugs `about-us`, `services` and `contact`.

### Known limitations

- Text on the Home hero, Services, Contact and About Us pages is written into the templates, not editable from the admin.
- The footer newsletter field is not connected to a mailing service.
- Social links, "Visit Website" and team Twitter links point to `#`.
- Down payment and mortgage amount on the property page are calculated as 20% and 80% of the price.
- Email was not tested: the local Docker setup has no mail server, so only the saved Inquiry was confirmed.
- The site was developed with plain permalinks (`?page_id=…`); pretty permalinks were not tested.
- There are no automated tests.

## Plugins and tools

**WordPress plugins:** none. Everything is in the theme.

**Tools:**

- **Claude Code** (Anthropic's AI coding assistant) to write the theme code and check it in a browser.
- **Figma MCP server** (official Figma plugin for Claude Code) to read the design and download its images and icons.
- **Figma** to export the Services, Contact and About Us frames as images.
- **Docker Compose** with the official `wordpress` and `mysql:8.0` images for the local site. The theme folder is bind-mounted into the container.
- **Google Fonts** for the Urbanist typeface, loaded from the Google Fonts CDN.

## Setup

1. Copy the `estatein` folder into `wp-content/themes/` and activate it under Appearance → Themes.
2. Create pages with the slugs `about-us`, `services` and `contact`.
3. Add properties under Properties → Add New Property. Set a featured image and fill in the "Property details" box.
4. Optionally assign a menu to the "Primary Menu" location; until then the header shows a built-in menu.
