<?php

namespace App\Listeners\Car;

use App\Exceptions\CustomException;
use DB;
use App\CarRegistration;
use App\Traits\ApiResponser;
use App\Traits\ImageManager;
use Aws\S3\Exception\S3Exception;
use App\Events\Car\CarRegistrationEvent;
use PDOException;
use SebastianBergmann\Diff\Exception;
use Storage;

/**
 * Class StoreCarRegistration
 * @package App\Listeners\Car
 */
class StoreCarRegistration
{
    use ImageManager, ApiResponser;

    /**
     * @param $event
     * @throws CustomException
     */
    public function handle($event)
    {
        $carRegistration = new CarRegistration();
        $event->car['is_registration_car_verified'] = false;

        $file_name = 'licence_plate_image';
        $image_names = $this->imageName($file_name, false, true);
        $path = 'cars/' . $event->car->id . '/ids/';
        $bigImage = $this->makeBigSizeOfImage($file_name);
        $smallImage = $this->makeSmallSizeOfImage($file_name);

        try{
            DB::beginTransaction();
            try{
                $s3 = Storage::disk('s3');
                if(!$event->data['update']){
                    $s3->deleteDir('cars/' . $event->car->id . '/ids');
                }
                $s3->put($path . $image_names['big'], $bigImage, 'public');
                $s3->put($path . $image_names['small'], $smallImage, 'public');
            }catch(S3Exception $e){
                throw new CustomException(SOMETHING_WENT_WRONG);
            }

            $carRegistration['car_id'] = $event->car->id;
            $carRegistration['city'] = $event->data['city'];
            $carRegistration['state'] = $event->data['state'];
            $carRegistration['country'] = $event->data['country'];
            $carRegistration['licence_plate'] = $event->data['licence_plate'];
            $carRegistration['expiration_date'] = $event->data['expiration_date'];
            $carRegistration['date_of_issue'] = $event->data['date_of_issue'];
            $carRegistration['small_car_registration_image'] = Storage::path($path . $image_names['small']);
            $carRegistration['original_car_registration_image'] = Storage::path($path . $image_names['big']);
            $carRegistration['expired'] = false;
            $carRegistration->save();
            $event->car->save();
            DB::commit();
        }catch (PDOException $e){
            DB::rollBack();
            throw new CustomException(SOMETHING_WENT_WRONG);
        }
    }
}
