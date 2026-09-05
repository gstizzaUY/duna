# Multi-moneda USD / UYU (ecommerce estandar)

## Decision (usuario, sesion)
La web es un **ecommerce estandar bimoneda** (USD + UYU), **independiente de Odoo**.
Los productos se cargan en cualquiera de las dos monedas. El cliente puede ver y
comprar tanto en USD como en UYU. La sincronizacion de moneda con Odoo se resolvera
cuando se construya el modulo de conexion (ver 04-integracion-odoo.md).

## Solucion tecnica
WooCommerce con **moneda base USD** (ya estaba) + plugin **Currency Switcher for
WooCommerce (WP Wham) v2.16.6** (gratuito, ya instalado) con **precio por producto**.

```
[WooCommerce base USD]  +  [Currency Switcher: USD + UYU]
     │                           │
     │ _price (USD)              │ _alg_currency_switcher_per_product_regular_price_UYU (opcional)
     ▼                           ▼
  carrito/totales en USD    display + switcher en USD/UYU (conversion con TC)
  gateway paga en USD       checkout convierte los totales a la moneda elegida
```

## Verificado en vivo (esta sesion)
- Plugin activado y configurado: monedas USD + UYU, default USD, per-product ON,
  tasa manual USD->UYU = 41.
- **Ficha de producto**: aparece el switcher (select `alg_currency`) y convierte
  correctamente: `$68,00 -> $59,84` en USD y `$2.788,00 -> $2.453,44` en UYU (68x41).
- **Carrito**: con `?alg_currency=UYU` el total estimado se muestra en UYU
  (`$2.453,44` = 59,84 x 41). El carrito matematico sigue en USD (base).
- Home y fichas sin errores fatales.

## Configuracion actual del plugin (options wp)
- `alg_wc_currency_switcher_enabled = yes` (plugin activo en active_plugins).
- `alg_currency_switcher_currency_1 = USD` (enabled_1 = yes).
- `alg_currency_switcher_currency_2 = UYU` (enabled_2 = yes).
- `alg_currency_switcher_total_number = 2`.
- `alg_currency_switcher_currency_shop_default = USD`.
- `alg_currency_switcher_per_product_enabled = yes`.
- `alg_currency_switcher_exchange_rate_update = manual`; server = ecb (para UYU no hay
  fuente BCU nativa -> mantener tasa manual y actualizarla).
- `alg_currency_switcher_exchange_rate_USD_UYU = 41` (TC usado en las pruebas).
- `alg_currency_switcher_placement = single_page_after_price_select` (switcher solo en
  la ficha de producto; se puede ampliar a shop/menu/carrito).
- `alg_currency_switcher_format = %currency_name%`.

### Simbolos por moneda (price formats)
- `alg_wc_currency_switcher_price_formats_enabled = yes` (maestro de la seccion).
- `alg_wc_currency_switcher_price_formats_currency_code_USD = U$S` (simbolo USD).
- `alg_wc_currency_switcher_price_formats_currency_code_UYU = $` (simbolo UYU).
- `alg_wc_currency_switcher_price_formats_currency_position_UYU = left_space`.
- Formatos numericos UYU: miles `.`, decimales `,`, 2 decimales.
- VERIFICADO EN VIVO: USD muestra "U$S 68,00 -> U$S 59,84"; UYU muestra
  "$ 2.788,00 -> $ 2.453,44" (ficha y cards).

> Backup de las opciones previas a la activacion:
> `C:\Users\Acer\AppData\Local\Temp\opencode\switcher-backup.json`
> y de los formatos: `C:\Users\Acer\AppData\Local\Temp\opencode\price-formats-backup.json`
> (por si hay que revertir).

## Carga de productos por moneda (regla)
Al cargar/importar un producto, escribir siempre el precio base en USD:

- **Producto en USD**: `_regular_price` = precio USD. No hace falta precio UYU por
  producto (el plugin convierte con el TC).
- **Producto en UYU**: 
  1. `_regular_price` = `precio_UYU / TC` (para que la base USD y el carrito sean
     coherentes).
  2. `_alg_currency_switcher_per_product_regular_price_UYU` = **precio UYU exacto**
     (asi se muestra el numero real sin redondeo de conversion).
  3. (opcional) `_alg_currency_switcher_per_product_sale_price_UYU` si hay oferta.
- Metas de referencia propias (opcional): `_wsf_price_currency` (USD/UYU) y
  `_wsf_price_original` (precio nativo).

## Pendientes / decisiones abiertas
- ~~**Simbolo de moneda**~~: RESUELTO - USD = "U$S", UYU = "$" (price formats, ver arriba).
- **Tipo de cambio**: definir la fuente (manual con cron que lea el TC del BCU, o
  proveedor externo con API key). El plugin no tiene BCU nativo.
- **Placement del switcher**: decidir si se muestra solo en la ficha (actual) o tambien
  en tienda/categorias/carrito/menu.
- **Gateway de pago**: validar con la pasarela elegida (Mercado Pago / otra) que el
  monto cobrado sea el correcto (el plugin muestra en la moneda elegida pero el
  gateway liquida en la base USD).
- **Envio/cupones/montos minimos**: probar en ambas monedas.
- **Redondeo**: el plugin tiene opciones de rounding; validar totales.
