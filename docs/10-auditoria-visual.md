# Auditoría visual del skin (duna-child v1.4.0) — FASE A

Fecha: 2026-09-07. Alcance: solo-child (sin tocar parent Motors, plugin
wheels-size-finder ni contenido). Metodología: 70 capturas full-page headless
(Chrome nuevo, CDP) + dump de estilos computados reales con reflow forzado.
El modelo SÍ pudo ver las capturas en esta sesión.

Rutas: `C:\Users\Acer\AppData\Local\Temp\opencode\auditoria-visual\`
(`<pagina>-<modo>-<ancho>.png` + `.json` con métricas + `_resumen.txt`).
Scripts: `duna-visual-audit.js` (matriz), `duna-probe.js`, `duna-probe2.js`,
`duna-probe3.js`, `duna-probe4.js` (focalizados).

Matriz cubierta: 13 páginas (`home shop categoria ficha buscador contacto
empresa blog cart checkout cuenta pressure faq`) x dark/light x 1367/375
(+ 768/1024 en home/shop/ficha/buscador) + `cart-full`/`checkout-full` con
ítem (ID 5667). URLs 200 verificadas las 13.

## Base sana (no requiere acción)

- Sin overflow horizontal en ninguna celda; sin errores JS salvo el conocido
  `ERR_CONNECTION_REFUSED` a `localhost:3002` (API del buscador apagada).
- Paridad claro/oscuro de superficies OK: body `#0d1117`/`#f7f8fa`, wrapper
  `#0d1117`/`#fff`, cards `#161b22`/`#fff`, inputs `#161b22`/`#fff`, footer
  `#0d1117`/`#f5f5f5`, topbar `#0e1315`-ish/`#f5f5f5`. Barrido de drifts = 0
  en las 13 páginas x ambos modos.
- Grid F3 intacto: shop/cat 3col ≥768 / 1col ≤480; home OFERTAS 4col ≥992,
  3col 768-991, 1col 375; gaps y equal-height OK; drawer "Filtros" <992 OK;
  topbar oculta <992; burbuja del carrito funciona (muestra "1" con ítem).
- Tipografías cohesivas: Exo 2 en títulos, Open Sans en cuerpo; precios
  20px/700; badges pill brand+blanco AA en ambos modos.
- Breadcrumb simple del parent SÍ existe ("HOME / SHOP", "DUNA NEUMÁTICOS >
  ...") en shop/cat/ficha/buscador/blog/cart/cuenta/faq/pressure
  (pendientes item 18: cubierto sin navxt).

## Hallazgos solo-child (ordenados por impacto)

### C1. Contacto @375: el H2 "Contacto" queda debajo del ribbon (overlap real)
Contacto no tiene `.entry-header` (el H2 WPBakery va directo en el contenido)
y la cinta de navegación (`position:absolute`, bottom en y=166) lo tapa:
H2 en y=101 < navBottom 166 (shop/faq no se afectan: su H1 arranca en y=195
gracias al titlebox). Solo móvil. Fix child (CSS): aire superior al contenido
de contacto bajo 992px (ej. `page-id-712` padding-top o min-height del primer
bloque). Región: `duna-child.css` Responsive.

### C2. El plugin pisa `--wsf-radius`: cards en 6px en vez de 4px
El plugin emite `<style>:root{...--wsf-radius:6px...}` (setting
`wsf_input_border_radius`) DESPUÉS del CSS agregado → pisa el token del child
(`--wsf-radius:4px`) por orden de cascada. Medido servido: `--wsf-radius:6px`
en `:root`; `.stm-product-inner` computa `6px` (decisión V2: 4px). El
`border-radius:var(--wsf-radius)` del child en L184 queda neutralizado.
También afecta al CTA `.wsf-cta` (6px) y al submit CF7 (medido 6px).
Fix child (CSS, sin tocar plugin): redeclarar con especificidad mayor que
`:root` (0,1,0), ej. `html:root{--wsf-radius:4px;--wsf-radius-sm:2px;
--wsf-radius-lg:6px}`. Nota: el `var(--wsf-radius,6px)` interno de los selects
del plugin no se ve afectado (sigue 6px en sus inputs). Región: tokens `:root`.

### C3. Titlebox gris plano en modo claro (9 páginas)
`.entry-header.small_title_box` sin imagen queda como bloque gris
`#f7f8fa` de ~222-398px sobre wrapper blanco (shop/cat/ficha/buscador/blog/
cart/cuenta/faq/pressure en light). En dark es coherente (`#0d1117`). Además
el H1 de archivo es 45px fijo también en 375 ("SHOP"/"BATERÍAS"/"MY ACCOUNT"
muy grandes en móvil; los vc_custom_heading sí bajan 36→26).
Fix child (CSS): en light, titlebox a `#fff` + borde inferior sutil, y clamp
del H1 del titlebox en <768. Región: Titlebox + Responsive.

### C4. CTA "Proceed to Checkout" sin énfasis (carrito con ítem)
`.wc-proceed-to-checkout a` gris con texto rojo apagado: el paso clave del
funnel sin jerarquía (ver `cart-full-dark-1367.png`). Fix child (CSS):
fondo brand + texto blanco + radius-sm + hover brand-hover.
Región: WooCommerce/tablas.

### C5. Selects del checkout por bloques en blanco (modo dark)
Checkout de Woo por bloques: selects País/Estado blancos sobre formulario
oscuro (`checkout-full-dark-1367.png`). Fix child (CSS):
`.wc-block-checkout select, .wc-block-components-select select` a
surf/txt/border + `color-scheme: dark`. Región: WooCommerce/checkout.

### M1. Tabla de atributos de la ficha pequeña (12px, parent)
`table.shop_attributes th/td` a 12px del parent; contenido denso (incluye fila
"YEARS" larguísima). Mejora child: 13-14px + padding vertical + `th`
txt-soft. Región: Single product.

### D1. Sin scrollbar propia (detalle)
El child no estiliza scrollbar; se usa la nativa. Detalle opcional:
`::-webkit-scrollbar` fina (10px, thumb border) + `scrollbar-color` Firefox.
Región: nueva sección Utilidades.

## Patrones transversales de CONTENIDO (no skin; gestiona el usuario)

- **Inglés sin traducir (falta .mo es-UY de Woo/Motors**: `wp-content/
  languages/` solo trae core+admin): `Shop/Cart/Checkout/My account/Newsroom`,
  `Add to cart/Read more/Sale!`, formularios cart/checkout/cuenta completos
  ("Your cart is currently empty!", "New in store", "Proceed to Checkout",
  "Billing address...", "Login/Remember me/Lost your password?"),
  tabs ficha ("ADDITIONAL INFORMATION/REVIEWS (0)", "Additional Information",
  "4 in stock"), "NO COMMENTS" del blog, switcher de moneda
  ("United States (US) dollar"). Vía: instalar traducciones es-UY
  (Actualizaciones → Traducciones o Loco Translate). Mapea a pendientes 15.
- **Demo visible**: home icon-box EN ("ONLINE APPOINTMENT...") + parallax
  "WELCOME TO THE MOTORS WORLD / READ MORE"; blog sidebar demo ("TEXT WIDGET"
  EN, "ARCHIVE" vacío, "MEDIA LIBRARY", "Recent posts"); footer "PHOTO GALLERY"
  vacío + copyright Motors/StylemixTexts; FAQ 100% Lorem ipsum; modales
  ocultos del parent ("Request car price..."). Vía: edición de contenido /
  Widgets / customizer (`footer_copyright_text`).
- **Datos**: precios `U$S 0,00` (padres/sin precio), placeholder sin imagen
  (~10, pendiente 3), taxonomías EN mezcladas (`Oil & Filters/Parts/Wheels/
  Uncategorized` + `Sin categorizar (0)`), fila "YEARS 2002...2022".
  Formato `$2 500`/`$1.500` = pendiente 16 (abierto).

## Top fixes propuestos (solo-child, en tandas)

1. T1: token radius blindado `html:root` → cards/botones a 4/2px (C2).
2. T1: titlebox light a blanco + borde + H1 clamp móvil (C3).
3. T1: CTA checkout a brand+blanco (C4) + selects checkout blocks dark (C5).
4. T1: aire superior contacto <992 (C1).
5. T2: atributos ficha 13-14px + padding (M1).
6. T2: scrollbar fina propia (D1).
7. Opcional: reducir `!important` (206 hoy) sin cambio visual — riesgo
   medio, se propone NO hacerlo en esta tanda salvo pedido expreso.
8. Contenido (usuario): traducciones, widgets demo, FAQ, copyright, precios 0.

Verificación por tanda: CDP antes/después + regresión matriz sin overflow +
Lighthouse A11y/SEO sin bajar (Perf navegador ~90). Si se toca CSS:
clearall de Autoptimize + perfil Chrome nuevo.

## T1 APLICADA (2026-09-07, child v1.5.0)

Tanda aprobada: C1-C5. Solo `duna-child.css` + bump de versión
(`style.css` + `functions.php` 1.4.0 → 1.5.0). Backup pre-cambio:
`docs/backups/duna-child-v1.4.0.{css,js}`. Sin tocar plugin/parent/contenido.

- **C2**: bloque `html:root{--wsf-radius:4px;--wsf-radius-sm:2px;
  --wsf-radius-lg:6px}` (spec 0,1,1 > `:root` 0,1,0 del `<style>` inline del
  plugin) → `.stm-product-inner` computa **4px** (antes 6px) en dark/light.
- **C3**: `body.wsf-light .entry-header/.stm_titlebox/.title-box` a `#fff` +
  borde inferior `var(--wsf-border)`; H1 del `.small_title_box` con
  `clamp(26px,7vw,36px)` en <767px (desktop 45px intacto).
- **C4**: CTA del carrito por bloques a primario de marca (fondo
  `var(--wsf-brand)` + texto blanco + radius-sm + hover brand-hover).
  Verificado: `rgb(223,29,29)/rgb(255,255,255)` (~4.85:1 AA).
- **C5**: selects del checkout por bloques a surf/txt/border + `color-scheme`
  por modo.
- **C1**: `page-id-712` con padding-top 96px en <991px → H2 "Contacto" en
  y=293 (navBottom 166), sin overlap en 375 (antes y=101).

Verificación T1 (perfil Chrome nuevo, Autoptimize clearall + regenerado):
regresión 11 páginas x dark/light x 1367/375 (+768/1024 complejas) sin
overflow ni drifts (2 celdas light leídas en dark = artefacto de carrera ya
conocido; re-check puntual OK en light). Lighthouse CLI v13.4.1:
home A11y 100 / BP 100 / SEO 92 (solo `robots-txt` local) = shop A11y 100 /
BP 100 / SEO 92. Sin bajas vs v1.4.0. Capturas: `auditoria-visual/t1-after/`
+ `t1-regress/`.

## T2 APLICADA (child v1.5.1)

- **M1**: `table.shop_attributes th/td` a 13.5px/1.6 + padding 10px 14px;
  `th` en txt-soft uppercase nowrap; `td` en txt con `overflow-wrap:anywhere`.
  Verificado: 13.5px servido, sin overflow, captura `t2-after/`.
- **D1**: scrollbar propia fina (`scrollbar-width:thin` + `scrollbar-color`;
  `::-webkit-scrollbar` 10px, thumb border, hover brand; variante light).
  Verificado: `scrollbarWidth=thin` computado.
- Solo CSS + bump 1.5.1. Backup `docs/backups/duna-child-v1.5.0.css`.
  Autoptimize clearall + regenerado con T2 (T2-M1/T2-D1 presentes en el CSS
  agregado). Lighthouse ficha: A11y 100 / BP 100 / SEO 92 (solo robots-txt
  local). Paridad T1 intacta (re-check shop/categoria light OK, cards 4px).
