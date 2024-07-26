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
  public function __contruct(string $endpointBaseUrl): void {
    $this->endpointBaseUrl = $endpointBaseUrl;
    $this->client = new Client();
  }

  /**
   * {@inheritdoc}
   */
  public function setEndpoint(string $endpoint): static {
    $this->endpointBaseUrl = $endpoint;
  }
}