<?php
namespace Spiral\Commands\Console;

class ReloadCommand
{
    /**
     * @var \Spiral\Core\MemoryInterface
     */
    protected $memory = null;

    /**
     * @var \Spiral\Core\ContainerInterface
     */
    protected $container = null;

    /**
     * @var \Spiral\Debug\LogsInterface
     */
    protected $logs = null;

    /**
     * @var \Spiral\Http\HttpDispatcher
     */
    protected $http = null;

    /**
     * @var \Spiral\Console\ConsoleDispatcher
     */
    protected $console = null;

    /**
     * @var \Spiral\Console\ConsoleDispatcher
     */
    protected $commands = null;

    /**
     * @var \Spiral\Files\FilesInterface
     */
    protected $files = null;

    /**
     * @var \Spiral\Tokenizer\TokenizerInterface
     */
    protected $tokenizer = null;

    /**
     * @var \Spiral\Tokenizer\ClassesInterface
     */
    protected $locator = null;

    /**
     * @var \Spiral\Tokenizer\InvocationsInterface
     */
    protected $invocationLocator = null;

    /**
     * @var \Spiral\Views\ViewManager
     */
    protected $views = null;

    /**
     * @var \Spiral\Translator\Translator
     */
    protected $translator = null;

    /**
     * @var \Spiral\Database\DatabaseManager
     */
    protected $dbal = null;

    /**
     * @var \Spiral\ORM\ORM
     */
    protected $orm = null;

    /**
     * @var \Spiral\ODM\ODM
     */
    protected $odm = null;

    /**
     * @var \Spiral\Encrypter\EncrypterInterface
     */
    protected $encrypter = null;

    /**
     * @var \Spiral\Database\Entities\Database
     */
    protected $db = null;

    /**
     * @var \Spiral\ODM\Entities\MongoDatabase
     */
    protected $mongo = null;

    /**
     * @var \Spiral\Http\Cookies\CookieQueue
     */
    protected $cookies = null;

    /**
     * @var \Spiral\Session\SessionInterface
     */
    protected $session = null;

    /**
     * @var \Spiral\Pagination\PaginatorsInterface
     */
    protected $paginators = null;

    /**
     * @var \Psr\Http\Message\ServerRequestInterface
     */
    protected $request = null;

    /**
     * @var \Spiral\Http\Request\InputManager
     */
    protected $input = null;

    /**
     * @var \Spiral\Http\Response\ResponseWrapper
     */
    protected $response = null;

    /**
     * @var \Spiral\Http\Routing\RouteInterface
     */
    protected $route = null;

    /**
     * @var \Spiral\Security\PermissionsInterface
     */
    protected $permissions = null;

    /**
     * @var \Spiral\Security\RulesInterface
     */
    protected $rules = null;

    /**
     * @var \Spiral\Security\ActorInterface
     */
    protected $actor = null;

    /**
     * @var \Spiral\Http\Routing\RouterInterface
     */
    protected $router = null;
}