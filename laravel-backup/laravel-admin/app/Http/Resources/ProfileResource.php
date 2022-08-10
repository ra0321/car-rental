<?php

namespace App\Http\Resources;

use App\DriverLicence;
use App\ID_Card;
use Illuminate\Http\Resources\Json\JsonResource;

class ProfileResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $idCard = ID_Card::lastIdCard($this)->first();
        $dlCard = DriverLicence::lastDLCard($this)->first();
        return [
            'user_id' => $this->user_id,
            'works' => $this->works,
            'address' => $this->address,
            'school' => $this->school,
            'language' => $this->language,
            'about_me' => $this->about_me,
            'profile_photo' => $this->profile_photo,
            'profile_photo_header' => $this->profile_photo_header,
            #'id_card' => $idCard,
            'first_name' => isset($idCard->first_name) ? $idCard->first_name : null,
            'last_name' => isset($idCard->last_name) ? $idCard->last_name : null,
            'middle_name' => isset($idCard->middle_name) ? $idCard->middle_name : null,
            'dob' => isset($idCard->dob) ? $idCard->dob : null,
            'id_city' => isset($idCard->id_city) ? $idCard->id_city : null,
            'id_country' => isset($idCard->id_country) ? $idCard->id_country : null,
            'id_state' => isset($idCard->id_state) ? $idCard->id_state : null,
            'id_number' => isset($idCard->id_number) ? $idCard->id_number : null,
            'issued_by' => isset($idCard->issued_by) ? $idCard->issued_by : null,
            'id_image_path' => isset($idCard->image_path) ? $idCard->image_path : null,
            'id_image_path_small' => isset($idCard->image_path_small) ? $idCard->image_path_small : null,
            'expiration_date' => isset($idCard->expiration_date) ? $idCard->expiration_date : null,
            'date_of_issue' => isset($idCard->date_of_issue) ? $idCard->date_of_issue : null,
            'expired' => isset($idCard->expired) ? $idCard->expired : null,
            'id_created_at' => isset($idCard->created_at) ? $idCard->created_at : null,
            'id_updated_at' => isset($idCard->updated_at) ? $idCard->updated_at : null,
            #'driver_licence' => $dlCard,
            'driver_licence_data_of_issue' => isset($dlCard->date_of_issue) ? $dlCard->date_of_issue : null,
            'driver_licence_expiration_date' => isset($dlCard->expiration_date) ? $dlCard->expiration_date : null,
            'driver_licence_number' => isset($dlCard->dl_number) ? $dlCard->dl_number : null,
            'driver_licence_image_path' => isset($dlCard->image_path) ? $dlCard->image_path : null,
            'driver_licence_image_path_small' => isset($dlCard->image_path_small) ? $dlCard->image_path_small : null,
        ];
    }
}
