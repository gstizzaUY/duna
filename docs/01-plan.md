# Plan General

## Decisiones tomadas (usuario)
1. Servicios NO se cobran online -> se modelan con LISTINGS (presupuesto/turno).
2. Vehiculos usados: NO aplica.
3. Taxonomias de listings: SÍ renombrar a servicios.
4. Motors PRO: no esta instalado -> trabajar con free.
5. Layout de listings: el AGENTE decide -> mantener el layout/grid estandar actual
   (template motorcycle), NO cambiar layouts globales del tema.

## Fases
- F0. Docs + snapshot de configuracion.
- F1. Limpieza: plugins no usados, currency switcher, stm_importer, demo remnants.
- F2. Servicios con listings: renombrar taxonomias, crear servicios, configurar ficha,
      formularios turno/presupuesto, menu.
- F3. Home: seccion PRODUCTOS con categorias WooCommerce reales (imagen+contador+link).
- F4. Tienda con estetica del tema: templates, filtros por pa_*, ficha con medida.
- F5. Odoo: arquitectura de sync (decision: conector comercial vs servicio Node propio).
- F6. Produccion: MySQL, HTTPS, cleanup, backups.

## Plugins: accion (APROBADO en sesion: desactivar los "no usados")
| Plugin | Accion |
|---|---|
| WooCommerce, wheels-size-finder, js_composer, motors-wpbakery-widgets, motors-car-dealership-classified-listings, stm-motors-extends, stm-megamenu, revslider, breadcrumb-navxt, contact-form-7, envato-market | MANTENER |
| gutentor, gtranslate, mailchimp-for-wp, add-to-any, stm-elementor-icons | DESACTIVADO (no usados) |
| currency-switcher-woocommerce | DESACTIVADO (moneda unica USD para Odoo) |
| stm_importer | DESACTIVADO (solo desarrollo; evita duplicados) |
| spotlight-social-photo-feeds | PENDIENTE: el footer usa shortcode [instagram feed=...] del tema; si se usa Spotlight, reemplazar |
| akismet | Activar si hay comentarios |
