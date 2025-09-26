# RedCapital – Intranet de Cotizaciones (Prueba Técnica)

Microsistema en **Laravel 10 + MySQL** para gestionar **cotizaciones** con **1..n** productos, con **perfilamiento**:
- **Todos**: crear y ver cotizaciones
- **Solo Admin**: CRUD completo de usuarios

Incluye: **export a Excel (2 hojas)** con Laravel Excel, **observer + mail** por usuario **menor de edad**, **perfil** de usuario, **filtros + paginación**, **API por token**, **comando de consola** y **multilenguaje (ES/EN)** con switcher.

---

## Requisitos
- PHP **8.1** (CLI)
- MySQL 8.x
- Composer
- Node.js 18+
- Extensiones PHP: `mbstring`, `openssl`, `pdo_mysql`, `xml`, `zip`, `gd`
- Cuenta **Mailtrap** (Testing) para correos de prueba

---

## Instalación

```bash
# 1) Clonar
git clone <URL_DE_TU_REPO>
cd intranet_cotizaciones

# 2) Dependencias PHP
composer install

# 3) Variables de entorno
cp .env.example .env
# Edita .env (DB, MAILTRAP). Ver secciones más abajo.

# 4) Key de app
php artisan key:generate

# 5) Migraciones + Seeders
php artisan migrate --seed

# 6) Frontend
npm install
npm run dev   # (para desarrollo) o: npm run build 

# 7) Servidor local
php artisan serve
# http://127.0.0.1:8000
