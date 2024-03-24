<?php

namespace Izisaurio\OpenAI;

abstract class OpenAITask {
    /**
     * OpenAI API key
     * 
     * @access  protected
     * @var     string
     */
    protected $apiKey;

    /**
     * Errors found
     * 
     * @access  public
     * @var     string
     */
    public $error;

    /**
     * Constructor
     * 
     * @param   string  $apiKey
     */
    public function __construct($apiKey) {
        $this->apiKey = $apiKey;
    }

    /**
     * Send a request to the OpenAI API
     * 
     * @param   array  $data
     * @return  array
     */
    abstract public function send(array $data);
}