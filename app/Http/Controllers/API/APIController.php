<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;

class APIController extends Controller
{
    /**
     * @var int $statusCode
     */
    protected $statusCode = 200;

    public function __construct()
    {
       //
    }

    /**
     * Get the status code.
     *
     * @return int $statusCode
     */
    public function getStatusCode()
    {
        return $this->statusCode;
    }

    /**
     * Set the status code.
     *
     * @param $statusCode
     * @return $this
     */
    public function setStatusCode($statusCode)
    {
        $this->statusCode = $statusCode;

        return $this;
    }

    /**
     * Repond a no content response.
     * 
     * @return response
     */
    public function noContent()
    {
        return response()->json(null, 204);
    }

    /**
     * Respond with an object.
     * 
     * @param object $object
     * @param array $headers
     * @return response
     */
    public function respondWithObject(object $object, array $headers = [])
    {
        return response()->json($object, $this->statusCode, $headers);
    }

    /**
     * Respond with an array of data.
     *
     * @param array $array
     * @param array $headers
     * @return mixed
     */
    public function respondWithArray(array $array, array $headers = [])
    {
        return response()->json($array, $this->statusCode, $headers);
    }

    /**
     * Respond a message.
     * 
     * @param  string $message
     * @return json
     */

    public function respondWithMessage ($message) {
        return $this->setStatusCode(200)
            ->respondWithArray([
                    'message' => $message,
                ]);
    }

    /**
     * Respond an error message.
     * 
     * @param  string $message
     * @param  string $errorCode
     * @return json
     */
    protected function respondWithError($message, $errorCode, $errors = [])
    {
        if ($this->statusCode === 200) {
            trigger_error(
                "There better be a good reason for this...",
                E_USER_WARNING
            );
        }

        return $this->respondWithArray([
            'errors'  => $errors,
            'code'    => $errorCode,
            'message' => $message,
        ]);
    }

    /**
     * Respond the forbidden error.
     * 
     * @param  string $message
     * @return json
     */
    public function errorForbidden($message = 'FORBIDDEN', $errors = [])
    {
        return $this->setStatusCode(403)
                    ->respondWithError($message, $errors);
    }

    /**
     * Respond internal error message.
     * 
     * @param  string $message
     * @return json
     */
    public function errorInternalError($message = 'INTERNAL_SERVER_ERROR', $errors = [])
    {
        return $this->setStatusCode(500)
                    ->respondWithError($message, $errors);
    }

    /**
     * Respond the resource not found error
     * 
     * @param  string $message
     * @return json
     */
    public function errorNotFound($message = 'RESOURCE_NOT_FOUND', $errors = [])
    {
        return $this->setStatusCode(404)
                    ->respondWithError($message, $errors);
    }

    /**
     * Respond the unauthorized error.
     * 
     * @param  string $message
     * @return json
     */
    public function errorUnauthorized($message = 'UNAUTHORIZED', $errors = [])
    {
        return $this->setStatusCode(401)
                    ->respondWithError($message, $errors);
    }

    /**
     * Respond the invalid arguments error.
     * 
     * @param  string $message
     * @return json
     */
    public function errorWrongArgs($message = 'INVALID_ARGUMENTS', $errors = [])
    {
        return $this->setStatusCode(422)
                    ->respondWithError($message, $errors);
    }
}
