# Diagnostico del sitio + plan de rediseno v2 (tema hijo)

> Alcance: SOLO `wp-content/themes/duna-child` (CSS/JS/functions.php).
> NO tocar: tema parent motors, opciones del panel Motors (Nuxy), contenido de
> paginas, plugins. Cache/optimizacion = etapa posterior.
> Fecha del relevamiento: sesion de rediseno (ver docs/07-tema-hijo.md "DISENO V2").

## 1. Stack y arquitectura
- WP 7.0.3 + **Motors 5.6.95** (layout **motorcycle**, clasico, no Gutenberg) +
  child **duna-child 1.0.3** + WPBakery 8.7.2 + WooCommerce 11.0.1 + Revolution
  Slider 6.7.38 + CF7 6.1.6 + Currency Switcher (WP Wham) 2.16.6 +
  breadcrumb-navxt + stm-megamenu + motors-wpbakery-widgets +
  motors-car-dealership-classified-listings + stm-motors-extends + envato-market
  + spotlight-social-photo-feeds + wheels-size-finder.
- Front page = pagina estatica 4300 (Home) con WPBakery: revslider `home_slider`
  -> buscador `[wheels_finder]` -> categorias `[wsf_categories]` (12) ->
  icon-boxes x6 -> ofertas `[products on_sale]` -> parallax -> "La Empresa" ->
  logos clientes `[wsf_client_logos]`.
- Datos: 516 productos, ~500 categorias (desordenadas: "Marca 241",
  "Neumaticos 266", categorias EN "Accessories/Oil & Filters/Parts"), 560
  attachments, **463 MB** en uploads/2026, un unico usuario admin.
- Opciones Nuxy (motorcycle) relevantes: site_style `site_style_default`,
  header `motorcycle`, `header_sticky=true`, `header_bg_color #0e1315`,
  `header_cart_show=true`, top_bar activa, `footer_sidebar_count=4`,
  `footer_bg_color #161e21`, custom_css con 2 reglas.

## 2. Problemas de CONTENIDO (no se tocan; gestion manual)
1. Footer: widget "Quick Links" -> menu `nav_menu` **term_id 172 inexistente**.
2. Menu "Servicios" + hijos (Alineacion/Balanceo/Chequeo) -> paginas demo
   internas Motors (Inventory 639, Modern 808, Sold 4337); duplican destino.
3. FAQ (986): toggles "Lorem ipsum..." demo.
4. Shop: muchas categorias mezcladas / EN / vacias (OTR 0, Uncategorized).
5. Widget central footer "Photo Gallery" (#text-6) vacio.
6. `footer_copyright_text` con creditos Motors/Stylemix; phone secundario demo
   (878-3971-3223 / 878-0910-0770) en options Nuxy; header_phone_label demo
   ("Call us FREE", etc.).
7. Paginas demo del bottom_menu (Sell a Motorcycle 1414, Loan Calculator 932,
   Coming soon 777, Typography 300, Shortcodes 848, Service 546) no aplican al
   rubro real.

## 3. Problemas de TEMA HIJ0 / CODIGO (si se atacan en v2)
- `assets/css/duna-child.css`: **1050 lineas / 34,6 KB / 167 !important**.
- Resets agresivos que rompen colores intencionales:
  `[style*="color:#fff"] { color:#1a1a1a !important }` (afecta botones rojos con
  texto blanco inline), `h1..h6 global`, `.wpb_text_column p` -> gris oscuro en
  claro.
- Paridad claro/oscuro incompleta: light usa hex fijos y overrides parciales;
  superficies claras en oscuro y viceversa; `--wsf-logo-filter` gris hace el
  logo probablemente invisible en claro.
- Layout floats fragiles: ul.products/cards/sidebar con floats + width fija +
  parches (`:not(:has())` para spacer, `::before` altura 34px). No usa CSS Grid.
- Accesibilidad: `outline:none` + `box-shadow:none` en inputs elimina el foco
  visible. Falta `:focus-visible`. Texto-soft #b6bcc4 bajo contraste. Touch
  target <40px en flecha/toggle/close.
- JS encoding: literales con tilde en `assets/js/duna-child.js` muestran
  mojibake `Categor��as` (guardado/leido mal). Fix: reescribir en UTF-8.
- Cohesion: títulos Exo2 700 vs cuerpo Open Sans; rojo #df1d1d sobre casi
  negro; texto secundario pequeño; secciones demo WPBakery (parallax oscuro)
  sin ritmo uniforme; sin micro-interacciones ni hover consistentes.
- Performance: parent ~641KB motorcycle/app.css + 64KB header-motorcycle.css +
  47KB bootstrap, sin minificar; child sin minificar (dejar para etapa cache).
- Footer de columnas: ARREGLADO en v1.0.3 (sin cajas; gutter 20px desktop;
  apilado <1200 con padding 16px; card de sidebar de tienda intacta).

## 4. Plan de ejecucion (F1-F6) - resumen
- **F1 Fundamentos**: reorganizar CSS por secciones; tokens semanticos unicos en
  `:root` + `body.wsf-light`; reducir !important a <30; fix encoding JS; bump
  version.
- **F2 Tipografia**: mantener Exo2+OpenSans; `clamp()` fluido; `--space-*`;
  ritmo y max-width coherentes.
- **F3 Layout**: CSS Grid en productos/cards/categorias/footer; sidebar sticky;
  breakpoints 1500/1200/992/768/480.
- **F4 Interacciones/UX**: hover/focus/active uniformes; transiciones
  150-250ms + `prefers-reduced-motion`; `:focus-visible` ring; touch>=40px;
  scrollbar fina; estados carga/sin-resultados; toasts.
- **F5 Paridad claro/oscuro + pulido**: todo a variables; light solo redeclara;
  revisar logo/header/buscador/tablas/select2/footer; contraste; detalles
  premium (hero overlay, badges, breadcrumb, carrito).
- **F6 QA**: Lighthouse antes/despues; screenshots headless desktop+mobile en
  ambos modos; CDP para regresiones; commit por fase.

## 5. Decisiones del usuario (cerradas para v2)
1. Mantener fuentes actuales (Exo2 titulos / Open Sans cuerpo).
2. Estetica MAS CUADRADA tipo automotriz -> radios 0-4px (no 10px).
3. Cache/optimizacion: NO ahora, en proxima etapa.
4. Alcance: solo child (no tocar Nuxy/contenido).
5. Modo: paridad total claro/oscuro (sin cambiar modo por defecto).
