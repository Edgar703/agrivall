# Contexto de trabajo Agrivall

Fecha: 2026-04-15
Proyecto: `/home/edgar/edgmor.dev/agrivall`
Produccion: `https://agrivall.edgmor.dev/`
Despliegue: SFTP a Hostinger

## Preferencias de trabajo

- Recordar siempre al finalizar si hay acciones necesarias en produccion.
- Produccion se actualiza por SFTP, no por git pull.
- Si se cambian vistas/rutas/config en produccion, limpiar/cachear Laravel.
- Comunicacion preferida del usuario: breve.
- Mantener este archivo actualizado cada vez que haya cambios relevantes, decisiones nuevas, verificaciones, pendientes o pasos de produccion.
- Instruccion activa: revisar este archivo al empezar trabajo y actualizarlo antes de cerrar si cambia algo relevante.
- Se trabaja desde 2 PCs distintos: pueden aparecer cambios no hechos por esta sesion. No revertir ni sobrescribir cambios ajenos; revisar y convivir con ellos.

## Acciones de produccion habituales

Con SSH:

```bash
php artisan optimize:clear
php artisan view:cache
```

Si se cambian rutas:

```bash
php artisan route:clear
php artisan route:cache
```

Si se cambia `config/*.php` o `.env`:

```bash
php artisan config:clear
php artisan config:cache
```

Sin SSH, por SFTP borrar archivos cacheados dentro de:

```text
storage/framework/views/
bootstrap/cache/
```

No borrar las carpetas completas.

## Cambios realizados

### Correos de pedidos

Antes:

- Al crear pedido solo se mandaba correo al admin.

Ahora:

- Al crear pedido se manda correo al admin y al usuario.
- `PedidoMail` acepta flag `$admin`.
- Asunto distinto para admin/cliente.
- Vista `emails.pedido` muestra texto distinto para admin/cliente.
- Admin mail usa `config('mail.admin_address')`.

Archivos:

- `app/Http/Controllers/PedidoController.php`
- `app/Mail/PedidoMail.php`
- `resources/views/emails/pedido.blade.php`
- `config/mail.php`

### Correos de reservas

Reserva ya mandaba:

- `ReservaMail` al usuario.
- `ReservaAdminMail` al admin.

Se reviso y se mantuvo.

### Correos de cancelacion

Ahora, al cancelar reserva:

- Admin recibe `ReservaCanceladaMail`.
- Usuario recibe `ReservaCanceladaMail`.

Ahora, al cancelar pedido:

- Admin recibe `PedidoCanceladoMail`.
- Usuario recibe `PedidoCanceladoMail`.

Archivos nuevos:

- `app/Mail/ReservaCanceladaMail.php`
- `app/Mail/PedidoCanceladoMail.php`
- `resources/views/emails/reserva-cancelada.blade.php`
- `resources/views/emails/pedido-cancelado.blade.php`

Controladores:

- `app/Http/Controllers/ReservaController.php`
- `app/Http/Controllers/PedidoController.php`

### Config mail admin

Añadido en `config/mail.php`:

```php
'admin_address' => env('MAIL_ADMIN_ADDRESS', env('MAIL_FROM_ADDRESS', 'hello@example.com')),
```

En produccion conviene tener:

```env
MAIL_ADMIN_ADDRESS=correo_admin@dominio.com
MAIL_FROM_ADDRESS=correo_remitente@dominio.com
```

Nota seguridad: se vieron credenciales SMTP en `.env`. Si ese archivo se ha compartido o subido a repositorio publico, rotar la app password.

### Noches negativas en reservas

Causa:

- Carbon actual puede devolver `diffInDays` firmado.
- Habia llamadas invertidas: `fecha_fin->diffInDays(fecha_inicio)`.

Correccion:

- Usar `fecha_inicio->diffInDays(fecha_fin)`.

Archivos tocados:

- `app/Http/Controllers/ReservaController.php`
- `app/Models/Reserva.php`
- `resources/views/emails/reserva.blade.php`
- `resources/views/emails/reserva-admin.blade.php`
- `resources/views/casa-rural/index.blade.php`
- `resources/views/admin/reservas/index.blade.php`

Verificacion puntual:

```bash
php -r "require 'vendor/autoload.php'; echo \Carbon\Carbon::parse('2026-05-01')->diffInDays(\Carbon\Carbon::parse('2026-05-08'));"
```

Resultado esperado: `7`.

### Estados de reservas

Estados nuevos:

- `PRE-RESERVA`
- `RESERVADO`
- `NO_DISPONIBLE`
- `cancelada`

Correcciones:

- `ReservaRequest` validaba estados antiguos (`pendiente`, `confirmada`, `cancelada`); ya valida nuevos.
- `reservas/edit.blade.php` usa valores nuevos.
- Vistas que mostraban estados antiguos fueron actualizadas.
- Al crear/editar reserva se guarda `multiplicador_personas`.

Archivos:

- `app/Http/Requests/ReservaRequest.php`
- `app/Http/Controllers/ReservaController.php`
- `resources/views/reservas/edit.blade.php`
- `resources/views/reservas/index.blade.php`
- `resources/views/profile/edit.blade.php`
- `resources/views/admin/usuarios/show.blade.php`

### ParseError en `reservas/index.blade.php`

Error:

```text
syntax error, unexpected token "endif"
```

Causa:

- Habia `@forelse` sin `@empty`.
- Ya existia `@if ($reservas->isEmpty())`, por tanto se cambio a `@foreach`.

Archivo:

- `resources/views/reservas/index.blade.php`

### Revision exhaustiva de enlaces/rutas

Hallazgos y cambios:

- Rutas `dashboard` no existian. Se cambiaron a `index`.
- Catalogo enlazaba producto a `admin.productos.show`; ahora enlaza a ruta publica `productos.show`.
- Se añadio ruta publica:

```php
Route::get('/productos/{producto}', [ProductoController::class, 'show'])->name('productos.show');
```

- `admin.productos.show` usa el mismo metodo `show`, pero ahora valida admin si la ruta es admin.
- Rutas comentadas de `productos.edit`/`productos.destroy` en catalogo fueron cambiadas a nombres admin para evitar problemas futuros si se descomenta.

Archivos:

- `routes/web.php`
- `app/Http/Controllers/ProductoController.php`
- `resources/views/productos/catalogo.blade.php`
- `app/Http/Controllers/Auth/VerifyEmailController.php`
- `app/Http/Controllers/Auth/EmailVerificationPromptController.php`
- `app/Http/Controllers/Auth/EmailVerificationNotificationController.php`
- `app/Http/Controllers/Auth/ConfirmablePasswordController.php`
- `tests/Feature/Auth/AuthenticationTest.php`
- `tests/Feature/Auth/EmailVerificationTest.php`
- `tests/Feature/Auth/RegistrationTest.php`

Verificacion realizada:

```bash
php artisan route:list
php artisan view:cache
php artisan test --filter ExampleTest
```

Scanner local de `route('...')` contra rutas registradas dio `OK`.

No se pudo levantar `php artisan serve` en sandbox: fallo al escuchar puerto local.

### Layouts simplificados

Objetivo del usuario:

- Solo Bootstrap + CSS normal.
- No usar layout guest si no hace falta.

Cambios:

- Las vistas auth que usaban `<x-guest-layout>` ahora usan `@extends('layouts.app')`.
- Se elimino componente muerto `GuestLayout`.
- Se elimino layout muerto `app-public.blade.php`.

Vistas convertidas:

- `resources/views/auth/forgot-password.blade.php`
- `resources/views/auth/reset-password.blade.php`
- `resources/views/auth/confirm-password.blade.php`
- `resources/views/auth/verify-email.blade.php`

Eliminados:

- `app/View/Components/GuestLayout.php`
- `resources/views/layouts/app-public.blade.php`

Verificacion:

```bash
rg "x-guest-layout|layouts\.guest|GuestLayout|app-public|layouts\.app-public" resources app routes -n
php artisan view:cache
```

No quedan referencias.

## Estado CSS / Bootstrap

No es solo Bootstrap puro.

Hay:

- Bootstrap CDN en:
    - `resources/views/layouts/app.blade.php`
    - `resources/views/layouts/index.blade.php`
- CSS normal propio:
    - `resources/css/app.css`
    - `resources/css/agrivall-styles.css`
    - `resources/css/textures.css`
- Vite activo con `@vite(['resources/css/app.css'])`.
- Tailwind esta instalado en `package.json`, pero no se vieron directivas `@tailwind` en `resources/css/app.css`.

Si se quiere purgar Tailwind/Vite en futuro, revisar con cuidado antes porque produccion podria depender de `public/build`.

## Tablas/migraciones revisadas

Tabla sospechosa:

- `semanascasilla`

Motivo:

- Hay migracion y seeder.
- `Reserva::semanaCasilla()` apunta a `SemanaCasilla::class`.
- No existe `app/Models/SemanaCasilla.php`.

No se modifico. Antes de borrar tabla, decidir:

- Crear modelo `SemanaCasilla`, o
- Quitar relacion/foreign key/seeder.

## Archivos con JavaScript detectados

JS propio/config:

- `resources/js/app.js`
- `resources/js/bootstrap.js`
- `vite.config.js`
- `tailwind.config.js`
- `postcss.config.js`

Blade con JS inline:

- `resources/views/posts/index.blade.php`
- `resources/views/posts/show.blade.php`
- `resources/views/layouts/app.blade.php`
- `resources/views/layouts/index.blade.php`
- `resources/views/reservas/create.blade.php`
- `resources/views/reservas/edit.blade.php`
- `resources/views/reservas/show.blade.php`
- `resources/views/reservas/index.blade.php`
- `resources/views/components/modal.blade.php`
- `resources/views/components/dropdown.blade.php`
- `resources/views/admin/reservas/_acciones_estado.blade.php`
- `resources/views/profile/edit.blade.php`
- `resources/views/profile/partials/update-password-form.blade.php`
- `resources/views/profile/partials/delete-user-form.blade.php`
- `resources/views/profile/partials/update-profile-information-form.blade.php`
- `resources/views/casa-rural/index.blade.php`
- `resources/views/admin/productos/index.blade.php`
- `resources/views/productos/catalogo.blade.php`
- `resources/views/carrito/index.blade.php`

## Verificaciones realizadas

Comandos que pasaron:

```bash
php -l app/Http/Controllers/PedidoController.php
php -l app/Http/Controllers/ReservaController.php
php -l app/Http/Controllers/ProductoController.php
php -l app/Http/Requests/ReservaRequest.php
php -l app/Mail/PedidoMail.php
php -l app/Mail/PedidoCanceladoMail.php
php -l app/Mail/ReservaCanceladaMail.php
php -l app/Models/Reserva.php
php artisan route:list
php artisan view:cache
php artisan test --filter ExampleTest
```

`php artisan test` completo falla por entorno:

```text
SQLSTATE[HY000] [2002] php_network_getaddresses: getaddrinfo for mysql failed
Connection: mysql, Host: mysql, Port: 3306, Database: testing
```

No parece causado por cambios de rutas/vistas/correos. Falta host MySQL `mysql` en entorno test local.

## Pendiente antes de subir a produccion

1. Revisar `git diff` final.
2. Subir por SFTP archivos modificados/nuevos/eliminados.
3. En Hostinger limpiar cache:

```bash
php artisan optimize:clear
php artisan view:cache
```

4. Si se sube `routes/web.php`:

```bash
php artisan route:clear
php artisan route:cache
```

5. Si se sube `config/mail.php` o cambia `.env`:

```bash
php artisan config:clear
php artisan config:cache
```

6. Probar en produccion:

- `/`
- `/catalogo`
- Click producto del catalogo: debe ir a `/productos/{id}`.
- `/casa-rural`
- `/contactar`
- Login/registro.
- Recuperar contraseña.
- Crear reserva: correo admin + usuario.
- Cancelar reserva: correo admin + usuario.
- Crear pedido: correo admin + usuario.
- Cancelar pedido: correo admin + usuario.

## Archivos nuevos importantes

- `app/Mail/PedidoCanceladoMail.php`
- `app/Mail/ReservaCanceladaMail.php`
- `resources/views/emails/pedido-cancelado.blade.php`
- `resources/views/emails/reserva-cancelada.blade.php`
- `CONTEXTO_TRABAJO.md`

## Archivos eliminados intencionalmente

- `app/View/Components/GuestLayout.php`
- `resources/views/layouts/app-public.blade.php`

## Nota sobre `.codex`

Hay `.codex` sin trackear en `git status`. No se reviso ni se debe subir a produccion salvo que el usuario lo pida.
