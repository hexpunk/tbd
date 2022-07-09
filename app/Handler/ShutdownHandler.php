<?php

declare(strict_types=1);

namespace App\Handler;

use App\Handler\HttpErrorHandler;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Log\LoggerInterface;
use Slim\Exception\HttpInternalServerErrorException;
use Slim\Logger;
use Slim\ResponseEmitter;

class ShutdownHandler
{
    public function __construct(
        private Request $request,
        private HttpErrorHandler $errorHandler,
        private bool $displayErrorDetails,
        LoggerInterface | null $logger = null,
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
                case E_WARNING:
                case E_USER_WARNING:
                    $this->logger->warning($errorMessage);
                    break;

                case E_NOTICE:
                case E_USER_NOTICE:
                    $this->logger->notice($errorMessage);
                    break;

                default:
                    $details = "{$errorMessage} on line {$errorLine} in file {$errorFile}";
                    $this->logger->error($details);

                    if ($this->displayErrorDetails) {
                        $message = "FATAL ERROR: {$details}";
                    }

                    $exception = new HttpInternalServerErrorException($this->request, $message);
                    $response = $this->errorHandler->__invoke($this->request, $exception, $this->displayErrorDetails, false, false);

                    if (ob_get_length()) {
                        ob_clean();
                    }

                    $responseEmitter = new ResponseEmitter();
                    $responseEmitter->emit($response);
                    break;
            }
        }
    }
}
