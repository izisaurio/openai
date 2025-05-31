<?php

namespace Izisaurio\OpenAI;

use LiteRequest\Request,
    LiteRequest\Response,
    \CURLFile;

class Transcription extends OpenAITask
{
    /**
     * OpenAI API endpoint for this task
     * 
     * @access  private
     * @var     string
     */
    private $endpoint = 'https://api.openai.com/v1/audio/transcriptions';

    /**
     * Transcription model
     * 
     * @access  private
     * @var     string
     */
    private $model = 'whisper-1';

    /**
     * Request response
     * 
     * @access  public
     * @var     Response
     */
    public $response;

    /**
     * Send a request to the OpenAI API
     * 
     * "file" key (audio file path) is required in the data array
     * 
     * @param   array  $data
     * @return  Response
     */
    public function send(array $data)
    {
        if (!isset($data['file'])) {
            throw new OpenAIException('File key is required in the data array');
        }

        if (!isset($data['model'])) {
            $data['model'] = $this->model;
        }

        
        $data['file'] = new CURLFile($data['file']);

        $request = Request::post($this->endpoint, [
            CURLOPT_SSL_VERIFYHOST => false,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_POSTFIELDS => $data,
            CURLOPT_RETURNTRANSFER => true,
        ]);

        $request->headers([
            'Content-Type' => 'multipart/form-data',
            'Authorization' => 'Bearer ' . $this->apiKey,
        ]);

        $this->response = $request->exec();
        $this->error = $this->response->error;

        return $this->response;
    }

    /**
     * Get srt transcription from the response
     * 
     * @access  public
     * @return  string
     */
    public function srt() {
        return $this->response->body;
    }
}