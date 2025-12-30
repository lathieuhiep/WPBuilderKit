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