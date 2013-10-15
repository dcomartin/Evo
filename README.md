## Evo - PHP MVC Framework

Incredibly lightweight MVC framework with no fluff.  This framework was originally written sometime around 2004.

The main purpose of this framework is to provide:

- HTTP Routing
- Loading Models
- Loading Views

That's it.  It provides no database/orm, no scaffolding, no authentication, no templating.  

Framework bloat?  Not in this bad boy.

## License

This is open-sourced software licensed under the [MIT license](http://opensource.org/licenses/MIT)

## Documentation / Guide

### Routing
Routing is defined by the following convention:

http://domain.ltd/APPLICATION/CONTROLLER/ACTION

APPLICATION is the name of your application which is created in the applications folder.
CONTROLLER is the name of the PHP controller in the applications controller folder.
ACTION is the name of the method in the respective controller.

### File Structure
Example of the basic folder structure of a HelloWorld application:

/applications/HelloWorld/
/applications/HelloWorld/controller
/applications/HelloWorld/view
/applications/HelloWorld/library
/applications/HelloWorld/model
/applications/HelloWorld/errors

Please refer to the HelloWorld application in the source code as an example.

### Naming Convention

Controller and View file names must be CamelCase (ex: MyController.php)
Controller class names must be CamelCase (ex: MyController)
Controller action methods must be bumpy case (ex: myMethod)
View file name by default should be in ControllerName_ActionName.php (ex: MyController_myMethod.php)

### Defaults

The default controller if none specified the URL is "Index".  Same applies for the default action method is "index()"

## Controllers

Your controller must extend the Controller class.  In your constructor, you must call parent::__construct() to properly load the object.

### Views

The view object is incredibly simple.  PHP by its nature is a template language.  No need to reinvent the wheel here.  In order to use the view object you must first load it using the loader ($this->load->library('View').  Please refer to loader section for more information.

The view object has two primary methods:

assign($key, $val):  This assigns a key with a value that you want to pass to your view.

Example: $this->view->assign('name', 'John Doe');

In your view file, you can now use the PHP variable $name

render($view = NULL, $return = TRUE):  This loads the PHP view file and returns the contents with the assigned variables (if $return = TRUE).  You can specify a specific view to load by specifying $view parameter.  You can also choose to ouput directly by specifying the $return parameter as false.

### Loader

The loader is what is used to load the libraries, models and configurations files.

When a controller is created and the parent constructure is called the Loader library is created and assigned to a $this->loader

#### Library
library($class, $name = NULL, $args = NULL)
$class is the name of the class in the library directory.  The class name and file name should be identical.
$name is the name of the property that the newly created object will be assigned to (ex: this->mylibrary)
$args is the array of arguments to be passed to the constructor

The loaded library will be assigned to a newly created property of the class name in lowercase or the $name parameter in lowercase.

Example #1:  
$this->load->library('MyLibrary');
$this->mylibrary->doSomething();

Example #2:
$this->load->library('MyLibrary', 'mylib');
$this->mylib->doSomething();

#### Model
model($model, $name = NULL);
$model is the name of the class in the model/ directory.  The class name and file should be identical.
$name is the name of the property that the newly created object will be assigned to (ex: this->mymodel)

The loaded model will be assigned to a newly created property of the class name in lowercase or the $name parameter in lowercase.

#### Configuration

In order configuration variables/files, you can use the conf($name) method.

$name is the name of the file in the conf/ directory.

Only the variable $conf is allowed in the configuration php files.

Example Configuration Contents: $conf['myConfigKey'] = 'Some Value';

Example Usage:

$this->load->conf('myConfiguration');
echo $this->conf['myConfiguration']['myConfigKey'];

#### Session

You can start the PHP session using the session() method.  It will load the conf/session.php file looking for a $session[] array.  Any elements will be used with ini_set to define session.* values.

Example:

$session['save_path'] = '/path/to/tmp';

This will result in the session() method calling

ini_set('session.save_path'], '/path/to/tmp');

### Error

A static Error class contains the following static methods:

fatal($message = 'Unspecified fatal has occured.  Please try again.')
http404($message = 'File could not be found.  Please try again.')
phpError($errno, $errstr, $errfile, $errline)
phpException($exception)

All method calls load a file of the same name in the evo root /errors/ file depending on the method name.  You can use your own error file for each application by creating a file in your application/errors/ directory.

Example Usage:

Error::fatal('Ooops!');

This will first check if "/applications/MyApplication/errors/fatal.php" exists and load it.  If not, it will load "/error/fatal.php"

### Uri

The Uri class provides support for generating URL's.

view($view = 'index')
controller($controller = 'index', $view = 'index')
application($application = 'index', $controller = 'index', $view = 'index')

Example:

echo Uri::view('edit'); // outputs: /evo.php/MyApplication/MyController/edit
echo Uri::view('AnotherController', 'delete'); // outputs: /evo.php/MyApplication/AnotherController/delete
echo Uri::view('TestApplication', 'FooController', 'create'); // outputs: /evo.php/TestApplication/FooController/create

### Query String

In the format of pretty URL's the query string variables are passed after the view name in the URL.

Example:

http://domain.ltd/MyApplication/MyController/myAction/var1key/var1value/var2key/var2value

Evo will automatically generate the $_GET variable with:

$_GET['var1key'] = $var1value;
$_GET['var2key'] = $var2value;

### Constants

EVO_HOME = Full file path of the directory where evo.php lives.
EVO_HOME_DIR = Same as EVO_HOME
EVO_APPLICATION_DIR = Full file path of the /application/ directory
EVO_CONF_DIR = Full file path of the /conf/ directory
EVO_ERROR_DIR = Full path of the /error/ directory
EVO_LIB_DIR = Full path of the /lib/ directory
EVO_PUBLIC_DIR = Full path of the /public/ directory
EVO_TMP_DIR = Full path of the /tmp/ directory

EVO_PUBLIC_URL = URL of the /public directory
EVO_URL = URL of the evo.php
EVO_HOME_URL = URL of the directory where evo.php lives.
EVO_APPLICATION = Name of the application being requested.
EVO_REQUEST_DIR = Full path of the application directory being requested.
EVO_CONTROLLER = Name of the controller being requested.
EVO_VIEW = Name of the view being requested.
EVO_QUERY_STRING = Query string in the URL.
