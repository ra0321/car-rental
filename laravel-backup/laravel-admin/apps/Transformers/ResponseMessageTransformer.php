<?php

namespace App\Transformers;

use App\ResponseMessage;
use League\Fractal\TransformerAbstract;

/**
 * Class ResponseMessageTransformer
 * @package App\Transformers
 */
class ResponseMessageTransformer extends TransformerAbstract
{

    /**
     * @param ResponseMessage $message
     * @return array
     */
    public function transform(ResponseMessage $message)
    {
        return [
            'englishMessage' => $message->english_message,
            'arabicMessage' => $message->arabic_message,
            'code' => (int)$message->code,
            'paramName' => $message->param_name,
            'paramValue' => $message->param_value
        ];
    }
}
