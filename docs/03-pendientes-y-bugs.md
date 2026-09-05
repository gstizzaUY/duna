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
      agregar CSS en 1 archivo; autoptimize_js=0). El parent/plugins seguian
      ~950KB CSS en ~30 hojas render-blocking; ahora un solo archivo cache.
      JS intacto (autoptimize rompe RevSlider si lo toca: "SR7 is not defined").
    - CORRECCION (historico 62): la config inicial con css_defer=1 INLINEABA el
      CSS agregado en un <style> de 2MB en el head (HTML ~2.3MB). Se paso a
      css_defer=0 + css_inline=0: CSS como archivo enlazado, HTML ~100KB.
    - DIAGNOSTICO CLAVE: el Perf local (home 42-68 fluctuante) esta dominado por
      el TTFB del servidor WordPress Studio (~2.5-4s variable, SQLite sin opcache
      de pagina), NO por los assets. El score local no es representativo; el
      beneficio real de Autoptimize (CSS minificado+agregado en archivo + HTML
      liviano) se vera en PRODUCCION (TTFB normal).
    - PENDIENTE en produccion: (a) habilitar defer/agregar JS con exclusiones
      finas (requiere testeo real, hoy rompe RevSlider en local), (b) page cache
      (WP Super Cache u otro) para atacar el TTFB de produccion.
    - RESUELTO en v1.3.1 (2026-09-05, historico 60): Google Fonts recortadas de
      28 a 7 variantes via child (se quito Montserrat no usada + pesos extra;
      Open Sans 400/600/700 + Exo 2 400/500/600/700 + display=swap).
32. LIGHTHOUSE NAVEGADOR REAL - RENDIMIENTO RESUELTO A 90 (2026-09-05; ver historico
    60-63) - hallazgos restantes:
    - RENDIMIENTO: RESUELTO en gran parte -> 90 (FCP 0.8s/LCP 0.9s/CLS 0) tras
      sacar el CSS inline de 2MB del head (Autoptimize CSS como archivo, item 62).
      Restan (mayormente produccion): cache headers (None en assets ~5MB), gzip/br,
      TTFB local, imagenes pesadas de la home (~1.3MB: headway.webp 563KB, Maxam
      558KB, tuerca-cromada.jpg 356KB, Diseno-sin-titulo-82-1.png 165KB),
      admin-ajax.php lento (~8.9s, order-attribution Woo), JS sin usar del parent
      (~943KB).
    - SEO 92: robots.txt "Timed out fetching resource" (timeout local al
      fetchear, no el invalid previo; verificar en prod con dominio real).
    - BP 96: [user-scalable=no] en el viewport (del parent, fuera de child);
      bfcache 3 motivos (cache-control:no-store); errores de consola no
      reproducidos por CDP.
    - CLS: RESUELTO (0). El fix del CSS inline elimino los shifts de carga.
    - ACCESIBILIDAD (A11y 70) y VISTA MOVIL: PENDIENTES para la proxima sesion -
      detalle COMPLETO en el item 33.
33. ACCESIBILIDAD - INFORME DETALLADO - **RESUELTO en duna-child v1.4.0**
    (2026-09-05; ver historico 64-66). Lighthouse home/shop/single/categoria/
    buscador/contacto/empresa + movil 375 = **A11y 100**. Se mitigo TODO desde
    el child (opcion a: JS+CSS+functions.php, SIN tocar plugin ni parent):
    - NOMBRES Y ETIQUETAS:
      * Botones sin nombre (dots de testimonios del PLUGIN): FIX en
        duna-child.js (initA11y) - aria-label "Ir a la página de testimonios N"
        + aria-current sincronizado (MutationObserver) con el slide activo.
        Ademas CSS: touch target 20x20 (el dot visual queda 7px con ::before).
      * Selects sin label (buscador del PLUGIN): FIX JS - cada select del
        .wsf-select-item recibe id + su <label> del item recibe for (queda
        asociado explicito; aria-labelledby al label). Cubre width/profile/rim/
        brand/model/year/version.
      * Enlaces sin nombre (8x "a"): eran los ICONOS SOCIALES del header
        (.header-main-socs, 5) y footer (.widget_socials, 3) = <a> con solo
        <i>. FIX JS - aria-label Facebook/Instagram/WhatsApp segun href.
    - PRACTICAS RECOMENDADAS:
      * [user-scalable="no"] en viewport (PARENT Motors header.php): FIX en
        functions.php del child con OUTPUT-BUFFER (template_redirect prio 0,
        ob_start + str_replace en el HTML final). El parent imprime el meta
        como HTML crudo ANTES de wp_head, por lo que un meta extra no lo pisa;
        el buffer limpia user-scalable=no. Verificado en el HTML.
      * Areas tactiles pequenas (dots 7px del plugin): FIX CSS (20px + gap 6px,
        dot visual 7px via ::before centrado). Lighthouse target-size OK.
      * Documento sin <main> (PARENT usa #wrapper/#main divs): FIX JS -
        role="main" en #main (landmark-one-main OK en todas).
      * Enlaces identicos con misma finalidad: la paginacion del parent
        (.stm-prev-next, woocommerce/loop/pagination.php) duplicaba el href de
        la pagina numerada en un <a> solo-icono. FIX JS - aria-label
        "Página siguiente/anterior" + aria-hidden al <i>.
    - CONTRASTE:
      * span.wsf-testimonial-author (rojo marca 3.41:1 dark / 4.48 light):
        NINGUN rojo cumple AA en ambos modos -> FIX CSS por modo: oscuro
        #ff7b6b (6.54:1 sobre card dark), claro #d92020 (4.64:1 sobre #f4f6f8
        y 5.03:1 sobre #fff).
      * span.wsf-timeline-year (anio del timeline de La empresa, mismo rojo
        3.56:1): mismo fix (misma regla CSS).
    - NAVEGACION (heading-order): h4.title.heading-font, h5 (productos), h6
      (widgets/footer) saltan niveles por el markup del parent/plugin. FIX JS -
      recorrido en orden DOM de los encabezados VISIBLES: si uno salta mas de
      un nivel se le asigna role=heading + aria-level = nivel anterior + 1
      (nunca baja de 2). Sin cambio visual. heading-order OK en todas.
    - ARIA (IDs duplicados): NO era el plugin; era el PARENT (inc/modals.php +
      listings/modals/*.php imprimen los .modal get-car-price/test-drive/
      trade-offer ~2x por pagina con los MISMOs ids hardcodeados). FIX JS -
      dedupe global de ids (2da+ ocurrencia -> id-2/id-3) y re-apuntado de cada
      aria-labelledby de .modal a los h3 de SU modal.
    - WooCommerce (single): tabs de la ficha con aria-selected en el <a>
      (viola aria-allowed-attr; el rol tab esta en el <li>). FIX JS con
      MutationObserver (WC lo re-aplica en init/click). aria-allowed-attr OK.
    - 404 sprite radio.png (consola/BP): el PARENT (motors/listings/trade-in
      .php:196) hardcodea get_stylesheet_directory_uri()/assets/images/
      radio.png (ruta del CHILD) para el formulario trade-in oculto. FIX: se
      copio el sprite real del plugin motors-car-dealership-classified-listings
      a duna-child/assets/images/radio.png (1.8 KB). 404 eliminado.
    - VISTA MOVIL (auditada 375/768/1024): sin overflow horizontal, grid de
      cards OK (home 1/3/4 cols segun ancho; shop 1/3), boton Filtros solo
      <992, topbar oculta <992, drawer .wsf-mobile-sidebar ciclo open/close OK
      (inert+aria+body-lock+foco restaurado, sidebar restaurada), dots 20px.
      Lighthouse home MOBILE a11y = 100.
    - LIMITACIONES no mitigadas (documentadas, fuera de child): errores de
      consola = conexion a http://localhost:3002 (API backend del buscador, no
      corriendo en local); Perf CLI local 48 (TTFB servidor Studio ~3s, en
      navegador 90). Cache/BP restantes (cache headers, gzip) = produccion.
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
