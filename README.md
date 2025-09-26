
# REDCAPITAL COTIZACIONES INTRANET

Este repositorio contiene el desarrollo de un microsistema intranet solicitado en la prueba técnica de RedCapital.
El sistema permite la gestión de **cotizaciones** y **usuarios**, con un modelo de permisos basado en roles (administrador y usuario normal).
Está construido con **Laravel 10**, **MySQL**, **Blade**, **Bootstrap 5** y **Laravel Excel**.

---

## REQUISITOS

* PHP >= 8.1
* Composer
* MySQL >= 8.0
* Node.js >= 18 y npm >= 9
* Git

---

## INSTALACIÓN

1. **Clonar el repositorio y cambiar a la rama de la prueba:**

```
git clone https://github.com/kisarakii/intranet-cotizaciones.git
cd intranet-cotizaciones
git checkout prueba-redcapital
```

2. **Instalar dependencias de PHP:**

```
composer install
```

3. **Instalar dependencias de Node y compilar assets:**

```
npm install
npm run build
```

4. **Configurar el archivo `.env`:**

```
cp .env.example .env
php artisan key:generate
```

5. **Crear la base de datos en MySQL:**

```
CREATE DATABASE intranet_cotizaciones CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
```

6. **Ejecutar migraciones y seeders:**

```
php artisan migrate --seed
```

Esto crea todas las tablas necesarias y carga usuarios y productos iniciales.

---

## USUARIOS INICIALES

Se incluyen dos cuentas listas para pruebas:

* **Administrador**
  Email: `admin@intranet.test`
  Password: `Admin123!`
  Permisos: acceso completo (incluye gestión de usuarios).

* **Usuario normal**
  Email: `menor@intranet.test`
  Password: `Menor123!`
  Permisos: solo acceso a cotizaciones.

---

## FUNCIONALIDADES PRINCIPALES

* **Autenticación y roles**: inicio de sesión por email y contraseña, encriptados con bcrypt.
* **Sección Cotizaciones**:

  * Ver cotizaciones en una grilla con paginación (5 registros por página).
  * Filtros por rango de fechas y monto bruto mínimo.
  * Crear nuevas cotizaciones con múltiples productos.
  * Exportar cotizaciones a Excel (2 hojas: resumen y productos cotizados).
* **Sección Usuarios (solo administradores)**:

  * Crear, editar y eliminar usuarios.
  * Contraseña doble ingreso y encriptada.
  * Token generado automáticamente y solo lectura.
  * Eliminación lógica con `deleted_at` para preservar integridad.
* **Perfil de usuario**: cada usuario puede ver y editar su información y contraseña.
* **Recuperación de contraseña**: disponible desde la pantalla de login, vía email.
* **Notificaciones automáticas**:

  * Observer que alerta a administradores cuando se crea un usuario menor de edad.
* **API de Cotizaciones**:

  * Endpoint protegido con header `Authorization: Token <token_usuario>`.
  * Responde en JSON con filtros (`desde`, `hasta`, `min_total`, `page`).
* **Comando Artisan**:

  * `cotizacion:recalculo_bruto` recalcula totales brutos en todas las cotizaciones.

---

## ESTILOS Y FRONTEND

* **Blade** como motor de vistas.
* **Bootstrap 5** y **Bootstrap Icons** para UI.
* **Navbar responsivo** con offcanvas lateral (slidebar).
* **Botón flotante de idioma** para cambiar entre español e inglés.
* **Vite** usado para compilar CSS/JS.

  * Nota: no es necesario ejecutar `npm run dev`. Los assets se sirven desde `public/build` tras ejecutar `npm run build`.

---

## CONFIGURACIÓN DE CORREO

El proyecto está preparado para funcionar con [Mailtrap](https://mailtrap.io).
En el `.env` deben colocarse las credenciales propias de Mailtrap para probar recuperación de contraseña y notificaciones.

---

## API DE COTIZACIONES

Ejemplo de consumo vía `curl`:

```
curl -H "Authorization: Token CPwIhY64LsWBB0eyZc7PSrHXgkAu8JFOQ0gNypbW" \
  "http://127.0.0.1:8000/api/cotizaciones?desde=2025-01-01&hasta=2025-12-31&min_total=100"
```

Parámetros soportados:

* `desde=YYYY-MM-DD`
* `hasta=YYYY-MM-DD`
* `min_total=N`
* `page=N`

---

## COMANDOS RÁPIDOS DE PRUEBA

### Levantar el servidor

```
php artisan serve
```

### Migraciones + seeders desde cero

```
php artisan migrate:fresh --seed
```

### Probar login

* Admin: `admin@intranet.test / password`
* Usuario: `user@intranet.test / password`

### Exportar cotizaciones

Ingresar en el navegador a:

```
http://127.0.0.1:8000/cotizaciones
```

y presionar el botón **Exportar**.

### Recalcular totales de cotizaciones

```
php artisan cotizacion:recalculo_bruto --dry
php artisan cotizacion:recalculo_bruto --user=1
```

### Probar API con token de usuario

```
curl -H "Authorization: Token <TOKEN_DEL_USUARIO>" \
  "http://127.0.0.1:8000/api/cotizaciones"
```

---

## NOTAS FINALES

* El `.env.example` incluye valores listos para que la aplicación arranque sin dificultad.
* El proyecto no requiere ejecutar `vite dev` en entornos de prueba: basta con compilar una vez los assets (`npm run build`).
* Se han aplicado buenas prácticas de arquitectura en Laravel: migraciones, seeders, policies, observers y separación de servicios.
* El repositorio se entrega en una rama específica (`prueba-redcapital`) para mantener aislado el desarrollo de la prueba.

