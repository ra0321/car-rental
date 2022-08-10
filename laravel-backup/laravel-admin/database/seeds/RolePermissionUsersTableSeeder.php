<?php

use Illuminate\Database\Seeder;

use App\User;
use Faker\Generator as Faker;
use Illuminate\Support\Str;
use App\Helpers\FakerHelper;
class RolePermissionUsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(Faker $faker)
    {
        
		$this->createUser($faker);
				
	}

	/**
	 * Create a user with given role
	*
	* @param $role
	*/
	private function createUser($faker)
	{
		/*
		for($i=0; $i<=30000; $i++){
			$user = factory(User::class)->create();

		}
		*/
		$user = new User();
		for($i=2535; $i<=30000; $i++){
			$user->id = $i;
			$user->first_name = $faker->name;
			$user->last_name = $faker->name;
			$user->phone_number = $faker->phoneNumber;
			$user->email = $faker->unique()->safeEmail;
			$user->password = '$2y$10$TKh8H1.PfQx37YgCzwiKb.KjNyWgaHb9cbcoQgdIVFlYg7B77UdFm'; // password
			$user->currency_type = random_int(3, 4);
			$user->country_code = Str::random(5);
			$user->phone_number = $faker->phoneNumber;
			$user->email_verified = (bool)random_int(0, 1);
			$user->phone_verified = (bool)random_int(0, 1);
			$user->approved_to_drive = (bool)random_int(0, 1);
			$user->id_verified = (bool)random_int(0, 1);
			$user->save();
		}
		
		$strings = array(
			'automatic',
			'manual',
		);
		shuffle($strings);

		$renter_confirm_trip = array(
			'waiting',
			'confirmed',
			'canceled',
			'shortened',
		);
		shuffle($renter_confirm_trip);

		$owner_confirm_trip = array(
			'waiting',
			'confirmed',
			'canceled',
		);
		shuffle($owner_confirm_trip);


		$status = array(
			'waiting',
			'started',
			'canceled',
			'finished',
		);
		shuffle($status);


		$owner_confirm_trip_update = array(
			'waiting',
			'rejected',
			'accepted',
			'auto_rejected',
		);
		shuffle($owner_confirm_trip_update);


		$users = User::all();
		foreach($users as $user){
			/*
			$addProfile = new \App\Profile();
			$path = public_path('users/' . $user->id . '/profile');
			if(!File::isDirectory($path)){

				File::makeDirectory($path, 0777, true, true);
		
			}
			$url = $faker->imageUrl(300, 400);
			$this->saveFile($url, $path.'/user.jpg');
			$addProfile->user_id = $user->id;
			$addProfile->works = $faker->name;
			$addProfile->profile_photo = 'http://127.0.0.1:8000/users/' . $user->id . '/profile/user.jpg';
			$addProfile->original_image_path = 'http://127.0.0.1:8000/users/' . $user->id . '/profile/user.jpg';
			$addProfile->profile_photo_header = 'http://127.0.0.1:8000/users/' . $user->id . '/profile/user.jpg';
			$addProfile->address = $faker->address;
			$addProfile->save();
			
			$addCar = new \App\Car();
			$addCar->user_id = $user->id;
			$addCar->long_location = $faker->longitude($min = -180, $max = 180);
			$addCar->lat_location = $faker->latitude($min = -90, $max = 90);
			$addCar->car_city = $faker->city;
			$addCar->car_manufacturer = $faker->name;
			$addCar->car_manufacturer_arabic = $faker->name;
			$addCar->car_model = $faker->name;
			$addCar->production_year = $faker->year($max = 'now');
			$addCar->model_class = $faker->name;
			$addCar->car_transmission = reset($strings);
			$addCar->brended = (bool)random_int(0, 1);
			$addCar->car_value = $faker->randomNumber(2);
			$addCar->vehicle_type = $faker->name;
			$addCar->vehicle_type_arabic = $faker->name;
			$addCar->weekend_trip = (bool)random_int(0, 1);
			$addCar->long_term_trip = (bool)random_int(0, 1);
			$addCar->is_registration_car_verified = (bool)random_int(0, 1);
			$addCar->is_insurance_verified = (bool)random_int(0, 1);
			$addCar->car_is_active = (bool)random_int(0, 1);
			$addCar->is_deleted = (bool)random_int(0, 1);
			$addCar->paid_advertising = (bool)random_int(0, 1);
			$addCar->save();

			

			$addTrip = new \App\Trip();
			$addTrip->owner_id = $user->id;
			$addTrip->car_id = random_int(6, 1000);
			$addTrip->renter_id = random_int(10, 1000);
			$addTrip->delivery_on_airport = (bool)random_int(0, 1);
			$addTrip->delivery_on_car_location = (bool)random_int(0, 1);
			$addTrip->delivery_on_renter_location = (bool)random_int(0, 1);
			$addTrip->renter_confirm_trip = reset($renter_confirm_trip);
			$addTrip->owner_confirm_trip = reset($owner_confirm_trip);
			$addTrip->status = reset($status);
			$addTrip->renter_confirm_trip_update = (bool)random_int(0, 1);
			$addTrip->owner_confirm_trip_update = reset($owner_confirm_trip_update);
			$addTrip->trip_modified = (bool)random_int(0, 1);
			$addTrip->i_agree = (bool)random_int(0, 1);
			$addTrip->save();
			*/
			/*
			$addCar = new \App\RentalCalculator();
			$addCar->phone = $faker->phoneNumber;
			$addCar->email = $faker->unique()->safeEmail;
			$addCar->car_manufacturer = $faker->name;
			$addCar->car_manufacturer_arabic = $faker->name;
			$addCar->car_model = $faker->name;
			$addCar->production_year = $faker->year($max = 'now');
			$addCar->model_class = $faker->name;
			$addCar->car_transmission = reset($strings);
			$addCar->car_value = $faker->randomNumber(2);
			$addCar->vehicle_type = $faker->name;
			$addCar->vehicle_type_arabic = $faker->name;
			$addCar->daily_price = $faker->randomNumber(2);
			$addCar->yearly_price = $faker->randomNumber(2);
			$addCar->save();
			*/
		}
		

			
	}

	public function saveFile($url, $filename){
		file_put_contents($filename, file_get_contents($url)); 
		echo "File downloaded!";
	}
}
