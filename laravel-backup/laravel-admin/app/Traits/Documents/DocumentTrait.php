<?php

namespace App\Traits\Documents;


use App\Traits\ImageManager;
use Aws\S3\Exception\S3Exception;
use Storage;

/**
 * Trait DocumentTrait
 * @package App\Traits\Documents
 */
trait DocumentTrait
{
    use ImageManager;

    /**
     * @param $file_name
     * @param $id
     * @return array
     */
    public function uploadImageOfDocsToS3($file_name, $id)
    {
        $image_name = $this->imageName($file_name);
        $image_name_thumb = $this->imageName($file_name, true);
        $path = 'users/' . $id . '/ids/';

        $img = $this->imageIntervention($file_name);
        $img_thumb = $this->imageIntervention($file_name, true);

        try{
            $s3 = Storage::disk('s3');
            $s3->put($path . $image_name, $img, 'public');
            $s3->put($path . $image_name_thumb, $img_thumb, 'public');
        }catch(S3Exception $e){
            return $this->errorResponse(SOMETHING_WENT_WRONG);
        }

        return [
            'path' => $path,
            'image_name' => $image_name,
            'image_name_thumb' => $image_name_thumb
        ];
    }
}