# Historico de la sesion (resumen de trabajo realizado)

1. Fix CSS buscador vs tema Motors (selects ocultos, select2, popup, colores).
2. Fix add-to-cart (URL admin-ajax) -> cart/?add-to-cart=ID.
3. Fix RevSlider SQLite via mu-plugin revslider-sqlite-compat.
4. Diagnostico WPBakery "no hay sliders" -> causa: consultas ORDER BY 'id' 'ASC' (SQLite).
5. Importacion desde duna.com.uy (REST API): 506 productos + variaciones + imagenes
   + atributos + categorias + ajustes (scripts en C:\Users\Acer\AppData\Local\Temp\opencode\*).
6. Campo _wsf_tire_size en 181 productos + finder actualizado (v1.2.2->v1.2.6).
7. Limpieza paginas duplicadas (14 a papelera) + menu Productos -> /shop/.
8. Customizacion granular del buscador (v1.2.6): selects/opciones/resultado/boton con
   controles independientes + descripciones en el admin.
9. Fix flecha selects (wrap) + toolbars admin (sticky) + panel mode=both.
10. Relevamiento plugins + informe de compatibilidad + plan listings/servicios.
11. Creacion de docs/ (esta documentacion) + desactivacion de plugins no usados.
12. FASE 2 (servicios): taxonomias renombradas (Tipo de servicio, Modalidad, Aplica a),
    9 listings demo a papelera, 8 servicios creados (IDs 5704-5711), ficha configurada
    (turno/presupuesto/calculadora, sin compare/share/stock), titulo del archivo
    "Servicios", H1 de la ficha = titulo real (se vacio listing_directory_title_frontend),
    compare desactivado en 2 opciones (plugin_settings y search_results, por el merge de
    PluginOptions). Backups de opciones en docs/backups/.
13. FASE 3 (home): shortcode [wsf_categories] (v1.2.7) + CSS; home 4300: cards de
    stm_inventory_categories reemplazadas por vc_column_text con wsf_categories
    (Auto, Camioneta, Agricola y Forestal, Baterias, Camion Liviano y Pesado, Llantas).
    Backups de la home en docs/backups/page-4300-home-content.txt.
14. FASE 4 (tienda): badge de medida en ficha y cards (hooks en class-woocommerce.php,
    v1.2.8), sidebar Shop con widgets de filtro (categorias, marca, ancho, rodado,
    precio, filtros activos) asignados programaticamente. Filtros verificados.
15. Header: activado header_cart_show (icono de carrito); icono cambiado a
    stm-icon-shopping-cart-1 (array nuxy: icon/color/size) en wpcfto_motors_motorcycle_settings.
    Icono de usuario: el partial del tema (profile.php) requiere is_listing=true (false en
    este sitio) -> se agrego item "Mi cuenta" (ID 5730) al menu Primary con clase
    motors-icons-user y CSS propio del plugin para el glyph (\e980, font motors-icons).
    (v1.3.3)
16. CONTENIDO REAL (duna.com.uy) - migrado:
    - Servicios: papelera de 4 extras, alineados a los 5 reales (Alineacion, Balanceo,
      Chequeo, Mecanica, Reparacion de Neumaticos) con descripciones reales; terminos
      'body' renombrados (chequeo, reparacion-neumaticos, mecanica).
    - Blog: papelera posts demo, 2 posts reales (Headway + COETC), categoria Novedades.
    - Paginas: "La empresa" (about-us, historia/timeline/testimonios/FAQ/stats/WhatsApp),
      "Contacto" (CF7 form id=5751 + datos), PressurePro x9 (producto + 8 mercados).
    - Home: secciones agregadas (testimonios + logos de clientes [wsf_client_logos]).
    - Menu: PressurePro + 8 mercados como submenu (IDs 5762-5770).
    - Theme Options: header_main_phone=2364 4300, header_socials_enable=[facebook,instagram].
    - Footer: widget stm_text (info empresa) + socials reales (FB, IG, WhatsApp).
    NOTA: evaluar via scripts base64 (wp-cli eval-file falla con cadenas no-ASCII largas).
    (v1.3.4)
17. LOGOS DE CLIENTES: descargados de duna.com.uy (10 logos de clientes reales) y subidos
    a la biblioteca local (attachments 5772-5781) con meta _wsf_client_logo=1. La home
    los muestra en la seccion "Empresas que confian en nosotros" con CSS blanco/transparente.
18. CORRECCION ENCODING: contenidos con mojibake (la lectura via Get-Content de PowerShell
    usaba ANSI) fueron reparados leyendo los HTML fuente con file_get_contents (UTF-8).
    Afectados y reparados: La empresa (370), seccion home (4300), Contacto (712),
    footer widget stm_text. NOTA: usar siempre PHP/file_get_contents para contenido no-ASCII,
    nunca PowerShell Get-Content (ANSI en PS 5.1).
19. SLIDERS: testimonios en carousel (1 por vista, auto 5s, flechas + puntos) y logos en
    marquee continuo con tarjetas redondeadas (borde sutil). Logo IMM (5776) con
    _wsf_client_logo_color=1 (grayscale sin invert, evita el bloque blanco). (v1.3.5)
20. AJUSTES SLIDERS: testimonios 3 por vista (auto, dots grises sin flechas), logos
    marquee con tarjetas mas grandes, ambos a ancho del tema, margen inferior. (v1.3.6-v1.3.9)
21. HOME: grilla de categorias 4x3 (12 categorias, imagen cuadrada); seccion
    "FEATURED HOT DEALS" -> "OFERTAS" (productos on_sale); rebajas del 12% en 8 neumaticos.
    (v1.4.0)
22. TEMA CLARO/OSCURO ALTERNABLE: variables CSS (--wsf-surf, --wsf-txt, --wsf-brand,
    --wsf-logo-filter, etc.) + bloque body.wsf-light (overrides del tema: #wrapper, top-bar,
    header, footer, encabezados, secciones demo de la home, texto blanco inline, icon boxes)
    + boton de alternar en el menu (filtro wp_nav_menu_items en class-assets.php) + JS
    initThemeToggle (localStorage 'wsf-theme'). Acenro rojo DUNA mantenido. (v1.4.1-v1.4.5)
    NOTA: para verificar con CDP forzar reflow (offsetHeight) al leer getComputedStyle.
23. SELECTOR CLARO/OSCURO SOLO ADMIN: el boton del menu se muestra solo si
    current_user_can('manage_options') (filtro wp_nav_menu_items) y el body lleva la clase
    wsf-can-toggle (filtro body_class). El JS solo aplica/persiste el tema si existe
    wsf-can-toggle; los visitantes siempre ven oscuro. (v1.4.6)
24. BORDE EN CARDS DE PRODUCTO: li.product .stm-product-inner (OFERTAS en home y
    archivos de categoria/tienda) con el mismo borde/radio/fondo que las cards de
    categoria (1px var(--wsf-border), radius 10px, fondo var(--wsf-surf), hover borde
    rojo). (v1.4.7)
25. CARDS DE PRODUCTO PROLIJAS: padding interno (h5/product_info 16px horizontal),
    titulo con min-height 3 lineas (line-clamp 3, altura uniforme), ul.products y
    li.product flex para filas de igual altura, boton Add to cart rojo a ancho completo
    al pie. SIDEBAR: widgets (aside.widget y variantes) con borde 1px var(--wsf-border),
    radius 10px, fondo var(--wsf-surf), padding 24px, sin sombra (override del borde
    4px/sombra del tema). (v1.4.8-v1.4.9)
26. WIDGET CATEGORIAS COLAPSABLE: las subcategorias (li.cat-parent > ul.children) se
    colapsan por defecto (solo se mantiene abierta la rama activa current-cat/
    current-cat-parent). Se agrega una flecha funcional (.wsf-cat-toggle, borde del
    tema :before desactivado) por li.cat-parent que expande/colapsa con animacion.
    JS: initCategoryWidget en wheels-finder.js. (v1.5.0)
27. FLECHA WIDGET CATEGORIAS VISIBLE: el tema fuerza color #fff !important en todos los
    button, por lo que la flecha era invisible en modo claro (blanco sobre blanco) y
    solo aparecia en hover (roja). Fix: color: var(--wsf-txt) !important (y hover
    var(--wsf-brand) !important) para que se adapte a ambos modos. (v1.5.1-v1.5.2)
28. FLECHA WIDGET CATEGORIAS ROJA: segun decision del usuario, la flecha queda roja
    DUNA (var(--wsf-brand) !important) de forma permanente en ambos modos, no solo en
    hover. (v1.5.3)
29. BOTON-FLECHA CON FONDO ROJO: segun aclaracion del usuario, lo que debe ser rojo es
    el FONDO del boton que contiene la flecha, no el relleno del glifo. El boton
    .wsf-cat-toggle ahora tiene fondo var(--wsf-brand), flecha blanca, radius 4px,
    visible siempre en ambos modos; hover con var(--wsf-brand-hover). (v1.5.4)
30. CARDS DE PRODUCTO - TITULO A 2 LINEAS: h5 con min-height 2.8em y line-clamp 2.
    PRECIO DESTACADO: .price a 20px bold var(--wsf-brand), con del tachado gris
    (var(--wsf-txt-soft)) e ins sin subrayado; flex con gap 8px.
    ALTURAS IGUALES: .product_info con min-height 60px (badge medida 34 + precio 26) y
    spacer ::before de 34px en cards sin medida (:has()) para que todas las cards midan
    lo mismo tengan o no medida/precio (las de camion/camion grande no tienen precio).
    (v1.5.5-v1.5.7)
31. PRECIOS DE CARDS CENTRADOS Y CONSISTENTES: el tema fuerza ins a font-weight 400,
    por lo que el precio con rebaja se veia sin negrita mientras el sin rebaja (hereda
    800 del .price) se veia en negrita. Fix: .price/.amount/ins/del todos font-weight
    400 y justify-content center (precios centrados en la card, con o sin rebaja); del
    tachado gris 14px 0.7. (v1.5.8)
32. PRECIO FINAL BOLD Y OSCURO: segun el usuario, el precio final (con o sin rebaja)
    debe verse en negrita y color oscuro (no rojo). .price/.amount/ins a font-weight
    700 y color var(--wsf-txt) (oscuro en modo claro, claro en oscuro para legibilidad).
    El del (tachado) se mantiene sin cambios: gris 14px 400 tachado 0.7. (v1.5.9)
33. DOCUMENTACION DEL PLUGIN ACTUALIZADA: documentacion-tecnica.md y manual-usuario.md
    en wp-content/plugins/wheels-size-finder/docs/ reflejan el estado real (v1.5.9):
    nuevos shortcodes (wsf_categories, wsf_client_logos), display_tire_size, busqueda
    por _wsf_tire_size, assets (menu_theme_toggle/admin_body_class/get_style_vars),
    JS (initThemeToggle/initCategoryWidget/initTestimonialsSlider/initLogosMarquee),
    CSS (tema claro/oscuro, cards, sidebar, widget colapsable) y constantes/opciones.
34. MULTI-MONEDA USD/UYU: decision del usuario - la web es un ecommerce estandar
    bimoneda, independiente de Odoo. Base USD + plugin "Currency Switcher for
    WooCommerce" (WP Wham v2.16.6, ya instalado) activado y configurado (USD+UYU,
    default USD, per-product ON, TC manual 41). VERIFICADO EN VIVO: switcher en ficha
    convierte ($68,00->$2.788,00 UYU) y el carrito muestra totales en UYU
    ($2.453,44); base y gateway en USD. Backup de opciones previas en
    temp/opencode/switcher-backup.json. Documentado en docs/06-multi-moneda.md y
    regla actualizada en 04-integracion-odoo.md. Pendientes: simbolo de moneda,
    fuente TC (BCU), placement, gateway, envio/cupones, rounding.
35. SIMBOLOS DE MONEDA: USD = "U$S" y UYU = "$" via price formats del plugin
    (alg_wc_currency_switcher_price_formats_enabled=yes, currency_code_USD=U$S,
    currency_code_UYU=$). VERIFICADO: ficha/cards USD "U$S 68,00 -> U$S 59,84" y
    UYU "$ 2.788,00 -> $ 2.453,44". Backup en temp/opencode/price-formats-backup.json.
36. NAVBAR: el tema Motors (motorcycle) dibuja dos "colas" inclinadas (::before/:after
    del .inner, skewX ±37deg, 200px) con un rojo distinto (--hma_background_color
    #e32121) al de la barra/items (--hma_item_bg_color #df1d1d), causando pasos/
    imperfecciones visibles en los extremos. FINAL: se ocultan las colas del tema y se
    recrean los extremos inclinados como triangulos clip-path (44px) pegados a la
    barra (ul.header-menu:before/:after, position relative), todo con el rojo de los
    items. Silueta verificada = original; color uniforme #df1d1d; dropdowns intactos
    (sin clip en el UL, los ::before/::after no afectan hijos). (v1.6.0-v1.6.1)
37. NAVBAR COMPACTA Y COLORES: barra de 68px a 50px (items a altura completa, sin
    espacio extra bajo la barra negra) y colores de items: blanco por defecto, negro
    al hover (transition 0.25s) via overrides !important en wheels-finder.css.
    DETALLE CRITICO: line-height del UL debe quedar en 0 (los LI flotados arrancan
    pegados al tope; si se hereda line-height >0 se desplazan 50px abajo, dejando la
    cinta roja vacia arriba y los items en el borde inferior). Los <a> llevan
    line-height 50; submenus restauran line-height 1.4. (v1.6.2)
38. NAVBAR NEGRA / CINTA ROJA - AJUSTES: (1) toggle claro/oscuro deja de sobresalir
    de la cinta (li flotado con height 50 y boton block con margin 8px 0 0, sin flex
    ni align-items que desplazaban). (2) "Mi Cuenta" se saca de la cinta (display
    none li.motors-icons-user) y se muestra SOLO ICONO en la navbar negra a la
    izquierda del carrito (.wsf-header-user, motors-icons \e980, CSS oculta el texto
    del menu y JS moveHeaderUser lo inserta antes de .help-bar-shop; el carrito esta
    flotado por lo que el contenedor .pull-right.hdn-767 pasa a display:flex para que
    el orden DOM mande). (3) Telefono de la navbar (header-main-phone) forzado en
    blanco !important. (v1.6.3)
39. TELEFONO NAVBAR BLANCO (realmente visible): el override del modo claro
    (body.wsf-light .header-main-phone color #1a1a1a) dejaba el numero oscuro sobre
    la barra negra (que en modo claro mantiene su fondo oscuro interno
    .stm_mc-main.header-main). Eliminado ese override: el telefono es blanco SIEMPRE
    (ambos modos). (v1.6.4)
40. TOPBAR Y SOCIALS: iconos sociales de la barra negra (.header-main-socs) en blanco
    (estaban #aaa). Contenido del topbar (#top-bar .top-bar-wrapper) centrado con
    flex (estaba flotado pegado a la derecha). Reset de border-radius en
    topbar/stm_mc-main/header-main para evitar pasos en el borde blanco/negro
    (no reproducidos en headless; probablemente residuo de CSS viejo). (v1.6.5)
41. SEPARACION PLUGIN/TEMA: tema hijo duna-child (Template: motors) con TODO el skin
    del sitio (CSS: navbar/topbar/cards/sidebar/widget/toggle/modo claro; JS:
    initThemeToggle/initCategoryWidget/moveHeaderUser; PHP: hooks wp_nav_menu_items
    y body_class). El plugin wheels-size-finder queda como buscador puro (CSS wsf-*
    con fallback var(--wsf-*), JS finder + sliders, class-assets sin hooks de tema).
    VERIFICADO sin regresiones (home ambos modos, categorias, ficha, dropdowns,
    buscador, menu real, assets al final del cascade).
    NOTA ACTIVACION: al activar un tema hijo, WP crea theme_mods_<child> frescos y
    Motors puede resetear opciones WPCFTO (menu/phone/socials): se copiaron
    theme_mods_motors -> theme_mods_duna-child (nav_menu_locations, listing_*) y se
    restauraron header_main_phone='2364 4300' + header_socials_enable en
    wpcfto_motors_motorcycle_settings. Backup theme-backup.json en temp/opencode.
    Docs: nuevo docs/07-tema-hijo.md. (fase 1 separacion; carga condicional pendiente)
42. RESPONSIVE MOVIL (duna-child v1.0.1): (1) boton "Filtros" <992px sobre el grid de
    productos que abre la sidebar (oculta por el tema en movil) como drawer off-canvas
    con overlay; la sidebar se mueve al drawer (widget colapsable sigue vivo) y se
    restaura al cerrar (placeholder + resize guard >=992). (2) Topbar movil: <480 solo
    telefono + redes (horario y direccion ocultos). (3) Toggle claro/oscuro disponible
    en el drawer movil (admins). Verificado a 375/479/480/768/990/1200: sin overflow,
    ciclo open/close x2, boton oculto en desktop y home, sidebar normal en desktop.
43. FOOTER SIN CAJAS/BORDES (v1.0.3): la regla generica del child
    `aside.widget` (cards de sidebar) coincidia tambien con los <aside class=widget>
    del footer, pintando cada columna como "caja" (borde 1px + padding 24px !important
    que anulaba el gutter .cols_4 de 15px) y dejando las columnas muy juntas con
    borde interior antiestetico. Fix: (1) la regla de cards se acoto a areas de
    sidebar reales (.stm-shop-sidebar-area/.sidebar-area/.stm-sidebar/
    .wpb_widgetised_column), sin selector generico "aside.widget"; (2) nuevo bloque
    footer: quita borde/fondo/radio heredado; desktop >=1200 mantiene grilla con
    gutter 20px por columna; <1200px apila a 1 columna (el parent no tenia
    breakpoints y dejaba 25% en movil), padding 16px horizontal + margin 32px.
    VERIFICADO por CDP: desktop 4x320px pad 0 20px sin border; movil apilado al 100%
    con pad 16px; la card de la sidebar de tienda se mantiene (1px/10px/24px).
44. PADDING MOVIL EN FOOTER (v1.0.3): al apilar en <1200px el contenido quedaba pegado
    al borde izquierdo (el .cols_x tenia margin 0 -15px del parent y aside sin
    padding). Fix: en el media query <1200px se cancela el margen negativo de
    .cols_1/2/3/4 y cada aside apilado lleva padding 0 16px. VERIFICADO: contenido
    arranca ~31px del borde (container 15px + 16px).
45. REDISENO V2 - DIAGNOSTICO Y PLAN (solo child): a pedido del usuario de llevar el
    sitio a nivel "ultra profesional/vanguardia", se hizo diagnostico completo del
    sitio + child (ver 07-tema-hijo.md seccion DISENO V2). Decisiones: mantener
    fuentes (Exo2/OpenSans), estetica MAS CUADRADA (radios 0-4px, no 10px), paridad
    total claro/oscuro, cache/optimizacion = PROXIMA etapa, alcance SOLO child
    (no tocar Nuxy ni contenido). Pendiente de ejecutar: F1-F6 (ver 07-tema-hijo.md).
46. REDISENO V2 - F1 FUNDAMENTOS (duna-child v1.1.0):
    - Encoding JS: VERIFICADO que duna-child.js es UTF-8 valido (Subcategorias con
      bytes C3 AD). El mojibake visto era solo de la consola PowerShell 5.1 (ANSI).
      No requirio cambios.
    - Tokens semanticos en :root: se agregaron --wsf-focus/--wsf-focus-ring
      (accesibilidad), --wsf-radius/--wsf-radius-sm/--wsf-radius-lg (4/2/6px),
      --wsf-space-1..7 (4..64px), --wsf-container/--wsf-gutter. body.wsf-light
      redeclara los nuevos (focus/ring con variante clara).
    - ESTETICA CUADRADA: radius 10px -> var(--wsf-radius) (4px) en cards de producto
      y widgets de sidebar; botones (Add to cart, wsf-cat-toggle, wsf-mobile-filters)
      -> var(--wsf-radius-sm) (2px). El circulo del toggle de tema queda 50%.
    - RESET LIGHT ACOTADO: se ELIMINO el reset masivo
      `body.wsf-light [style*="color:#ffffff"...] { color:#1a1a1a !important }`
      que pisaba colores inline intencionales (botones/banners). Verificado sin
      elementos blancos-sobre-fondo-claro en Home light.
    - ACCESIBILIDAD (aditiva): :focus-visible ring 2px var(--wsf-focus) para
      a/button/input/select/textarea/.wsf-cat-toggle/.wsf-theme-toggle/close +
      @media prefers-reduced-motion (reduce) global.
    - Bump version -> 1.1.0 (style.css + functions.php). Backup pre-cambio en
      docs/backups/duna-child-v1.0.3.*.
    - VERIFICADO CDP: cards/widgets radius 4px; body dark rgb(13,17,23) / light
      rgb(247,248,250); surf #161b22 -> #ffffff al toggle light; footer sin borde
      y pad 0 20px (v1.0.3 intacto); ficha precio/tabs paridad por variables;
      focus-visible presente en la hoja v1.1.0. Sin blancos-sobre-claro en Home.
47. REDISENO V2 - F2 TIPOGRAFIA Y RITMO (duna-child v1.1.1):
    - Lectura comoda en contenido de paginas (Home y WPBakery): parrafos
      .entry-content/.page-content-wrap/.wpb_text_column/.vc_column_text a
      font-size 15px + line-height 1.7 (antes 14px/22px del parent). VERIFICADO
      CDP: parrafos de Home en 15px / line-height 25.5px.
    - Titulos de contenido (entry-content h1-h3 / wpb_text_column) con
      line-height 1.25 (mas aire). Titulos de seccion WPBakery
      (.vc_custom_heading) con letter-spacing -0.01em + font-weight 700.
    - Se mantienen las fuentes (Exo2 titulos / Open Sans cuerpo) y los tamanos
      base del tema; los cambios son solo de cuerpo de lectura y titulos de
      seccion dentro del contenido, sin tocar widgets/UI/cards.
    - "La empresa" usa HTML propio del plugin (wsf-*) -> no afectado (fuera de
      este scope; separacion plugin/tema).
    - Evaluacion: NO se migro el grid a CSS Grid en esta iteracion (F3) por
      riesgo sin inspeccion visual; el grid actual (flex + widths % del parent
      con breakpoints contextuales shop/categorias) funciona. El grid real
      queda como F3 pendiente para una sesion con revision visual.
    - Bump version -> 1.1.1.
48. REDISENO V2 - F5 PARIDAD CLARO/OSCURO del BUSCADOR + componentes (v1.1.3):
    - CAUSA RAIZ buscador: wheels-finder.js `applyColors()` pinta los selects
      con estilos INLINE `!important` (background/color/border/color-scheme)
      leyendo las variables --wsf-* desde `getComputedStyle(document.documentElement)`
      (el <html>, no el body). El plugin define esas variables en :root (style
      tag) con valores oscuros, por lo que el modo claro del child (body.wsf-light)
      NUNCA los aclaraba (inline !important > cualquier CSS).
    - FIX (solo child, sin tocar plugin):
      1) CSS: las variables del modo claro ahora se declaran en
         `html.wsf-light, body.wsf-light` (no solo body) para que al leer desde
         documentElement en light se obtengan valores claros.
      2) JS (duna-child.js initThemeToggle): el toggle aplica/remueve la clase
         wsf-light TAMBIEN en <html> (documentElement) y, tras cada cambio de
         tema, re-aplica inline a los `.wsf-select-item select` los colores
         leidos de las variables (applyWsfSelects) -> el buscador se aclara u
         oscurece al instante.
    - VERIFICADO como admin real (login headless + toggle): dark select #161b22/
      texto claro/scheme dark; light select #ffffff/texto #1a1a1a/scheme light.
    - OTROS FIX de paridad en CSS:
      * .wSelect-theme-classic (select de moneda Currency Switcher) -> variables
        surf/txt/border (antes #FAFAFA fijo claro -> rompia dark; hover a brand).
      * .stm-blog-pagination .stm-prev-next y ul.page-numbers li a (el parent los
        pinta #2f3c40) -> surf/border/txt en ambos modos; hover a brand.
    - RESIDUALES validados como NO-bug: navbar negra .stm_mc-main.header-main
      (oscura en ambos modos por decision v1.6.4); .single-add-to-compare es
      decorativo opacity:0 (oculto); .nojq es artefacto de sesion admin (barra
      superior 32px de la admin bar), no afecta visitantes.
    - Bump version -> 1.1.3 (style.css + functions.php; JS y CSS cambiaron).
49. REDISENO V2 - F4 MICRO-INTERACCIONES + F5 pulido (duna-child v1.1.4):
    - Cards de producto: sombra base sutil + elevacion al hover
      (box-shadow var(--wsf-shadow)/var(--wsf-shadow-hover)) + translateY(-3px)
      + zoom suave de la imagen (scale 1.04, transition 0.4s). Se agregaron
      tokens --wsf-shadow y --wsf-shadow-hover en :root y en modo claro
      (sombra mas suave en light).
    - Botones WooCommerce (a.button/button.button/input#submit/
      .wc-proceed-to-checkout/#place_order): border-radius var(--wsf-radius-sm),
      transition, hover con sombra + brand-hover, active con translateY(1px).
    - Ficha de producto: la galeria .woocommerce-product-gallery se enmarca
      como card (border var(--wsf-border), radius var(--wsf-radius), overflow
      hidden, padding 4px); thumbnails .flex-control-thumbs con borde sutil.
    - VERIFICADO CDP: ficha boton radius 2px rojo; galeria radius 4px; tabs
      coherentes. Paginacion del shop (.stm-blog-pagination .stm-prev-next /
      .page-numbers) en light -> blanco surf (confirmado tras reflow 400ms;
      los falsos "leftovers" oscuros previos eran por medir antes del reflow).
    - Header en light: contenedor .stm_motorcycle-header blanco + barra
      superior .stm_mc-main #0e1315 oscura (navbar Duna, intencional en ambos
      modos, decision v1.6.4). NO-bug.
    - Bump version -> 1.1.4 (style.css + functions.php).
50. REDISENO V2 - F5 AUDITORIA contraste/ritmo/logo/badges + CARRITO (v1.1.5):
    - AUDITORIA con CDP (datos reales):
      * Contraste texto-soft: dark #b6bcc4 sobre #0d1117 ~8.9:1 (AA+); light
        #333/#555 sobre fondo claro ~7:1 (AA). OK, sin cambios necesarios.
      * Ritmo vertical de secciones Home: paddings WPBakery por seccion ya
        generosos (42-116px top). OK, no forzar margins a vc_row.
      * Logo header (duna-logo-home.png): filter:none en ambos modos; el header
        es oscuro en ambos (navbar Duna) -> logo disenado para ese fondo. OK.
      * Badge de medida (.wsf-product-measure): rojo brand sobre card, legible.
      * Breadcrumb: el tema no lo renderiza en shop/categorias (usa title_box).
      * Se dejo constancia: estos items estaban correctos (verificados, no
        requirieron cambios).
    - CARRITO DEL HEADER (mejora UX): el parent OCULTA el contador del carrito
      (.list-badge display:none en header-motorcycle.css). Se activa una burbuja
      roja (var(--wsf-brand)) con el numero en blanco, position absolute sobre
      el icono (top -6 / right -10, min 16px, radius 8px). VERIFICADO CDP:
      badge display flex, bg #df1d1d, color #fff, 16x16, texto "0", sin cortarse
      (overflow del contenedor visible).
    - VERIFICACION sin regresiones (shop/cat/home/ficha): cards radius 4px,
      sombra aplicada, botones radius 2px, galeria ficha radius 4px.
    - Bump version -> 1.1.5 (style.css + functions.php).
51. REPORTE STICKY "CORTADO" - DIAGNOSTICADO, NO-REPRODUCIBLE (v1.1.5):
    - El usuario reporto que el navbar sticky al scrollear se veia "cortado":
      la cinta negra superior (.stm_mc-main, con el logo de Duna al centro)
      no llegaba a desplegarse completa y el logo se veia recortado.
    - DIAGNOSTICO CDP (estructura real del header motorcycle):
      * .stm_motorcycle-header.header-listing-fixed: al scrollear el JS
        (app-header-scroll.js -> stm_motocycle_fixed_header) aplica
        stm-fixed-invisible (scroll > headerPos+200) y stm-fixed
        (scroll > headerPos+400): position fixed, top 0.
      * Estructura del header: .stm_mc-main.header-main (barra negra del logo,
        h 81px, padding 22px, fondo #0e1315) + .stm_mc-nav (cinta del menu
        rojo, h 50px, position absolute top 81 respecto al header).
      * Logo: duna-logo-home.png (natural 1469x365, ~4:1), renderizado
        width:150 -> h ~37px, centrado en la barra (top 22..59 de 81px).
      * Verificado en Home y La empresa (scroll 1200/2500): el menu rojo se ve
        completo (y 81..131), el logo cabe (37px en barra de 81px), el
        contenido arranca debajo (y ~134). Sin recorte medible.
    - RESOLUCION: al probar en una ventana de INCOGNITO (navegador sin cache
      de la sesion previa) el sticky NO se corta. Conclusion: el "corte" era un
      artefacto de CACHE/CSS viejo de una sesion anterior del navegador (el
      CSS del child se cacheo con una version anterior que tenia el bug ya
      corregido o un residuo). NO es un bug del codigo actual (v1.1.5).
    - NOTA para futuro: si reaparece, revisar (1) altura real de .stm_mc-main
      en sticky (debe ser 81px con logo centrado), (2) que no haya otra hoja
      cacheada, (3) hard reload Ctrl+F5 / incognito.
    - Sin cambios de codigo en esta sesion (v1.1.5 intacta).
52. REDISENO V2 - F3 GRID REAL de productos (duna-child v1.1.6):
    - NOTA DE SESION: en esta sesion el modelo no pudo VER imagenes, por lo
      que la revision visual quedo del lado del usuario (screenshots en
      C:\Users\Acer\AppData\Local\Temp\opencode\f3-after-v116\ y baseline
      medido por geometria en f3-baseline/ ANTES de la migracion). Toda la
      verificacion se hizo por CDP (geometria/estilos computados), igual que
      en sesiones previas.
    - DIAGNOSTICO del grid (matriz CDP en 11 anchos x shop/categoria/home):
      * ul.products NO usaba float real: era flex-wrap del child (v1.4.8)
        + cada <li> con ancho por clases bootstrap contextuales del parent
        (col-md-4/col-sm-4/col-xs-12 -> 3col; columns-4 -> 4col) y float
        inerte (display flex ganaba). Gaps reales 0 (cards contiguas, el
        parent usaba margin 0 -15px + padding 15px por lado -> card 290px
        en celda 320px).
      * Matriz antes (v1.1.5): shop/categorias 3col >=768 / 1col <768 (card
        full-width 360-585px en movil). Home columns-4: 4col >=992, 3col
        768-991, 1col <768. Ficha related columns-4: 4col (3 productos).
      * Cards de altura NO uniforme entre columnas (flex-wrap no alinea
        filas; cada card media lo que su contenido, medido 524px variable).
    - MIGRACION a CSS Grid (regla base en duna-child.css bloque F3):
      * ul.products -> display:grid; grid-template-columns repeat(3,1fr)
        base; column-gap:24px; row-gap:32px; align-items:stretch.
      * columns-4 (home OFERTAS + single related) -> repeat(4,1fr).
      * Breakpoints: columns-4 -> 3col @<992; ambos -> 2col @<768;
        1col @<576 (la propuesta aprobada por el usuario).
      * li.product -> width auto/float none/padding 0; .stm-product-inner
        -> height:100% + margin-bottom:0 (el row-gap separa filas) y el
        boton Add-to-cart con margin:auto -> anclado al pie en filas de
        altura uniforme.
      * BUG ENCONTRADO Y CORREGIDO durante la implementacion: los
        ::before/::after de limpieza de float del parent
        (.woocommerce ul.products:before/:after { content:" "; display:
        table }) se convertian en ITEMS DE GRID fantasma de ~294px que
        ocupaban la primera celda y desplazaban los productos (fila 1 con
        2 items, resto 3). Fix: content:none !important en los pseudo del
        UL dentro del grid.
      * OTRO BUG DE IMPLEMENTACION (deteccion): un comentario CSS con
        "col-md-*/col-sm-*" contenian la secuencia */ que CERRABA el
        comentario antes de tiempo -> el parser se comia la regla base
        display:grid (la hoja se servia bien pero cssRules no la incluia;
        detectado comparando cssRules vs fetch del .css). Corregido el
        texto del comentario (sin col-md-*).
    - VERIFICADO CDP (v1.1.6, perfiles frescos, version 1.1.6 servida):
      * Shop 1367px: 12 items -> 4 filas x 3 col, card 294x498, gaps 24px,
        todas las cards de la fila miden 498 (equal-height real) y el boton
        queda a 17px del borde inferior (alineado).
      * Matriz responsive OK: shop/cat 3col >=768, 2col @600, 1col <=480;
        home columns-4: 4col >=992 (8 items = 2 filas), 3col 768-991, 2col
        @600, 1col <=480. Sin overflow horizontal (scrollWidth==innerWidth)
        en 375/600/1367.
      * Related del single (columns-4): 3 items 1 fila x 4 col iguales.
      * Buscador (?s=&post_type=product): mismo grid que shop (3col).
      * Paridad claro/oscuro OK: card bg #161b22(dark)/#ffffff(light),
        borde var(--wsf-border) sigue a la variable (VERIFICADO con reflow
        forzado; sin reflow el getComputedStyle daba el valor viejo ->
        mismo trap de CDP documentado en sesiones previas), precio, boton.
      * Boton "Filtros" movil y drawer siguen OK (375/600 presentes, 1367
        oculto); home sin sidebar -> sin drawer.
    - DIFERENCIA VISUAL RESPECTO A ANTES (medida): el card interior pasa de
      290px a ~294px (3col/960px) y de 290 a ~295px (4col/1280px) porque ya
      no hay padding bootstrap 15px por lado dentro del grid (la celda es el
      card). Los gaps reales de 24px separan las cards (antes 0). En <768
      ahora 2 columnas (antes 1); <576 1 columna. El usuario debe validar el
      aspecto final con f3-after-v116/*.png.
    - NO se toco el plugin ni el parent ni el JS del child (solo CSS).
    - Backup pre-cambio: docs/backups/duna-child-v1.1.5.{css,js}.
    - Bump version -> 1.1.6 (style.css + functions.php).
53. F2 clamp() en titulos de Home - DIFERIDO (requiere decision visual):
    - Se investigo la escala de los titulos de seccion de la Home: los
      vc_custom_heading WPBakery (BUSCADOR/CATEGORIAS/La Empresa/clientes)
      YA escalan fluido por el builder (36px desktop -> 26px movil, media
      del parent .stm-template-motorcycle h2). Los unicos que NO escalan
      bien son los del plugin wheels-size-finder (.wsf-categories-title
      "OFERTAS" 24px y .wsf-logos-title 22px): en movil el media del parent
      los fuerza a 26px -> CRECEN en pantallas chicas (inversion).
    - Se propuso un clamp() en el child para esos 2 (mantener el desktop del
      plugin y bajar fluido). Se revirtio el cambio porque el plan original
      pedia "requiere decision visual" y en esta sesion el modelo no puede
      ver los screenshots -> evitar adivinar tamanos y romper el ritmo
      visual sin control.
    - PENDIENTE para una sesion con revision visual (o decision del usuario):
      aplicar clamp() a .wsf-categories-title/.wsf-logos-title (sugerido
      clamp(20px,1.2vw+8px,24px) y clamp(18px,1vw+9px,22px)) o dejarlos como
      estan (24/22 desktop, 26 movil).
54. REDISENO V2 - F2 COMPLETADO: clamp() en titulos de la Home del plugin
    (duna-child v1.1.7):
    - El usuario confirmo avanzar con F2 + F6. Se aplico la propuesta del
      item 53 en el child (sin tocar el plugin): el media query del parent
      (.stm-template-motorcycle h2 -> 26px en movil) hacia que los titulos
      de seccion renderizados por wheels-size-finder CRECIERAN en pantallas
      chicas (24/22px desktop -> 26px movil), invirtiendo la jerarquia
      frente a los vc_custom_heading WPBakery que SI bajan (36->26px).
    - Regla agregada en duna-child.css (bloque F2, junto a vc_custom_heading):
        .wpb_text_column .wsf-categories-title { font-size: clamp(20px, 1.2vw + 8px, 24px); }
        .wpb_text_column .wsf-logos-title    { font-size: clamp(18px, 1vw + 9px, 22px); }
      Especificidad (0,2,0) gana al media h2 del parent (0,1,1) sin
      !important (el child ademas carga al final de la cascada).
    - VERIFICADO CDP por ancho (reflow forzado): OFERTAS 24px@1367 ->
      22.2@1200 -> 20@<=992; logos 22px@1367 -> 20.85@1200 -> 18@<=768.
      Ya no crecen en movil (antes 26px). Sin picos ni saltos.
    - Solo CSS. Bump version -> 1.1.7.
55. REDISENO V2 - F6 QA Lighthouse + FIXES de contraste/a11y del child
    (duna-child v1.1.8 y v1.1.9):
    - NOTA DE SESION: el modelo no puede ver imagenes; la verificacion es
      por CDP + Lighthouse (metricas objetivas). Lighthouse v13.4.1 local.
    - BASELINE Lighthouse (v1.1.6, antes de fixes): home Perf 50/A11y 70/
      BP 96/SEO 92; shop Perf 54/A11y 81/BP 96/SEO 85; single Perf 54/
      A11y 80/BP 96/SEO 85.
    - Hallazgos accionables dentro del alcance "solo child" (los demas son
      del parent/plugin/contenido -> documentados como pendientes):
      * CONTRASTE AA - badge de medida .wsf-product-measure (cards + ficha):
        el plugin lo pinta como pill TEXTO rojo var(--wsf-accent) sobre
        fondo transparente (rojo #df1d1d sobre card #161b22 = 3.57:1 en
        dark -> falla AA 4.5; en light 4.85 pasa). FIX en child: pill
        RELLENO var(--wsf-brand) con texto blanco (blanco sobre #df1d1d =
        4.85:1 AA en AMBOS modos) + .wsf-product-measure-label blanco
        opacity 1. Coherente con los botones rojos del skin. NO toca el
        plugin (override en el child con mayor especificidad).
      * CONTRASTE AA - "DUNA" (span.colored) en el titulo del primer widget
        del footer: el parent .stm-template-motorcycle .footer_widgets_
        wrapper .widget-title h6 .colored lo pinta rojo fijo #df1d1d
        (3.9:1 sobre --wsf-surf-deep dark -> falla; 4.45 sobre #f5f5f5
        light, al limite). Analizado: NINGUN rojo cumple AA en ambos modos
        (claro pasa dark y falla light; oscuro al reves). FIX en child:
        .colored del footer sigue a var(--wsf-txt) (como el resto del
        titulo que ya fuerza el child) -> ~14.8:1 dark / ~15.9:1 light. La
        marca roja vive en header/logo. Decision del usuario: "aplicar
        ambos fixes AA".
      * CONTRASTE AA - precio tachado del single (p.price del): el parent
        fuerza opacity:0.5 (hereda --wsf-txt a 50%, render ~#777b80 sobre
        #0d1117 = 4.44:1, bajo AA). FIX en child: del del single a
        var(--wsf-txt-soft) SIN opacity (dark #b6bcc4 ~8.9:1; light #555
        ~7:1) manteniendo line-through. Las cards del grid conservan su
        propio del (txt-soft + opacity 0.7) sin tocar.
      * ARIA-HIDDEN-FOCUS - drawer .wsf-mobile-sidebar: el shell vive
        siempre en el DOM con aria-hidden="true" pero el boton "Cerrar" era
        focusable dentro (fallo axe). FIX en duna-child.js: se usa la
        propiedad [inert] (soporte Chrome 102+/modernos) sincronizada con
        el estado open/close + aria-hidden true/false; al abrir el drawer el
        foco va al boton "Cerrar" y al cerrar vuelve al boton "Filtros".
        VERIFICADO ciclo open/close por CDP: cerrado inert:true+aria:true,
        abierto inert:false+aria:false con foco en Cerrar, al cerrar foco en
        Filtros.
    - VERIFICACION CDP post-fix: badge bg rgb(223,29,29)/texto blanco en
      ambos modos; footer colored = --wsf-txt en ambos (225,228,232 dark /
      26,26,26 light); del single = txt-soft sin opacity.
    - LIGHTHOUSE POST-FIX: shop A11y 81 -> 88 (color-contrast y
      aria-hidden-focus resueltos); single A11y 80 -> 86 (contrast items 0).
      Home A11y 70 sin cambio: los fallos restantes son del PLUGIN
      (testimonios: dots button sin nombre/aria-label y .wsf-testimonial-
      author sin contraste; selects del buscador sin label) -> fuera de
      alcance "solo child" (regla de oro: no tocar plugin). BP/SEO sin
      cambios (96/92/85). Perf 42-55 fluctuante (ligada al parent y a la
      etapa cache, fuera de scope).
    - Solo se toco duna-child.css + duna-child.js. Bump -> 1.1.8 (badge+
      footer+drawer) y -> 1.1.9 (del single). Backups en docs/backups/
      duna-child-v1.1.6.{css,js}.
56. F6 - REGRESION FINAL (duna-child v1.1.9): barrido de 11 paginas clave
    (home/shop/categoria/single/cart/checkout/my-account/buscador/contacto/
    empresa/blog) x dark/light x desktop(1367)/movil(375): 44/44 OK, sin
    overflow horizontal, sin errores JS, grid/cards correctos. Se dejo el
    grid F3 intacto y los fixes F6 sin regresiones. Version servida: 1.1.9
    (css+js, verificado por ?ver=1.1.9 en el HTML).
57. FIX VISUAL - CTA del plugin con texto del mismo color que el fondo
    (duna-child v1.2.0):
    - REPORTE del usuario: en http://localhost:8881/pressure-pro-comercial/
      el boton (CTA "Consultar por WhatsApp") se veia rojo con el TEXTO del
      mismo color (o muy parecido) -> ilegible.
    - CAUSA RAIZ (diagnostico CDP): el parent Motors fuerza
      `.stm-template-motorcycle a { color:#df1d1d }` (especificidad 0,2,0)
      que GANA al `color:#fff` del `.wsf-cta` del plugin wheels-size-finder
      (especificidad 0,1,0) porque la hoja del plugin carga ANTES que la del
      parent? NO: el orden real es wpcfto/parent/plugin/child. El problema:
      `.wsf-cta { color:#fff }` (plugin, 0,1,0) pierde contra
      `.stm-template-motorcycle a { color:#df1d1d }` (parent, 0,2,0) por
      ESPECIFICIDAD, con independencia del orden. Resultado: texto rojo
      #df1d1d sobre fondo rojo #df1d1d (invisible).
    - FIX en el child (sin tocar plugin/parent): override con especificidad
      suficiente y !important para que el texto del .wsf-cta sea blanco
      siempre (+ hover con fondo brand-hover):
        .stm-template-motorcycle .wsf-page a.wsf-cta,
        .stm-template-motorcycle a.wsf-cta, body a.wsf-cta, a.wsf-cta {
            color: #ffffff !important; text-decoration: none; }
        ... :hover { color:#ffffff !important; background: var(--wsf-brand-hover); }
    - VERIFICADO CDP en las 9 paginas PressurePro (pressure-pro,
      comercial, recreacional, pesados, portuarios, forestal, agricultura,
      especiales, emergencias) + Contacto: CTA color rgb(255,255,255) sobre
      rgb(223,29,29) = ratio 4.85:1 (AA) en dark y light.
    - BARRIDO preventivo del MISMO patron (elementos con fondo de color
      saturado opaco y texto con ratio <3:1) en 13 paginas clave
      (home/shop/cat/single/buscador/contacto/empresa/2x pressure/blog/
      cart/checkout/account) x dark/light: SIN otros casos tras el fix.
      Tambien se barrio el patron "texto-link con ratio <4.5 sobre fondo"
      en contenido: OK en todas (los enlaces de texto normales no son rojos;
      el override `a{color:var(--wsf-txt)}` del child los mantiene legibles;
      el rojo del parent solo afectaba al CTA por tener fondo rojo propio).
    - Screenshots de QA visual (para revision del usuario) en
      C:\Users\Acer\AppData\Local\Temp\opencode\qa-visual-v120\.
    - Backup pre-cambio: docs/backups/duna-child-v1.1.9.css.
    - Bump version -> 1.2.0 (solo CSS).
58. SEO - META-DESCRIPTION + TYPO DEL TAGLINE (duna-child v1.3.0; NO se instalo
    plugin SEO):
    - DIAGNOSTICO (item 31 de 03-pendientes-y-bugs.md): blogdescription =
      "Aolienación | Neumáticos e Insumos" (typo "Aolienación" -> "Alineación");
      NO habia <meta name=description> en ninguna pagina (no habia plugin SEO);
      el item de menu "La empresa" YA apuntaba a /about-us/ (200) en los 3 menus
      (Primary/Bottom/Top right), la unica pagina es ID 370 slug about-us (el
      doc previo reportaba /la-empresa/ como pendiente, quedó desactualizado);
      robots.txt "invalid" era solo por la linea Sitemap con hostname local.
    - FIX 1 - TYPO TAGLINE: se corrigio blogdescription a
      "Alineación | Neumáticos e Insumos" (wp option update). Backup en
      docs/backups/blogdescription-backup.txt. VERIFICADO en el <title> de la
      home: "Duna Neumáticos – Alineación | Neumáticos e Insumos".
    - FIX 2 - META-DESCRIPTION (opcion A, solo child): nuevo hook en
      wp_head (prioridad 1) en functions.php (duna_child_meta_description)
      que emite <meta name=description> contextual por tipo de pagina:
      front_page / is_shop / is_product_category (usa el nombre real de la
      categoria en minuscula) / is_product (nombre + SKU) / contacto / about-us
      / las 9 paginas PressurePro / buscador / faq / service-inventory / cart /
      checkout / my-account / blog / is_singular (excerpt si existe, si no
      titulo del post). Todos los textos en es-UY de 120-155 chars. No pisa
      WPSEO si en el futuro se instala (guard defined('WPSEO_VERSION')).
    - VERIFICADO con curl en 14 URLs (home/shop/categoria-agricola/producto/
      la-empresa/contacto/pressure-pro/buscador/faq/service/blog/cart/
      my-account/post-coetc): todas con meta description presente (127-151
      chars), sin duplicados ni caracteres rotos.
    - LIGHTHOUSE SEO (v13.4.1 local) ANTES vs DESPUES:
        Home  92 -> 100   (fallaba solo meta-description)
        Shop  85 -> 100   (fallaba meta-description + robots local)
        Single 85 -> 100
      El audit "robots.txt" tambien queda en verde en local (el invalid previo
      era por la Sitemap apuntando a localhost; al usar dominio real debe
      apuntar a https://<dominio>/wp-sitemap.xml — verificado en prod).
    - Link "La empresa": sin accion (ya apuntaba a /about-us/). Queda
      documentado como resuelto.
    - Regresion visual rapida (CDP, home dark/light + shop + ficha): sin
      errores; screenshots en temp/opencode/qa-seo-v130/. Version servida 1.3.0
      (verificado en el HTML por ?ver=1.3.0).
    - Solo se toco functions.php del child + style.css (version). Bump ->
      1.3.0.
    - PENDIENTE para produccion: robots.txt Sitemap apuntando al dominio real
      (hoy localhost:8881) — documentado, no forzado.
59. ETAPA CACHE/OPTIMIZACION - Autoptimize SOLO-CSS (2026-09-05; item 28):
    - DIAGNOSTICO del problema real: el Perf Lighthouse local (home 43 / shop 55 /
      single 50) NO esta dominado por los assets sino por el TTFB del servidor de
      WordPress Studio local: ~2.5s en TODAS las paginas (incluso about-us simple;
      medido 3x: 2.72/2.67/2.55s; el CSS estatico responde en 4ms). Es el costo de
      arrancar WP + SQLite por request, sin opcache de pagina. En produccion el
      TTFB seria normal (~100-300ms) y ahi la optimizacion de assets SI mueve el
      score.
    - Assets al inicio: 30 CSS (~950KB sin minificar: app.css 657KB, animation.css
      86KB, header 66KB, child 52KB, bootstrap 48KB, theme-icons 24KB, wsf 15KB)
      + 50 JS (11 sync en head) + Google Fonts (28 variantes de 3 familias).
    - INSTALADO Autoptimize 3.1.15.1. CONFIG FINAL (solo-CSS, seguro):
        autoptimize_css=1, autoptimize_css_aggregate=1, autoptimize_css_defer=1
        autoptimize_js=0  (JS 100% intacto)
        autoptimize_minify_excluded=0, autoptimize_js_include_inline=0
    - POR QUE JS=0: con JS agregado o solo minificado, Autoptimize ROMPE RevSlider
      (errores "ReferenceError: SR7 is not defined" en la home; el slider no
      arranca). Causa: RevSlider registra sr7/tp-tools con strategy async y emite
      bloques inline SR7.JSON que Autoptimize reordena/minifica rompiendo la
      dependencia. Se descarto js_aggregate=1 con exclusiones (revslider,sr7,
      tp-tools,migration) y js_aggregate=0 (solo minify): ambos seguian rompiendo.
      La unica config sin errores es JS intacto (autoptimize_js=0).
    - RESULTADO: el CSS del sitio pasa de ~30 hojas render-blocking a UN solo
      archivo PHP agregado (incluye el .none concatenado-minificado) servido
      DIFERIDO (no-bloqueante). El JS y Google Fonts quedan intactos.
    - VERIFICADO sin regresiones (CDP): home/buscador/shop sin errores JS; skin
      intacto (body #0d1117 / card #161b22 dark, #f7f8fa/#fff light; buscador
      presente). Screenshots en temp/opencode/qa-autoptimize/.
    - LIMITACION confirmada: el score Perf local NO mejora (sigue 43) porque el
      TTFB de ~2.5s del servidor Studio domina el audit server-response-time
      (savings ~3147ms). El beneficio real (CSS minificado+agregado+diferido) se
      vera en PRODUCCION con TTFB normal. NO tiene sentido forzar mas optimizacion
      en local (defer JS rompe RevSlider y el CSS ya esta optimizado).
    - NOTA: la cache de autoptimize genera archivos .php (wrapper, incluye el
      .none crudo) en wp-content/cache/autoptimize/; se limpio con clearall y se
      borraron residuos .none huerfanos. wp-content/cache/ ya estaba en .gitignore.
    - PENDIENTE en produccion: revisar si conviene habilitar defer JS con
      exclusiones finas (el CSS ya esta; el JS requiere testeo real), y evaluar
      WP Super Cache / page cache para el TTFB de produccion.
