# Integracion Odoo (inventario, precios, ventas)

## Arquitectura recomendada
Odoo = maestro de inventario/precios/ventas; WooCommerce = storefront.
Sync bidireccional: productos/stock/precios Odoo -> WC; pedidos/clientes WC -> Odoo.

## Opciones
1. Conector comercial Odoo<->WooCommerce (Odoo Apps Store: Cybrosys/Webkul/Emipro,
   ~USD 200-400 unicos): mas rapido si Odoo esta montado. RECOMENDADA si el presupuesto
   lo permite.
2. Servicio propio Node (ya existe backend Node en localhost:3002):
   WC REST API v3 + API externa Odoo (JSON-RPC o modulo REST). Control total, mas desarrollo.
3. Middleware SaaS (mensual).

## Reglas criticas
- SKU = llave maestra (ya importados). Odoo debe conservarlos.
- Campo custom _wsf_tire_size (meta WC): mapear como campo en Odoo -> WC meta.
- MONEDA: la web es bimoneda USD/UYU e independiente de Odoo (ver 06-multi-moneda.md).
  Al sincronizar, Odoo debe enviar {precio, moneda} por producto; el sync escribe el
  precio base en USD (si viene UYU: precio/TC) y el precio UYU por producto
  (_alg_currency_switcher_per_product_regular_price_UYU) para mostrar el numero exacto.
- Mapeos: categorias Odoo <-> product_cat; atributos Odoo <-> pa_*; imagenes por URL.
- Pedidos: WC -> Odoo (webhook order.created). Stock: Odoo -> WC (push por SKU).
- No usar IDs: siempre SKU.
- Servicios (listings) quedan fuera de stock Odoo (o como productos de servicio si
  Odoo los requiere para facturacion).

## Pendiente de decision del usuario
- Odoo ya en uso o a montar? Version (16/17/18)?
- Conector comercial vs servicio Node propio?
