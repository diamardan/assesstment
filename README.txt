Desarrollador: Daniel Díaz Martínez
Posición deseada: Desarrollador Full-Stack
Nivel de conocimiento de lenguajes: JavaScript 60%, TypeScript 60%, Dart 70%, PHP 60%, SQL 70%
Correo de contacto: diamardev@gmail.com
Nivel elegido para el assesstment: BÁSICO


Este proyecto está realizado utilizando 
    - PHP 7.4
    - MySQL 15.1
    - Apache 2.4

Instrucciones de instalación:
#Paso 1 - Clonación del proyecto.

    - Clonar el repositorio en su carpeta de proyectos php
        para ello debe descargar el proyecto como zip y descomprimirlo en su carpeta de proyectos
        descargarlo con la aplicación GitHub Desktop ò abriendo una consola de comandos (terminal) y navegando
        hasta su carpeta de proyectos php y utilizando el comando de clonación.

    El comando para clonar el repositorio es 
    ´git clone git@github.com:diamardan/assesstment.git´
    puede agregar un nombre al final para asignar a la carpeta donde se clonará el proyecto, por ejemplo si quisiera asignar el nombre 'proyecto1'
    debo utilizar el comando de clonación de la siguiente manera
    ´git clone git@github.com:diamardan/assesstment.git proyecto1´

    Si ya tenía una carpeta con un nombre asignado dentro de su carpeta de proyectos simplemente navegue desde su consola de comandos a esa carpeta 
    y reemplace el nombre del proyecto por un punto '.'
    ´git clone git@github.com:diamardan/assesstment.git .´

#Paso 2 - Inicialización de los servicios web.

    - Inicializar su servidor Apache y su gestor de base de datos MySql (XAMPP,WAMPP, MAMPP, Laragon, etc);

#Paso 3 - Abriendo el proyecto en Web.

    - Una vez inicializados los servidores ingresar a su host local a la ruta del proyecto clonado, suponiendo que su configuración de entorno es standard y el nombre del proyecto que asignó fué 'proyecto1' debera ingresar en su navegador web (Google Chrome, Edge, Mozilla Firefox, Safari, etc) la siguiente dirección en su barra direcciones.
    'localhost/proyecto1/install/install.php'

#Paso 4 - Instalación de scripts

    - Dentro de la carpeta install se tiene un script llamado install.php que se encargará de guiarnos en la configuración inicial del sitio.

    Debemos agregar los valores correspondientes a los campos listados
    - En Host de la base de datos debemos asignar el valor de la dirección donde tenemos alojado nuestro servidor de base de datos mysql, en una configuración standard de XAMPP suele ser localhost.
    
    - El usuario de la base de datos suele ser 'root' en una configuración standard  y la contraseña vacía, a menos que durante la instalación usted haya cambiado los valores y debe asignar los de su configuración personal.

    - El ultimo campo corresponde al nombre que usted quiere asignar a la base de datos del proyecto, puede ser 'db_1', 'pruebas', etc. 

    Una vez realizado lo anterior solo debe dar click en el botón 'Aplicar configuración' para comenzar con la creación de la base de datos y configurar la cadena de conexión para el proyecto.

    Al terminar será redirigido al index y se le habrá cambiado el nombre al archivo install.php


Actividades completadas:

## CREACIÓN DE LA BASE DE DATOS
- Script con la creación de las tablas 'producto', 'comentarios' y 'categorias'.
- Script para la inserción de los primeros 10 registros para cada tabla.
- Script de conexión a la base de datos 
- Script para la inserción de 10 registros extra a cada tabla.
- Logger de reporte de errores y cantidad de registros insertados.

## Modelos
- Creación del modelo Product
- Creación del modelo Category
- Creación del modelo Comments

## Métodos para las clases
- Metodos de obtención para Produc
- Metodos de obtención para Category
- Metodos de obtención para Comments

## PUBLIC_HTML
- Vista general de categorías padre en index.php
- Vista de subcategorias al entrar en una categoría padre
- Visualización de 10 productos aleatorios mostrado com 'Productos destacados'
- Visualización de 10 productos mejor valorados
- Navegación a detalle del producto con visualización de comentarios