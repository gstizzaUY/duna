# Plan Tecnico de Implementacion

## F2 — Servicios con listings [COMPLETADO]
1. Renombrar taxonomias (opcion `stm_vehicle_listing_options`):
   - body -> "Tipo de servicio" (terminos: Alineacion, Balanceo, Chequeo de neumaticos,
     Reparacion de neumaticos, Montaje y desmontaje, Rotacion, Camaras y convencionales)
   - condition -> "Modalidad" (terminos: En tienda, A domicilio)
   - make -> "Aplica a" (terminos: Auto, Camioneta, Camion, Moto, Agricola, Maquinaria)
   - Desactivadas (todas las use_* = 0): category_type, serie, mileage, engine, ca-year, exterior-color
   - precio: activa (filtro + slider + ficha)
2. Listings demo: 9 movidos a papelera (7 motos + 2 dummy). Terminos demo eliminados.
3. Creados 8 servicios como listings (IDs 5704-5711): metas price/stm_genuine_price/
   stm_car_user=1 + taxonomias + thumbnail de imagenes importadas + descripcion en espanol.
4. Ficha (`mvl_listing_details_settings`): activos test_drive (Reservar turno), trade_in
   (Presupuesto), offer_price (Quote by phone), calculator; ocultos stock/compare/share/pdf/
   vin/certificados/added_date/print. Ademas show_listing_compare=false en
   `motors_vehicles_listing_plugin_settings` Y `mvl_search_results_settings` (el segundo
   pisa al primero en el merge de PluginOptions).
5. Titulo del archivo -> "Servicios" (mvl_search_results_settings).
6. Verificado: /inventory/ muestra los 8 servicios + filtros (Tipo de servicio, Modalidad,
   Aplica a) + ficha con formularios. Comparar: desactivado (stm_compare_unit=0).
7. NOTA: los textos de los formularios del tema estan en ingles (Schedule test drive,
   Trade In, Request a quote...) — pendiente de traduccion (child theme/translations).
8. NOTA: la seccion home "FEATURED HOT DEALS" ahora muestra los servicios (recent).

## F3 — Home seccion PRODUCTOS (categorias WooCommerce) [COMPLETADO]
1. Shortcode `[wsf_categories]` creado en wheels-size-finder (class-shortcode.php):
   - Parametros: slugs (lista por comas), count (1-12), title opcional.
   - Render: grid de cards (imagen, nombre, contador "X productos", link al archivo).
   - Imagen: thumbnail de la categoria si existe; si no, primera imagen de un producto
     de la categoria; fallback placeholder.
   - CSS en wheels-finder.css (.wsf-categories, .wsf-category-card...), usa las
     variables --wsf-* (colores configurables del admin).
2. Home (post 4300): las 4 cards de stm_inventory_categories reemplazadas por
   [vc_column_text][wsf_categories slugs="auto,camioneta,agricola-y-forestal,baterias,
   camion-liviano-y-pesado,llantas"][/vc_column_text] (NOTA: NO usar vc_raw_html,
   decodifica base64 y no procesa shortcodes anidados).
3. Categorias elegidas (top por cantidad, sin duplicar padre/hijo): Auto (74),
   Camioneta (62), Agricola y Forestal (60), Baterias (38), Camion Liviano y Pesado (35),
   Llantas (33). Las categorias importadas NO tienen imagen propia: se usa la foto
   del primer producto.
4. Verificado en navegador: 6 cards visibles con imagen, contador y link correctos.
5. AVISO: si la pagina 4300 esta abierta en el editor WPBakery, al guardar pisa los
   cambios hechos por codigo. Cerrar/refrescar el editor antes de editar por codigo.

## F4 — Tienda con estetica del tema [COMPLETADO]
1. Medida destacada (_wsf_tire_size): hooks en class-woocommerce.php
   (constructor): woocommerce_single_product_summary (pri 5) y
   woocommerce_after_shop_loop_item_title (pri 5) -> badge .wsf-product-measure
   ("Medida: 205/65R15") en ficha y cards del shop. CSS con variables --wsf-accent.
2. Sidebar Shop (widgets WooCommerce asignados programaticamente):
   - widget_woocommerce_product_categories ("Categorías", jerarquico con contadores)
   - widget_woocommerce_layered_nav x3 (Marca de Neumatico, Ancho, Rodado)
   - widget_woocommerce_price_filter (Filtrar por precio)
   - widget_woocommerce_layered_nav_filters (Filtros activos)
   El widget layered_nav guarda 'attribute' SIN prefijo pa_ (ej. marca-de-neumatico).
3. El tema muestra el sidebar del shop solo en desktop (col-md-3; oculto <992px
   por hidden-sm hidden-xs del tema). En movil, full width sin sidebar.
4. Filtros verificados: ?filter_marca-de-neumatico=headway filtra correctamente.
5. Breadcrumbs: el tema NO renderiza breadcrumbs (navxt) en shop/ficha — pendiente
   de integracion custom si se desea.
6. NOTA: los widgets se pierden si se re-importa/reinstala WC; reasignar con el
   script docs/backups o f4-widgets (temp).

## F5 — Odoo (diseño, pendiente de decision)
- Ver docs/04-integracion-odoo.md

## F6 — Produccion
- Migrar a MySQL (Studio export genera dump MySQL-compatible).
- RevSlider: en MySQL el aviso max_allowed_packet desaparece; el mu-plugin
  revslider-sqlite-compat es inerte en MySQL (no estorba, no borrar).
- Desactivar stm_importer, currency switcher; hardcodear moneda USD.
- HTTPS, SSL, backups, borrar claves API de duna.com.uy.
