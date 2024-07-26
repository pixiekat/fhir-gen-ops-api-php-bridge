<?php
declare(strict_types = 1);
namespace Pixiekat\FhirGenOpsApi;

interface FhirGenOpsApiInterface {

  /**
   * Defines the constructor class.
   * 
   * @param string $endpointBaseUrl THe base URL of the endpoint.
   * @return void
   */
  public function __contruct(string $endpointBaseUrl): void;
}