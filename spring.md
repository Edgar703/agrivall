# Proyecto Agrivall. Sprint Final: Sitio Web Funcional alojado en Server

A continuación, se detalla el enunciado completo del Sprint Final del proyecto Agrivall.

En este Sprint ya debemos presentar y alojar en Servidor de hosting una versión completa o
parcialmente Funcional de vuestra propuesta de site.

## Objetivo General

Desarrollar el sitio web **completamente functional\*** y responsive.

- **Completamente functional** , pero solo de las partes A B y/o C, las que decidas realizar.

De esto tres bloques tú decides qué backoffices quieres hacer (puedes hacer los 3 si quieres):

**A. Venta de Frutas con carrito (sin pago real) y backoffice de Pedidos** => **3 puntos máximo**

**B. Sistema de reserva de Casa Rural por semanas** , incluyendo un **backoffice para gestionar el
estado de las reservas** (reservas por semanas enteras) => **2 puntos máx.**

**C. Blog de noticias con su correspondiente Backofice (CRUD** ) => **2 puntos máx.**

Importante: los **Backoffices** los maquetarás **sin usar CSS nativo** , sino con un **framework de CSS**
a tu gusto: Bootstrap, Tailwind, PicoCSS, Bulma, etc. También se premiará el uso de componentes y
librerías que gustes: SweetAlert2, Wow.

En las páginas siguientes tenéis explicadas las funcionalidades A. B. y C.

## Compromiso de entregar un Front Completo (aunque tenga parte simuladas)

Independientemente de los backoffices A, B y/o C que realices, **la web debe presentar todo el
Front acabado** (o sea que si, p.e. no hay Backoffice B, al menos en el front debe presentar una
“vista tonta” para ver cómo luciría esta parte).
La puntuación máxima de la **implementación del Front** en esta fase es de => **3 puntos máx.**
Si, además, sitio y backoffice correctamente **alojados** en Servidor de Hosting => **1 puntos máx.**

**Front debe ser responsive/Mobile First , implementado con HTML/CSS nativo\*** (o PUG/SASS).
**Se penaliza** si en el Front se usa Framework de CSS, pero **se premia** si se usa librerías vistas en
D.I.W.: FontAwesome, Wow, SweetAlert2, Luxbar, Pushi, u otras librerías de componentes.

- Nota: se entiende que el HTML se generará desde código de Servidor y que, en muchos casos,
  podréis usar motores de plantillas (Blade, Pug para NodeJS, etc.). Sea como sea, el HTML que
  finalmente renderice el navegador debe ser Estándar, bien estructurado y Semántico.

## Apartado A: Venta de Frutas

En este apartado los alumnos deberán implementar:

- Catálogo de frutas.
- Carrito de compra (NO requiere integración de pago, solo se muestra datos para pago por
  Transferencias o Bizum).
- Formulario de envío del pedido.
- Envío automático de correo confirmando el pedido.
- Backoffice A: Visualización de pedidos recibidos, y ver estado

**Estructura mínima de base de datos:**

**Operativas básicas en el Backoffice:**

1. Administrador del sitio da de alta los Productos en un CRUD. Ejemplo de alta de un producto:
   Nombre: Cereza Variedad: Burlat Formato: 2Kg \*
   Precio: 5€ Imagen: <ruta a imagen> Disponible: Sí

```
Nota: si tenemos Cereza Burlat en formato de caja 5Kg, se debe hacer otra alta de producto.
Admin siempre puede Borrar y Editar un registro de Productos. Formato solo hay 2Kg y 5Kg
```

2. Cliente desde el Front Web, ve los productos dados de alta, y mediante un Carrito de
   compra elige: Producto, Cantidad, y Guarda también Precio_Unitario (que es el precio q
   marcaba cuando se hizo el pedido). Una vez completado Carrito de Compra, rellena los
   Datos del Pedido: Nombre Cliente, email, Tlf. , Dir. envío y Mét odo pago (Transferencia o
   Bizum). Se guarda además en un CRUD la fecha de pedido y precio total del pedido
   (calculado)
3. Admin del sitio recibe email, y además, tendrá un CRUD de Pedidos, donde ver los pedidos
   y cambiar el ESTADO del pedido, que puede ser: INICIADO, EN PROCESO, REPARTO,
   FINALIZADO.

## Apartado B: Reserva Casa Rural por Semanas

Se debe implementar:

- Página pública que muestre el estado de cada semana del año (DISPONIBLE, OCUPADA o LIBRE).
- Reserva únicamente por semanas completas.
- Backoffice B: Gestión de 54 semanas del año, pudiendo marcar cada semana como DISPONIBLE,
  OCUPADA o LIBRE.

**Estructura mínima de base de datos:**

**Operativas básicas en el Backoffice:**

1. En Tabla SemanasCasilla, ya estar registradas 30 Semanas, desde la actual hasta última del año:
   Nº Semana: 11 (nºsemana del año) Descriptor:”9 Mar-15 Mar”
   Año: 2026 Precio: 0 Estado: DISPONIBLE
2. Admin tiene un Backoffice, desde donde:
    - Editar las semanas para cambiar Precio, y Estado (DISPONIBLE, PRE-RESERVA,
      RESERVADO, NO DISPONIBLE)
3. Cliente desde el Front Web, puede ver las semanas del Año Actual\*, su nº, descriptor,
   Precio y Estado. Aquí un ejemplo:

```
*Nota: se podría mejorar mostrando desde la semana actual hasta las 20 siguiente,
también se puede mejorar, si en vez de lista, mostrais semanas tipo Card u otro aspecto
más visual.
```

4. Cliente desde el Front tiene un Form, en el que elije semana, y pone observaciones. El form
   envía email a admin del sitio, y la semana queda en estado PRE-RESERVA
5. Admin, desde backoffice puede Cambiar el Estado de PRE-RESERVA a RESERVADO o, de
   nuevo, a DISPONIBLE (p.e. si no se recibe el pago). Las semanas que no se quiera alquilarl
   (p.e. para uso propio), se podrán poner en estado NO DISPONIBLE (y en precio se pone “-“)

## Apartado C: Blog de Noticias

Debe incluir:

- Página pública de noticias.
- Backoffice C: CRUD completo para Posts de Noticias, y CRUD completo para TipoPost.

**Estructura mínima de base de datos:**

**Operativas básicas en el Backofice:**

1. Admin del sitio tiene CRUD para dar de alta los Tipos de Post. Inicialmente hay 3 Tipos:
   Cultivos, Ecología y Cursos
2. Admin tiene CRUD donde Añadir y Gestionar Noticias. Ingresa el Título, el texto de la Noticia.
   La imagen de noticia puede ser una o ninguna (si no ponemos ninguna en Front se pone img de
   relleno). La fecha se pone automáticamente, será la de creación de la noticia.

## Resumen de puntuaciones

La nota final del proyecto se calculará según:

- Frontend completo, Responsive (móvil y PC): **hasta 3 puntos**
- Backoffice A (Venta de Frutas completamente operativa): **hasta 3 puntos**
- Backoffice B (Sistema de Reservas Casa Rural operativa): **hasta 2 puntos**
- Backoffice C (Blog de Noticias completamente operativo): **hasta 2 puntos**

En todos los casos de arriba, se puntúa la Programación, Aspecto Visual, y Usabilidad

- Hosting en Server, con despliegue automático, y certif. SSL: **hasta 1 punto**
- Buenos estándares (siempre que y además se hayan cumplido prerrequisitos): **+0,5 puntos**
