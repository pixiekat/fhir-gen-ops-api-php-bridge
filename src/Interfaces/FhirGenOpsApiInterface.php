<?php
declare(strict_types = 1);
namespace Pixiekat\FhirGenOpsApi\Interfaces;

interface FhirGenOpsApiInterface {

  /**
   * Defines the valid query paramers for genomic operations.
   */
  const VALID_QUERY_PARAMETERS = [
    'subject',
    'ranges',
    'testIdentifiers',
    'testDateRange',
    'specimenIdentifiers',
    'genomicSourceClass',
    'includeVariants',
    'includePhasing',
    'variants',
    'haplotypes',
    'treatments',
    'conditions',
    'gene',
  ];

  /**
   * Defines the constructor class.
   * 
   * @param string $endpointBaseUrl THe base URL of the endpoint.
   * @return void
   */
  public function __construct(string $endpointBaseUrl);

/**
   * Used to fetch GET data from the endpoint.
   *
   * @param string $endpoint
   * @param array $query
   * @return array|null
   */
  public function get(string $endpoint, array $query = []): array;

  /**
   * Sets the endpoint base URL.
   *
   * @param string $endpoint
   * @return void
   */
  public function setEndpoint(string $endpoint): static;
}