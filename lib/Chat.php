<?php

namespace Izisaurio\OpenAI;

use LiteRequest\Request;

class Chat extends OpenAITask
{
    /**
     * OpenAI API endpoint for this task
     * 
     * @access  private
     * @var     string
     */
    private $endpoint = 'https://api.openai.com/v1/chat/completions';

    /**
     * Transcription default model
     * 
     * @access  private
     * @var     string
     */
    private $model = 'gpt-4o-mini';

    /**
     * Error storage
     * 
     * @access  public
     * @var     string
     */
    public $error;

    /**
     * Response storage
     * 
     * @access  public
     * @var     array
     */
    public $response = [];

    /**
     * Send a request to the OpenAI API
     * 
     * "messages" key (array of messages) is required in the data array
     * 
     * @param   array  $data
     * @return  array
     */
    public function send(array $data)
    {
        if (!isset($data['messages'])) {
            throw new OpenAIException('"messages" key is required in the data array');
        }

        if (!isset($data['model'])) {
            $data['model'] = $this->model;
        }

        $request = Request::post($this->endpoint, [
            CURLOPT_SSL_VERIFYHOST => false,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        ]);

        $request->headers([
            'Content-Type' => 'application/json',
            'Authorization' => "Bearer {$this->apiKey}",
        ]);

        $request->postbody($data);

        $response = $request->exec();
        $this->error = $response->error;

        $this->response =  $response->json();
        return $this->response;
    }

    /**
     * Return the response main message
     * 
     * @access  public
     * @return  string
     */
    public function message() {
        return $this->response['choices'][0]['message']['content'];
    }
}