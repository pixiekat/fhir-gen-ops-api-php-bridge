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
  public function __construct(?string $endpointBaseUrl = '') {
    $this->endpointBaseUrl = $endpointBaseUrl;
    $this->client = new Client();
  }

  /**
   * Gets molecular consequences for a given subject.
   *
   * @param string $subject
   * @param array|null $params
   * @return array
   */
  public function findSubjectMolecularConsequences(string $subject, ?array $params = []): array {
    $query = ['subject' => $subject];
    $query = $this->getQueryParams($params, $query);
    return $this->get('subject-operations/phenotype-operations/$find-subject-molecular-consequences', $query);
  }

  /**
   * {@inheritdoc}
   */
  public function findSubjectVariants(string $subject, string $ranges, ?array $params= []): array {
    $query = [
      'subject' => $subject,
      'ranges' => $ranges,
    ];
    $query = $this->getQueryParams($params, $query);
    return $this->get('subject-operations/genotype-operations/$find-subject-variants', $query);
  }

  /**
   * Used to fetch GET data from the endpoint.
   *
   * @param string $endpoint
   * @param array $query
   * @return array|null
   */
  public function get(string $endpoint, array $query = []): array {
    if (empty($this->endpointBaseUrl)) {
      throw new Exception\InvalidArgumentException('The endpoint base URL is not set. You must first call the setEndpoint() method or set it in __construct().');
    }

    try {
      $response = $this->client->request('GET', $this->endpointBaseUrl . $endpoint, [
        'query' => Query::build($query),
      ]);
      if ($response->getStatusCode() !== 200) {
        throw new Exception('Failed to fetch data from the endpoint.');
      }
      return json_decode($response->getBody()->getContents(), TRUE);
    } catch (Exception $e) {
      throw new Exception($e->getMessage());
    }
  }

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

    return $this;
  }
}