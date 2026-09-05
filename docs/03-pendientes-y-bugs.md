# Pendientes y Bugs

## Corregidos (sesiones previas)
1. Selects invisibles/colores: tema Motors ocultaba selects (opacity/visibility) +
   convertia a Select2 (app-select2.js). Fix: CSS !important + restoreSelects() + applyColors().
2. Popup desplegable claro: color-scheme por luminosidad + opciones con colores propios.
3. Add-to-cart: URL apuntaba a admin-ajax.php (reescritura del tema en AJAX).
   Fix: URL explicita cart/?add-to-cart=ID (variables -> pagina del producto).
4. Flecha de selects: anclada al item (quedaba alta) y duplicada en admin (CSS de WP
   .wp-core-ui select). Fix: .wsf-select-wrap::after + background-image:none en selects.
5. Paneles invisibles con mode="both": ahora se activa el panel de la pestana activa.
6. Toolbar admin flotante (sticky) tapaba controles: se hizo static.
7. Paginas duplicadas (3x import demo): 14 movidas a papelera; menu "Productos" -> /shop/.
8. RevSlider en SQLite: ORDER BY 'id' 'ASC' rompe en SQLite. Fix: mu-plugin
   wp-content/mu-plugins/revslider-sqlite-compat.php (filtro 'query'). Inerte en MySQL.
9. Buscador sin resultados: campo _wsf_tire_size + busqueda ampliada.
10. 19 productos faltantes (paginacion remota): importados por ID.

## Bugs/Pendientes abiertos
1. find_by_sku solo busca post_type=product: las VARIACIONES con SKU no son
   encontrables (solo padres). Decidir si buscar en product_variation.
2. LIKE en _sku/_wsf_tire_size puede dar falsos positivos (ej. 205/65R15 dentro de
   otro SKU). Opcional: refinar (busqueda exacta primero, LIKE solo si 0 resultados).
3. ~10 imagenes fallaron en la importacion (productos sin foto). Reintentar/faltan.
4. Productos sin precio (padres de variables) o precio 0: revisar si son correctos
   o faltan datos en el remoto.
5. Home seccion PRODUCTOS: REEMPLAZADA en F3 por [wsf_categories] (6 categorias reales).
   Ajuste posterior: titulo "CATEGORIAS", grid 3 columnas desktop / 2 tablet / 1 movil,
   imagen 260px, colores propios de las cards (independientes de la config del buscador:
   si el usuario pone wsf_card_bg/wsf_text_color en blanco, las cards de la home no se
   ven afectadas).
6. Listings demo: a papelera en F2 (9); vaciar papelera antes de produccion.
7. Duplicados de listings/posts de las 3 importaciones demo: solo limpiamos paginas;
   revisar posts/adjuntos duplicados.
8. Currency switcher: REACTIVADO y configurado USD+UYU (multi-moneda, ver 06-multi-moneda.md).
9. Widgets footer: shortcode [instagram feed=4339] del tema vs Spotlight.
10. stm_importer activo: desactivar antes de produccion. — DESACTIVADO
11. stm_motors_token "activated" (placeholder): validar licencia del tema real.
12. Verificar trash (papelera) de las 14 paginas y los 9 listings antes de produccion.
13. gtranslate/gutentor/mailchimp/add-to-any/stm-elementor-icons: desactivados.
14. Ficha de producto: la medida (_wsf_tire_size) SI se muestra en ficha y cards (F4).
15. F2: formularios de servicios en ingles (Schedule test drive, Trade In, Request a quote,
    Calculate Payment...) — traducir via child theme o translations de motors.
16. F2: precios de servicios en USD sin formato local ($1500 en vez de $1.500) — verificar
    formato de precio de listings (affix/simbolo). — Parcial: la ficha muestra "$2 500".
17. F2: la seccion home "FEATURED HOT DEALS" no muestra los servicios (configurada con
    listings especificos del demo o especiales) — revisar en F3.
18. F4: breadcrumbs (breadcrumb-navxt) no se renderizan en shop/ficha (el tema usa su
    propio layout) — integrar si se desea.
19. F4: sidebar de shop oculto en pantallas <992px (hidden-sm/hidden-xs del tema) —
    los filtros no estan disponibles en movil.
20. LOGOS DE CLIENTES: IMPORTADOS desde duna.com.uy (10 logos: CUTCSA, UTE, Cielo Azul
    Cemento, Comuna Canaria, IMM, COETC, DB Schenker, Ras Logistica, Malteria Oriental,
    Hipodromo Las Piedras). Attachments con meta _wsf_client_logo=1 (IDs 5772-5781).
    Aparecen en la home con CSS blanco/transparente (grayscale+brightness+invert).
21. CF7 "Contacto" (id 5751): probar envio real de email (ajustar SMTP si el hosting
    no envia con wp_mail). Destino: info@duna.com.uy.
22. Agendar Cita / Cotizar / Mi Garage: se haran como PLUGINS NUEVOS (fuera de scope).
    Mi cuenta de WooCommerce ya cubre el "garage" basico.
23. Multi-moneda USD/UYU: RESUELTO - ecommerce bimoneda con Currency Switcher WP Wham
    (ver 06-multi-moneda.md). Simbolos: USD="U$S", UYU="$". Pendientes de esa config:
    fuente TC (BCU/manual), placement del switcher (solo ficha hoy), validar gateway
    (liquida en USD base), envio/cupones/rounding en ambas monedas. El real usaba
    WOOCS: evaluar migrar a WOOCS si se quiere coherencia con el remoto.
24. PressurePro: paginas creadas sin imagenes (iconos FA). Si se consiguen fotos,
    reemplazar iconos.
25. Blog: 2 posts reales creados; los posts demo estan en papelera.
26. FASE 2 - CARGA CONDICIONAL DE ASSETS DEL PLUGIN (para implementar luego,
    cuando la estructura definitiva del sitio este cerrada):
    - Hoy wheels-finder.css/.js cargan en TODAS las paginas del frontend
      (~31 KB CSS + ~18 KB JS innecesarios en blog/contacto/tienda/fichas/servicios).
    - Objetivo: cargarlos solo donde se usan.
    - Dividir assets:
      * wheels-finder.css/.js COMPLETO -> solo paginas con shortcodes del plugin
        (has_shortcode: [wheels_finder], [wsf_categories], [wsf_client_logos]).
      * product-measure.css (nuevo, ~2 KB) -> solo con badge .wsf-product-measure:
        is_product(), is_shop(), is_product_category() y home (OFERTAS [products]).
      * CSS dinamico del customizer (:root{--wsf-*} actual inline) -> reubicar en el
        child o junto al css del badge (evaluar).
    - Logica de enqueue en class-assets.php:
        shortcode presente        -> css+js completos (con CSS dinamico)
        is_product/shop/cat/home -> solo css del badge
        resto                     -> nada del plugin
      (validar buscador dentro de widgets de texto/custom builders si aplica).
    - Verificacion: suite completa (home, shop, categoria, ficha, blog, contacto,
      servicios, buscador) en ambas modalidades.
    - Medicion antes/despues: bytes css+js por tipo de pagina.
27. REDISENO V2 del skin (solo child, plan en docs/07-tema-hijo.md "DISENO V2"):
    F1 HECHO (v1.1.0: tokens, estetica cuadrada 4/2px, reset light eliminado,
    :focus-visible + prefers-reduced-motion). F2 PARCIAL (v1.1.1: parrafos de
    contenido 15px/1.7, titulos line-height 1.25, vc_custom_heading tracking).
    F5 PARCIAL (v1.1.3: paridad buscador via html.wsf-light + applyWsfSelects;
    wSelect moneda y paginacion shop a variables). F4 HECHO (v1.1.4: sombras/
    elevacion cards, zoom imagen, botones WC radius+hover, galeria ficha card).
    Pendiente: completar F2 (clamp titulos Home), F3 grid real,
    F5 contraste/texto-min/logo, F6 QA. Decisiones: mantener fuentes, alcance
    solo child, cache=proxima etapa.
    AVANCE v1.1.5: auditoria CDP de F5 confirmo contraste/ritmo/logo/badge OK
    (sin cambios); se activo el contador del carrito del header como burbuja
    roja (el parent lo ocultaba). Restan F3 (grid real), F6 QA y cache.
    AVANCE v1.1.6: F3 HECHO - ul.products migrado a CSS Grid real (3col shop/
    categorias/buscador, 4col home OFERTAS/related, 2col <768, 1col <576,
    gaps 24px, equal-height por fila; fix ::before/::after fantasma del
    parent; fix comentario CSS col-md-*). Verificado CDP sin regresiones
    (historico 52, 07-tema-hijo Estado F3). PENDIENTE: F2 clamp titulos Home
    (diferido por revision visual, historico 53), F6 QA Lighthouse + commit
    por fase.
    AVANCE v1.1.7-1.1.9: F2 HECHO (v1.1.7 clamp titulos plugin Home);
    F6 QA Lighthouse + fixes de contraste/a11y del child (v1.1.8 badge pill
    brand+blanco, footer .colored a var(--wsf-txt), v1.1.9 del del single a
    txt-soft; v1.1.8 drawer inert+aria sync). Shop A11y 81->88, single
    80->86. Regresion final 44/44 OK (items 54-56). QUEDA del rediseno:
    nada en child (F1-F6 completos). Pendientes NO-child: a11y del PLUGIN
    (testimonios/buscador), SEO contenido (meta-description/robots), etapa
    cache (item 28). Git commit por fase aun pendiente si se desea.
28. ETAPA CACHE/OPTIMIZACION - PARCIALMENTE RESUELTO (2026-09-05, ver historico 59):
    - Se instalo y configuro Autoptimize 3.1.15.1 en modo SOLO-CSS (minify +
      agregar + diferir CSS en 1 archivo no-bloqueante; autoptimize_js=0).
      El parent/plugins seguian ~950KB CSS en ~30 hojas render-blocking; ahora
      un solo archivo diferido. JS intacto (autoptimize rompe RevSlider si lo
      toca: "SR7 is not defined").
    - DIAGNOSTICO CLAVE: el Perf local (home 43/shop 55/single 50) esta dominado
      por el TTFB del servidor WordPress Studio (~2.5s en todas las paginas, SQLite
      sin opcache de pagina), NO por los assets. El score local no mejora con
      optimizacion de CSS porque Lighthouse penaliza server-response-time
      (~3147ms savings). El beneficio real de Autoptimize se vera en PRODUCCION
      (TTFB normal).
    - PENDIENTE en produccion: (a) habilitar defer/agregar JS con exclusiones
      finas (requiere testeo real, hoy rompe RevSlider en local), (b) page cache
      (WP Super Cache u otro) para atacar el TTFB de produccion, (c) diferir/
      reducir Google Fonts (28 variantes de 3 familias, render-blocking).
29. NAVBAR STICKY "CORTADO" (reporte de usuario): RESUELTO = no-bug. El usuario
    vio el logo de la cinta negra del header cortado al scrollear, pero en una
    ventana de INCOGNITO (sin cache previo) NO se corta. Diagnostico CDP completo
    en 05-historico item 51: estructura/alturas verificadas correctas (barra
    81px + logo 37px centrado + menu rojo 50px visible). Era cache/CSS viejo de
    la sesion del navegador. Si reaparece: hard reload / incognito, y revisar
    la altura de .stm_mc-main en sticky.
30. CTA del plugin con TEXTO DEL MISMO COLOR QUE EL FONDO (reporte usuario en
    pressure-pro-comercial): RESUELTO en v1.2.0. Causa: el parent
    `.stm-template-motorcycle a { color:#df1d1d }` (0,2,0) ganaba por
    especificidad al `color:#fff` del `.wsf-cta` del plugin (0,1,0) -> texto
    rojo sobre fondo rojo. Fix en child (a.wsf-cta color #fff !important +
    hover). Verificado en las 9 paginas PressurePro + Contacto. Barrido del
    mismo patron (fondo saturado opaco + texto <3:1) en 13 paginas x ambos
    modos: sin otros casos. Detalle: historico 57.
    NOTA para futuras revisiones visuales: el patron "boton/CTA con texto del
    color del fondo" es el tipo de detalle a auditar; se dejo un detector
    CDP reutilizable en temp/opencode (duna-sat.js / duna-sweep2.js).
31. SEO - RESUELTO (implementado el 2026-09-05 en el child v1.3.0; NO se instalo
    plugin SEO). Detalle completo en docs/05-historico-sesion.md item 58.
    - SCORES SEO Lighthouse v13.4.1 ANTES -> DESPUES: Home 92->100 | Shop 85->100
      | Single 85->100 (los 3 sin fallos de categoria SEO tras los cambios).
    - meta-description AUSENTE en todas las paginas: RESUELTO con opcion A (sin
      plugin) via el tema hijo duna-child: hook wp_head prioridad 1 en
      functions.php (duna_child_meta_description) con descripciones por tipo de
      pagina (home / is_shop / is_product_category con el nombre real de la
      categoria / is_product con nombre+SKU / contacto / about-us / PressurePro x9
      / buscador / faq / service-inventory / cart / checkout / my-account / blog /
      is_singular con excerpt o titulo del post). Textos es-UY 120-155 chars.
      VERIFICADO con curl en 14 URLs. Guard defined('WPSEO_VERSION') para no pisar
      un futuro plugin SEO.
    - TYPO del <title> de la home: RESUELTO - blogdescription corregido de
      "Aolienación" a "Alineación | Neumáticos e Insumos" (backup en
      docs/backups/blogdescription-backup.txt). <title> home ya muestra
      "Alineación".
    - LINK ROTO "La empresa": RESUELTO / sin accion - ya apuntaba a /about-us/
      (200) en los 3 menus (Primary/Bottom/Top right); la unica pagina con esa
      slug es ID 370 about-us. El doc previo (que reportaba /la-empresa/ en el
      menu) estaba desactualizado.
    - robots.txt "invalid" en local: CAUSA = linea "Sitemap: http://localhost:8881/
      wp-sitemap.xml" (hostname local). PENDIENTE SOLO EN PRODUCCION: al pasar a
      dominio real, verificar que la Sitemap apunte a https://<dominio>/wp-sitemap
      .xml y re-correr Lighthouse. NO se forzo Sitemap dinamica (decision del
      usuario: documentar y verificar en prod).
    - Verificacion realizada: curl del <head> (title + meta description) en 14
      paginas + barrido de status de las URLs de los menus (sin 404) + Lighthouse
      SEO re-corrido en home/shop/single.
