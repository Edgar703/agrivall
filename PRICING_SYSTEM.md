# Sistema de Precios para Reservas

## Cambios Realizados

Se ha implementado un sistema de precios dinámico para las reservas de la casa rural. El precio ahora se calcula automáticamente basándose en:

1. **Precio por noche**: Tarifa base configurada en la aplicación (por defecto $50)
2. **Número de noches**: Diferencia entre fecha de inicio y fecha de fin
3. **Número de personas**: Multiplicador que aumenta el precio + 10% por cada persona adicional

### Fórmula de Cálculo

```
Precio Total = Precio por Noche × Número de Noches × Multiplicador de Personas

Multiplicador = 1 + ((Número de Personas - 1) × 0.10)

Ejemplos:
- 1 persona: 1.0x
- 2 personas: 1.1x (10% más)
- 3 personas: 1.2x (20% más)
- 5 personas: 1.4x (40% más)
```

## Archivos Modificados

### 1. Base de Datos

- **Migración**: `database/migrations/2026_02_17_100000_add_pricing_to_reservas_table.php`
    - Agrega campos: `precio_por_noche` y `multiplicador_personas` a la tabla `reservas`

### 2. Modelo

- **Archivo**: `app/Models/Reserva.php`
    - Nuevo atributo: `num_noches` (calcula dinámicamente la cantidad de noches)
    - Nuevo método: `calcularPrecioTotal()` (realiza el cálculo del precio)
    - Campos en fillable: `precio_por_noche` y `multiplicador_personas`

### 3. Controlador

- **Archivo**: `app/Http/Controllers/ReservaController.php`
    - Método `store()`: Calcula automáticamente el precio al crear una reserva
    - Método `update()`: Recalcula el precio cuando se cambian fechas o personas

### 4. Configuración

- **Archivo**: `config/reservas.php` (NUEVO)
    - `precio_por_noche`: Precio base por noche (configurable via `.env`)
    - `incremento_por_persona`: Porcentaje de aumento por persona (0.10 = 10%)

### 5. Vistas

- **Formulario de Creación**: `resources/views/reservas/create.blade.php`
    - Agrega estimador de precio en tiempo real mientras el usuario completa el formulario
- **Formulario de Edición**: `resources/views/reservas/edit.blade.php`
    - Agrega estimador de precio que se actualiza dinámicamente
- **Vista de Detalle**: `resources/views/reservas/show.blade.php`
    - Muestra desglose detallado de:
        - Precio por noche
        - Número de noches
        - Número de personas
        - Multiplicador de precio
        - Precio total calculado

## Cómo Ejecutar los Cambios

### Paso 1: Ejecutar la Migración

```bash
php artisan migrate
```

Esto agregará los campos `precio_por_noche` y `multiplicador_personas` a la tabla `reservas`.

### Paso 2: Configurar el Precio por Noche (Opcional)

Por defecto, el precio es $50 por noche. Para cambiarlo:

#### Opción A: Variable de Entorno

Edita `.env` y agrega:

```
RESERVA_PRECIO_POR_NOCHE=75
```

#### Opción B: Directamente en `config/reservas.php`

```php
'precio_por_noche' => 75,
```

### Paso 3: (Opcional) Actualizar Reservas Existentes

Si tienes reservas existentes sin precio, puedes actualizarlas ejecutando este comando (requiere crear un artisan command):

```bash
php artisan reservas:update-prices
```

O manualmente en la base de datos:

```sql
UPDATE reservas SET precio_por_noche = 50 WHERE precio_por_noche IS NULL;
```

## Características del Sistema

### En el Formulario de Creación

- ✅ Estimador de precio en tiempo real
- ✅ Se actualiza cuando cambian las fechas
- ✅ Se actualiza cuando cambia el número de personas
- ✅ Muestra el desglose completo del cálculo

### En el Formulario de Edición

- ✅ Estimador de precio actualizado
- ✅ Muestra el precio actual de la reserva
- ✅ Recalcula automáticamente al cambiar fechas o personas

### En la Vista de Detalle

- ✅ Desglose completo del precio
- ✅ Muestra precio por noche
- ✅ Muestra número de noches
- ✅ Muestra multiplicador de personas
- ✅ Muestra precio total en grande para claridad

### En el Listado de Reservas

- ✅ Muestra el precio total de cada reserva
- ✅ Fácil de identificar en la tabla

## Notas Importantes

1. **Cálculo Automático**: El precio se calcula automáticamente y se guarda en la base de datos cuando se crea o edita una reserva.

2. **Multiplicador de Personas**: El sistema usa un multiplicador simple del 10% por persona adicional. Si necesitas un sistema más complejo, puedes modificar la fórmula en `app/Models/Reserva.php`.

3. **Precio Flexible**: El `precio_por_noche` se puede cambiar por reserva si es necesario (editar directamente en la base de datos).

4. **Compatibilidad**: El sistema es retrocompatible con reservas existentes.

## Ejemplos de Cálculo

### Ejemplo 1: 3 noches, 2 personas, $50/noche

- Multiplicador: 1 + (2 - 1) × 0.10 = 1.1
- Total: $50 × 3 noches × 1.1 = **$165**

### Ejemplo 2: 7 noches, 4 personas, $50/noche

- Multiplicador: 1 + (4 - 1) × 0.10 = 1.3
- Total: $50 × 7 noches × 1.3 = **$455**

### Ejemplo 3: 10 noches, 1 persona, $75/noche

- Multiplicador: 1 + (1 - 1) × 0.10 = 1.0
- Total: $75 × 10 noches × 1.0 = **$750**
