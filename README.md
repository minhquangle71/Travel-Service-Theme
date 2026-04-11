# Travel Service Theme - Routing & Template Structure

A custom WordPress theme built with modern development practices, leveraging WordPress Template Hierarchy for clean routing without a traditional router.

---

## Table of Contents

1. [How WordPress Routing Works](#how-wordpress-routing-works)
2. [Route Structure](#route-structure)
3. [Page Mapping & Slugs](#page-mapping--slugs)
4. [Blog Configuration](#blog-configuration)
5. [Template Hierarchy](#template-hierarchy)
6. [Folder Structure](#folder-structure)
7. [Best Practices](#best-practices)

---

## How WordPress Routing Works

Unlike modern frameworks (Laravel, Next.js, etc.), **WordPress doesn't use a traditional router**. Instead, it determines which template to load using the **Template Hierarchy** — an intelligent system that checks URL patterns and post types.

### The Process

1. **URL is requested** → WordPress parses the URL path
2. **Post/Page lookup** → WordPress queries the database for matching content
3. **Template Hierarchy** → WordPress searches for template files in this order:
   - Specific template files (e.g., `front-page.php`, `page-{slug}.php`)
   - Generic template files (e.g., `single.php`, `page.php`, `index.php`)
   - First match is loaded and executed

### Why This Approach?

- **Flexibility** — Different URL patterns can use different layouts without code routing
- **Content-driven** — Template selection is based on WordPress content structure
- **Convention over configuration** — Naming conventions define behavior

---

## Route Structure

This theme defines the following routes:

| URL                 | Template           | Purpose                           |
| ------------------- | ------------------ | --------------------------------- |
| `/`                 | `front-page.php`   | Homepage / Landing page           |
| `/blog`             | `home.php`         | Blog listing page (posts archive) |
| `/blog/{post-slug}` | `single.php`       | Individual blog post              |
| `/contact`          | `page-contact.php` | Contact page                      |
| `/about`            | `page-about.php`   | About page                        |
| `/{page-slug}`      | `page-{slug}.php`  | Custom pages (if template exists) |
| Fallback            | `index.php`        | Catches all unmatched routes      |

---

## Page Mapping & Slugs

### How Page URLs Work

Pages are created in **WordPress Admin → Pages**. The page's **slug** determines its URL.

#### Example Setup

```
WordPress Admin Panel:
┌─────────────────────────────────────────┐
│ Add New Page                            │
├─────────────────────────────────────────┤
│ Title:        "Contact Us"              │
│ Slug:         "contact"                 │
│ Publish:      ✓                         │
└─────────────────────────────────────────┘

Result:
URL: /contact
Template: page-contact.php
```

### Template Naming Convention

For custom page layouts, use the naming pattern:

```
page-{slug}.php
```

**Examples:**

- Slug: `contact` → `page-contact.php`
- Slug: `about` → `page-about.php`
- Slug: `services` → `page-services.php`

### Fallback Behavior

If no custom template exists for a page slug, WordPress falls back to `page.php`, then `index.php`.

---

## Blog Configuration

### Understanding front-page.php vs home.php

These templates serve **different purposes** and can't be used interchangeably:

| Template         | Purpose             | Shows                                   |
| ---------------- | ------------------- | --------------------------------------- |
| `front-page.php` | **Static homepage** | Whatever page is assigned as "Homepage" |
| `home.php`       | **Blog listing**    | Post archive (list of published posts)  |

### Why front-page.php and home.php Exist

WordPress allows you to:

- Set a **static page** as the homepage
- Set a separate **blog listing page** in Settings → Reading

This separation lets you have:

- A custom landing page (front-page.php)
- A traditional blog listing elsewhere (home.php)

### Setup Steps

1. **Create Pages** in WordPress Admin:
   - "Homepage" (assign as Site Homepage)
   - "Blog" (assign as Posts Page)

2. **Configure in Settings → Reading:**

   ```
   Your homepage displays: ○ Your latest posts
                           ◉ A static page

   Homepage:    [Homepage]
   Posts page:  [Blog]
   ```

3. **Template Loading:**
   - `/` → loads `front-page.php`
   - `/blog` → loads `home.php` (with query loop of posts)

### What Gets Passed to home.php

```php
<?php
// In home.php, the global $wp_query is set to the posts archive
if (have_posts()) {
    while (have_posts()) {
        the_post();
        // $post contains the current post in the loop
        echo get_the_title();
    }
}
?>
```

---

## Template Hierarchy

WordPress follows a priority-based template hierarchy. It searches for templates in order; the first file found is used.

### Simplified Hierarchy for This Theme

```
Single Post:
1. single-{post-type}.php
2. single.php
3. index.php

Static Page:
1. page-{slug}.php
2. page.php
3. index.php

Homepage:
1. front-page.php
2. home.php (if front-page not found)
3. index.php

Blog Archive:
1. home.php
2. archive.php
3. index.php

Any Other Route:
1. [Matching specific template]
2. index.php (fallback)
```

### Visual Example

```
Request: /about
↓
WordPress queries database for page with slug "about"
↓
Check 1: Does page-about.php exist?
   ✓ Yes → Use page-about.php

Request: /contact
↓
WordPress queries database for page with slug "contact"
↓
Check 1: Does page-contact.php exist?
   ✓ Yes → Use page-contact.php

Request: /services (no template exists)
↓
WordPress queries database for page with slug "services"
↓
Check 1: Does page-services.php exist?
   ✗ No
↓
Check 2: Does page.php exist?
   ✗ No
↓
Check 3: Use index.php (fallback)
```

---

## Folder Structure

```
travelServiceTheme/
├── README.md                    # This file
├── index.php                    # Fallback template
├── front-page.php               # Homepage
├── home.php                     # Blog listing
├── single.php                   # Single blog post
├── page-about.php               # About page
├── page-contact.php             # Contact page
├── header.php                   # Global header
├── footer.php                   # Global footer
├── functions.php                # Theme setup & functions
├── style.css                    # Stylesheet (metadata)
├── vite.config.js               # Vite configuration
├── package.json                 # Dependencies & scripts
│
├── assets/
│   ├── dist/                    # Compiled assets (Vite output)
│   │   ├── main.js              # Compiled JavaScript
│   │   ├── style.css            # Compiled CSS
│   │   └── ...
│   │
│   └── src/
│       ├── main.js              # Entry point
│       ├── style.css            # Source styles
│       └── components/          # (Optional) Component files
│
└── template-parts/              # Reusable template components
    ├── components/
    │   ├── navigation.php
    │   ├── hero.php
    │   ├── sidebar.php
    │   └── ...
    │
    └── content/
        ├── post.php
        ├── page.php
        └── ...
```

### Directory Purposes

| Directory                    | Purpose                                        |
| ---------------------------- | ---------------------------------------------- |
| `assets/src/`                | Source JavaScript and CSS (pre-compilation)    |
| `assets/dist/`               | Compiled/bundled assets (Vite output)          |
| `template-parts/`            | Reusable template components                   |
| `template-parts/components/` | Structural components (header, footer, nav)    |
| `template-parts/content/`    | Content type displays (post card, page layout) |

---

## Best Practices

### 1. Keep Logic Out of Templates

**Bad:**

```php
<?php
// ✗ Don't do complex logic in templates
$posts = $wpdb->get_results("SELECT * FROM wp_posts...");
foreach ($posts as $post) {
    echo $post->post_title;
}
?>
```

**Good:**

```php
<?php
// In functions.php
function get_featured_posts() {
    return new WP_Query([
        'posts_per_page' => 5,
        'meta_key' => '_featured',
        'orderby' => 'date',
    ]);
}

// In template
$featured = get_featured_posts();
if ($featured->have_posts()) {
    while ($featured->have_posts()) {
        $featured->the_post();
        the_title();
    }
}
wp_reset_postdata();
?>
```

### 2. Use get_template_part() for Reusable Components

**Instead of including files directly:**

```php
<?php
// ✗ Don't do this
include 'template-parts/components/post-card.php';
?>
```

**Use get_template_part():**

```php
<?php
// ✓ Better approach
get_template_part('template-parts/components/post-card');

// With variables
get_template_part('template-parts/components/post-card', null, ['post_id' => 42]);
?>
```

### 3. Organize Templates into template-parts

**Structure:**

```
template-parts/
├── components/      # UI components
│   ├── header.php
│   ├── footer.php
│   ├── navigation.php
│   ├── hero.php
│   └── cta-section.php
│
└── content/         # Content type displays
    ├── post.php     # Single post card
    └── page.php     # Page content block
```

### 4. Enqueue Scripts and Styles Properly

**In functions.php:**

```php
<?php
function travel_theme_enqueue_assets() {
    // Vite-generated assets in production
    wp_enqueue_style('travel-theme-style', get_template_directory_uri() . '/assets/dist/style.css');
    wp_enqueue_script('travel-theme-main', get_template_directory_uri() . '/assets/dist/main.js', [], false, true);
}
add_action('wp_enqueue_scripts', 'travel_theme_enqueue_assets');
?>
```

### 5. Use WordPress Hooks for Customization

Instead of modifying core template files, use hooks:

```php
<?php
// Extend functionality without modifying templates
add_action('wp_footer', 'my_custom_footer_content');

function my_custom_footer_content() {
    echo '<p>Custom content</p>';
}
?>
```

### 6. Follow WordPress Coding Standards

- Use `wp_kses_post()` for sanitization
- Use `esc_html()`, `esc_attr()`, `esc_url()` for output escaping
- Use nonces for form security
- Cache expensive queries with `wp_cache_*` functions

### 7. Conditional Tags for Template Logic

**Use WordPress conditionals:**

```php
<?php
if (is_front_page()) {
    // Show homepage content
}

if (is_home()) {
    // Show blog archive
}

if (is_single()) {
    // Show single post
}

if (is_page('about')) {
    // Show about page specifically
}

if (have_posts()) {
    // Loop through posts
}
?>
```

---

## Asset Pipeline (Vite)

This theme uses **Vite** for asset compilation:

### Development

```bash
npm install      # Install dependencies
npm run dev      # Start dev server (localhost:5173)
```

### Production

```bash
npm run build    # Build optimized assets to assets/dist/
```

### Why Vite?

- **Fast hot module replacement** during development
- **Optimized bundles** for production
- **Modern module system** (ES6 imports)
- **CSS preprocessing** (if using Sass/PostCSS)

---

## Quick Start Checklist

- [ ] Create "\_\_Homepage" page (static)
- [ ] Create "Blog" page (for posts archive)
- [ ] Go to **Settings → Reading**:
  - Set Homepage to your homepage page
  - Set Posts page to your blog page
- [ ] Create custom pages and corresponding `page-{slug}.php` templates as needed
- [ ] Use `get_template_part()` for reusable components
- [ ] Keep business logic in `functions.php`, not templates
- [ ] Run `npm run build` before deploying

---

## Resources

- [WordPress Template Hierarchy](https://developer.wordpress.org/themes/basics/template-hierarchy/)
- [WordPress Theme Development Handbook](https://developer.wordpress.org/themes/)
- [WordPress Plugin API (Hooks)](https://developer.wordpress.org/plugins/hooks/)
- [Vite Documentation](https://vitejs.dev/)

---

## Support & Questions

Refer to the function definitions in `functions.php` for custom hooks and functionality specific to this theme.
