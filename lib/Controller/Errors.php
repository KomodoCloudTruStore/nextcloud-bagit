<?php

namespace OCA\BagIt\Controller;

use Closure;

use OCP\AppFramework\Http;
use OCP\AppFramework\Http\DataResponse;
use OCA\Bagit\Service\BagitServiceNotFoundException;

trait Errors
{
    protected function handleNotFound(Closure $callback)
    {
        try {
            return new DataResponse($callback());
        } catch (BagitServiceNotFoundException $e) {
            $message = ['message' => $e->getMessage()];
            return new DataResponse($message, Http::STATUS_NOT_FOUND);
        }
    }
}