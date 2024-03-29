<p align="center">
    <img src="https://github.com/FabioAugustoRodrigues/iMono/blob/main/app/views/assets/images/iMono.png" width="200" alt="iMono">
</p>

# About iMono
An open-source PHP MVC monolithic framework for efficient web development. Organized structure, simplicity, and powerful features for agile apps.

## Installation
To get started with iMono, follow these simple steps

1. Ensure you have Composer installed on your system.
2. Run the following command to install dependencies.

```
composer create-project i-mono/i-mono
```

## Project Structure (MVC)
The project follows a clear MVC structure to separate concerns and enhance maintainability.

## Getting Started

### Creating a Controller
```php
class ExampleController extends ControllerAbstract
{
    public function getCurrentDateTime() {
        return $this->respondJson(
            [
                "data" => [
                    "current_date_time" => date('Y-m-d H:i:s')
                ],
                "message" => ""
            ],
            200
        );
    }
}
```

You can also create a Controller to render templates:
```php
class ExampleController extends ControllerAbstract
{
    public function index() {
        $this->view('index');
    }
}
```

## Routing System
The routing system is a structure that links URLs to PHP controllers and methods, supporting diverse HTTP methods (GET, POST, PUT, DELETE, PATCH, OPTIONS). It also allows the addition of middleware for preprocessing requests and supports route patterns, facilitating dynamic parameters within URLs.

### Creating a Route
You can define a route in the ```routes/web.php``` or ```routes/api.php``` file and define the controller and method.
```php
Router::post("/api/getCurrentDateTime", ExampleController::class, "getCurrentDateTime");
```

### Example Usage
To call a specific method in your controller, you should send a request to your defined route. Here's an example in JavaScript:
```javascript
const data = {};

const requestOptions = {
    method: 'POST',
    headers: {
        'Content-Type': 'application/json'
    },
    body: JSON.stringify(data)
};

fetch('api/getCurrentDateTime', requestOptions)
    .then(response => response.json())
    .then(responseData => {
        console.log(responseData);
                
        let data = responseData["data"];
        let current_date_time = data["current_date_time"];

        document.getElementById("currentDateTime").textContent = current_date_time;
    })
    .catch(error => {
        console.error('There was an error: ' + error);
    });
```

This JavaScript example demonstrates a POST request to the api route.

## More Settings
iMono provides more configuration options to customize its behavior. To tweak these settings, check the .env file and modify the following parameters:
- ```DB_HOST```, ```DB_USER```, ```DB_PASS```, ```DB_NAME```: Database connection details.

## Middleware Usage
Middleware allows you to filter HTTP requests entering your application. Define and apply middleware in the ```Router``` class to execute custom logic before reaching the controller.

## Working with Databases
To interact with databases, use the provided Connection class in ```/app/database/Connection.php```. Example usage:
```php
$db = Connection::getConnection();
```

## View System
iMono includes a view system for rendering templates. Place your templates in the ```/app/views``` directory and use the appropriate methods in your controllers to render views.

## Caching System
iMono now includes a simple caching system that can be used to temporarily store data and improve the performance of your application.

### Configuration
The type of cache to be used can be configured in the ```.env``` file. The default value is array, which uses an in-memory array to store cached data.
```
CACHE_DRIVER=array
```

### Supported Cache Types
Currently, only ```array-based``` caching is supported.

### Using the Cache
To use the cache, you can leverage the ```CacheFacade``` class.

```php
use app\cache\CacheFacade;

// Set a value in the cache
CacheFacade::set('my_key', 'my_value');

// Check if a key exists in the cache
if (CacheFacade::has('my_key')) {
    // Get the value from the cache
    $value = CacheFacade::get('my_key');
}

// Remove a value from the cache
CacheFacade::remove('my_key');

// Clear all expired items from the cache
CacheFacade::clearExpired();

// Clear the entire cache
CacheFacade::clearAll();
```

## Automated Testing
Ensure the reliability of your code by writing automated tests. iMono supports PHPUnit for unit and integration testing. Refer to the ```/tests``` directory for examples.

## How to run
- Ensure that your project is hosted on a web server that supports .htaccess files.

- Access the project: Open the web browser and navigate to your local server or the configured domain.

## Comments
```diff
# Currently, the project does not strictly adhere to Semantic Versioning (SemVer), but it aims to do so in the future.
```



## License
This project is licensed under the MIT License.
