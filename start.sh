#!/bin/bash

echo "=========================================="
echo "   INICIANDO APLICACIÓN CAFETERÍA"
echo "=========================================="
echo ""

# 1. Iniciar MariaDB
echo "[1/4] Iniciando MariaDB..."
podman start mariadb 2>/dev/null
if [ $? -eq 0 ]; then
    echo "       ✓ MariaDB iniciado"
else
    echo "       ✗ Error al iniciar MariaDB"
fi

# 2. Iniciar phpMyAdmin
echo "[2/4] Iniciando phpMyAdmin..."
podman start phpmyadmin 2>/dev/null
if [ $? -eq 0 ]; then
    echo "       ✓ phpMyAdmin iniciado"
else
    echo "       ✗ Error al iniciar phpMyAdmin"
fi

# 3. Detener servidor PHP anterior si existe
echo "[3/4] Verificando servidor PHP..."
pkill -f "php -S 0.0.0.0:8765" 2>/dev/null
sleep 1

# 4. Iniciar proyecto CakePHP
echo "[4/4] Iniciando aplicación CakePHP..."
cd /home/live/cakephp/entregablefinal/app_ef
php -S 0.0.0.0:8765 -t webroot > /tmp/cake.log 2>&1 &
sleep 2

# Verificar que todo esté corriendo
echo ""
echo "=========================================="
echo "   ESTADO DE SERVICIOS"
echo "=========================================="
echo ""
echo "Contenedores:"
podman ps --format "table {{.Names}}\t{{.Status}}" | grep -E "mariadb|phpmyadmin"
echo ""
echo "Servidor PHP:"
lsof -i:8765 | grep LISTEN | awk '{print "  Puerto 8765: " $1 " (PID: " $2 ")"}'

echo ""
echo "=========================================="
echo "   APLICACIÓN LISTA"
echo "=========================================="
echo ""
echo "Accesos:"
echo "  - Tu aplicación: http://172.25.0.225:8765"
echo "  - phpMyAdmin:    http://172.25.0.225:8081"
echo ""
echo "Usuario Admin: admin@example.com"
echo "Usuario Normal: rivaldiramirez@gmail.com"
echo "Contraseña: password"
echo ""