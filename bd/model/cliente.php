<?php

namespace bd\model;

header('Content-Type: text/html; charset=UTF-8');

use bd\model\Farmacia;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

require_once 'conexion.php';
require '..\PHPMailer-master\PHPMailer-master\src\PHPMailer.php';
require '..\PHPMailer-master\PHPMailer-master\src\Exception.php';
require '..\PHPMailer-master\PHPMailer-master\src\SMTP.php';

use PDOException;
use PDO;

class Cliente
{
    public static function registrarCliente($nombre, $email, $password, $fechaNacimiento, $dni, $telefono)
    {
        $pdo = Farmacia::conectar();

        // Validar los datos (realiza validaciones más robustas según tus necesidades)
        if (empty($nombre) || empty($email) || empty($password) || empty($fechaNacimiento) || empty($dni) || empty($telefono)) {
            return "Por favor, complete todos los campos.";
        } else {
            try {
                // Generar código de activación
                $codigoActivacion = bin2hex(random_bytes(16)); // 16 bytes para obtener una cadena de 32 caracteres hexadecimal

                $salt = bin2hex(random_bytes(16));

                // Hash de la contraseña (mejora la seguridad almacenando contraseñas de manera segura)
                $hashedPassword = hash('sha256', $password . $salt);

                // Definir el valor predeterminado para el campo activo como false
                $activo = false;

                // Utilizar prepared statements para evitar inyección SQL
                $stmt = $pdo->prepare("INSERT INTO clientes (nombre, gmail, contrasena, DNI, fechaNac, telefono, activo, codigo_activacion, salt) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
                $stmt->bindParam(1, $nombre);
                $stmt->bindParam(2, $email);
                $stmt->bindParam(3, $hashedPassword);
                $stmt->bindParam(4, $dni);
                $stmt->bindParam(5, $fechaNacimiento);
                $stmt->bindParam(6, $telefono);
                $stmt->bindParam(7, $activo, PDO::PARAM_BOOL);
                $stmt->bindParam(8, $codigoActivacion);
                $stmt->bindParam(9, $salt);

                if ($stmt->execute()) {
                    // Enviar el código de activación por correo electrónico usando PHPMailer
                    $mail = new PHPMailer(true);

                    $mail->isSMTP();
                    $mail->Host = 'smtp.gmail.com';
                    $mail->SMTPAuth = true;
                    $mail->Username = 'biosalud422@gmail.com';
                    $mail->Password = 'cbit ysar gtoq bwpl';
                    $mail->SMTPSecure = 'tls';
                    $mail->Port = 587;
                    $mail->SMTPDebug = 2;

                    $mail->CharSet = 'UTF-8';
                    $mail->Encoding = 'base64';

                    $mail->setFrom('biosalud422@gmail.com', 'BioSalud');
                    $mail->addAddress($email);

                    $mail->isHTML(true);
                    $mail->Subject = mb_encode_mimeheader('Código de Activación', 'UTF-8');
                    $mail->Body = "Su código de activación es: $codigoActivacion";

                    $mail->send();

                    // Redirigir a otra página después de enviar el correo electrónico exitosamente
                    header("Location: ../view/codigoActivacion.php");
                    exit;
                } else {
                    return "Error al registrar: " . $stmt->errorInfo()[2];
                }
            } catch (PDOException $e) {
                return "Error al registrar: " . $e->getMessage();
            } catch (Exception $e) {
                return "Error al enviar el correo: " . $e->getMessage();
            }
        }
    }
    public static function getDatosCliente($pdo)
    {

        try {
            //Realizamos una query
            $query = "SELECT * FROM clientes";

            $resultado = $pdo->query($query);

            //FetchAll nos saca todos los registros de la query
            //El fetchall no se puede utilizar mas de una vez
            $resulSet = $resultado->fetchAll();
        } catch (PDOException $e) {
            print "¡Error!: " . $e->getMessage() . "<br/>";
            die();
        }
        //Devolvemos los datos de la query
        return $resulSet;
    }

    public static function iniciarSesion($email, $password)
    {
        // Realizar la conexión a la base de datos
        $pdo = Farmacia::conectar();

        // Iniciar o reanudar la sesión
        session_start();

        // Restablecer el tiempo de inactividad cuando se inicia sesión
        $_SESSION['ultimoAcceso'] = time();

        if (empty($email) || empty($password)) {
            return "Por favor, complete todos los campos.";
        } else {
            try {
                // Obtener el usuario de la base de datos
                $stmt = $pdo->prepare("SELECT * FROM clientes WHERE gmail = ?");
                $stmt->execute([$email]);

                $usuario = $stmt->fetch(PDO::FETCH_ASSOC);

                if ($usuario) {
                    // Verificar si la contraseña hash coincide con la almacenada en la base de datos
                    $salt = $usuario['salt'];
                    $hashedPassword = hash('sha256', $password . $salt);

                    //Verificar si el usuario esta o no activo
                    $esActivo = $usuario['activo'];

                    if ($hashedPassword === $usuario['contrasena']) {
                        // Verificar si el usuario está activo
                        if ($esActivo) {
                            return "Inicio de sesión exitoso.";
                        } else {
                            // Redireccionar al usuario a otra página si no está activo
                            header("Location: ../view/codigoActivacion.php");
                            exit;
                        }
                    } else {
                        return "El usuario o la contraseña no es correcto.";
                    }
                }
            } catch (PDOException $e) {
                return "Error al iniciar sesión: " . $e->getMessage();
            }
        }
    }

    public static function compararCodigoVerificacion($codigoVerificacion)
    {
        // Realizar la conexión a la base de datos
        $pdo = Farmacia::conectar();

        try {
            // Consultar el usuario utilizando el código de activación
            $stmt = $pdo->prepare("SELECT * FROM clientes WHERE codigo_activacion = ?");
            $stmt->execute([$codigoVerificacion]);

            $usuario = $stmt->fetch(PDO::FETCH_ASSOC);

            // Verificar si se encontró un usuario con el código de activación proporcionado
            if ($usuario) {
                // Actualizar el estado de activación del usuario a activo
                $stmt = $pdo->prepare("UPDATE clientes SET activo = 1 WHERE codigo_activacion = ?");
                $stmt->execute([$codigoVerificacion]);

                // Devolver verdadero para indicar que el código de activación es válido
                return true;
            } else {
                // Devolver falso si no se encontró ningún usuario con el código de activación proporcionado
                return false;
            }
        } catch (PDOException $e) {
            return "Error al comparar el código de verificación: " . $e->getMessage();
        }
    }


    public static function updateCliente($pdo, $cliente)
    {
        try {
            // Query para modificar
            $query = "UPDATE clientes SET";

            // Si no nos meten nada para modificar devolvemos error
            if (count($cliente) == 0) {
                return -1;
            }

            // Building the SET clause of the query
            $setClauses = array();
            if (isset($cliente['nombre'])) {
                $setClauses[] = "nombre = :nombre";
            }
            if (isset($cliente['DNI'])) {
                $setClauses[] = "DNI = :DNI";
            }
            if (isset($cliente['gmail'])) {
                $setClauses[] = "gmail = :gmail";
            }
            if (isset($cliente['fechaNac'])) {
                $setClauses[] = "fechaNac = :fechaNac";
            }
            if (isset($cliente['telefono'])) {
                $setClauses[] = "telefono = :telefono";
            }

            // Joining the SET clauses
            $query .= ' ' . implode(', ', $setClauses);

            $stmt = $pdo->prepare($query);

            // Binding parameters
            if (isset($cliente['nombre'])) {
                $stmt->bindValue(':nombre', $cliente['nombre']);
            }
            if (isset($cliente['DNI'])) {
                $stmt->bindValue(':DNI', $cliente['DNI']);
            }
            if (isset($cliente['gmail'])) {
                $stmt->bindValue(':gmail', $cliente['gmail']);
            }
            if (isset($cliente['fechaNac'])) {
                $stmt->bindValue(':fechaNac', $cliente['fechaNac']);
            }
            if (isset($cliente['telefono'])) {
                $stmt->bindValue(':telefono', $cliente['telefono']);
            }

            // Ejecutamos la query
            $stmt->execute();

            // Sacamos la cantidad de filas afectadas
            $filas_afectadas = $stmt->rowCount();

            return $filas_afectadas;
        } catch (PDOException $e) {
            print "¡Error!: " . $e->getMessage() . "<br/>";
            return -1;
        } finally {
            $pdo = null;
        }
    }





}




