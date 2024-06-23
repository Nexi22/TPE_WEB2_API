# https://markdown.es/sintaxis-markdown/
## Índice
1. [AutoApiController](#documentación-autopicontroller)
    - [Función `getAll()`](#función-getAll)
    - [Función `getAllDESC()`](#función-getalldesc)
    - [Función `getAuto()`](#función-getauto)
    - [Función `addAuto()`](#función-addauto)
    - [Función `borrarAuto()`](#función-borrarauto)
    - [Función `autoVendido()`](#función-autovendido)
    - [Función `getAllxMarca()`](#función-getallxmarca)
    - [Función `editarVehiculo()`](#función-editarvehiculo)


2. [UserApiController](#documentación-userapicontroller)
    - [Función `getAllUsers()`](#función-getallusers)
    - [Función `getUser()`](#función-getuser)
3. [Requisitos y notas adicionales](#requisitos-y-notas-adicionales)

___

# Documentación `AutoApiController`
## Introducción
Esta API permite gestionar una colección de vehículos. Se puede obtener información sobre todos los vehículos, obtener un vehículo específico por su ID, agregar nuevos vehículos, borrar vehículos existentes, marcar un vehículo como vendido, obtener todos los vehículos de una marca específica y editar la información de un vehículo.
## Función `getAll()`

### Descripción
Obtiene una lista de todos los vehículos.

### CÓDIGO:

```php
public function getAll() {
        try {
            // Obtener todos los autos del modelo
            $vehicles = $this->model->getAll();
            if ($vehicles) {
                $response = [
                    "status" => 200,
                    "data" => $vehicles
                ];
                // Si hay autos, devolverlas con un código 200 (éxito)
                $this->view->response($response, 200);
            } else {
                // Si no hay autos, devolver un mensaje con un código 404
                $this->view->response("No hay autos en la base de datos", 404);
            }
        } catch (Exception) {
            $this->view->response("Error de servidor", 500);
        }
    }
```


### Retorno
La función no retorna ningún valor directamente. En su lugar, envía una respuesta al cliente utilizando el objeto `view`. Los posibles códigos de estado de respuesta son:

### Respuesta Exitosa:
Estado: **200 OK:** si la peticion fue exitosa y se trajeron todos los vehiculos.

### CÓDIGO:
```php
$this->view->response($response, 200);
```

### Respuesta Fallida:
Estado: **404 Not Found:** Si no hay autos en la base de datos.

### CÓDIGO:
```php
$this->view->response("No hay autos en la base de datos", 404);
```

### Respuesta de error del server:
- **500 Internal Server Error:** Si ocurre un error del servidor al intentar obtener los autos.

### CÓDIGO:
```php
$this->view->response("Error de servidor", 500);
```


## Ejemplos de uso `localhost/TPE_WEB2_API/api/autos`
### Ejemplo 1: Obtención exitosa de Vehiculos

Si hay vehiculos en la base de datos, la función enviará una respuesta con código 200 y las tareas en formato JSON:
```json
{
    "status": 200,
    "data": [ ... ] // Lista de vehículos
}

```

### Ejemplo 2: Vehiculos no encontrados

Si no existen vehiculos en la base de datos, la función enviará una respuesta con código 404 y un mensaje de error:
```json
{
    "status": 404,
    "message": "No hay autos en la base de datos"
}

```

### Ejemplo 3: Error de servidor

Si ocurre un error del servidor, la función enviará una respuesta con código 500 y un mensaje de error:

```json
{
    "status": 500,
    "message": "Error de servidor: [detalles del error]"
}
```

### Notas 

- **La inclusión del mensaje de excepción (`$e->getMessage()`) en la respuesta de error del servidor puede ser útil para depuración, pero puede exponer detalles sensibles del servidor. Considera esta práctica con cuidado, especialmente en entornos de producción.** 
- **Asegúrate de manejar adecuadamente las excepciones y errores en el modelo y la vista para evitar problemas inesperados.** 



___




## Función `getTask()`

### Descripción
La función `getTask` del controlador obtiene una tarea específica de la base de datos y envía una respuesta adecuada al cliente basado en el resultado.

### CÓDIGO ESCRITO A MANO (COPY - PASTE DEL CONTROLADOR)

```php
public function getTask($params = null) {
        $id = $params[':ID'];

        try {
            // Obtiene una tarea del modelo
            $tarea = $this->model->get($id);
            // Si existe la tarea, la retorna con un código 200 (éxito)
            if($tarea){
                $response = [
                "status" => 200,
                "data" => $tarea
               ];
                $this->view->response($response, 200);
            }
            else
                // Si exite la tarea, retorna un mensaje con un código 404 (no encontrado)
                 $this->view->response("No existe la tarea con id: $id", 404);
        } catch (Exception $e) {
            // En caso de error del servidor, devolver un mensaje con un código 500 (error del servidor)
            $this->view->response("Error de servidor", 500);
        }

    }  
```
### Parámetros
**`$params (array)`: Un array asociativo que contiene los parámetros de la solicitud. En este caso, se espera que contenga '`:ID`', el identificador de la tarea que se desea obtener.**

### Retorno
La función no retorna ningún valor directamente. En su lugar, envía una respuesta al cliente utilizando el objeto `view`. Los posibles códigos de estado de respuesta son:

- **200 OK:** Si se obtuvieron tareas correctamente.
- **404 Not Found:** Si no hay tareas en la base de datos.
- **500 Internal Server Error:** Si ocurre un error del servidor al intentar obtener las tareas.

## Ejemplos de uso `http://localhost/proyectos/todo-api/api/tareas/1`
### Ejemplo 1: Obtención exitosa de la tarea

Si la tarea con el ID proporcionado existe, la función enviará una respuesta con código 200 y la tarea en formato JSON:
```json
{
    "status": 200,
    "data": [
        {
            "id": 1,
            "nombre": "Tarea 1",
            "descripcion": "Descripción de la tarea 1"
        }
    ]
}
```

### Ejemplo 2: Tarea no encontradas

Si no existe una tarea con el ID proporcionado, la función enviará una respuesta con código 404 y un mensaje de error:
```json
{
   {
    "status": 404,
    "message": "No existe la tarea con id: 1"
   }
}
```

### Ejemplo 3: Error de servidor

Si ocurre un error del servidor, la función enviará una respuesta con código 500 y un mensaje de error:

```json
{
    "status": 500,
    "message": "Error de servidor: [detalles del error]"
}
```

### Notas 

- **La inclusión del mensaje de excepción (`$e->getMessage()`) en la respuesta de error del servidor puede ser útil   para depuración, pero puede exponer detalles sensibles del servidor. Considera esta práctica con cuidado, especialmente en entornos de producción.** 
- **Asegúrate de manejar adecuadamente las excepciones y errores en el modelo y la vista para evitar problemas inesperados.** 



___

# Documentación `UserApiController`
## Introducción
............................................
..............................................
.................................................

## Función `getAllUsers()`

### Descripción
............................................
..............................................
.................................................


## Función `getUser()`

### Descripción
............................................
..............................................
.................................................




___


## Requisitos y notas adicionales
- Modelo de tarea debe implementar los siguientes métodos `getTasks`, `getTask`.
- Modelo de usuario debe implementar los siguientes métodos `getAllUsers`, `getUser`.
- Vista que implemente el método `response`.
