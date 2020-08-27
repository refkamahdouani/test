<?php

namespace App\Middleware;

use Psr\Http\Message\ResponseFactoryInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Slim\Exception\HttpException;
use Slim\Views\Twig;

final class HttpExceptionMiddleware implements MiddlewareInterface
{
    /**
     * @var ResponseFactoryInterface
     */
    private $responseFactory;

    public function __construct(ResponseFactoryInterface $responseFactory,Twig $twig)
    {
        $this->responseFactory = $responseFactory;
        $this->twig = $twig;
    }

    public function process(
        ServerRequestInterface $request, 
        RequestHandlerInterface $handler
    ): ResponseInterface
    {
        try {
            return $handler->handle($request);
        } catch (HttpException $httpException) {
            // Handle the http exception here
            $statusCode = $httpException->getCode();
            $response = $this->responseFactory->createResponse()->withStatus($statusCode);
            $errorMessage = sprintf('%s %s', $statusCode, $response->getReasonPhrase());

            // Log the errror message
            // $this->logger->error($errorMessage);

            $viewData = [];
            // Render twig template or just add the content to the body
            $this->twig->render($response, 'error.twig', $viewData);
            //$response->getBody()->write($errorMessage);

            return $response;
        }
    }
}