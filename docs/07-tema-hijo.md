# Tema hijo duna-child (Motors)

## Que es
Tema hijo de **Motors** (Template: motors) que contiene los ajustes de
**skin/aspecto del sitio**. El plugin `wheels-size-finder` queda como
**buscador puro** (funcionalidad), y el look & feel del sitio vive aca.

Ruta: `wp-content/themes/duna-child/`

| Archivo | Contenido |
|---|---|
| `style.css` | Cabecera del tema (Template: motors) |
| `functions.php` | Enqueue de assets (prioridad 20, despues del parent y del plugin) + hooks `wp_nav_menu_items` (boton claro/oscuro) y `body_class` (wsf-can-toggle) |
| `assets/css/duna-child.css` | TODOS los overrides de skin: variables `--wsf-*` + modo claro (`body.wsf-light`), navbar (cinta roja 50px, triangulos clip-path, hover negro), topbar centrado (iconos/sociales), telefono blanco, Mi Cuenta en la navbar negra, cards de producto (borde/padding/titulo 2 lineas/precio), sidebar/border widgets, widget de categorias colapsable, boton de tema, **UNIFORM (v1.0.2)** base global (body/wrapper/titlebox/footer a `var(--wsf-surf-deep)` + inputs/forms/tablas WC/single product/WPCF7/paginación a `var(--wsf-surf)`) que corrige claros heredados `#eceff3/#f0f2f5/#f6f7f9/#fff/#8f9fad` y el `page_bg_color` inline de Contacto, MOBILE (boton Filtros + drawer off-canvas + topbar <991 oculta) |
| `assets/js/duna-child.js` | `initThemeToggle` (claro/oscuro + localStorage), `initCategoryWidget` (subcategorias colapsadas + flecha), `moveHeaderUser` (icono Mi Cuenta antes del carrito), `initMobileSidebar` (boton Filtros + drawer off-canvas con mover/restaurar la sidebar, overlay, cierre, resize guard) |

## Uniformidad (v1.0.2 del child) – todas las páginas mismo estilo
**Páginas auditadas 1×1 (dark default, 1367×900):** Home (4300), Shop (9), Categoría baterias, Single product (juego-de-llantas-vw), Cart (10 vacío), Checkout (11), My Account (12), Buscador (53), La empresa/about-us (370), Contacto (712), Blog/Newsroom (707), Typography (300), FAQ (986), Service (546), Inventory (639), Shortcodes (848), Compare (156), PressurePro (5753+ familias) + genéricas.

**Drifts corregidos:**
- **Contacto**: `#wrapper` claro `#f0f2f5` via `page_bg_color` inline (#712) → forzado a `var(--wsf-surf-deep) #0d1117` con `html body #wrapper !important` + meta actualizada a `#0d1117` (también Coming soon #777).
- **Formularios/inputs** claros heredados `#eceff3/#f6f7f9/#fff` (WPCF7, Woo, search, `select2`) → unificados a `var(--wsf-surf) #161b22` / borde `var(--wsf-border) #30363d` / texto `var(--wsf-txt) #e1e4e8`.
- **Tablas Woo** (cart/checkout/order-review/my-account) transparentes → `var(--wsf-surf)` + `th` `var(--wsf-surf-2)`.
- **Single product**: precio rojo `#df1d1d` vs card blanco → unificado a `var(--wsf-txt)`; tabs/panels transparentes → `var(--wsf-surf)` / active `var(--wsf-surf-2)`.
- **Titlebox/breadcrumbs** gris `#8f9fad` → `var(--wsf-surf-deep)` + texto `var(--wsf-txt-soft)`; `colored-separator` a brand.
- **Footer** transparente → `var(--wsf-surf-deep)` + borde `var(--wsf-border)`.
- **Topbar/Header** `#232628` vs body `#0e1315` → unificado a `var(--wsf-surf-deep)` (light: `#f7f8fa` vs `#ffffff` con contraste sutil).
- **Buscador (plugin)**: selects con `background #fff !important` + `color #fff !important` invisibles (settings `wsf_input_bg/text/border` blancos) → corregidos a `#161b22/#e1e4e8/#30363d` y CSS `.wsf-container select` a vars; verificado `rgb(22,27,34)` correcto.

**Verificación post-fix (CDP):** `body/wrapper/topbar/footer` todos `rgb(13,17,23)` en dark, `input/card` `rgb(22,27,34)`, `titleBox` `rgb(13,17,23)`, `breadcrumb` `rgb(182,188,196)`, `price` `rgb(225,228,232)` uniformes en todas las páginas listadas; light `body #f7f8fa / wrapper #fff / card #fff` OK.

## Responsive movil (v1.0.1 → v1.0.2 del child)
- **Boton "Filtros"** arriba del grid de productos, visible solo <992px (la sidebar
  del tema esta oculta en movil). Click -> **drawer off-canvas**:
  - La sidebar `.wpb_widgetised_column` se MUeVE al drawer (los toggles del widget
    siguen vivos: mismo nodo DOM), overlay oscuro, boton cerrar.
  - Al cerrar se restaura en su posicion original (placeholder + parent guardado);
    si la ventana vuelve a >=992 con el drawer abierto, se cierra solo.
  - Solo existe en paginas con `ul.products` + sidebar (shop/categorias).
- **Topbar movil**: <991 oculta entera (antes <480 solo tel/redes; simplificado para uniformidad dark).
- **Toggle claro/oscuro**: presente en el menu movil (drawer) para admins.
- Verificado: 375/479/480/768/990/1200 sin overflow; ciclo open/close x2; boton
  oculto en desktop y en home (home no tiene sidebar). Re-verificado en v1.0.2: topbar none en 375, filtros block, drawer open OK.

## Reglas de oro
1. **NO editar el tema parent `motors`** (comercial, con actualizaciones).
2. Los cambios de skin del sitio van **aca** (CSS/JS/funciones.php del child).
3. El plugin wheels-size-finder solo lleva **funcionalidad del buscador**
   (shortcodes, AJAX, badge de medida) y sus componentes `wsf-*`.
4. La interfaz de variables de skin: el child define las variables
   (`--wsf-surf`, `--wsf-txt`, `--wsf-brand`, `--wsf-border`,
   `--wsf-txt-soft`, `--wsf-logo-filter`, ...) en `:root` y el bloque
   `body.wsf-light`; el plugin las usa con fallbacks
   (`var(--wsf-surf, #161b22)`).

## Como funciona la carga
- El CSS/JS del child se enqueuea con prioridad **20** (`wp_enqueue_scripts`),
  despues de los estilos del parent (`stm-theme-style-sass`,
  `stm-theme-style-css`) que cargan en prioridad 10. Asi los overrides ganan
  la cascada con las mismas especificidades del plugin (que carga en 10).
- El toggle claro/oscuro es **solo para administradores**
  (`current_user_can('manage_options')`); los visitantes ven el tema oscuro.

## Notas de activacion (importante)
- Al activar el child desde wp-admin (o via DB), WordPress crea opciones
  `theme_mods_duna-child` **frescas** — por eso se deben copiar los
  `theme_mods_*` originales (nav_menu_locations, listing_*) al child.
- La activacion puede disparar el importador demo de Motors: **verificar
  `nav_menu_locations` y la opcion `wpcfto_motors_motorcycle_settings`**
  (claves `header_main_phone`, `header_socials_enable`, `top_bar_*`).

## Actualizacion del plugin
Cuando se actualice/recree el plugin wheels-size-finder (version que
arrastraba los estilos de skin), verificar que las secciones de tema esten
acá y no se agreguen de nuevo al plugin.

## DISENO V2 - Rediseno de skin (en progreso, retomar proxima sesion)

### Contexto / decisiones del usuario
- Objetivo: que el sitio se vea **100% profesional, alto nivel y vanguardia**,
  refinando el tema hijo actual (NO rediseno profundo, NO migrar a Gutenberg).
- **Alcance**: SOLO el tema hijo `duna-child` (CSS/JS/functions). NO tocar opciones
  del panel Motors (Nuxy) ni contenido de paginas. El contenido roto/demo se deja
  para que lo gestione el usuario (solo se listo en el diagnostico).
- **Fuentes**: MANTENER las actuales (Exo 2 para titulos / Open Sans cuerpo).
- **Estetica**: MAS CUADRADA, tipo automotriz/industrial -> radios pequenos
  (0-4px) en vez de 10px actuales en cards; lineas rectas, sobrio.
- **Modo por defecto**: paridad total claro/oscuro (hoy el dark manda y el light
  es parcial/hex fijos). Sin cambio de modo por defecto; pulir ambos.
- **CACHE/OPTIMIZACION (LazyLoad, minify, etc.)**: se deja para UNA PROXIMA etapa
  (no se instala nada ahora).
- Contenido roto detectado (NO tocar, gestionar manual): footer widget
  "Quick Links" apunta a menu inexistente (term_id 172); menu Servicios ->
  paginas demo internas; FAQ con "Lorem ipsum"; Shop con categorias mezcladas
  (Marca/Neumaticos + categorias EN); widget Photo Gallery vacio; copyright con
  texto de Motors/Stylemix; header_phone secundario demo (878-3971 / 878-0910).

### Diagnostico tecnico del child (estado al inicio de la etapa)
- `assets/css/duna-child.css`: **1050 lineas**, **34,6 KB**, **167 usos de
  !important**. Overrides por capas: cards producto/sidebar (radius 10px),
  navbar cinta roja (clip-path 44px), topbar centrado, toggle, UNIFORM global
  (v1.0.2: superficies/inputs/tablas WC/single/productos), modo claro parcial,
  responsive movil (filtros drawer).
- Problemas detectados:
  1. **Css-escalada**: 167 !important; resets agresivos
     (`[style*="color:#fff"]`, `.wpb_text_column p`, `h1..h6` globales) que
     rompen colores inline intencionales (botones rojos con texto blanco).
  2. **Paridad claro/oscuro incompleta**: el modo light usa hex fijos y
     selectores parciales; superficies claras en oscuro o viceversa; logo con
     filtro gris probablemente invisible en claro.
  3. **Layout con floats fragiles**: cards/sidebar/footer usan floats +
     width fija + parches (`:not(:has())`, `::before` altura fija). No usa CSS
     Grid.
  4. **Accesibilidad**: `outline:none` + `box-shadow:none` en inputs eliminan
     el foco visible. Falta `:focus-visible` ring. Texto-soft `#b6bcc4` en
     oscuro con contraste bajo; objetivos tactiles <40px en algunos controles.
  5. **JS encoding**: literales con tilde en `duna-child.js` leidos como UTF-8
     muestran mojibake (`Categor��as` en aria-labels). Corregir guardando UTF-8.
  6. **Cohesion visual**: títulos Exo2 700 vs cuerpo Open Sans; rojo #df1d1d
     sobre casi-negros; texto secundario pequeño; secciones WPBakery demo
     (parallax) sin ritmo uniforme; falta micro-interaccion y estados hover.
  7. **Performance**: el parent carga ~641 KB `motorcycle/app.css` + ~64 KB
     header-motorcycle.css + bootstrap 47 KB (sin minificar). El child no debe
     anadir peso; consolidar (el child actual NO esta minificado; evaluar en la
     etapa de cache).
  8. Footer de columnas: ya arreglado en v1.0.3 (sin cajas/bordes; gutter 20px
     desktop, apilado <1200px con padding 16px). Ver historico 43-45.

### Fases del rediseno (para ejecutar)
- **F1 Fundamentos**: reorganizar duna-child.css en secciones (Tokens / Base /
  Header / Topbar / Buscador / Shop-grid / Sidebar / Productos / Single /
  Checkout-Cuenta / Footer / Light / Responsive / A11y / Utilidades).
  Centralizar TODOS los colores/superficies en variables `--wsf-*` con nombres
  semanticos. Reducir !important (<30, por especificidad/orden de carga).
  Fix encoding UTF-8 en JS. Bump version.
- **F2 Tipografia**: mantener Exo2+OpenSans; escala fluida con `clamp()`;
  ritmo vertical con `--space-*` (4/8/16/24/32/48/64); max-width coherente.
- **F3 Layout vanguardia**: migrar ul.products / cards / categorias / footer a
  CSS Grid (`auto-fill/minmax`, `gap`) con fallback; sidebar sticky; breakpoints
  explicitos (1500/1200/992/768/480).
- **F4 Interacciones/UX**: hover/focus/active uniformes en nav, submenus, cards
  (elevacion + borde brand), botones; transiciones 150-250ms con
  `prefers-reduced-motion`; `:focus-visible` ring (var `--wsf-focus`);
  touch target >=40px; scrollbar fina; estados de carga/sin-resultados del
  buscador; toasts/notices.
- **F5 Paridad claro/oscuro + pulido**: mover TODO a variables; el modo light
  solo redeclara variables. Revisar header/logo, topbar, buscador, tablas WC,
  select2, footer/copyright para paridad total. Ajustar contraste texto-soft y
  tamanos minimos. Detalles premium: hero/revslider overlay legible, badges,
  breadcrumb, estado carrito.
- **F6 QA + cierre**: Lighthouse local antes/despues (Perf/A11y/BP/SEO);
  screenshots headless desktop+mobile ambos modos; corregir regresiones con CDP.
  Git commit por fase.

### Estado F1 - [HECHO en v1.1.0] (05-historico item 46)
- Tokens semanticos en :root: --wsf-focus/--wsf-focus-ring, --wsf-radius(4)/
  --wsf-radius-sm(2)/--wsf-radius-lg(6), --wsf-space-1..7 (4..64),
  --wsf-container/--wsf-gutter. body.wsf-light redeclara focus/ring.
- Estetica cuadrada: cards productos y widgets de sidebar a 4px; botones
  (add-to-cart, wsf-cat-toggle, wsf-mobile-filters) a 2px.
- Eliminado reset light `[style*="color:#ffffff"...]` (pisaba colores de marca).
- Accesibilidad aditiva: :focus-visible ring + prefers-reduced-motion.
- JS encoding verificado valido UTF-8 (sin cambios).
- Backup pre-cambio: docs/backups/duna-child-v1.0.3.*.

### Estado F2 - [HECHO en v1.1.7] (05-historico items 47 + 54)
- Parrafos de contenido (.entry-content/.page-content-wrap/.wpb_text_column/
  .vc_column_text) a 15px + line-height 1.7 (v1.1.1).
- Titulos de contenido line-height 1.25; .vc_custom_heading con
  letter-spacing -0.01em + weight 700 (v1.1.1).
- Escala fluida clamp() en los titulos de la Home del plugin (v1.1.7):
  .wsf-categories-title (OFERTAS) y .wsf-logos-title a clamp() que mantiene
  el tamano desktop (24/22px) y baja fluido a 20/18px en movil. Corrige la
  inversion del media del parent (antes crecian a 26px en movil).
- Fuentes y tamanos base mantenidos. "La empresa" (plugin) no afectada.
- Ritmo vc_row / max-width: validado OK en la auditoria v1.1.5 (paddings
  WPBakery generosos); sin cambios forzados. F2 COMPLETO.

### Estado F3 - [HECHO en v1.1.6] (05-historico item 52)
- ul.products migrado a CSS Grid real (antes flex-wrap + widths % bootstrap
  contextuales con float inerte y gap 0). Regla base en duna-child.css
  (bloque F3): display:grid; repeat(3,1fr); column-gap 24px; row-gap 32px.
- columns-4 (OFERTAS home + related single) -> repeat(4,1fr).
- Breakpoints: columns-4 -> 3col <992; ambos -> 2col <768; 1col <576.
- li -> width auto/float none/padding 0; .stm-product-inner height:100%;
  boton Add-to-cart con margin:auto -> pie alineado en filas iguales.
- Fixes encontrados en la implementacion:
  1. ::before/::after del parent (limpieza de float con content:" "
     display:table) son ITEMS DE GRID fantasma de ~294px que ocupaban la
     primera celda -> content:none !important en el UL.
  2. Comentario CSS del child con "col-md-*/col-sm-*" cerraba el comentario
     antes de tiempo (el parser descartaba la regla display:grid); se
     corrigio el texto del comentario.
- Verificado CDP (matriz 11 anchos x shop/cat/home + related + buscador):
  shop/cat 3col >=768 / 2col @600 / 1col <=480; home columns-4 4col >=992
  (2 filas x 8 items) / 3col 768-991 / 2col @600 / 1col <=480; filas de
  altura igual (498/418px) con boton al pie; gaps reales 24px; sin overflow
  horizontal; paridad claro/oscuro OK (reflow forzado para leer estilos).
- Diferencia visual vs antes: cards ~294px (antes 290 con padding falso),
  gaps 24px (antes 0), 2 col en tablet 600-768 (antes 1). El card ya no
  tiene el padding 15px interno del li.
- Screenshots "after" para validar: C:\Users\Acer\AppData\Local\Temp\
  opencode\f3-after-v116\*.png
- Backup pre-cambio: docs/backups/duna-child-v1.1.5.{css,js}. Bump 1.1.6.

### PENDIENTE F1 restante
- Reorganizar el archivo CSS en bloques comentados por seccion.
- Seguir reduciendo !important por especificidad (tablas WC/checkout no
  verificables sin sesion -> difiere).

### Estado F5 - [PARCIAL en v1.1.3] (05-historico item 48)
- BUSCADOR (wheels-size-finder): paridad total resuelta. Causa raiz: el plugin
  pinta los selects con estilos INLINE !important leyendo variables --wsf-* de
  :root (documentElement), por lo que body.wsf-light nunca los aclaraba. Fix en
  child: variables claras declaradas tambien en html.wsf-light + el toggle del
  child aplica la clase al <html> y re-aplica los colores inline de los selects
  (applyWsfSelects) al cambiar de tema. VERIFICADO admin real: dark #161b22 /
  light #ffffff.
- Select de moneda (.wSelect-theme-classic) y paginacion del shop
  (.stm-blog-pagination .stm-prev-next / ul.page-numbers li a) a variables.
- PENDIENTE F5 para completar: revisar contraste de texto-soft y tamaños minimos,
  detalles premium (hero overlay, badges, breadcrumb, estado carrito), logo en
  modo claro.

### Estado F4 - [HECHO en v1.1.4] (05-historico item 49)
- Cards de producto con elevacion/sombra (tokens --wsf-shadow) + zoom de imagen
  al hover. Botones WooCommerce redondeados (radius-sm) con hover/active.
- Galeria de la ficha enmarcada como card.
- Header light = contenedor blanco + barra superior negra Duna (intencional).

### Estado F5 - [v1.1.5, auditoria OK] (05-historico item 50)
- AUDITORIA CDP: contraste texto-soft cumple AA en ambos modos; ritmo vertical
  de secciones Home OK (paddings WPBakery); logo del header OK (oscuro en
  ambos); badge de medida legible. No requirieron cambios.
- CARRITO del header: se activo el contador como burbuja roja con numero en
  blanco (el parent lo ocultaba, .list-badge display:none). VERIFICADO CDP.
- PENDIENTE F5/F6 para futuras sesiones: F3 grid real (requiere revision
  visual), F2 completar (clamp titulos Home), F6 QA Lighthouse + commit por
  fase. Cache/optimizacion = proxima etapa (fuera de scope).
  ACTUALIZADO v1.1.7/1.1.9: F3 HECHO (grid real), F2 HECHO (clamp titulos
  Home). F6 QA Lighthouse + fixes a11y/contraste del child en v1.1.8/1.1.9
  (abajo). Queda: cache (proxima etapa) + a11y del PLUGIN (fuera de alcance).

### Estado F6 - [QA Lighthouse + fixes child, v1.1.8/v1.1.9] (05-historico items 55-56)
- Lighthouse v13.4.1 local, baseline y post-fix.
  * baseline v1.1.6: home 50/70/96/92 | shop 54/81/96/85 | single 54/80/96/85
    (Perf/A11y/BP/SEO).
  * post-fix: shop A11y 81 -> 88; single A11y 80 -> 86. Home A11y 70 sin
    cambio (fallos restantes = plugin testimonios/buscador, fuera de scope).
- Fixes aplicados (solo child):
  1. Badge .wsf-product-measure -> pill relleno brand + texto blanco
     (AA 4.85:1 ambos modos; antes texto rojo 3.57:1 dark fallaba).
  2. Footer "DUNA" (.colored) -> var(--wsf-txt) (~15:1 ambos modos; el rojo
     no cumple AA en los 2 modos a la vez).
  3. Precio tachado del single (p.price del) -> var(--wsf-txt-soft) sin
     opacity (antes heredaba --wsf-txt a 50% = 4.44:1).
  4. Drawer .wsf-mobile-sidebar: inert + aria-hidden sincronizado con
     open/close + manejo de foco (fix aria-hidden-focus).
- Regresion final: 11 paginas x dark/light x 1367/375 = 44/44 OK.
- Perf 42-55: fluctuante, ligada al parent (~641KB css sin minificar) y a la
  etapa cache (fuera de scope). SEO 85-92: faltan meta-description/robots.txt
  (contenido/config, fuera del skin).

### Fix visual v1.2.0 - CTA plugin con texto del color del fondo (05-historico 57)
- Reporte: en pressure-pro-comercial el boton "Consultar por WhatsApp"
  (.wsf-cta) se veia rojo con el texto rojo (ilegible). Causa: el parent
  `.stm-template-motorcycle a { color:#df1d1d }` (0,2,0) ganaba por
  especificidad al `color:#fff` del plugin (0,1,0). Fix en child con
  `a.wsf-cta { color:#fff !important }` + hover. Verificado en las 9 paginas
  PressurePro + Contacto (ratio 4.85:1). Barrido del mismo patron en 13
  paginas x ambos modos: sin otros casos.
- LECCION: el parent pinta TODOS los `a` de rojo #df1d1d (spec alta). El
  child NO puede revertirlo con un `a` generico (spec menor). Para elementos
  con fondo propio (botones/CTAs) hay que forzar el texto con !important y
  especificidad suficiente. Detectar = buscar "fondo de color + texto del
  mismo color" (detector CDP en temp/opencode/duna-sat.js).

### Decisiones abiertas al retomar
- Radio final de cards/botones/inputs (sugerido 4px cards / 2px botones).
- Reduccion de la paleta roja vs superficies: mantener contraste AA.
- Confirmar si `footer_copyright_text` (texto Motors) se deja o se gestiona aparte.
- A11y del PLUGIN wheels-size-finder y del PARENT: PROXIMA SESION (detalle
  completo en docs/03-pendientes-y-bugs.md item 33). Fallos: dots de testimonios
  sin aria-label, selects sin label, autor de testimonio sin contraste (PLUGIN);
  [user-scalable=no] y falta de <main> (PARENT); touch targets pequenos;
  heading-order. DECIDIR: mitigar desde el child (CSS+JS+wp_head) vs autorizar
  tocar plugin/parent. Recomendado: intentar mitigar desde child primero.
- VISTA MOVIL: auditar a fondo en la misma sesion de a11y (375px: touch targets,
  overflow, drawer de filtros, topbar, menu).
- Contenido/SEO: RESUELTO en v1.3.0 (2026-09-05) - ver docs/03-pendientes-y-bugs.md
  item 31 y historico item 58: meta-description implementada en el child via
  wp_head (opcion A sin plugin), typo del tagline corregido, link "La empresa"
  ya apuntaba a /about-us/. Queda SOLO en produccion: robots.txt Sitemap apuntando
  al dominio real (hoy localhost:8881, causa del "invalid" local).
- Etapa cache/optimizacion: RESUELTO EN GRAN PARTE (historico 59-63). Autoptimize
  en modo solo-CSS con CSS como ARCHIVO (no inline de 2MB en el head). Resultado:
  Lighthouse navegador PERF 90 (FCP 0.8/LCP 0.9/CLS 0). Restan para produccion:
  cache headers, gzip, TTFB, imagenes pesadas de la home (~1.3MB), JS sin usar del
  parent.

### Nota sticky header (v1.1.5, sin cambios)
Reporte de usuario de navbar sticky "cortado" (logo de la cinta negra) resulto
NO-BUG: verificado por CDP que la estructura/alturas son correctas y en
incognito (sin cache) no se corta. Causa: CSS viejo cacheado de la sesion.
Detalle: docs/05-historico-sesion.md item 51 y docs/03-pendientes item 29.
Sugerencia al usuario: hard reload (Ctrl+F5).

### Estado SEO - [HECHO en v1.3.0] (05-historico item 58)
- Meta-description por tipo de pagina via hook `wp_head` prioridad 1 en
  `functions.php` (`duna_child_meta_description`): front_page / is_shop /
  is_product_category (nombre real de la categoria) / is_product (nombre+SKU)
  / contacto / about-us / PressurePro x9 / buscador / faq / service-inventory
  / cart / checkout / my-account / blog / is_singular (excerpt o titulo).
  Textos es-UY 120-155 chars. Guard `WPSEO_VERSION` (no pisa plugin SEO futuro).
- Typo del tagline corregido ("Aolienación" -> "Alineación | Neumáticos e
  Insumos", blogdescription). Link "La empresa" verificado OK (ya era /about-us/).
- Lighthouse SEO v13.4.1: Home 92->100 | Shop 85->100 | Single 85->100.
- Pendiente solo en produccion: robots.txt Sitemap al dominio real.

## Pendiente: Fase 2 - carga condicional de assets
El CSS/JS del plugin hoy cargan en todas las paginas del frontend. Cuando la
estructura del sitio este definitiva, implementar la carga condicional:
solo donde existen los shortcodes del plugin (css/js completos) o el badge de
medida (product-measure.css chico); el resto de paginas no descarga nada del
plugin. Detalle completo en `docs/03-pendientes-y-bugs.md` (item 26).

