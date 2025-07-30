<?php
//la ip de mysql docker es 172.16.238.12
$configFile = 'config.php';
$sqlFile = 'database.sql';

//Verificar si ya existe el archivo config.php y está configurado para evitar reinstalaciónes
if (file_exists($configFile) && filesize($configFile) > 0) {
    //si el archivo ya está configurado nos movemos al index.php y terminamos la ejecución del código
    header('Location: ../public_html/index.php');
    exit;
}
$errors = [];
$messages = [];

//Si no existe el archivo config.php o no está configurado comenzamos con el procesamiento del formulario.

if ($_SERVER['REQUEST_METHOD'] === 'POST') { //verificamos que el método de la petición sea exactamente igual a POST
    //Inicializamos las variables
    $dbHost = $_POST['db_host'] ?? ''; //asignamos el valor que nos llega en la petición o asignamos un valor vacìo en caso de que no venga en la petición
    $dbUser = $_POST['db_user'] ?? '';
    $dbPass = $_POST['db_pass'] ?? '';
    $dbName = $_POST['db_name'] ?? '';

    // Validaciones básicas
    if (empty($dbHost) || empty($dbUser) || empty($dbName)) { //omitimos la validación de dbPass ya que puede ser vacío en una instalación standard de mysql
        $errors[] = "Todos los campos con * son obligatorios.";
    }

    if (empty($errors)) {
        try {
            //Nos conectamos al manejador de base de datos sin especificar nombre de base de datos
            $pdo_conn = new PDO("mysql:host=$dbHost", $dbUser, $dbPass);
            $pdo_conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            //Una vez conectados creamos la base de datos si no existe
            $pdo_conn->exec("CREATE DATABASE IF NOT EXISTS `$dbName`");
            $messages[] = "Base de datos '$dbName' creada satisfactoriamente";

            //Nos conectamos a la base de datos especificada en $dbName
            $pdo_conn = new PDO("mysql:host=$dbHost;dbname=$dbName", $dbUser, $dbPass);
            $pdo_conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            //Ejecutamos el script sql para agregar las tablas y los registros iniciales
            if (file_exists($sqlFile)) { //Nos aseguramos que el archivo exista
                $sql = file_get_contents($sqlFile);
                $statements = array_filter(array_map('trim', explode(';', $sql))); //Separamos los sql statements por su delimitador ";"

                foreach ($statements as $stmt) {
                    if (!empty($stmt)) {
                        $pdo_conn->exec($stmt); //ejecutamos cada uno de los statements sql 
                    }
                }
                $messages[] = "Datos iniciales de la base de datos cargados correctamente.";
            } else {
                $errors[] = "El archivo SQL '$sqlFile' no se encontró.";
            }

            //Aqui generamos y guardamos el archivo config.php con la información capturada en el formulario
            $configContent = "<?php\n";
            $configContent .= "define('DB_HOST', '$dbHost');\n";
            $configContent .= "define('DB_USER', '$dbUser');\n";
            $configContent .= "define('DB_PASS', '$dbPass');\n";
            $configContent .= "define('DB_NAME', '$dbName');\n";
            $configContent .= "\n";
            $configContent .= "// Otras configuraciones\n";
            $configContent .= "define('APP_NAME', 'Assesstment');\n";
            $configContent .= "define('DEBUG_MODE', true);\n";

            if (file_put_contents($configFile, $configContent) != false) {
                $messages[] = "Archivo de configuración '$configFile' creado con éxito.";
                echo "<p><strong>¡Instalación completada con éxito!</strong></p>";
                echo "<p>Redireccionando a la aplicación en 3 segundos...</p>";
                rename('install.php', 'install_completed.php'); // cambiamos el nombre de éste archivo para no poder acceder por url en la ruta install
                // header('Refresh: 3; URL=index.php'); // Redirigir después de 3 segundos
                echo "<script>setTimeout(function(){ window.location.href = '../public_html/index.php'; }, 3000);</script>";
                exit;
            } else {
                $errors[] = "No se pudo escribir el archivo de configuración en '$configFile'. Verifica los permisos de escritura.";
            }
        } catch (PDOException $e) {
            $errors[] = "Error de base de datos: " . $e->getMessage();
            if (strpos($e->getMessage(), 'Access denied for user') != false) {
                $errors[] = "Usuario o contraseña de la base de datos incorrecta";
            }
            if (strpos($e->getMessage(), 'Unknown database') !== false) {
                $errors[] = "La base de datos '$dbName' no existe y el usuario especificado no tiene permisos para crearla.";
            }
        }
    }
}
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Configuración de la instalación</title>
    <style>
        body {
            font-family: sans-serif;
            margin: 20px;
            background-color: #f4f4f4;
        }

        .container {
            background-color: #fff;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            max-width: 600px;
            margin: 40px auto;
        }

        .error {
            color: red;
            margin-bottom: 10px;
            border: 1px solid red;
            padding: 10px;
            background-color: #ffe0e0;
            border-radius: 4px;
        }

        .message {
            color: green;
            margin-bottom: 10px;
            border: 1px solid green;
            padding: 10px;
            background-color: #e0ffe0;
            border-radius: 4px;
        }

        label {
            display: block;
            margin-bottom: 5px;
            font-weight: bold;
        }

        input[type="text"],
        input[type="password"],
        input[type="email"] {
            width: calc(100% - 22px);
            padding: 10px;
            margin-bottom: 15px;
            border: 1px solid #ddd;
            border-radius: 4px;
        }

        button {
            background-color: #007bff;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 16px;
        }

        button:hover {
            background-color: #0056b3;
        }
    </style>
</head>

<body>
    <div class="container">
        <h2>Configuración de la instalación</h2>

        <?php if (!empty($errors)): ?>
            <?php foreach ($errors as $error): ?>
                <p class="error"><?php echo htmlspecialchars($error); ?></p>
            <?php endforeach; ?>
        <?php endif; ?>

        <?php if (!empty($messages)): ?>
            <?php foreach ($messages as $message): ?>
                <p class="message"><?php echo htmlspecialchars($message); ?></p>
            <?php endforeach; ?>
        <?php endif; ?>

        <form action="install.php" method="post">
            <h3>Configuración de Base de Datos</h3>
            <p>Ingresa los detalles de tu base de datos MySQL.</p>

            <label for="db_host">Host de la Base de Datos *</label>
            <input type="text" id="db_host" name="db_host" value="localhost" required>

            <label for="db_user">Usuario de la Base de Datos *</label>
            <input type="text" id="db_user" name="db_user" required>

            <label for="db_pass">Contraseña de la Base de Datos</label>
            <input type="password" id="db_pass" name="db_pass">

            <label for="db_name">Nombre de la Base de Datos *</label>
            <input type="text" id="db_name" name="db_name" required>

            <button type="submit">Aplicar configuración</button>
        </form>
    </div>
</body>

</html>