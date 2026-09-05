# Documentación Técnica — Wheels Size Finder para WordPress

## 1. Arquitectura General

```
[WordPress]  ←→  [Servidor Node.js / Express]  ←→  [MongoDB]
     │                      │
     │ wp_remote_request    │ REST API
     │ AJAX (admin-ajax)    │
     ▼                      ▼
[WooCommerce]          [Colección vehicles]
 búsqueda por SKU       medidas OEM + catálogo
```

El plugin es un **cliente HTTP** que consulta una API REST externa (el servidor Node.js del proyecto Wheels). No almacena datos de vehículos ni medidas localmente; todas las consultas de ancho/perfil/aro/marca/modelo se resuelven contra la API en tiempo real.

Los productos se buscan **localmente** en WooCommerce mediante `WP_Query` filtrando por `_sku`.

---

## 2. Estructura de Archivos

```
wheels-size-finder/
├── wheels-size-finder.php          # Punto de entrada, constantes, hooks de activación/desactivación
├── assets/
│   ├── css/wheels-finder.css       # Estilos del BUSCADOR (componentes wsf-*). Las variables de skin
│   │                               # y los overrides del tema viven en el tema hijo duna-child (fallback aqui)
│   └── js/
│       ├── wheels-finder.js        # Frontend (jQuery): tabs, cascada, AJAX, renderizado, sliders
│       └── admin.js                # Admin: inicializa wpColorPicker
└── includes/
    ├── class-plugin.php            # Singleton principal, orquesta todos los módulos
    ├── class-api.php               # Cliente HTTP a la API Node.js
    ├── class-license.php           # Validación de licencia con caché transient
    ├── class-admin.php             # Página de configuración (settings + licencia + vista previa en vivo)
    ├── class-shortcode.php         # Shortcodes [wheels_finder], [wsf_categories], [wsf_client_logos] + AJAX
    ├── class-woocommerce.php       # Búsqueda por SKU/_wsf_tire_size + badge de medida en shop/ficha
    └── class-assets.php            # Enqueue CSS/JS + CSS dinámico inline
```

> Los ajustes de ASPECTO del sitio (navbar, topbar, tema claro/oscuro, cards de
> producto, sidebar, widget de categorías colapsable) viven en el **tema hijo
> duna-child** (ver `docs/07-tema-hijo.md` del repo). Este plugin queda como
> buscador puro.

---

## 3. Flujo de Inicialización

```
wheels-size-finder.php
  define('WSF_*', ...)              → Constantes globales
  require class-plugin.php
  register_activation_hook(...)      → Wheels_Size_Finder_Plugin::activate()
  Wheels_Size_Finder_Plugin::instance()

class-plugin.php (constructor)
  add_action('init', [$this, 'init'])
  add_action('admin_notices', ...)   → chequeo de requisitos

init():
  → $this->api         = new Wheels_Size_Finder_API()
  → $this->license     = new Wheels_Size_Finder_License()
  → $this->assets      = new Wheels_Size_Finder_Assets()        → enqueue hooks
  → $this->woocommerce = new Wheels_Size_Finder_WooCommerce()
  → $this->shortcode   = new Wheels_Size_Finder_Shortcode(...)  → add_shortcode + AJAX hooks
  → $this->admin       = new Wheels_Size_Finder_Admin(...)      → admin_menu + settings
```

---

## 4. Clase `Wheels_Size_Finder_API` (`class-api.php`)

**Propósito**: Capa de abstracción HTTP. Todas las llamadas a la API Node.js pasan por acá.

**Método privado `request($endpoint, $method, $body)`**:
- Usa `wp_remote_request()` (wrapper de WordPress sobre cURL).
- Timeout: 15 segundos.
- Retorna array asociativo decodificado o `WP_Error`.

**Endpoints consumidos**:

| Método | Endpoint | Parámetros |
|---|---|---|
| `get_widths()` | `GET /api/tire-widths` | — |
| `get_profiles($w)` | `GET /api/tire-profiles` | `?width=` |
| `get_rims($w, $p)` | `GET /api/tire-rims` | `?width=&profile=` |
| `get_brands()` | `GET /api/vehicle-brands` | `?type=1` (CAR, default) |
| `get_models($b)` | `GET /api/vehicle-models` | `?brand=&type=1` |
| `get_years($b, $m)` | `GET /api/vehicle-years` | `?brand=&model=&type=1` |
| `get_versions($b, $m, $y)` | `GET /api/vehicle-versions` | `?brand=&model=&year=&type=1` |
| `get_vehicle_tire($b, $m, $y, $v)` | `GET /api/vehicle-tire` | `?brand=&model=&year=&version=&type=1` |
| `validate_license($k, $d)` | `POST /api/license/validate` | `{license_key, domain}` |

---

## 5. Clase `Wheels_Size_Finder_License` (`class-license.php`)

**Mecanismo**:
- La clave se guarda en `wp_options` (`wsf_license_key`, `wsf_license_status`).
- `is_valid()`: primero chequea un transient de 24h (`wsf_license_valid`). Si expiró, lee `wsf_license_status`.
- `validate($key, $api)`: sanitiza la clave, llama a `$api->validate_license()`, actualiza opciones y transient.
- Estados permitidos: `active`, `inactive`, `expired`, `invalid`.
- `schedule_check()`: programa un cron diario (`wsf_license_check`) — el callback de verificación debe implementarse aparte si se desea.

**Puntos de extensión**: Para agregar un chequeo automático diario, registrá un hook:
```php
add_action('wsf_license_check', function() {
    $license = new Wheels_Size_Finder_License();
    $license->validate($license->get_key(), new Wheels_Size_Finder_API());
});
```

---

## 6. Clase `Wheels_Size_Finder_Shortcode` (`class-shortcode.php`)

**Propósito**: Renderizar el frontend del buscador, las grillas de categorías y los logos de clientes, y manejar las peticiones AJAX.

Shortcodes registrados en el constructor:

| Shortcode | Método | Función |
|---|---|---|
| `[wheels_finder]` | `render($atts)` | Formulario de búsqueda (medidas/vehículo/ambos) |
| `[wsf_categories]` | `render_categories($atts)` | Grid de categorías de WooCommerce |
| `[wsf_client_logos]` | `render_client_logos($atts)` | Marquee de logos de clientes |

### `render($atts)`
1. Verifica `$this->license->is_valid()` → si no, retorna mensaje de error.
2. Lee el modo desde `$atts['mode']` o de las opciones guardadas.
3. Renderiza HTML con:
   - Tabs (si `mode=both`)
   - Panel de medidas: 3 selects + preview + botón
   - Panel de vehículo: 4 selects + preview + botón
   - Contenedor de resultados (oculto inicialmente)
4. Inyecta `data-nonce`, `data-redirect`, `data-per-page` en el contenedor raíz.
5. Soporta título opcional (`wsf_title`, `wsf_title_tag`, `wsf_title_classes`).

### `render_preview($settings)`
- Renderiza el formulario **sin** validar licencia. Se usa en la vista previa en vivo del admin.

### `render_categories($atts)`
- Atributos: `slugs` (lista separada por comas, respeta el orden), `count` (1-12, default 6), `title`.
- Sin `slugs`: toma las categorías con más productos (excluye `uncategorized`).
- Cada card: imagen (thumbnail de la categoría o primera imagen de un producto), nombre y cantidad de productos.
- Imagen fallback: `wc_placeholder_img_src('medium_large')`.

### `render_client_logos($atts)`
- Atributos: `ids` (lista de attachment IDs), `title`.
- Sin `ids`: attachments con `_wsf_client_logo = 1` (máx. 30).
- Cada logo usa `_wsf_client_logo_color = 1` para la clase `wsf-logo-color` (grayscale sin invertir).
- Output: `<div class="wsf-logos"><div class="wsf-logos-track">` con `wsf-logo-card`.

### `ajax_search_products()`
- Recibe `tire_size` y `page` por POST.
- Verifica nonce con `check_ajax_referer('wsf_ajax_nonce', 'nonce')`.
- Llama a `$this->woocommerce->find_by_sku($tire_size, $page)`.
- Retorna JSON con `{products, total, pages, page}`.

### `ajax_get_vehicle_data()`
- Recibe `data_type` + parámetros específicos por POST.
- Switch según tipo: `brands`, `models`, `years`, `versions`, `tire`.
- Retorna los datos crudos de la API (o error si `WP_Error`).

### Flujo de datos en modo vehículo
```
usuario → select marca → AJAX brands → select modelo → AJAX models →
select año → AJAX years → select versión → AJAX tire_size →
preview medida → clic buscar → AJAX productos → render grid
```

---

## 7. Clase `Wheels_Size_Finder_WooCommerce` (`class-woocommerce.php`)

**Propósito**: Buscar productos de WooCommerce por SKU/medida y mostrar la medida en el frontend del shop.

Hooks registrados en el constructor:

| Hook | Prioridad | Método | Función |
|---|---|---|---|
| `woocommerce_single_product_summary` | 5 | `display_tire_size()` | Badge "Medida:" en la ficha de producto |
| `woocommerce_after_shop_loop_item_title` | 5 | `display_tire_size()` | Badge "Medida:" en las cards del shop/categorías |

### `display_tire_size()`
- Lee `_wsf_tire_size` del producto global (`global $product`).
- Si está vacío, no imprime nada.
- Output: `<div class="wsf-product-measure"><span class="wsf-product-measure-label">Medida:</span> <size></div>`.

### `find_by_sku($tire_size, $page)`
1. Verifica que WooCommerce esté activo con `class_exists('WooCommerce')`.
2. Normaliza la medida: `strtoupper(preg_replace('/\s+/', '', trim($tire_size)))`.
3. Arma `WP_Query` con:
   - `post_type = 'product'`, `post_status = 'publish'`, paginado según `wsf_per_page` (1-100).
   - `meta_query` con `OR` que combina:
     - `_sku = $tire_size` y `_sku LIKE %$tire_size%`
     - `_wsf_tire_size = $tire_size` y `_wsf_tire_size LIKE %$tire_size%`
4. Itera resultados con `wc_get_product()`.
5. `add_to_cart_url` por tipo:
   - Variable → permalink del producto.
   - Simple comprable y con stock → `add_query_arg('add-to-cart', $id, wc_get_cart_url())`.
   - Otro caso (sin stock/no comprable) → permalink.
6. Arma array asociativo por producto:
   ```php
   ['id', 'title', 'permalink', 'price' (HTML), 'image', 'sku', 'stock_status', 'add_to_cart_url']
   ```
7. Retorna `{products, total, pages, page, size}`.

**Nota**: La búsqueda cubre tanto el SKU como la meta `_wsf_tire_size` (campo usado por el importador de DUNA para neumáticos sin SKU estándar).

**Punto de extensión**: Para cambiar la lógica de búsqueda (ej: buscar también por título), modificá `$args['meta_query']` o agregá un `tax_query`.

---

## 8. Clase `Wheels_Size_Finder_Admin` (`class-admin.php`)

**Propósito**: Página de configuración en `/wp-admin/admin.php?page=wheels-size-finder`.

### Secciones de la página
1. **Configuración de la API**: URL, modo de búsqueda, productos por página, redirect.
2. **Personalización de estilos**: colores, tipografía y medidas (ver claves completas en §12) con **vista previa en vivo** (el formulario se renderiza con `render_preview()` y los editores quedan fijos mientras se scrollea).
3. **Licencia Premium**: formulario de activación/desactivación con `admin-post.php`.
4. **Información del shortcode**: muestra `[wheels_finder]`.

### Manejo de formularios
- **Settings**: `register_setting('wsf_settings_group', WSF_SETTINGS_OPTION)` con callback `sanitize_settings()`. Cada campo se sanitiza individualmente (`esc_url_raw`, `sanitize_hex_color`, `absint`, `sanitize_text_field`).
- **Licencia**: `admin_post_wsf_activate_license` → verifica nonce con `check_admin_referer` → llama a `$license->validate()`.

### Sanitización aplicada
| Tipo de campo | Función |
|---|---|
| URL | `esc_url_raw()` |
| Color hex | `sanitize_hex_color()` |
| Número | `absint()` |
| Texto libre | `sanitize_text_field()` |
| Select | `in_array($val, ['tire','vehicle','both'])` |

---

## 9. Clase `Wheels_Size_Finder_Assets` (`class-assets.php`)

Hooks registrados en el constructor:

| Hook | Prioridad | Método | Función |
|---|---|---|---|
| `wp_enqueue_scripts` | 10 | `enqueue()` | CSS/JS + CSS dinámico inline + `wsfData` |

> El botón claro/oscuro y la clase `wsf-can-toggle` (antes en esta clase)
> viven ahora en el **tema hijo duna-child** (`functions.php`).

### `enqueue()`
- Solo en frontend (`!is_admin()`).
- Encola `wheels-finder.css` con versión `WSF_VERSION + '-' + md5(serialize($settings))[:8]` (cache-busting al cambiar ajustes).
- `wp_add_inline_style('wheels-size-finder', build_dynamic_css($settings))`.
- Encola `wheels-finder.js` (dependencia `jquery`).
- `wp_localize_script('wheels-size-finder', 'wsfData', [...])`:
  `ajaxUrl`, `apiUrl`, `searchMode`, `redirectUrl`, `perPage`, `i18n` (select, loading, searchProducts, noResults, error, prev, next, page, of, addToCart, outOfStock, inStock).

### `get_style_vars($settings)`
- Mapea cada opción `wsf_*` a una variable CSS (`--wsf-*`). Se omiten las vacías (heredan del tema).
- Colores: `--wsf-primary`, `--wsf-bg`, `--wsf-card`, `--wsf-text`, `--wsf-label`, `--wsf-border`, `--wsf-input`, `--wsf-option-bg`, `--wsf-option-text`, `--wsf-arrow`, `--wsf-result-color`, `--wsf-btn-bg`, `--wsf-btn-text`, `--wsf-btn-hover`, `--wsf-btn-border`, `--wsf-accent`, `--wsf-font`.
- Medidas: `--wsf-input-font-size`, `--wsf-radius`, `--wsf-input-pad`, `--wsf-result-size`, `--wsf-btn-radius`.
- Esquema: `--wsf-scheme` (`light`/`dark`) calculado por luminancia de `wsf_input_bg` (método `color_scheme()`).

### `build_dynamic_css($settings)`
- Genera `:root { --wsf-*: ...; }` con las variables resultantes.
- Agrega regla para mantener los `<select>` nativos usables en temas que los ocultan: `appearance:none; opacity:1 !important; visibility:visible !important`.

---

## 10. Frontend JavaScript (`wheels-finder.js`)

**Dependencia**: jQuery.

**Namespace**: `WSF` (objeto global dentro del IIFE).

**Inicialización**:
```javascript
$(document).ready(function() { WSF.init(); });
```

**Métodos principales**:

| Método | Función |
|---|---|
| `init()` | Busca todos los `.wsf-container` e inicializa paneles + sliders, tema y widget |
| `initTirePanel(container, nonce)` | Configura selects ancho → perfil → aro, listeners, cascada |
| `initVehiclePanel(container, nonce)` | Configura selects marca → modelo → año → versión |
| `initTabs(container)` | Listener para cambio de pestañas |
| `initSearchButtons(container, nonce)` | Listener para el botón "Buscar productos" |
| `loadProducts(container, size, page, nonce)` | AJAX a `admin-ajax.php` → renderiza grid |
| `loadSelect(select, url)` | GET directo a la API Node.js (para modo medidas) |
| `ajaxLoad(select, dataType, extraData, nonce)` | POST a `admin-ajax.php` (para modo vehículo) |
| `applyColors(select)` | Colorea el select (fondo/texto/flecha) según variables |
| `resetSelect(select)` | Limpia un select y sus dependientes |
| `restoreSelects()` | Restaura los selects ocultos por el tema (Select2) |
| `initTestimonialsSlider()` | Carrusel de testimonios (`.wsf-testimonials`) |
| `initLogosMarquee()` | Marquee continuo de logos (`.wsf-logos`) |

> El toggle claro/oscuro, el widget de categorías colapsable y el ícono
> "Mi Cuenta" (antes aquí) viven ahora en `duna-child/assets/js/duna-child.js`.

**Flujo AJAX modo medidas**:
```
select ancho → GET /api/tire-widths (directo a API, sin nonce)
select perfil → GET /api/tire-profiles?width=X
select aro   → GET /api/tire-rims?width=X&profile=Y
botón buscar → POST admin-ajax.php (action=wsf_search_products) → necesita nonce
```

**Flujo AJAX modo vehículo**:
```
select marca    → POST admin-ajax.php (action=wsf_get_vehicle_data, data_type=brands)
select modelo   → POST admin-ajax.php (data_type=models, brand=X)
select año      → POST admin-ajax.php (data_type=years, brand=X, model=Y)
select versión  → POST admin-ajax.php (data_type=versions, ...)
auto tire size  → POST admin-ajax.php (data_type=tire, ...)
botón buscar    → POST admin-ajax.php (action=wsf_search_products)
```

**¿Por qué modo medidas usa GET directo y modo vehículo usa POST con nonce?**
- Las consultas de medidas se hacen contra la API Node.js que tiene CORS abierto. No requieren autenticación WordPress.
- Las consultas de vehículo y productos pasan por `admin-ajax.php` porque la API de vehículos también es pública, pero por consistencia con WordPress se usa el proxy AJAX.

---

## 11. CSS (`wheels-finder.css`)

**Sistema de theming**: Dos capas de variables CSS:

1. **Tema claro/oscuro** (en `:root` del archivo): `--wsf-surf`, `--wsf-surf-2`, `--wsf-surf-deep`, `--wsf-border`, `--wsf-border-soft`, `--wsf-txt`, `--wsf-txt-soft`, `--wsf-brand`, `--wsf-brand-hover`, `--wsf-dot-*`, `--wsf-logo-filter`, `--wsf-logo-filter-color`. El bloque `body.wsf-light` sobrescribe las variables para el modo claro.
2. **Ajustes del plugin** (inline `:root{...}` vía `class-assets.php`): `--wsf-primary`, `--wsf-bg`, `--wsf-card`, `--wsf-text`, `--wsf-input`, `--wsf-btn-bg`, `--wsf-accent`, `--wsf-font`, etc. Solo se emiten las que el usuario configuró; las vacías heredan del tema.

**Clases BEM-like** (sin seguir estrictamente BEM):

| Prefijo | Uso |
|---|---|
| `.wsf-container` | Contenedor raíz del buscador |
| `.wsf-tabs` / `.wsf-tab` | Pestañas de modo |
| `.wsf-panel` | Panel de búsqueda (tire/vehicle) |
| `.wsf-select-group` / `.wsf-select-item` | Grid de selects |
| `.wsf-tire-size` / `.wsf-result-preview` | Preview de la medida encontrada |
| `.wsf-search-btn` | Botón principal de búsqueda |
| `.wsf-results-container` | Contenedor de resultados |
| `.wsf-products-grid` / `.wsf-product-card` | Grid de productos |
| `.wsf-pagination` / `.wsf-page-btn` | Paginación |
| `.wsf-hidden` / `.wsf-active` / `.wsf-loading` / `.wsf-error` / `.wsf-no-results` | Estados |
| `.wsf-categories` / `.wsf-category-card` / `.wsf-category-image` / `.wsf-category-name` / `.wsf-category-count` | Grilla de categorías (home) |
| `.wsf-testimonials` / `.wsf-testimonial` / `.wsf-testimonial-dots` / `.wsf-dot` | Slider de testimonios |
| `.wsf-logos` / `.wsf-logos-track` / `.wsf-logo-card` / `.wsf-logo` / `.wsf-logo-color` | Marquee de logos |
| `.wsf-product-measure` / `.wsf-product-measure-label` | Badge de medida en shop/ficha |
| `.wsf-theme-toggle` / `.wsf-theme-toggle-li` / `.wsf-theme-icon` | Botón claro/oscuro del menú |
| `.wsf-cat-toggle` / `.wsf-cat-toggle.open` | Flecha del widget de categorías |

**Cards de producto** (overrides sobre el tema Motors):
- `ul.products li.product .stm-product-inner`: borde `1px solid var(--wsf-border)`, radio `10px`, fondo `var(--wsf-surf)`, flex column, `margin-bottom: 30px`.
- `h5`: `min-height: 2.8em`, `line-clamp: 2` (título a 2 líneas, alturas uniformes).
- `.product_info`: `min-height: 60px`; en cards sin medida un `::before` de 34px (`:has(.wsf-product-measure)`) reserva el espacio del badge → todas las cards miden igual.
- `.price`: centrado, `font-size: 20px`, `font-weight: 700`, color `var(--wsf-txt)`; `del` tachado gris 14px opacidad 0.7; `ins` bold oscuro sin subrayado.
- `a.button` (Add to cart): rojo `var(--wsf-brand)`, ancho completo, radio 6px.

**Sidebar**:
- `aside.widget` y variantes: borde `1px solid var(--wsf-border)`, radio `10px`, fondo `var(--wsf-surf)`, padding 24px, sin sombra (override del borde 4px/sombra del tema).
- `.widget_product_categories .wsf-cat-toggle`: botón 18px con fondo `var(--wsf-brand)` y flecha blanca.

**Responsive**: Media queries a 1200/992/600px que ajustan la grilla de categorías; a 768px el slider de testimonios a 1 columna; el grid de productos a 150px mínimo.

---

## 12. Constantes Definidas

Definidas en `wheels-size-finder.php`:

| Constante | Valor |
|---|---|
| `WSF_VERSION` | `1.5.9` |
| `WSF_PLUGIN_DIR` | Ruta absoluta del plugin |
| `WSF_PLUGIN_URL` | URL del plugin |
| `WSF_PLUGIN_BASENAME` | `wheels-size-finder/wheels-size-finder.php` |
| `WSF_MINIMUM_WP_VERSION` | `6.0` |
| `WSF_MINIMUM_PHP_VERSION` | `7.4` |
| `WSF_LICENSE_OPTION` | `wsf_license_key` |
| `WSF_LICENSE_STATUS` | `wsf_license_status` |
| `WSF_SETTINGS_OPTION` | `wsf_settings` |

Las opciones en `wsf_settings` son un array serializado. Claves actuales:

**Configuración general**: `wsf_api_url`, `wsf_search_mode`, `wsf_redirect`, `wsf_per_page`, `wsf_title`, `wsf_title_tag`, `wsf_title_classes`.

**Colores**: `wsf_primary_color`, `wsf_bg_color`, `wsf_card_bg`, `wsf_text_color`, `wsf_label_color`, `wsf_border_color`, `wsf_input_bg`, `wsf_option_bg`, `wsf_option_text`, `wsf_arrow_color`, `wsf_result_color`, `wsf_button_bg`, `wsf_button_text`, `wsf_button_hover`, `wsf_button_border`, `wsf_accent_color`, `wsf_font_family`.

**Medidas**: `wsf_input_font_size`, `wsf_input_border_radius`, `wsf_input_padding`, `wsf_result_size`, `wsf_button_radius`.

---

## 13. Seguridad

| Capa | Medida |
|---|---|
| **PHP inputs** | `sanitize_text_field()`, `sanitize_hex_color()`, `esc_url_raw()`, `absint()`, `wp_unslash()` |
| **PHP outputs** | `esc_html()`, `esc_attr()`, `esc_url()`, `wp_json_encode()` |
| **AJAX** | `check_ajax_referer('wsf_ajax_nonce', 'nonce')` en todos los handlers |
| **Admin POST** | `check_admin_referer('wsf_license_nonce', 'wsf_nonce')` |
| **Capabilities** | `current_user_can('manage_options')` en admin |
| **Acceso a archivos** | `if (!defined('ABSPATH')) exit;` en todos los includes |
| **HTTP saliente** | `esc_url_raw()` en URLs antes de `wp_remote_request()` |

---

## 14. Testing y Depuración

### Activar WP_DEBUG
En `wp-config.php`:
```php
define('WP_DEBUG', true);
define('WP_DEBUG_LOG', true);
```

### Probar endpoints manualmente
```bash
curl https://tu-api.com/api/tire-widths
curl "https://tu-api.com/api/vehicle-brands?type=1"
curl -X POST https://tu-api.com/api/license/validate \
  -H "Content-Type: application/json" \
  -d '{"license_key":"WSF-TEST-KEY","domain":"tusitio.com"}'
```

---

## 15. Puntos de Extensión y Mejora Futura

1. **Soporte multi-idioma**: Los strings ya usan `__()` y `load_plugin_textdomain()`. Solo falta generar archivos `.po/.mo`.
2. **Caché de respuestas API**: Implementar transients para `get_widths()`, `get_brands()`, etc. Reduciría llamadas repetidas.
3. **Filtros WordPress**: Agregar `apply_filters('wsf_before_search', ...)` y `apply_filters('wsf_products', ...)` para que otros plugins modifiquen resultados.
4. **Widget**: Registrar un widget de WordPress (extend `WP_Widget`) para colocar el buscador en sidebars.
5. **Gutenberg block**: Registrar un bloque con `register_block_type()` usando el mismo render del shortcode.
6. **Búsqueda avanzada**: Agregar filtros por categoría de producto, rango de precio, fabricante.
7. **Logging**: Sistema de logs para depurar fallos de conexión a la API.
8. **Soporte para más tipos de vehículo**: Actualmente fijo a `type=1` (CAR) en modo vehículo. Agregar un select de tipo de vehículo como primer paso.
