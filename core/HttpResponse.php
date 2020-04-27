<?php


namespace Intass;


class HttpResponse
{
    protected $status;
    protected $message;
    protected $contentType;

    public function __construct($message, $status = 200)
    {
        $this->status = $status;
        $this->message = $message;
        $this->contentType = 'html';
    }

    /**
     * @return mixed
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * @param mixed $status
     */
    public function setStatus($status)
    {
        $this->status = $status;
    }

    /**
     * @return mixed
     */
    public function getMessage()
    {
        return $this->message;
    }

    /**
     * @param mixed $message
     * @return HttpResponse
     */
    public function setMessage($message)
    {
        $this->message = $message;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getContentType()
    {
        return $this->contentType;
    }

    /**
     * @param mixed $contentType
     * @return HttpResponse
     */
    public function setContentType($contentType)
    {
        $this->contentType = $contentType;
        return $this;
    }

    public static function json($data = [], $statusCode = 200)
    {
        return (new HttpResponse($data, $statusCode))->setContentType('json');
    }

    public function render()
    {
        header_remove();
        http_response_code($this->status);
        header("Cache-Control: no-transform,public,max-age=300,s-maxage=900");

        $messages = array(
            200 => '200 OK',
            400 => '400 Bad Request',
            404 => '404 Not Found',
            403 => '403 Forbidden',
            401 => '401 Unauthorized',
            422 => 'Unprocessable Entity',
            500 => '500 Internal Server Error'
        );

        header('Status: '.$messages[$this->status]);

        switch ($this->contentType) {
            case 'json':
                header('Content-Type: application/json');
                exit(json_encode(array(
                    'status' => $this->status < 300,
                    'data' => $this->message
                )));
            default:
                header('Content-Type: text/html');
                exit($this->message);
        }
    }
}
