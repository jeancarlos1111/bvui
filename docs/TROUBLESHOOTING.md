# Guía de Resolución de Problemas (Troubleshooting)

## Módulo de Carga de Documentos (Livewire)

### Error: `Uncaught SyntaxError: Unexpected token '<', "<!DOCTYPE "... is not valid JS` al subir archivos

#### Descripción del Problema
Cuando un usuario intenta subir un archivo PDF a través del componente de Livewire (`DocumentUpload`) y la barra de progreso llega al 100% pero se queda "congelada", la consola del navegador arrojará el error mencionado arriba. 

Adicionalmente, puede observarse un registro similar a este en los logs de depuración (Boost/Telescope):
`POST: /_boost/browser-logs • Auth ID: guest • url: http://localhost:8000/documentos/subir`

#### Causa Raíz
Este error no es un fallo de JavaScript ni de Livewire directamente, sino una **limitación en la configuración del servidor PHP**.

Por defecto, PHP viene configurado con un límite máximo de subida (`upload_max_filesize`) de `2M` (2 Megabytes). Cuando se intenta subir un archivo que supera este peso (ej. 2.3MB):
1. El navegador envía la petición asíncrona (AJAX/XHR) al servidor.
2. PHP intercepta la petición a bajo nivel y, al ver que supera el límite, aborta el proceso de inmediato sin llegar al ciclo de vida de Laravel.
3. El servidor web retorna una página de error o una redirección en formato **HTML puro** (que comienza con `<!DOCTYPE html>`).
4. El script de Livewire que está esperando una respuesta JSON estructurada recibe este HTML, intenta interpretarlo como código JavaScript/JSON, y falla con el error de sintaxis `Unexpected token '<'`.

#### Solución
Para resolver este problema, es necesario aumentar las directivas de tamaño máximo de carga en el archivo de configuración activo de PHP (`php.ini`).

1. Localiza tu archivo `php.ini` (en entornos como Herd Lite en Linux, suele estar en `~/.config/herd-lite/bin/php.ini`).
2. Modifica (o añade al final del archivo) los siguientes valores:
   ```ini
   upload_max_filesize = 30M
   post_max_size = 40M
   ```
   *(Nota: `post_max_size` siempre debe ser ligeramente mayor o igual a `upload_max_filesize`).*
3. **Reinicia el servidor local**. Si utilizas Laravel Artisan, apaga el servidor (`Ctrl + C`) y vuelve a ejecutar:
   ```bash
   php artisan serve
   ```
   Si utilizas Herd nativo, usa `herd restart`.

Tras estos pasos, los archivos superiores a 2MB se procesarán correctamente y la barra de carga de Alpine/Livewire se completará de manera exitosa.
