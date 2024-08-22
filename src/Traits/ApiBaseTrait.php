<?php
declare(strict_types=1);
namespace Pixiekat\FhirGenOpsApi\Traits;

use GuzzleHttp\Client;
use GuzzleHttp\Exception;
use GuzzleHttp\Psr7\Query;

trait ApiBaseTrait {

  /**
   * The \GuzzleHttp\Client definition.
   *
   * @var \GuzzleHttp\Client $client
   */
  private Client $client;

  /**
   * Defines the endpoint base URL.
   */
  private ?string $endpointBaseUrl = null;

  /**
   * Used to fetch GET data from the endpoint.
   *
   * @param string $endpoint
   * @param array $query
   * @return array|null
   */
  public function get(string $endpoint, array $query = []): array {
    if (empty($this->getEndpoint())) {
      throw new Exception\InvalidArgumentException('The endpoint base URL is not set. You must first call the setEndpoint() method.');
    }

    try {
      $client = $this->getClient();
      $apiEndpoint = $this->getEndpoint();
      $methodEndpoint = ltrim($endpoint, '/');
      $guzzleUrl = "{$apiEndpoint}/{$endpoint}";

      $response = $client->request('GET', $guzzleUrl, [
        'query' => Query::build($query),
      ]);
      if ($response->getStatusCode() !== 200) {
        throw new Exception('Failed to fetch data from the endpoint.');
      }
      $body = json_decode($response->getBody()->getContents(), TRUE) ?? [];
      return $body;
    } catch (Exception $e) {
      throw new Exception($e->getMessage());
    }
    return [];
  }

  /**
   * Gets a \GuzzleHttp\Client instance.
   */
  public function getClient(): Client {
    if (!isset($this->client)) {
      $this->client = new Client();
    }
    return $this->client;
  }

  /**
   * Gets the endpoint base URL.
   */
  public function getEndpoint(): string {
    $defaultEndpoint = defined('self::DEFAULT_ENDPOINT') ? self::DEFAULT_ENDPOINT : NULL;
    return $this->endpointBaseUrl ?? $defaultEndpoint;
  }

  /**
   * Gets and merges the query params for the api.
   *
   * @param array $params
   * @param array $query
   * @return array
   */
  private function getQueryParams(array $params = [], array &$query = []): array {
    $validQueryParams = [];
    if (defined('self::VALID_QUERY_PARAMETERS')) {
      $validQueryParams = self::VALID_QUERY_PARAMETERS;
    }
    if (!empty($params)) {
      foreach ($params as $param => $value) {
        if (in_array($param, $validQueryParams) && !empty($value)) {
          $query[$param] = $value;
        }
      }
    }
    return $query;
  }

  /**
   * Sets the endpoint base URL.
   *
   * @param string $endpointBaseUrl
   */
  public function setEndpoint(string $endpointBaseUrl): static {
    $this->endpointBaseUrl = $endpointBaseUrl;
    return $this;
  }

}
