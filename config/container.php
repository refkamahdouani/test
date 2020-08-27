<?php


use App\Factory\LoggerFactory;
use Cake\Database\Connection;
use Psr\Container\ContainerInterface;
use Psr\Http\Message\ResponseFactoryInterface;
use Slim\App;
use Slim\Factory\AppFactory;
use Slim\Middleware\ErrorMiddleware;
use Selective\BasePath\BasePathMiddleware;
use Slim\Views\Twig;
use Slim\Views\TwigMiddleware;
use Symfony\Component\Mailer\Mailer;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mailer\Transport;


 
return [
    'settings' => function () {
        return require __DIR__ . '/settings.php';
    },
    
    App::class => function (ContainerInterface $container) {
        AppFactory::setContainer($container);

        return AppFactory::create();
    },

    ErrorMiddleware::class => function (ContainerInterface $container) {
        $app = $container->get(App::class);
        $settings = $container->get('settings')['error'];

        return new ErrorMiddleware(
            $app->getCallableResolver(),
            $app->getResponseFactory(),
            (bool)$settings['display_error_details'],
            (bool)$settings['log_errors'],
            (bool)$settings['log_error_details']
        );
    },

    BasePathMiddleware::class => function (ContainerInterface $container) {
        return new BasePathMiddleware($container->get(App::class));
    },

    //Error and exception handling
    LoggerFactory::class => function (ContainerInterface $container) {
        return new LoggerFactory($container->get('settings')['logger']);
    },

    // Database connection
    Connection::class => function (ContainerInterface $container) {
            return new Connection($container->get('settings')['db']);
        },
    
        PDO::class => function (ContainerInterface $container) {
            $db = $container->get(Connection::class);
            $driver = $db->getDriver();
            $driver->connect();
    
            return $driver->getConnection();
    },
    // Twig templates
    Twig::class => function (ContainerInterface $container) {
        $settings = $container->get('settings');
        $twigSettings = $settings['twig'];

        $options = $twigSettings['options'];
        $options['cache'] = $options['cache_enabled'] ? $options['cache_path'] : false;

        $twig = Twig::create($twigSettings['paths'], $options);

        // Add extension here
        $basePath = $settings['config']['baseURL'];
        $twig->addExtension(new \Fullpipe\TwigWebpackExtension\WebpackExtension(
            // must be a absolute path
            $settings['root'] . '/public/assets/manifest.json',
            // url path for js
            $basePath . 'assets/',
            // url path for css
            $basePath . 'assets/'
        ));

        return $twig;
    },
    TwigMiddleware::class => function (ContainerInterface $container) {
        return TwigMiddleware::createFromContainer(
            $container->get(App::class),
            Twig::class
        );
    },
    // SMTP transport
    MailerInterface::class => function (ContainerInterface $container) {
        $settings = $container->get('settings')['smtp'];
        // or
        // $settings = $container->get('settings')['smtp'];
        
        // smtp://user:pass@smtp.example.com:25
        $dsn = sprintf(
            '%s://%s:%s@%s:%s',
            $settings['type'],
            $settings['username'],
            urlencode($settings['password']),
            $settings['host'],
            $settings['port']
        );

        return new Mailer(Transport::fromDsn($dsn));
    },

    ResponseFactoryInterface::class => function (ContainerInterface $container) {
        return $container->get(App::class)->getResponseFactory();
    },
];