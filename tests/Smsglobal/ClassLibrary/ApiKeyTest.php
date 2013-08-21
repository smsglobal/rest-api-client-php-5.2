<?php
class Smsglobal_RestApiClient_ApiKeyTest extends PHPUnit_Framework_TestCase
{
    public function testHashAlgoSupported()
    {
        $this->assertContains(Smsglobal_RestApiClient_ApiKey::HASH_ALGO, hash_algos());
    }
    public function testConstructor()
    {
        $key = 'test';
        $secret = 'abcd';
        $apiKey = new Smsglobal_RestApiClient_ApiKey($key, $secret);
        $this->assertAttributeEquals($key, 'key', $apiKey);
        $this->assertAttributeEquals($secret, 'secret', $apiKey);
    }
    public function testGetKey()
    {
        $expected = 'test';
        $apiKey = new Smsglobal_RestApiClient_ApiKey($expected, 'abcd');
        $this->assertEquals($expected, $apiKey->getKey());
    }
    /**
     * @covers Smsglobal\RestApiClient\ApiKey::getAuthorizationHeader
     */
    public function testGetAuthorizationHeader()
    {
        $apiKey = new Smsglobal_RestApiClient_ApiKey('test', 'abcd');
        $header = $apiKey->getAuthorizationHeader('GET', '/v1/sms/', 'api.smsglobal.com', 443);
        $regExp = '/^MAC id="test", ts="\\d+", nonce=".*", mac=".*"$/';
        $this->assertRegExp($regExp, $header);
    }
    public function testHashRequest()
    {
        $apiKey = new Smsglobal_RestApiClient_ApiKey('test', 'abcd');
        $reflection = new _ReflectionClass(is_string($apiKey) ? str_replace('\\', '_', $apiKey) : $apiKey);
        $method = $reflection->getMethod('hashRequest');
        $method->setAccessible(true);
        $args = array(1375000000, 'random-nonce', 'GET', '/v1/sms/', 'api.smsglobal.com', 443, '');
        $hash = $method->invokeArgs($apiKey, $args);
        $expected = 'xHRg9NU2FyDXb6X/iWGfseHslX7ES3IKPSwFV5QLguQ=';
        $this->assertEquals($expected, $hash);
    }
}