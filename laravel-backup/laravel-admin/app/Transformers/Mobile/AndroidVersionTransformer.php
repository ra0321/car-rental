<?php

namespace App\Transformers\Mobile;

use App\AndroidVersion;
use League\Fractal\TransformerAbstract;

/**
 * Class AndroidVersionTransformer
 * @package App\Transformers\Mobile
 */
class AndroidVersionTransformer extends TransformerAbstract
{

    /**
     * @param AndroidVersion $version
     * @return array
     */
    public function transform(AndroidVersion $version)
    {
        return [
            'versionCode' => (int)$version->version_code,
            'versionName' => $version->version_name,
            'level' => (int)$version->important_level,
            'forceUpdate' => (boolean)$version->force_update
        ];
    }
}
