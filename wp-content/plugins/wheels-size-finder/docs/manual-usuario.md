# Manual de Usuario — Wheels Size Finder para WordPress

## 1. Requisitos

| Componente | Mínimo |
|---|---|
| WordPress | 6.0 o superior |
| PHP | 7.4 o superior |
| WooCommerce | 7.0 o superior |
| Servidor Wheels API | Activo y accesible |
| Licencia premium | Clave válida |

---

## 2. Instalación

1. Descargá el archivo ZIP del plugin.
2. En el panel de WordPress, andá a **Plugins > Añadir nuevo > Subir plugin**.
3. Seleccioná el ZIP y hacé clic en **Instalar ahora**.
4. Activá el plugin desde **Plugins > Plugins instalados**.
5. Verificá que aparezca el menú **Wheels Finder** en la barra lateral.

> Si WooCommerce no está instalado, el plugin mostrará un aviso y la búsqueda de productos no funcionará.

---

## 3. Activación de Licencia

1. Andá a **Wheels Finder** en el menú lateral.
2. En la sección **Licencia Premium** ingresá tu clave (formato `WSF-XXXX-XXXX-XXXX`).
3. Hacé clic en **Activar licencia**.
4. El estado debe cambiar a **Activa**.

> Si no activás la licencia, el buscador no se mostrará en el frontend.

---

## 4. Configuración de la API

En la pestaña **Configuración de la API**:

| Campo | Descripción |
|---|---|
| **URL del servidor Wheels** | URL completa de tu servidor Node.js (ej: `https://api.misitio.com`). Sin barra final. |
| **Modo de búsqueda** | `Por medidas` / `Por vehículo` / `Ambos (tabs)` |
| **Productos por página** | Cantidad de productos a mostrar por página en los resultados (1-100). |
| **Página de resultados** | Opcional: slug de una página donde redirigir los resultados. Dejar vacío para mostrar en el mismo lugar. |

---

## 5. Título del buscador

En la sección **Título del buscador** podés configurar:

| Campo | Descripción |
|---|---|
| **Título** | Texto que se muestra sobre el formulario. Dejalo vacío para no mostrar título. |
| **Etiqueta del título** | Etiqueta HTML usada (`h1`–`h6`). `h2` (por defecto) hereda los estilos de encabezado del tema activo. |
| **Clases CSS del título** | Clases extra aplicadas al título para integrarlo con estilos del tema (ej: `vc_custom_heading vc_do_custom_heading vc_custom_1470913347701` para encabezados de WPBakery). Solo letras, números, guiones y guiones bajos. |

## 6. Personalización de estilos

En la sección **Personalización de estilos** podés ajustar colores, tipografía y medidas de los componentes. Por defecto **todos los campos están vacíos**, lo que hace que el buscador herede los estilos del tema activo (colores, tipografía y encabezados). Al completar un campo, ese estilo deja de heredarse y se usa el valor configurado.

> **Vista previa en vivo:** la página de ajustes muestra el buscador tal cual se vería en el frontend. En la **barra superior de la vista previa** están todos los editores de estilo (colores con su botón `×` para volver a heredar del tema, tipografía, tamaño de letra, esquinas y relleno de los selects, y etiqueta del título) más el botón **Restablecer estilos** para vaciarlos todos. La tarjeta de vista previa queda fija mientras scrolleás el resto del formulario. Guardá los cambios con el botón **Guardar cambios** para aplicarlos en el sitio.

### Colores

| Variable | Afecta |
|---|---|
| **Color primario** | Precio, medida encontrada, badges |
| **Color de acento** | Links activos, bordes en focus, hover |
| **Fondo de botones** | Botón "Buscar productos", "Agregar al carrito" |
| **Texto de botones** | Color del texto dentro de los botones |
| **Fondo general** | Fondo del contenedor del buscador |
| **Fondo de tarjetas** | Fondo de las cards de producto |
| **Fondo de selects** | Fondo de los selects desplegables |
| **Color de texto** | Color del texto general |
| **Color de etiquetas** | Color de las etiquetas de los selects |
| **Color de bordes** | Bordes de tarjetas, inputs, separadores |

Usá el selector de color o ingresá un valor hexadecimal (ej: `#3fb950`). Borrá el campo para volver a heredar el estilo del tema.

### Tipografía y medidas de los selects

| Campo | Afecta |
|---|---|
| **Tipografía** | Familia tipográfica del contenedor (ej: `Roboto, sans-serif`). Vacío = hereda del tema. |
| **Tamaño de letra de los selects** | Tamaño de fuente en píxeles (10–40). Vacío = hereda del tema. |
| **Radio de esquinas de los selects** | Redondeo de las esquinas en píxeles (por defecto `6`). |
| **Relleno interno de los selects** | Padding vertical/horizontal en píxeles (por defecto `12`). |

---

## 7. Insertar el Buscador

Usá el shortcode en cualquier página, post o widget de texto:

```
[wheels_finder]
```

### Atributos opcionales

```
[wheels_finder mode="tire"]
[wheels_finder mode="vehicle"]
[wheels_finder mode="both"]
```

| `mode` | Comportamiento |
|---|---|
| `tire` | Solo buscador por medidas (ancho → perfil → aro) |
| `vehicle` | Solo buscador por vehículo (marca → modelo → año → versión) |
| `both` | Ambos modos con pestañas intercambiables |

Si no especificás `mode`, se usa el valor configurado en la página de ajustes.

### Grilla de categorías

```
[wsf_categories]
[wsf_categories slugs="autos,camionetas,camion" count="12" title="Categorías"]
```

| Atributo | Descripción |
|---|---|
| `slugs` | Lista de slugs de categorías separada por comas. Vacío = las categorías con más productos (excluye "Sin categoría"). |
| `count` | Cantidad máxima de categorías (1–12, por defecto 6). |
| `title` | Título opcional sobre la grilla. |

Cada card muestra la imagen de la categoría (o la primera imagen de un producto), el nombre y la cantidad de productos.

### Logos de clientes

```
[wsf_client_logos]
[wsf_client_logos ids="5772,5776,5781" title="Empresas que confían en nosotros"]
```

| Atributo | Descripción |
|---|---|
| `ids` | Lista de IDs de attachments (imágenes) separada por comas. Vacío = usa los attachments marcados con `_wsf_client_logo = 1`. |
| `title` | Título opcional sobre el marquee. |

Se muestra como un marquee continuo de tarjetas con los logos. Si un logo tiene `_wsf_client_logo_color = 1`, se muestra en escala de grises oscura (no invertido), pensado para logos de un solo color.

---

## 8. Uso del Buscador

### Modo medidas

1. Seleccioná un **ancho** (ej: `205`).
2. El sistema carga automáticamente los **perfiles** que existen para ese ancho.
3. Seleccioná un **perfil** (ej: `55`).
4. Seleccioná un **aro** (ej: `16`).
5. Se muestra la medida encontrada: `205/55R16`.
6. Hacé clic en **Buscar productos**.

### Modo vehículo

1. Seleccioná una **marca**.
2. Seleccioná un **modelo**.
3. Seleccioná un **año**.
4. Seleccioná una **versión**.
5. El sistema consulta la medida OEM del vehículo.
6. Hacé clic en **Buscar productos**.

---

## 9. Resultados

Los resultados muestran:
- Imagen del producto
- Nombre del producto (clickeable)
- SKU de referencia
- Precio
- Botón **Agregar al carrito** (si hay stock) o etiqueta **Sin stock**

La paginación aparece automáticamente si hay más productos que el límite por página.

---

## 10. Requisitos de WooCommerce

Para que la búsqueda funcione correctamente, los productos deben tener configurado el **SKU** con la medida del neumático en formato `ancho/perfilRaro`:

| Producto | SKU |
|---|---|
| Neumático 205/55R16 | `205/55R16` |
| Neumático 225/45R17 | `225/45R17` |

También se busca por la meta `_wsf_tire_size` (campo que puede cargar un importador para productos sin SKU estándar). La búsqueda encuentra coincidencias exactas y parciales.

### Badge de medida

Si un producto tiene la meta `_wsf_tire_size`, se muestra un badge con la medida:
- En las **cards** de la tienda/categorías (debajo del título, estilo píldora con borde).
- En la **ficha** del producto (bajo el título).

---

## 11. Funcionalidades del frontend

### Tema claro/oscuro (solo administradores)

En el menú principal aparece un botón ☀/☾ que alterna entre el tema oscuro (predeterminado) y el claro. La preferencia se guarda en el navegador. **Solo lo ven los administradores**; los visitantes siempre ven el tema oscuro del sitio.

### Cards de producto

- Las cards de productos (OFERTAS, tienda y categorías) usan el mismo borde y esquinas redondeadas que las cards de categorías.
- El título reserva 2 líneas y el precio queda **centrado**, en **negrita** y color oscuro; el precio tachado (rebaja) se ve en gris.
- Todas las cards tienen la **misma altura**, tengan o no medida/precio.

### Sidebar de categorías

- Los widgets de la sidebar tienen el mismo borde que las cards.
- El widget de categorías muestra las **subcategorías colapsadas** por defecto, con una **flecha roja** por cada categoría con hijas para expandir/colapsar. Solo se mantiene abierta la rama donde estás parado.

---

## 12. Solución de Problemas

| Problema | Posible causa | Solución |
|---|---|---|
| El buscador no se muestra | Licencia no activada | Activá la licencia en Wheels Finder |
| Error "Sin resultados" | SKU no coincide | Verificá que el SKU del producto coincida con la medida |
| Error al conectar | API inaccesible | Verificá la URL y que el servidor Node.js esté corriendo |
| Los selects no cargan | CORS o firewall | Asegurate de que CORS esté habilitado en el servidor |
| WooCommerce no detectado | Plugin no instalado | Instalá y activá WooCommerce |

---

## 13. Desinstalación

1. Desactivá el plugin en **Plugins > Plugins instalados**.
2. Hacé clic en **Eliminar**.
3. Se borrarán todas las configuraciones, licencia y opciones guardadas.
