# iMono
An open-source PHP MVC monolithic framework for efficient web development. Organized structure, simplicity, and powerful features for agile apps.

## Installation
To get started with iMono, follow these simple steps

1. Ensure you have Composer installed on your system.
2. Run the following command to install dependencies.

```
composer require ......
```

## Project Structure (MVC)
The project follows a clear MVC structure to separate concerns and enhance maintainability. Key directories include:
- ```/app```: Contains core application classes, including models, controllers, and services.
- ```/config```: Framework configurations.
- ```/vendor```: Dependencies managed by Composer.
- ```/tests```: Automated tests to ensure the reliability of your MVC components.

## Getting Started
### Creating a Route
```
use app\controller\http\ControllerRoutes;

$routes = new ControllerRoutes();
$routes->addRoute('/', 'app\\controller\\http\\API\\ExampleController', 'index', false, false, null);
```
### Creating a Controller
```
namespace app\controller\http\API;

class ExampleController
{
    public function index()
    {
        return 'Hello, World!';
    }
}
```

## More Settings
iMono provides more configuration options to customize its behavior. To tweak these settings, check the .env file and modify the following parameters:
- ```DB_HOST```, ```DB_USER```, ```DB_PASS```, ```DB_NAME```: Database connection details.

## Middleware Usage
Middleware allows you to filter HTTP requests entering your application. Define and apply middleware in the ```ControllerRoutes``` class to execute custom logic before reaching the controller.

## Working with Databases
To interact with databases, use the provided Connection class in ```/app/database/Connection.php```. Example usage:
```
$db = Connection::getConnection();
```

## View System
iMono includes a view system for rendering templates. Place your templates in the ```/app/views``` directory and use the appropriate methods in your controllers to render views.

## Automated Testing
Ensure the reliability of your code by writing automated tests. iMono supports PHPUnit for unit and integration testing. Refer to the ```/tests``` directory for examples.

## License
This project is licensed under the MIT License.
