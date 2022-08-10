<?php

namespace App\Transformers;

use App\ID_Card;
use League\Fractal\TransformerAbstract;

/**
 * Class IdCardTransformer
 * @package App\Transformers
 */
class IdCardTransformer extends TransformerAbstract
{

    /**
     * @param ID_Card $idCard
     * @return array
     */
    public function transform(ID_Card $idCard)
    {
        return [
            "IDNumber"                  => $idCard->id_number ? (string)$idCard->id_number : null,
            "countryID"                 => $idCard->id_country ? (string)$idCard->id_country : null,
            "stateID"                   => $idCard->id_state ? (string)$idCard->id_state : null,
            "cityID"                    => $idCard->id_city ? (string)$idCard->id_city : null,
            "dateOfIssue"               => $idCard->date_of_issue ? (string)$idCard->date_of_issue : null,
            "expirationDate"            => (string)$idCard->expiration_date,
            "issuedBy"                  => $idCard->issued_by ? (string)$idCard->issued_by : null,
            "imageIdPath"               => (string)$idCard->image_path,
            "imageIdPathSmall"          => (string)$idCard->image_path_small,
        ];
    }
}
