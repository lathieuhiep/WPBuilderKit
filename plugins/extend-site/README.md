# Extend Site Plugin Framework

A modular, OOP-based WordPress plugin framework for managing custom content types and Elementor integrations.

## 📂 Folder Structure & Responsibilities

### ⚙️ Core Modules
- **Constants**: Global configuration and path management via `Config` class.
- **Core**: Plugin lifecycle management (Autoloader, Kernel Boot).
- **Helpers**: Utility functions for various operations.

### 📝 Content Management
- **PostType**: Abstracted Post Type registration and Template Routing system.
- **Fields**: Custom Meta Box and Field logic handling.
- **Options**: Plugin settings and admin option pages.

### 🎨 Frontend & Page Builders
- **ElementorAddon**: Custom widgets and extensions for Elementor.
- **Widgets**: Standard WordPress widgets for sidebars.
- **Templates**: Default template files (can be overridden by active theme).

## 🛠 Developer Guide

### Registering a new Post Type
1. Create a class in `includes/PostType/` extending `BasePostType`.
2. Register it in `PostTypeManager::$post_types`.

### Creating Elementor Widgets
1. Add your widget class to `includes/ElementorAddon/`.
2. Ensure it is initialized within the Elementor boot sequence.

### Theme Overrides
Place templates in `your-theme/extend-site/` to override plugin defaults.

---

# 🍞 Breadcrumb Module (ExtendSite Core)

A high-performance, OOP-based breadcrumb system integrated into the ExtendSite framework. It features context-aware detection, smart taxonomy resolving, and full extensibility via the WordPress hook system.

## 📂 Architecture & Resolvers

Located in `includes/Core/Breadcrumb/`, this module follows the **Strategy Pattern** to handle different WordPress query contexts.

### ⚙️ Main Components

* **BreadcrumbManager**: The central orchestrator that handles caching, pagination logic, and global filters.
* **ContextDetector**: Identifies the current request type (404, Search, Single, etc.).
* **Resolvers**: Individual classes dedicated to building logic for specific contexts.

### 🧩 Logic Resolvers

* **SingleResolver**: Handles Posts and CPTs. Supports "Deepest Child" logic and integrates with Yoast/Rank Math Primary Categories.
* **PageResolver**: Automatically builds hierarchical paths for nested static pages.
* **TaxonomyResolver**: Recursively resolves parent-child relationships for categories and tags.
* **Date/Author/Search**: Specialized handlers for archive-based navigation.

## 🛠 Developer Guide: Custom Hooks

The module provides several "points of entry" to modify the breadcrumb trail without altering core files.

### 1. Modifying Labels

Use the `extend_site_breadcrumb_item_label` filter to change any breadcrumb text (e.g., adding icons or shortening long titles).

```php
add_filter('extend_site_breadcrumb_item_label', function($label, $id, $type) {
    if ($type === 'home') {
        return '<i class="es-icon-home"></i> ' . $label;
    }
    return $label;
}, 10, 3);

```

### 2. Primary Taxonomy Routing

By default, the system uses 'category'. Use this filter to switch the primary path for specific Custom Post Types.

```php
add_filter('extend_site_breadcrumb_primary_taxonomy', function($taxonomy, $post) {
    if ($post->post_type === 'es_portfolio') {
        return 'portfolio_cat';
    }
    return $taxonomy;
}, 10, 2);

```

### 3. Global Trail Modification

Use `extend_site_breadcrumb_items` to inject, remove, or reorder items just before they are rendered.

```php
add_filter('extend_site_breadcrumb_items', function($items, $context) {
    // Add a static "News" link before blog posts
    if ($context === 'single' && get_post_type() === 'post') {
        // Custom logic to splice items...
    }
    return $items;
}, 10, 2);

```

## ⚡ Performance & Caching

The module automatically caches the resolved breadcrumb array using `wp_cache` with context-specific keys (e.g., `es_bc_post_123` or `es_bc_term_45`).

* **Cache TTL**: 15 minutes (adjustable via `BreadcrumbManager`).
* **Cache Invalidation**: Automatically bypassed if WordPress core variables change.

---