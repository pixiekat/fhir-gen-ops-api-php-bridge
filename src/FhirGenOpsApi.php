<?php
declare(strict_types=1);
namespace Pixiekat\FhirGenOpsApi;

use GuzzleHttp\Client;
use GuzzleHttp\Exception;
use GuzzleHttp\Psr7\Query;
use Pixiekat\FhirGenOpsApi\Interfaces\FhirGenOpsApiInterface;

class FhirGenOpsApi implements FhirGenOpsApiInterface {

  /**
   * The \GuzzleHttp\Client definition.
   * 
   * @var \GuzzleHttp\Client $client
   */
  private Client $client;

  /**
   * Defines the endpoint base URL.
   */
  private string $endpointBaseUrl;

  /**
   * {@inheritdoc}
   */
  public function __construct(string $endpointBaseUrl) {
    $this->endpointBaseUrl = $endpointBaseUrl;
    $this->client = new Client();
  }

  /**
   * Used to fetch GET data from the endpoint.
   *
   * @param string $endpoint
   * @param array $query
   * @return array|null
   */
  public function get(string $endpoint, array $query = []): array {
    try {
      $response = $this->client->request('GET', $this->endpointBaseUrl . $endpoint, [
        'query' => Query::build($query),
      ]);
      if ($response->getStatusCode() !== 200) {
        throw new Exception\GuzzleException('Failed to fetch data from the endpoint.');
      }
      return json_decode($response->getBody()->getContents(), TRUE);
    } catch (Exception\GuzzleException $e) {
      throw new Exception\GuzzleException($e->getMessage());

  /**
   * Gets and merges the query params for the api.
   *
   * @param array $params
   * @param array $query
   * @return array
   */
  private function getQueryParams(array $params = [], array &$query = []): array {
    if (!empty($params)) {
      foreach ($params as $param => $value) {
        if (in_array($param, self::VALID_QUERY_PARAMETERS) && !empty($value)) {
          $query[$param] = $value;
        }
      }
    }
    return $query;
  }

  /**
   * {@inheritdoc}
   */
  public function setEndpoint(string $endpoint): static {
    $this->endpointBaseUrl = $endpoint;
  }
}