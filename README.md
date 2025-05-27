1. Requisitos del Sistema

- Tener XAMPP instalado y en ejecución (Apache y MySQL).
- Tener Python 3.9+ instalado.
- Tener Composer instalado (opcional, si deseas usar SDKs externos).
- Acceso a internet para uso de conversor de divisas (opcional).

2. Configuración de Base de Datos

1. Abre phpMyAdmin en http://localhost/phpmyadmin.
2. Crea la base de datos llamada `ferramax`.
3. Importa el archivo `BASE_DE_DATOS_FERRAMAX.sql`.
4. Asegúrate de tener las siguientes tablas:
   - PRODUCTOS
   - USUARIOS
   - TIPO_PRODUCTO
   - SUSCRIPCIONES

3. API en Python (Flask)

1. Abre CMD en la carpeta de la API.
2. Ejecuta: pip install -r requirements.txt
3. Inicia el servidor Flask: python app.py
4. Accede a la API: http://127.0.0.1:5000/api/products

4. Archivos PHP Clave y Accesos

• index.php
  - Inicio del sitio web.
  - Ruta: http://localhost/FERRAMAX/index.php

• productos.php
  - Lista de productos por categoría.
  - Ejemplo: http://localhost/FERRAMAX/productos.php?categoria=Herramientas%20manuales

• carrito.php
  - Muestra productos agregados al carrito.
  - Ruta: http://localhost/FERRAMAX/carrito.php

• pago.php
  - Simula el pago con resumen final.
  - Ruta: http://localhost/FERRAMAX/pago.php

• login.php
  - Iniciar sesión como cliente (activa descuento).
  - Ruta: http://localhost/FERRAMAX/login.php
Usuario: admin
Contraseña: clave123

• logout.php
  - Cierra la sesión del cliente.
  - Ruta: http://localhost/FERRAMAX/logout.php

• suscribirse.php
  - Guarda correos en la tabla SUSCRIPCIONES.
  - Se usa internamente al enviar formulario de suscripción.

• admin_suscripciones.php
  - Visualiza todos los correos suscritos.
  - Ruta: http://localhost/FERRAMAX/admin_suscripciones.php

5. Funcionalidades Clave

- Filtro por categoría de producto.
- Carrito de compras con descuento para clientes logueados.
- Cambio de divisa (CLP / USD).
- Registro de correos electrónicos mediante formulario.

6. Cambio de Divisa

- En index.php y productos.php puedes seleccionar USD o CLP.
- Se guarda en $_GET["currency"].
- Ejemplo para ver productos en dólares:
  http://localhost/FERRAMAX/productos.php?currency=usd
- Ejemplo para ver carrito en dólares:
  http://localhost/FERRAMAX/carrito.php?currency=usd

7. Recomendaciones Finales

- Siempre tener Apache, MySQL y la API en Flask corriendo.
- Revisar bien los nombres de archivos y URLs en cada botón.
- Validar que la API entregue datos correctamente.
- Probar conexión a la base de datos desde PHP.

