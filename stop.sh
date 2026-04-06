#!/bin/bash

echo "=========================================="
echo "   DETENIENDO APLICACIÓN"
echo "=========================================="
echo ""

# Detener servidor PHP
echo "[1/1] Deteniendo servidor PHP..."
pkill -f "php -S 0.0.0.0:8765" 2>/dev/null

if [ $? -eq 0 ]; then
    echo "       ✓ Servidor PHP detenido"
else
    echo "       ℹ No había servidor PHP activo"
fi

echo ""
echo "=========================================="
echo "   APLICACIÓN DETENIDA"
echo "=========================================="
echo ""
echo "Nota: Los contenedores (MariaDB, phpMyAdmin)"
echo "      siguen corriendo. Para detenerlos usa:"
echo "      podman stop mariadb phpmyadmin"
echo ""