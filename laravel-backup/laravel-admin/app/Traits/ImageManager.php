<?php

namespace App\Traits;

use Image;

/**
 * Trait ImageManager
 * @package App\Traits
 */
trait ImageManager
{

    /**
     * @param $fileName
     * @param bool $user
     * @param bool $document
     * @return array
     */
    public function imageName($fileName, $user = false, $document = false)
	{
		$source = request()->file($fileName);
		$ext = $source->getClientOriginalExtension();
		return $this->imageNameMaker($ext, $user, $document);
	}

	public function imageNameMaker($ext, $user, $document)
    {
        $image_names = [];
        $time = time();
        switch (true){
            case $document:
                $image_names['big'] = md5($time) . '-big.' . $ext;
                $image_names['small'] = md5($time) . '-small.' . $ext;
                break;
            case $user:
                $image_names['big'] = md5($time) . '-big.' . $ext;
                $image_names['small'] = md5($time) . '-small.' . $ext;
                $image_names['smallest'] = md5($time) . '-smallest.' . $ext;
                break;
            default:
                $image_names['biggest'] = md5($time) . '.' . $ext;
                $image_names['big'] = md5($time) . '-big.' . $ext;
                $image_names['small'] = md5($time) . '-small.' . $ext;
                $image_names['smallest'] = md5($time) . '-smallest.' . $ext;
        }
        return $image_names;
    }

    public function imageFromMessageName($fileName)
    {
        $time = time();
        $source = request()->file($fileName);
        $ext = $source->getClientOriginalExtension();
        return md5($time) . '.' . $ext;
    }

    /**
     * @param $fileName
     * @return resource|null
     */
    public function makeOriginalSizeOfImage($fileName)
    {
        $source = request()->file($fileName);
        return Image::make($source)->orientate()->fit(1440, 810)->stream()->detach();
    }

    /**
     * @param $fileName
     * @return resource|null
     */
    public function makeBigSizeOfImage($fileName)
    {
        $source = request()->file($fileName);
        return Image::make($source)->orientate()->fit(1140, 640)->stream()->detach();
    }

    /**
     * @param $fileName
     * @return resource|null
     */
    public function makeSmallSizeOfImage($fileName)
    {
        $source = request()->file($fileName);
        return Image::make($source)->orientate()->fit(375, 210)->stream()->detach();
    }

    /**
     * @param $fileName
     * @return resource|null
     */
    public function makeIconSizeOfImage($fileName)
    {
        $source = request()->file($fileName);
        return Image::make($source)->orientate()->fit(60, 60)->stream()->detach();
    }

    /**
     * @param $fileName
     * @param bool $isThumb
     * @return null|resource
     */
    public function imageIntervention($fileName, $isThumb = false)
	{
		$source = request()->file($fileName);
        return $isThumb ? Image::make($source)->orientate()->fit(200, 120)->stream()->detach() : Image::make($source)->orientate()->fit(1920, 1080)->stream()->detach();
	}

    /**
     * @param $fileName
     * @return null|resource
     */
    public function messageImageIntervention($fileName)
    {
        $source = request()->file($fileName);
        return Image::make($source)
            ->resize(640, null, function ($constraint) {
                $constraint->aspectRatio();
            })
            ->orientate()->stream()->detach();
    }
}