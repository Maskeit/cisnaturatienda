# Documentacion del proyecto CISNATURA TIENDA

 ![Banner Home](./public/img/social.jpg).

## - Descripción del Proyecto: E-commerce PHP con Stripe
Este proyecto es un sistema de comercio electrónico (e-commerce) desarrollado en PHP, con tecnologías web nativas como HTML, CSS y JavaScript, aprovechando bibliotecas populares como jQuery y Bootstrap para una experiencia de usuario moderna y receptiva.

## - Características Principales:
Lenguajes Utilizados: PHP para la lógica del servidor, HTML para la estructura de las páginas, CSS para el diseño y JavaScript para la interactividad del cliente.
Librerías y Frameworks: Se implementa jQuery para simplificar operaciones en el lado del cliente y Bootstrap para el diseño responsivo y atractivo.
Pasarela de Pagos: La plataforma integra Stripe como pasarela de pagos, permitiendo transacciones seguras y eficientes para compras en línea.
Funcionalidades de E-commerce: Ofrece características esenciales de un e-commerce, como la visualización de productos, la gestión del carrito de compras, la realización de pedidos y la administración de cuentas de usuario.
Diseño Responsivo: La interfaz se adapta a diferentes dispositivos y tamaños de pantalla, garantizando una experiencia de usuario óptima tanto en computadoras de escritorio como en dispositivos móviles.

## - Tecnologías Adicionales:

Bootstrap: Utilizado para la creación rápida y sencilla de interfaces de usuario atractivas y responsivas.
jQuery: Agiliza la manipulación del DOM y la interacción del usuario, mejorando la eficiencia del desarrollo.


# Para Instalar las dependencias
### node_modules/:
    para obtener los modulos de node usaras **`npm ci`**

### vendor/
    para obtener los modulos de composer usaras **`composer install`**

#Instalacion del proyecto:

- Tener una version de php 8 o superior
- Tener xampp instalado
- La base de datos esta en la raíz del proyecto **"cisnaturatienda.sql"**
- Importar la base de datos en su motor de sql.

- **Crear una rama por issue**

### Estructura del proyecto < / >

/app
/resources
index.php


### Estructura del proyecto < /app >

/Controllers      # Controladores principales para las operaciones y manejo de metodos  
/Models           # Modelos de tablas y clases Principales
/pimg             # carpeta de las imagenes de productos
app.php           # api del proyecto
autoloader.php    # Carga las clases de documentos del proyecto


### Estructura del proyecto < /resources >

/css        # directorio de los estilos de los archivos del proyecto
/img        # directorio de imagenes de las interfaces
/js         # documentos JavaScript con la logica de operaciones para el control dinamico de la pagina, peticiones y animaciones.
/views      # directorio principal que contiene el frontend de la pagina web completa, rutas y sus archivos
