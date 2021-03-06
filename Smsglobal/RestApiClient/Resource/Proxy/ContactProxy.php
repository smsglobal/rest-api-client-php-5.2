<?php
class Smsglobal_RestApiClient_Resource_Proxy_ContactProxy extends Smsglobal_RestApiClient_Resource_Contact
{
    private $rest;
    public function __construct($resourceUri, Smsglobal_RestApiClient_RestApiClient $rest)
    {
        $this->resourceUri = $resourceUri;
        $this->rest = $rest;
        $this->id = substr($resourceUri, 0, -1);
        $this->id = (int) substr($this->id, (strrpos('/', $this->id) + 1), (-1));
    }
    private function load()
    {
        if (isset($this->rest)) {
            $options = $this->rest->get($this->getResourceName(), $this->id);
            $this->setOptions($options);
            unset($this->rest);
        }
    }
    public function getDisplayName()
    {
        $this->load();
        return parent::getDisplayName();
    }
    public function getFamilyName()
    {
        $this->load();
        return parent::getFamilyName();
    }
    public function getGivenName()
    {
        $this->load();
        return parent::getGivenName();
    }
    public function getMsisdn()
    {
        $this->load();
        return parent::getMsisdn();
    }
    public function getEmailAddress()
    {
        $this->load();
        return parent::getEmailAddress();
    }
    public function getGroup()
    {
        $this->load();
        return parent::getGroup();
    }
}