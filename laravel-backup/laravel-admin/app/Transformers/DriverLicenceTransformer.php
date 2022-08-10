<?php

namespace App\Transformers;

use App\DriverLicence;
use League\Fractal\TransformerAbstract;

/**
 * Class DriverLicenceTransformer
 * @package App\Transformers
 */
class DriverLicenceTransformer extends TransformerAbstract
{

    /**
     * @param DriverLicence $driverLicence
     * @return array
     */
    public function transform(DriverLicence $driverLicence)
    {
        return [
            "number"                  => $driverLicence->dl_number ? (string)$driverLicence->dl_number : null,
            "country"                 => $driverLicence->country ? (string)$driverLicence->country : null,
            "state"                   => $driverLicence->state ? (string)$driverLicence->state : null,
            "city"                    => $driverLicence->city ? (string)$driverLicence->city : null,
            "dateOfIssue"               => $driverLicence->date_of_issue ? (string)$driverLicence->date_of_issue : null,
            "expirationDate"            => (string)$driverLicence->expiration_date,
            "issuedBy"                  => $driverLicence->issued_by ? (string)$driverLicence->issued_by : null,
            "imageIdPath"               => (string)$driverLicence->image_path,
            "imageIdPathSmall"          => (string)$driverLicence->image_path_small,
        ];
    }
}
