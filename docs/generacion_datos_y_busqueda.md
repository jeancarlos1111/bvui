# Generación de Datos de Prueba y Sincronización con Meilisearch

Este documento explica cómo utilizar las herramientas de pruebas de la Biblioteca Virtual (BVUI) para generar miles de registros falsos de manera eficiente y cómo sincronizar dichos registros con el motor de búsqueda Meilisearch utilizando Laravel Scout.

## 1. Generación de Datos Falsos (Model Factories y Seeders)

El proyecto cuenta con un `TestingDataSeeder` diseñado específicamente para realizar pruebas de estrés. Este seeder genera:
- **500 Usuarios** con roles aleatorios entre `Gestor` y `Estudiante` (excluyendo Administradores).
- **10,000 Documentos** repartidos equitativamente entre los usuarios creados.

### Ejecución del Seeder

Para ejecutar la generación de datos, utiliza el siguiente comando de Artisan en tu terminal:

```bash
php artisan db:seed --class=TestingDataSeeder
```

### ¿Cómo funciona internamente?

Dado que 10,000 registros es una cantidad enorme para ser procesada al mismo tiempo, el seeder está optimizado de dos maneras:
1. **Lotes (Chunks):** Inserta los registros en bloques pequeños (de 100 o 200 a la vez) para no saturar la memoria RAM de PHP.
2. **Pausa de Scout:** Desactiva temporalmente los *Observers* de Laravel Scout mediante el método `Document::withoutSyncingToSearch()`. Si no hiciéramos esto, Laravel intentaría enviar 10,000 peticiones HTTP a Meilisearch al mismo tiempo, colapsando el servicio.

---

## 2. Laravel Scout y Meilisearch

Una vez que los datos han sido generados en la base de datos MariaDB, es necesario "empujarlos" hacia Meilisearch para que el buscador pueda encontrarlos rápidamente.

### Sincronización de Configuración

Antes de importar datos masivos, es fundamental asegurarse de que Meilisearch conoce la estructura de nuestros índices (qué campos son filtrables o divisibles). Para sincronizar las configuraciones declaradas en `config/scout.php`, ejecuta:

```bash
php artisan scout:sync-index-settings
```

### Importación de Datos a Meilisearch

Para tomar todos los registros existentes en la tabla `documents` y enviarlos a Meilisearch, utiliza el comando de importación masiva:

```bash
php artisan scout:import "App\Models\Document"
```

> **Nota sobre el consumo de memoria:**
> La importación de decenas de miles de registros desde la base de datos hacia Meilisearch puede provocar errores como `zend_mm_heap corrupted` si PHP se queda sin memoria durante la ejecución. Si esto ocurre, la mejor alternativa es continuar la importación en lotes o aumentar el `memory_limit` de PHP en tu archivo `php.ini`. Sin embargo, con los primeros miles de registros indexados, el buscador ya es completamente funcional para realizar pruebas.

### Vaciado del Índice

Si alguna vez necesitas resetear o borrar todos los documentos cacheados en el motor de búsqueda Meilisearch sin borrar tu base de datos principal, puedes vaciar el índice con:

```bash
php artisan scout:flush "App\Models\Document"
```
