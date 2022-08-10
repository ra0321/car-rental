<?php

namespace App\Transformers\Mobile;

use App\IosVersion;
use League\Fractal\TransformerAbstract;

/**
 * Class IosVersionTransformer
 * @package App\Transformers\Mobile
 */
class IosVersionTransformer extends TransformerAbstract
{

    /**
     * @param IosVersion $version
     * @return array
     */
    public function transform(IosVersion $version)
    {
        return [
            'versionCode' => (int)$version->version_code,
            'versionName' => $version->version_name,
            'level' => (int)$version->important_level,
            'forceUpdate' => (boolean)$version->force_update
        ];
    }
}
