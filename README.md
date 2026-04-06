# Proyecto Web II - Sistema de Gestión de Rutas

Aplicación web desarrollada en CakePHP 5 para gestión de rutas con mapa interactivo.

## 🚀 Características

- **Sistema de Login** - Autenticación de usuarios (Admin y Normal)
- **CRUD de Usuarios** - Gestión de usuarios (Admin puede gestionar todos, usuarios normales solo su perfil)
- **Gestión de Rutas** - CRUD completo de rutas
- **Mapa Interactivo** - Selección de origen y destino en el mapa
- **Cálculo de Distancia** - Cálculo automático de distancia y tiempo estimado
- **Tipo de Ruta** - Determinación automática de ruta nacional o internacional
- **Historial** - Registro de rutas usadas por cada usuario
- **Tema Oscuro/Claro** - Toggle de tema
- **Multilingüe** - Soporte para Español (ES) e Inglés (EN)

## 📋 Requisitos

- PHP 8.2+
- Composer
- MariaDB/MySQL
- Extensiones PHP: intl, mbstring, xml, curl, pdo_mysql

## 🔧 Instalación

```bash
# 1. Clonar el repositorio
git clone https://github.com/rivaldoramirezmamani/proyectowebII.git
cd proyectowebII

# 2. Entrar a la carpeta del proyecto
cd app_ef

# 3. Instalar dependencias PHP
composer install

# 4. Importar la base de datos
# Importar db_ef.sql en phpMyAdmin

# 5. Copiar configuración de base de datos
cp config/app_local.example.php config/app_local.php

# 6. Editar config/app_local.php con tus datos de conexión
```

## ▶️ Uso

```bash
# Iniciar la aplicación
cd /ruta/del/proyecto
./start.sh

# La aplicación estará disponible en:
# http://localhost:8765
```

## 👤 Usuarios de Prueba

| Rol | Email | Contraseña |
|-----|-------|------------|
| Admin | admin@example.com | admin123 |
| Normal | rivaldiramirez@gmail.com | password |

## 🗺️ Ciudades Disponibles

### Bolivia (17 ciudades)
La Paz, Cochabamba, Santa Cruz, Oruro, Sucre, Potosí, Tarija, Beni, Pando, Cobija, Riberalta, Guayaramerín, San Ignacio de Velasco, Trinidad, Uyuni, Villazón, Yacuiba

### Internacionales (14 ciudades)
Lima, Arequipa, Cusco (Perú); Iquique, Antofagasta (Chile); Santiago (Chile); Buenos Aires (Argentina); São Paulo, Brasilia (Brasil); Asunción (Paraguay); Montevideo (Uruguay); Bogotá, Medellín (Colombia); Caracas (Venezuela)

## 🌐 Cambio de Idioma

La aplicación soporta **Español** e **Inglés**. Desde el menú superior:
- **ES** para Español
- **EN** para Inglés

## 📂 Estructura del Proyecto

```
proyectowebII/
├── app_ef/                  # Aplicación CakePHP
│   ├── bin/                 # Scripts de CakePHP
│   ├── config/             # Configuración
│   ├── plugins/            # Plugins
│   ├── resources/           # Recursos
│   ├── src/                 # Código fuente
│   ├── templates/           # Vistas
│   ├── tests/               # Tests
│   ├── webroot/             # Archivos públicos
│   ├── composer.json        # Dependencias PHP
│   └── composer.lock        # Lock de dependencias
├── db_ef.sql                # Base de datos
├── start.sh                 # Script de inicio
└── stop.sh                  # Script de parada
```

## 📄 Licencia

Este proyecto es para fines educativos.

---

## 📊 Evaluación - Criterios Cumplidos

| Criterio | Estado |
|----------|--------|
| Informe IMRD | ✅ Completado |
| Git remoto con README | ✅ Completado |
| Contenedores (MariaDB) | ✅ Completado |
| Dockerfile | ✅ Incluido |
| Traducción 2 idiomas | ✅ Completado |
| Cumplimiento de requerimientos | ✅ Completado |