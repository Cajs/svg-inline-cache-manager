# SVG Inline Cache Manager

**Version:** 1.0  
**Author:** Cameron Stephen  
**Description:** A WordPress plugin that optimizes the `get_attached_file` function for remote SVGs by caching them locally. This improves performance, enables CSS styling through inline SVGs, and ensures flexibility for developers to extend functionality.

---

## Key Features

### 🔄 Enhances `get_attached_file`
- Automatically caches remote SVG files locally by hooking into WordPress’s `get_attached_file` function.
- Ensures cached files are served locally, improving performance and reducing network requests.

### 🎨 Inline SVG Rendering
- Serves SVGs inline in the DOM when developers call custom logic (e.g., using helper functions).
- Allows full CSS styling and animations directly on SVG content.

### ⏱ Configurable Cache Duration
- Use the `SVG_CACHE_HOURS` environment variable to set the duration (in hours) for how long SVG files are cached.
- Defaults to **72 hours** if the variable is not set.

### 📂 Configurable Cache Directory
- Use the `SVG_CACHE_PATH` environment variable to define a custom directory for storing cached SVGs.
- Defaults to `wp-content/uploads/cached_svgs/` if not set.

### 🧹 Automatic Cache Clearing
- Clears the cache when WordPress Customizer settings are saved, ensuring updates are reflected immediately.

### ⚡ Developer-Friendly Design
- Designed to modify only the `get_attached_file` function.
- Offers a helper function, `get_inline_svg`, to enable developers to build custom rendering logic.

---

## Usage

- **Default Behavior**:
   - The plugin automatically caches remote SVG files when WordPress uses `get_attached_file`.

- **Developer Integration**:
   - Developers can extend or customize how SVGs are handled by building their own logic.
   - Use the helper function `get_inline_svg($attachment_id)` to fetch and render inline SVG content in themes or plugins.

---

## Example Code

### Render Inline SVG in Your Theme

```php
<div class="icon">
    <?= get_inline_svg($attachment_id); ?>
</div>
```

---

## Configuration Options

### Environment Variables

#### `SVG_CACHE_HOURS`
- Defines how long cached SVG files are stored before being refreshed.
- **Default:** 72 hours.

#### `SVG_CACHE_PATH`
- Specifies a custom directory for cached SVG files.
- **Default:** `wp-content/uploads/cached_svgs/`.

### Example `.env` Configuration

```env
SVG_CACHE_PATH=/path/to/custom/cache/directory
SVG_CACHE_HOURS=72