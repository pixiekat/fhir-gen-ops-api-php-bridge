<?php
declare(strict_types=1);
namespace Pixiekat\FhirGenOpsApi;
use Pixiekat\FhirGenOpsApi\Interfaces;
use Pixiekat\FhirGenOpsApi\Traits;

class FhirApi implements Interfaces\FhirApiInterface {
  use Traits\ApiBaseTrait;

  public function getPatient(string $patientMRN, array $params = []): ?array {
    $path = 'open/Patient';
    $query = ['identifier' => $patientMRN];
    $queryParams = $this->getQueryParams($params, $query);
    $result = $this->get($path, $queryParams);
    return $result;
  }
}
