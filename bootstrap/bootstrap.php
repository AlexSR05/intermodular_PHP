<?php

// Configuración
require_once __DIR__ . '/../config/config.php';
require_once __DIR__ . '/../config/db.php';

// Nucleo
require_once __DIR__ . '/../app/Core/Auth.php';
require_once __DIR__ . '/../app/Core/DB.php';
require_once __DIR__ . '/../app/Core/Cart.php';
require_once __DIR__ . '/../app/Core/helpers.php';
require_once __DIR__ . '/../app/Core/Model.php';
require_once __DIR__ . '/../app/Core/QueryBuilder.php';
require_once __DIR__ . '/../app/Core/Session.php';
require_once __DIR__ . '/../app/Core/Request.php';
require_once __DIR__ . '/../app/Core/Response.php';
require_once __DIR__ . '/../app/Core/ErrorHandler.php';

// Interfaces
require_once __DIR__ . '/../app/Contracts/Stockeable.php';

// Modelos (Mejor en los scripts donde se necesiten. Se importan aquí por comodidad)
require_once __DIR__ . '/../app/Models/Usuario.php';

require_once __DIR__ . '/../app/Models/Instrumental.php';
require_once __DIR__ . '/../app/Models/Productor.php';
require_once __DIR__ . '/../app/Models/Genero.php';
require_once __DIR__ . '/../app/Models/Contact.php';


// Inicio de sesión (siempre después de cargar el modelo Usuario)
session();