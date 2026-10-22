# BVUI - Biblioteca Virtual Universitaria Integrada

Sistema de gestión y repositorio documental académico para trabajos especiales de grado (TEG), pasantías, proyectos y servicio comunitario.

---

## 🛠️ Stack Tecnológico

- **Backend**: Laravel 13 (PHP 8.5 Alpine)
- **Frontend**: Livewire 3 + Volt, TailwindCSS, Alpine.js
- **Base de Datos**: MariaDB 10.11
- **Caché y Colas**: Redis (Alpine) + extensión PECL `redis`
- **Búsqueda Full-Text**: Laravel Scout + Meilisearch
- **Gestión de Procesos**: Supervisor (`php-serve` + 4 workers de cola)
- **Administrador DB**: phpMyAdmin

---

## 🚀 Requisitos Previos

- Docker Engine >= 24.0
- Docker Compose v2 >= 2.20

---

## ⚙️ Puesta en Marcha (Entorno Docker)

### 1. Variables de Entorno

Copiar el archivo base si no existe:

```bash
cp .env.example .env
```

Verificar variables clave en `.env`:

```env
APP_URL=http://localhost:8000
DB_CONNECTION=mariadb
DB_HOST=mariadb
DB_PORT=3306
DB_DATABASE=bvui
DB_USERNAME=root
DB_PASSWORD=secret

QUEUE_CONNECTION=redis
CACHE_STORE=database
REDIS_CLIENT=phpredis
REDIS_HOST=redis
REDIS_PORT=6379

SCOUT_DRIVER=meilisearch
MEILISEARCH_HOST=http://meilisearch:7700
MEILISEARCH_KEY=masterKey
```

### 2. Levantar Contenedores

Construir e iniciar los servicios en segundo plano:

```bash
docker compose up -d --build
```

> **Nota:** El contenedor `bvui-app` espera automáticamente a que `mariadb`, `redis` y `meilisearch` pasen su verificación de salud (`service_healthy`) antes de iniciar.

### 3. Compilar Assets de Frontend (Vite)

Compilar el bundle de producción (genera `public/build/manifest.json`):

```bash
docker compose exec app npm run build
```

### 4. Migraciones y Seeders

Ejecutar migraciones de base de datos (crea tablas de usuarios, permisos, documentos, caché, colas):

```bash
docker compose exec app php artisan migrate
```

Ejecutar seeders de roles y permisos iniciales:

```bash
docker compose exec app php artisan db:seed
```

### 5. Configurar y Sincronizar Meilisearch (Scout)

> [!IMPORTANT]
> **Paso obligatorio tras crear o resetear el contenedor:** Meilisearch inicia sin atributos filtrables por defecto. Si no se sincroniza la configuración, las búsquedas fallarán con el error `Attribute status is not filterable`.

Sincronizar atributos filtrables/ordenables del índice documental:

```bash
docker compose exec app php artisan scout:sync-index-settings
docker compose exec app php artisan scout:import "App\Models\Document"
```

### 6. Datos de Prueba Masivos (Opcional)

Para pruebas de rendimiento y volumen, se incluye `TestingDataSeeder` que crea 500 usuarios falsos y 10.000 documentos vinculados:

```bash
# 1. Cargar usuarios y documentos a la base de datos
docker compose exec app php artisan db:seed --class=TestingDataSeeder

# 2. Indexar los 10.000 documentos en Meilisearch
docker compose exec app php artisan scout:import "App\Models\Document"
```

---

## 🌐 Servicios y Puertos

| Servicio | Contenedor | Host / Puerto | Descripción |
|---|---|---|---|
| **App Web** | `bvui-app` | [http://localhost:8000](http://localhost:8000) | Laravel Web App (`artisan serve`) |
| **Vite Dev Server** | `bvui-app` | [http://localhost:5173](http://localhost:5173) | Hot Module Replacement (HMR) |
| **phpMyAdmin** | `bvui-phpmyadmin` | [http://localhost:8080](http://localhost:8080) | Panel de administración MariaDB |
| **Meilisearch** | `bvui-meilisearch` | [http://localhost:7700](http://localhost:7700) | Motor de búsqueda indexado |
| **MariaDB** | `bvui-mariadb` | `localhost:3306` | Servidor MariaDB 10.11 |
| **Redis** | `bvui-redis` | `localhost:6379` | Broker de colas y caché |

---

## 🔄 Gestión de Procesos (Supervisor)

El contenedor `bvui-app` ejecuta Supervisor para administrar la aplicación web y los workers en paralelo:

- `php-serve`: Ejecuta `composer install`, `npm install`, `npm run build` y `php artisan serve`.
- `laravel-worker` (00 al 03): 4 procesos de `artisan queue:work` para procesamiento asíncrono.

### Comandos útiles de Supervisor:

```bash
# Ver estado de los workers y servidor
docker compose exec app supervisorctl status

# Reiniciar workers (tras cambios en jobs o colas)
docker compose exec app supervisorctl restart laravel-worker:*

# Reiniciar todos los procesos
docker compose exec app supervisorctl restart all
```

---

## 📋 Comandos Frecuentes

```bash
# Ver logs en tiempo real
docker compose logs -f app

# Entrar a consola interactiva del contenedor
docker compose exec app bash

# Limpiar caché de Laravel
docker compose exec app php artisan optimize:clear

# Ejecutar tests con Pest
docker compose exec app php artisan test --compact
```

---

## 🛠️ Solución de Problemas (Troubleshooting)

### Error: `Vite manifest not found at: .../public/build/manifest.json`
- **Causa:** No se generaron los archivos compilados de CSS/JS para producción.
- **Solución:**
  ```bash
  docker compose exec app npm run build
  ```

### Error: `Attribute status is not filterable` en Meilisearch
- **Causa:** El volumen de Meilisearch fue creado de cero y no tiene aplicadas las reglas de `config/scout.php`.
- **Solución:**
  ```bash
  docker compose exec app php artisan scout:sync-index-settings
  docker compose exec app php artisan scout:import "App\Models\Document"
  ```
