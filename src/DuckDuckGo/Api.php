<?php

namespace DuckDuckGo;

use DuckDuckGo\Misc;
use GuzzleHttp\Client as Http;
use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\Exception\ServerException;

Class Api
{
    /**
     * Api endpoint url.
     * @var string
     */
    protected $endpoint;

    /**
     * DuckDuckGo Api constructor.
     */
    public function __construct()
    {
        $this->endpoint = "api.duckduckgo.com/";
    }

    /**
     * Perform a query against the DuckDuckGo API.
     * @param  string $query
     * @throws Exception
     * @return Json
     */
    public function zeroClickQuery(string $query)
    {
        $url = $this->buildUrl($query);
        $http = new Http();
        try {
            $response = $http->request("GET", $url);
            return $response->getBody();
        } catch (ClientException $e) {
            throw new Exception($e->getResponse()->getBody(), $e->getResponse()->getStatusCode());
        } catch (ServerException $e) {
            throw new Exception("Could not retrieve API result.", 503);
        }
    }

    /**
     * Build a url with config parameters and query.
     * 
     * @param string $query
     * @return string $url
     */
    public function BuildUrl(string $query)
    {
        $misc = new Misc();

        $parameters = [
            "q" => urlencode($query),
            "format" => $misc->getConfig("format"),
            "no_html" => $misc->getConfig("html"),
            "no_redirect" => 1,
            "skip_disambig" => $misc->getConfig("disambiguations"),
        ];

        $url = ($misc->getConfig("https")) 
            ? "https://".$this->endpoint."?"
            : "https://".$this->endpoint."?";

        $url .= http_build_query($parameters);
        return $url;
    }
}
