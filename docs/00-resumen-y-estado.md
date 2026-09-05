# Wheels Size Finder — Duna Neumáticos: Resumen y Estado

## Proyecto
Web de venta de neumaticos para todo tipo de vehiculos (grandes y chicos) +
productos relacionados al automotor. Tema: **Motors (motorcycle template)**.
Entorno local: WordPress Studio (SQLite), http://localhost:8881 (admin/admin).
Backend API Node del buscador: http://localhost:3002.

## Estado actual (verificado)
- **516 productos WooCommerce** importados desde duna.com.uy (REST API solo lectura):
  487 via paginacion + 19 via ID (paginacion inestable del remoto).
  203 variaciones, 533 imagenes, 46 atributos globales (pa_*), 80 categorias (jerarquicas).
   Ajustes: moneda base USD, formato $1.234,56. MULTI-MONEDA USD/UYU activa
   (Currency Switcher WP Wham, ver 06-multi-moneda.md).
- **Buscador wheels-size-finder v1.2.6**:
  - Campo nuevo `_wsf_tire_size` (post meta) en 181 productos, extraido del titulo.
  - `find_by_sku` busca en `_sku` y `_wsf_tire_size` (= y LIKE), normaliza entrada.
  - Funciona por medidas y por vehiculo (end-to-end verificado).
- **Tema hijo duna-child v1.3.0** (skin del sitio, ver docs/07-tema-hijo.md):
  - v1.0.3: footer sin cajas/bordes + gutter 20px desktop + apilado <1200px con
    padding 16px movil (historico 43-44).
  - v1.1.0: REDISENO V2 F1 - tokens semanticos (radius 4/2/6px cuadrada,
    spaces, focus), estetica cuadrada aplicada a cards/sidebar/botones, reset
    de modo claro `[style*=color]` eliminado, :focus-visible +
    prefers-reduced-motion.
  - v1.1.1: REDISENO V2 F2 parcial - parrafos de contenido a 15px/1.7,
    titulos line-height 1.25, tracking en vc_custom_heading.
  - v1.1.3: REDISENO V2 F5 parcial - PARIDAD del BUSCADOR resuelta (el plugin
    pinta selects inline leyendo :root; se declaran variables claras en
    html.wsf-light y el toggle re-aplica colores con applyWsfSelects);
    wSelect de moneda y paginacion shop a variables.
  - v1.1.4: REDISENO V2 F4 - sombras/elevacion en cards de producto (tokens
    --wsf-shadow), zoom de imagen al hover, botones WooCommerce con radius
    cuadrada + hover/active, galeria de ficha enmarcada como card.
  - v1.1.5: REDISENO V2 F5 - auditoria CDP (contraste/ritmo/logo/badge OK, sin
    cambios) + contador del carrito del header activado como burbuja roja
    (el parent lo ocultaba).
  - Reporte sticky header "cortado": NO-BUG (cache de sesion; verificado en
    incognito). Docs: historico 51, pendientes 29. Sin cambios de codigo.
  - v1.1.6: REDISENO V2 F3 - GRID REAL: ul.products migrado de flex-wrap +
    widths % bootstrap a CSS Grid (3col shop/categorias/buscador, 4col home
    OFERTAS/related, 2col <768, 1col <576, gaps 24px, equal-height por fila).
    Fix de ::before/::after del parent que eran items de grid fantasma.
    Verificado por CDP (matriz responsive sin overflow + paridad claro/
    oscuro). Backup duna-child-v1.1.5.{css,js}. Historico 52.
  - v1.1.7: REDISENO V2 F2 completado - escala fluida clamp() en los titulos
    de la Home del plugin (OFERTAS/logos; corrigen la inversion del media del
    parent que los hacia crecer en movil). Historico 54.
  - v1.1.8/v1.1.9: REDISENO V2 F6 - QA Lighthouse local + fixes de
    contraste/a11y del child (badge de medida pill brand+blanco AA 4.85:1;
    "DUNA" del footer a var(--wsf-txt); precio tachado del single a txt-soft;
    drawer con inert+aria sync y manejo de foco). Shop A11y 81->88, single
    80->86. Regresion final 11 paginas x 2 modos x 2 anchos = 44/44 OK.
    Historico 55-56.
  - v1.2.0: fix visual del CTA del plugin (.wsf-cta) que el parent pintaba
    con texto rojo sobre fondo rojo (ilegible) en las 9 paginas PressurePro +
    Contacto. Override child con texto blanco !important (AA 4.85:1). Barrido
    del patron "texto=color de fondo" en 13 paginas x 2 modos: sin otros
    casos. Historico 57.
  - v1.3.0: SEO - meta-description por tipo de pagina via wp_head en
    functions.php (opcion A, sin plugin) + fix del typo del tagline
    "Aolienación"->"Alineación | Neumáticos e Insumos". Lighthouse SEO:
    Home 92->100 | Shop 85->100 | Single 85->100. Historico 58.
  - v1.3.1: optimizacion Google Fonts - recorte de 28 a 7 variantes (se quito
    Montserrat no usada + pesos/itálicas innecesarios; Open Sans 400/600/700 +
    Exo 2 400/500/600/700 + display=swap) via functions.php. Lighthouse real en
    navegador (incognito): Perf 70/A11y 70/BP 96/SEO 92. Historico 60.
  - v1.3.2: precarga de la imagen del hero (fachada.webp) via <link rel=preload>
    en la home (wp_head prio -10, antes del <style> inline gigante de 2MB de
    WooCommerce). Adelanta la descarga del hero ~1s (el techo es el TTFB local
    ~3s; en produccion mejora el LCP real). Historico 61.
  - ESTADO: rediseno V2 del child COMPLETO (F1-F6) + fixes visuales
    puntuales + SEO basico (meta-description) implementado + fuentes
    optimizadas. Pendientes no-child: a11y del plugin (testimonios/buscador),
    robots.txt Sitemap a dominio real en produccion (item 31), CLS del slider
    RevSlider, imagenes grandes sin width/height, JS/CSS no usado del parent.
  - OPTIMIZACION (2026-09-05, historico 59): se instalo Autoptimize 3.1.15.1
    en modo solo-CSS (minify+agregar+diferir; JS intacto por RevSlider). El
    Perf local sigue bajo (home 43) por el TTFB del servidor Studio (~2.5s),
    no por assets; beneficio real en produccion.
- **Home**: seccion "PRODUCTOS" (titulo WPBakery) con 4 cards de categorias de
  LISTINGS (Motorcycles, Scooters, ATVS, Watercraft) -> A REEMPLAZAR por categorias WooCommerce.
- **7 listings demo** (motos) -> a convertir en SERVICIOS o eliminar.
- **Motors PRO: NO instalado** (free). Venta online de listings no disponible (irrelevante).
- **Plugins**: revisados (ver 01-plan y tabla completa en pendientes).

## Credenciales / avisos
- API duna.com.uy (consumer key/secret): BORRAR la clave en el sitio real al terminar.
- wsf_license_status=active (clave test WSF-TEST-2024-0001).
- stm_motors_token="activated" (placeholder demo) — validar licencia del tema en produccion.
