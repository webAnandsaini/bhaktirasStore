# SCSS Setup - Dharmgyan Theme

## ✅ SCSS is Now Configured!

Your `main.scss` file is now being compiled by Vite. The SCSS syntax will be automatically converted to CSS during the build process.

## File Structure

```
src/
├── css/
│   ├── app.css          ← Main entry point (imports main.scss)
│   ├── main.scss        ← Your custom SCSS file (write here!)
│   ├── globals/
│   │   └── header.css
│   └── woocommerce copy.css
```

## How to Use

### 1. Write SCSS in `src/css/main.scss`

You can now use full SCSS features:
- **Nesting**: `.parent { .child { } }`
- **Variables**: `$color: red;`
- **Mixins**: `@mixin button { }`
- **Partials**: `@import 'partials/buttons';`
- **Parent selectors**: `&:hover`, `&-title`

### 2. Build Your Styles

Run one of these commands:

```bash
# Development watch mode (auto-rebuilds on changes)
npm run dev

# Production build
npm run build

# Watch for production
npm run watch:prod
```

### 3. Compiled Output

Your compiled CSS will be in:
- `assets/css/style.css`

## Example SCSS Usage

```scss
// src/css/main.scss

// Variables
$primary-color: #610802;
$secondary-color: #850b00;

// Nested styles
.navigation {
  ul {
    list-style: none;
    
    li {
      display: inline-block;
      
      a {
        color: $primary-color;
        text-decoration: none;
        
        &:hover {
          color: $secondary-color;
        }
      }
    }
  }
}

// Parent selector
.button {
  background: $primary-color;
  
  &-primary {
    background: darken($primary-color, 10%);
  }
  
  &:hover {
    opacity: 0.8;
  }
}
```

## Current Setup

✅ SCSS is imported into `app.css`  
✅ Vite compiles SCSS to CSS automatically  
✅ Your styles are included in the compiled `style.css`  
✅ You can use all SCSS features

## Notes

- SCSS is compiled during the Vite build process
- No separate SCSS compiler needed - Vite handles it all
- Changes to `main.scss` are automatically picked up by the watcher
- The compiled CSS is minified in production builds


