<?php
class Smsglobal_RestApiClient_AdapterStub implements Smsglobal_RestApiClient_Http_Response_Adapter
{
    protected $statusCode;
    public function setStatusCode($statusCode)
    {
        $this->statusCode = $statusCode;
    }
    public function getContent()
    {
        return '{"error":"test"}';
    }
    public function getHeaders()
    {
        return new Smsglobal_RestApiClient_Http_HeaderBag();
    }
    public function getStatusCode()
    {
        return $this->statusCode;
    }
}
class Smsglobal_RestApiClient_RestClientTest extends PHPUnit_Framework_TestCase
{
    public function testHandleStatusCode()
    {
        $response = new Smsglobal_RestApiClient_AdapterStub();
        $data = array(200 => null, 201 => null, 202 => null, 204 => null, 410 => null, 400 => 'Smsglobal\\RestApiClient\\Exception\\InvalidDataException', 401 => 'Smsglobal\\RestApiClient\\Exception\\AuthorizationException', 404 => 'Smsglobal\\RestApiClient\\Exception\\ResourceNotFoundException', 405 => 'Smsglobal\\RestApiClient\\Exception\\MethodNotAllowedException', 500 => 'Smsglobal\\RestApiClient\\Exception\\ServiceException', 502 => 'Smsglobal\\RestApiClient\\Exception\\ServiceException', 503 => 'Smsglobal\\RestApiClient\\Exception\\ServiceException', 504 => 'Smsglobal\\RestApiClient\\Exception\\ServiceException', 418 => 'Exception');
        $rest = new Smsglobal_RestApiClient_RestApiClient(new Smsglobal_RestApiClient_ApiKey('', ''));
        $method = new _ReflectionClass(is_string($rest) ? str_replace('\\', '_', $rest) : $rest);
        $method = $method->getMethod('handleStatusCode');
        $method->setAccessible(true);
        foreach ($data as $statusCode => $expectedException) {
            $response->setStatusCode($statusCode);
            try {
                $method->invoke($rest, $response);
            } catch (\Exception $ex) {
                if (null === $expectedException) {
                    $this->fail('Status code threw unexpected exception');
                }
                if ($expectedException === str_replace('_', '\\', get_class($ex))) {
                    $this->addToAssertionCount(1);
                } else {
                    $this->fail((((('Status code threw incorrect exception: ' . str_replace('_', '\\', get_class($ex))) . ': ') . $ex->getMessage()) . ' Status code: ') . $statusCode);
                }
                continue;
            }
            if (null === $expectedException) {
                $this->addToAssertionCount(1);
            }
        }
    }
    public function testGetTimeZone()
    {
        $rest = new Smsglobal_RestApiClient_RestApiClient(new Smsglobal_RestApiClient_ApiKey('', ''));
        $method = new _ReflectionClass(is_string($rest) ? str_replace('\\', '_', $rest) : $rest);
        $method = $method->getMethod('getTimeZone');
        $method->setAccessible(true);
        $timeZone = $method->invoke($rest);
        $this->assertInstanceOf('DateTimeZone', $timeZone);
        $this->assertSame($timeZone, $method->invoke($rest));
    }
}