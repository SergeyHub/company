<?php
namespace App\Services\Translate;

use \GuzzleHttp\Client;

class LingvanexTranslator {
    private $httpClient;
    private $baseUrl = 'https://api-b2b.backenster.com/b1/api/v3/';

    private $textForTranslate = '';
    private $languageFrom = null;
    private $languageTo = null;

    public function __construct() {
        $this->httpClient  = new Client;
    }

    /**
     * Set text for translate
     *
     * @param string $text
     * @return $this
     */
    public function setText(string $text) {
        $this->textForTranslate = $text;

        return $this;
    }

    /**
     * Set source language
     *
     * @param string $lang
     * @param string|null $langTo
     * @return $this
     */
    public function setLanguageFrom(string $lang) {
        if(!preg_match('/.+\_.+/', $lang)) {
            $lang = $lang . '_' . $lang;
        }
        $this->languageFrom = $lang;

        return $this;
    }

    /**
     * Set destination language
     *
     * @param string $lang
     * @param string|null $langTo
     * @return $this
     */
    public function setLanguageTo(string $lang) {
        if(!preg_match('/.+\_.+/', $lang)) {
            $lang = $lang . '_' . $lang;
        }
        $this->languageTo = $lang;

        return $this;
    }

    /**
     * Get translate of recivied text;
     *
     * @return mixed
     */
    public function translate() {
        $response = $this->request('translate', [
            'from' => $this->languageFrom,
            'to' => $this->languageTo,
            'data' => $this->textForTranslate,
            'platform' => 'api'
        ]);
        $this->textForTranslate = '';

        if(json_decode($response)) {
            $response = json_decode($response);
        }
        return $response;
    }

    /**
     * Make http request to server
     *
     * @param $method
     * @param $params
     * @return mixed
     */
    private function request($method, $params) {
        return $this->httpClient->request('POST', $this->baseUrl . $method, [
            'form_params' => $params,
            'headers' => [
                'Authorization' => 'Bearer ' . config('translate.api_key')
            ]
        ])->getBody()->getContents();
    }
}
