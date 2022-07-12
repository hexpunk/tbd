<?php

declare(strict_types=1);

namespace App\Handlers;

use App\Handlers\HttpErrorHandler;
use App\ResponseEmitter;
use Psr\Http\Message\RequestInterface as Request;
use Psr\Log\LoggerInterface;
use Slim\Exception\HttpInternalServerErrorException;
use Slim\Logger;

class ShutdownHandler
{
    public function __construct(
        private Request $request,
        private HttpErrorHandler $errorHandler,
        private bool $displayErrorDetails,
        ?LoggerInterface $logger = null,
    ) {
        $this->logger = $logger ?: new Logger();
    }

    public function __invoke()
    {
        $error = error_get_last();
        if ($error) {
            $errorFile = $error['file'];
            $errorLine = $error['line'];
            $errorMessage = $error['message'];
            $errorType = $error['type'];
            $message = 'An error while processing your request. Please try again later.';

            switch ($errorType) {
                case E_COMPILE_WARNING:
                case E_CORE_WARNING:
                case E_USER_WARNING:
                case E_WARNING:
                    $this->logger->warning($errorMessage);
                    break;

                case E_DEPRECATED:
                case E_NOTICE:
                case E_STRICT:
                case E_USER_DEPRECATED:
                case E_USER_NOTICE:
                    $this->logger->notice($errorMessage);
                    break;

                case E_COMPILE_ERROR:
                case E_CORE_ERROR:
                case E_ERROR:
                case E_PARSE:
                case E_RECOVERABLE_ERROR:
                case E_USER_ERROR:
                default:
                    $details = "{$errorMessage} on line {$errorLine} in file {$errorFile}";
                    $this->logger->error($details);

                    if ($this->displayErrorDetails) {
                        $message = "FATAL ERROR: {$details}";
                    }

                    $exception = new HttpInternalServerErrorException($this->request, $message);
                    $response = $this->errorHandler->__invoke($this->request, $exception, $this->displayErrorDetails, false, false);

                    $responseEmitter = new ResponseEmitter();
                    $responseEmitter->emit($response);
                    break;
            }
        }
    }
}
