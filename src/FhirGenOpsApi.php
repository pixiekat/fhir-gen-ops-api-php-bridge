<?php
declare(strict_types=1);
namespace Pixiekat\FhirGenOpsApi;

use GuzzleHttp\Client;
use GuzzleHttp\Exception;
use GuzzleHttp\Psr7\Query;
use Pixiekat\FhirGenOpsApi\Interfaces\FhirGenOpsApiInterface;
use Pixiekat\FhirGenOpsApi\Traits;

class FhirGenOpsApi implements FhirGenOpsApiInterface {
  use Traits\ApiBaseTrait;

  /**
   * {@inheritdoc}
   */
  public function __construct() {}

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
    $subject = strtoupper($subject);
    $query = [
      'subject' => $subject,
      'ranges' => $ranges,
    ];
    $query = $this->getQueryParams($params, $query);
    return $this->get('subject-operations/genotype-operations/$find-subject-variants', $query);
  }

  /**
   * {@inheritdoc}
   */
  public function getFeatureCoordinates(string $chromosome = null, string $gene = null, string $transcript = null, string $protein = null): array {
    $query = [];
    if (!empty($chromosome)) {
      $query['chromosome'] = $chromosome;
    }
    if (!empty($gene)) {
      $query['gene'] = $gene;
    }
    if (!empty($transcript)) {
      $query['transcript'] = $transcript;
    }
    if (!empty($protein)) {
      $query['protein'] = $protein;
    }
    if (empty($query)) {
      throw new \InvalidArgumentException('At least one of the following parameters must be provided: chromosome, gene, transcript, protein');
    }
    $params = [];
    $query = $this->getQueryParams($params, $query);
    return $this->get('utilities/get-feature-coordinates', $query);
  }

  /**
   * {@inheritdoc}
   */
  public function findTheGene(string $range, ?array $params = []): array {
    $query = ['range' => $range];
    $query = $this->getQueryParams($params, $query);
    return $this->get('utilities/find-the-gene', $query);
  }
}
