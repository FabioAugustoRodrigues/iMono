# iMono
An open-source PHP MVC monolithic framework for efficient web development. Organized structure, simplicity, and powerful features for agile apps.

## Installation
To get started with iMono, follow these simple steps

1. Ensure you have Composer installed on your system.
2. Run the following command to install dependencies.

```
composer require i-mono/i-mono
```

## Project Structure (MVC)
The project follows a clear MVC structure to separate concerns and enhance maintainability. Key directories include:
- ```/app```: Contains core application classes, including models, controllers, and services.
- ```/config```: Framework configurations.
- ```/vendor```: Dependencies managed by Composer.
- ```/tests```: Automated tests to ensure the reliability of your MVC components.

## Getting Started

### Creating a Controller
```php
class ExampleController extends ControllerAbstract
{

    public function __construct() {}

    public function getCurrentDateTime() {
        return $this->respondsWithData(
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

### Creating a Route
```ControllerRoutes``` class
```php
public function __construct()
{
    self::$routes = array();

    $this->addRoute("getCurrentDateTime", "app\\controller\\http\\API\\ExampleController", "getCurrentDateTime", false, false, null);
}
```

## Routing System
Instead of strictly following the REST pattern, the routing system in this framework adopts a custom approach to provide flexibility and simplicity. Routes are not directly defined in the URL but rather passed as parameters through the `/api/` route.

### Example Usage
To call a specific method in your controller, you should send a POST request to the `/api/` route and include the `route` parameter in the request body. Here's an example in JavaScript:
```javascript
const data = {
    route: 'getCurrentDateTime'
};

const requestOptions = {
    method: 'POST',
    headers: {
        'Content-Type': 'application/json'
    },
    body: JSON.stringify(data)
};

fetch('../api/', requestOptions)
    .then(response => response.json())
    .then(responseData => {
        console.log(responseData);

        const data = responseData.data;
        const currentDateTime = data.current_date_time;

        document.getElementById("currentDateTime").textContent = currentDateTime;
    })
    .catch(error => {
        console.error('There was an error: ' + error);
    });
```

This JavaScript example demonstrates a POST request to the ../api/ route, passing the route parameter with the value 'getCurrentDateTime'.

## More Settings
iMono provides more configuration options to customize its behavior. To tweak these settings, check the .env file and modify the following parameters:
- ```DB_HOST```, ```DB_USER```, ```DB_PASS```, ```DB_NAME```: Database connection details.

## Middleware Usage
Middleware allows you to filter HTTP requests entering your application. Define and apply middleware in the ```ControllerRoutes``` class to execute custom logic before reaching the controller.

## Working with Databases
To interact with databases, use the provided Connection class in ```/app/database/Connection.php```. Example usage:
```php
$db = Connection::getConnection();
```

## View System
iMono includes a view system for rendering templates. Place your templates in the ```/app/views``` directory and use the appropriate methods in your controllers to render views.

## Automated Testing
Ensure the reliability of your code by writing automated tests. iMono supports PHPUnit for unit and integration testing. Refer to the ```/tests``` directory for examples.

## License
This project is licensed under the MIT License.
