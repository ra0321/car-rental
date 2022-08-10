<?php


namespace App\Helpers;

use Pusher\PushNotifications\PushNotifications;
use App\User;
use App\Car;

class EsarPushNotifications
{
	public static function newUser($user)
	{
		$pushNotifications = new PushNotifications([
			'instanceId' => config('values.pusher_pn_instance_id'),
			'secretKey' => config('values.pusher_pn_secret_key'),
		]);
		$publishToInterestsResponse = $pushNotifications->publishToInterests(
			array("account" . $user->id),
			array(
				"fcm" => array(
					"data" => array(
						"id" => $user->id,
						"type" => 1,

						"titleEn" => "Welcome to ESAR",
						"bodyEn" => "Thanks for joining ESAR community. Your adventure starts here.",
						"titleAr" => "مرحباً بك في إيسار",
						"bodyAr" => "نشكرك لانضمامك إلى منصة إيسار لتأجير السيارات.",
					)
				),
				"apns" => array(
					"aps" => array(
						"alert" => array(
							"title-loc-key" => "Welcome to ESAR",
							"loc-key" => "Thanks for joining ESAR community. Your adventure starts here."
						),
						"badge" => 1,
						"sound" => "chime.aiff",
					),

					"data" => array(
						"id" => $user->id,
						"type" => 1,
					)
				)
			));
	}


	public static function carCreated($car)
	{
		$pushNotifications = new PushNotifications([
			'instanceId' => config('values.pusher_pn_instance_id'),
			'secretKey' => config('values.pusher_pn_secret_key'),
		]);
		$publishToInterestsResponse = $pushNotifications->publishToInterests(
			array("car" . $car->user_id),
			array(
				"fcm" => array(
					"data" => array(
						"id" => $car->id,
						"type" => 2,

						"titleEn" => "Car created",
						"bodyEn" => "Your " . $car->car_manufacturer . " " . $car->car_model . " is created.",
						"titleAr" => "تم إنشاء السيارة",
						"bodyAr" => "سيارتك" . $car->car_manufacturer . " " . $car->car_model .  "معروضة الآن  ويستطيع المستأجرين طلب استئجارها.
 
",
					)
				),
				"apns" => array(
					"aps" => array(
						"alert" => array(
							"title-loc-key" => "Car created",
							"loc-key" => "CAR_CREATED",
							"loc-args" => array(
								$car->car_manufacturer,
								$car->car_model
							)
						),
						"badge" => 1,
						"sound" => "chime.aiff",
					),
					"data" => array(
						"id" => $car->id,
						"type" => 2,
					)
				)
			));
	}

	public static function tripBookedInstantlyOwner($trip, $renter)
	{
		$car = Car::find($trip->car_id);
		$owner = User::find($trip->owner_id);

		$pushNotifications = new PushNotifications([
			'instanceId' => config('values.pusher_pn_instance_id'),
			'secretKey' => config('values.pusher_pn_secret_key'),
		]);
		$publishToInterestsResponse = $pushNotifications->publishToInterests(
			array("trip" . $owner->id),
			array(
				"fcm" => array(
					"data" => array(
						"id" => $trip->id,
						"type" => 32,
						'chat_id' => $trip->chat_id,
						"titleEn" => "Booked trip",
						"bodyEn" => $renter->first_name . " trip with your " . $car->car_manufacturer . " " . $car->car_model . " is booked.",
						"titleAr" => "الحجز مؤكد",
						"bodyAr" => "حجز " . $renter->first_name . " لسيارتك " . $car->car_manufacturer . " " . $car->car_model . "حجز مؤكد.
 
",
					)
				),
				"apns" => array(
					"aps" => array(
						"alert" => array(
							"title-loc-key" => "Booked trip",
							"loc-key" => "BOOKED_TRIP",
							"loc-args" => array(
								$renter->first_name,
								$car->car_model,
								$car->car_manufacturer
							)
						),
						"badge" => 1,
						"sound" => "chime.aiff",
					),

					"data" => array(
						"id" => $trip->id,
						"type" => 32,
						'chat_id' => $trip->chat_id
					)
				)
			));
	}

	public static function tripBookedInstantlyRenter($trip, $renter)
	{
		$car = Car::find($trip->car_id);
		$owner = User::find($trip->owner_id);

		$pushNotifications = new PushNotifications([
			'instanceId' => config('values.pusher_pn_instance_id'),
			'secretKey' => config('values.pusher_pn_secret_key'),
		]);
		$publishToInterestsResponse = $pushNotifications->publishToInterests(
			array("trip" . $renter->id),
			array(
				"fcm" => array(
					"data" => array(
						"id" => $trip->id,
						"type" => 3,
						'chat_id' => $trip->chat_id,
						"titleEn" => "Booked trip",
						"bodyEn" => "Your trip with" . $owner->first_name . " " . $car->car_manufacturer . " " . $car->car_model . " is booked. We’ve charged your payment method for the full trip cost.",
						"titleAr" => "الحجز مؤكد",
						"bodyAr" => "حجزك مع" . $owner->first_name . " " . $car->car_manufacturer . " " . $car->car_model .  "حجز مؤكد. و نفيدكم أنه تم تحصيل كامل مبلغ الحجز من بطاقتكم.",
					)
				),
				"apns" => array(
					"aps" => array(
						"alert" => array(
							"title-loc-key" => "Booked trip",
							"loc-key" => "BOOKED_TRIP_WITH_PAYMENT",
							"loc-args" => array(
								$car->car_manufacturer,
								$car->car_model,
								$owner->first_name
							)
						),
						"badge" => 1,
						"sound" => "chime.aiff",
					),

					"data" => array(
						"id" => $trip->id,
						"type" => 3,
						'chat_id' => $trip->chat_id
					)
				)
			));
	}

	public static function pendingTripOwner($trip)
	{
		$car = Car::find($trip->car_id);
		$renter = User::find($trip->renter_id);
		$owner = User::find($trip->owner_id);

		$pushNotifications = new PushNotifications([
			'instanceId' => config('values.pusher_pn_instance_id'),
			'secretKey' => config('values.pusher_pn_secret_key'),
		]);
		$publishToInterestsResponse = $pushNotifications->publishToInterests(
			array("trip" . $owner->id),
			array(
				"fcm" => array(
					"data" => array(
						"id" => $trip->id,
						"type" => 23,
						'chat_id' => $trip->chat_id,
						"titleEn" => "Pending trip",
						"bodyEn" => $renter->first_name . " has requested to rent your " . $car->car_manufacturer . " " . $car->car_model . ".",
						"titleAr" => "حجز تحت الاجراء",
						"bodyAr" => "طلب" . $renter->first_name . "حجز سيارتك" . $car->car_manufacturer . " " . $car->car_model . ".",
					)
				),
				"apns" => array(
					"aps" => array(
						"alert" => array(
							"title-loc-key" => "Pending trip",
							"loc-key" => "RENT_REQUEST",
							"loc-args" => array(
								$renter->first_name,
								$car->car_manufacturer,
								$car->car_model
							)
						),
						"badge" => 1,
						"sound" => "chime.aiff",
					),

					"data" => array(
						"id" => $trip->id,
						"type" => 23,
						'chat_id' => $trip->chat_id
					)
				)
			));
	}

	public static function pendingTripRenter($trip)
	{
		$car = Car::find($trip->car_id);
		$owner = User::find($trip->owner_id);
		$renter = User::find($trip->renter_id);

		$pushNotifications = new PushNotifications([
			'instanceId' => config('values.pusher_pn_instance_id'),
			'secretKey' => config('values.pusher_pn_secret_key'),
		]);
		$publishToInterestsResponse = $pushNotifications->publishToInterests(
			array("trip" . $renter->id),
			array(
				"fcm" => array(
					"data" => array(
						"id" => $trip->id,
						"type" => 4,
						'chat_id' => $trip->chat_id,
						"titleEn" => "Pending trip",
						"bodyEn" => "You’ve requested to rent " . $owner->first_name . " " . $car->car_manufacturer . " " . $car->car_model . ". You may see a temporary payment authorization your payment method for this trip, but you won’t be charged until your trip is confirmed.",
						"titleAr" => "حجز تحت الاجراء",
						"bodyAr" => "انت طلبت حجز سيارة" . $car->car_manufacturer . " " . $car->car_model . " " . $owner->first_name . " يحتاج بعض الوقت للتأكيد علما انه لم يتم تحصيل رسوم الرحلة بعد ولكن تم حجز إجمالي مبلغ الرحلة بشكل مؤقت. و سوف يتم تحصيل كامل الرسوم بعد تأكيد الحجز.",
					)
				),
				"apns" => array(
					"aps" => array(
						"alert" => array(
							"title-loc-key" => "Pending trip",
							"loc-key" => "YOUR_RENT_REQUEST",
							"loc-args" => array(
								$car->car_manufacturer,
								$car->car_model,
								$owner->first_name
							)
						),
						"badge" => 1,
						"sound" => "chime.aiff",
					),

					"data" => array(
						"id" => $trip->id,
						"type" => 4,
						'chat_id' => $trip->chat_id
					)
				)
			));
	}

	public static function autoCancelOwner($trip)
	{
		$car = Car::find($trip->car_id);
		$owner = User::find($trip->owner_id);
		$renter = User::find($trip->renter_id);

		$pushNotifications = new PushNotifications([
			'instanceId' => config('values.pusher_pn_instance_id'),
			'secretKey' => config('values.pusher_pn_secret_key'),
		]);
		$publishToInterestsResponse = $pushNotifications->publishToInterests(
			array("trip" . $owner->id),
			array(
				"fcm" => array(
					"data" => array(
						"id" => $trip->id,
						"type" => 22,
						'chat_id' => $trip->chat_id,
						"titleEn" => "Declined trip",
						"bodyEn" => $renter->first_name . " trip with your "  . $car->car_manufacturer . " " . $car->car_model . " was automatically declined after you didn’t respond for 5 hours.",
						"titleAr" => "حجز مرفوض",
						"bodyAr" => "حجز " .  $renter->first_name . " لسيارتك " . $car->car_manufacturer . " " . $car->car_model . " تم رفضه االياً لأنك لم تستجيب خلال ٥ ساعات من وقت إرسال الطلب.",
					)
				),
				"apns" => array(
					"aps" => array(
						"alert" => array(
							"title-loc-key" => "Declined trip",
							"loc-key" => "TRIP_AUTO_DECLINED_1",
							"loc-args" => array(
								$renter->first_name,
								$car->car_manufacturer,
								$car->car_model
							)
						),
						"badge" => 1,
						"sound" => "chime.aiff",
					),

					"data" => array(
						"id" => $trip->id,
						"type" => 22,
						'chat_id' => $trip->chat_id
					)
				)
			));
	}

	public static function autoCancelRenter($trip)
	{
		$car = Car::find($trip->car_id);
		$owner = User::find($trip->owner_id);
		$renter = User::find($trip->renter_id);

		$pushNotifications = new PushNotifications([
			'instanceId' => config('values.pusher_pn_instance_id'),
			'secretKey' => config('values.pusher_pn_secret_key'),
		]);
		$publishToInterestsResponse = $pushNotifications->publishToInterests(
			array("trip" . $renter->id),
			array(
				"fcm" => array(
					"data" => array(
						"id" => $trip->id,
						"type" => 5,
						'chat_id' => $trip->chat_id,
						"titleEn" => "Declined trip",
						"bodyEn" => "Your trip with " . $owner->first_name . " "  . $car->car_manufacturer . " " . $car->car_model . " was automatically declined after owner didn’t respond for 5 hours.",
						"titleAr" => "تم رفض الحجز",
						"bodyAr" => "حجزك مع " . $owner->first_name . " "  . $car->car_manufacturer . " " . $car->car_model . " تم رفضه  الياً لأن المؤجر لم يستجيب خلال ٥ ساعات من وقت إرسال الطلب.",
					)
				),
				"apns" => array(
					"aps" => array(
						"alert" => array(
							"title-loc-key" => "Declined trip",
							"loc-key" => "TRIP_AUTO_DECLINED_2",
							"loc-args" => array(
								$car->car_manufacturer,
								$car->car_model,
								$owner->first_name
							)
						),
						"badge" => 1,
						"sound" => "chime.aiff",
					),

					"data" => array(
						"id" => $trip->id,
						"type" => 5,
						'chat_id' => $trip->chat_id
					)
				)
			));
	}

	public static function rejectedTripOwner($trip)
	{
		$car = Car::find($trip->car_id);
		$owner = User::find($trip->owner_id);
		$renter = User::find($trip->renter_id);

		$pushNotifications = new PushNotifications([
			'instanceId' => config('values.pusher_pn_instance_id'),
			'secretKey' => config('values.pusher_pn_secret_key'),
		]);
		$publishToInterestsResponse = $pushNotifications->publishToInterests(
			array("trip" . $owner->id),
			array(
				"fcm" => array(
					"data" => array(
						"id" => $trip->id,
						"type" => 24,
						'chat_id' => $trip->chat_id,
						"titleEn" => "Rejected trip",
						"bodyEn" => "You rejected " . $renter->first_name . " trip with your "  . $car->car_manufacturer . " " . $car->car_model . ".",
						"titleAr" => "حجز مرفوض",
						"bodyAr" => "انت رفضت طلب الحجز الخاص بي " . $renter->first_name . " لسيارتك "  . $car->car_manufacturer . " " . $car->car_model . ".",
					)
				),
				"apns" => array(
					"aps" => array(
						"alert" => array(
							"title-loc-key" => "Rejected trip",
							"loc-key" => "YOUR_TRIP_REJECTION",
							"loc-args" => array(
								$renter->first_name,
								$car->car_manufacturer,
								$car->car_model
							)
						),
						"badge" => 1,
						"sound" => "chime.aiff",
					),

					"data" => array(
						"id" => $trip->id,
						"type" => 24,
						'chat_id' => $trip->chat_id
					)
				)
			));
	}

	public static function rejectedTripRenter($trip)
	{
		$car = Car::find($trip->car_id);
		$owner = User::find($trip->owner_id);
		$renter = User::find($trip->renter_id);

		$pushNotifications = new PushNotifications([
			'instanceId' => config('values.pusher_pn_instance_id'),
			'secretKey' => config('values.pusher_pn_secret_key'),
		]);
		$publishToInterestsResponse = $pushNotifications->publishToInterests(
			array("trip" . $renter->id),
			array(
				"fcm" => array(
					"data" => array(
						"id" => $trip->id,
						"type" => 6,
						'chat_id' => $trip->chat_id,
						"titleEn" => "Rejected trip",
						"bodyEn" => $owner->first_name . " rejected your trip with his "  . $car->car_manufacturer . " " . $car->car_model . ". We’re sorry things didn’t work out. Because owner cancelled your trip, all charges to your card will be refunded.",
						"titleAr" => "تم رفض الحجز",
						"bodyAr" => $owner->first_name . "رفض طلبكم لحجز سيارته "  . $car->car_manufacturer . " " . $car->car_model . ". نحن نأسف بأن الأمور لم تسير كما هو مخطط لها. وبما أن المؤجر رفض طلبكم سوف يتم ارجاع جميع المبالغ المحجوزة الى بطاقتكم.",
					)
				),
				"apns" => array(
					"aps" => array(
						"alert" => array(
							"title-loc-key" => "Rejected trip",
							"loc-key" => "TRIP_REJECTED",
							"loc-args" => array(
								$owner->first_name,
								$car->car_manufacturer,
								$car->car_model
							)
						),
						"badge" => 1,
						"sound" => "chime.aiff",
					),

					"data" => array(
						"id" => $trip->id,
						"type" => 6,
						'chat_id' => $trip->chat_id
					)
				)
			));
	}

	public static function carStatus($user, $carUnlisted)
	{
		$car = Car::find($carUnlisted->car_id);
		if($carUnlisted->car_status == 'unlisted')
		{
			$pushNotifications = new PushNotifications([
				'instanceId' => config('values.pusher_pn_instance_id'),
				'secretKey' => config('values.pusher_pn_secret_key'),
			]);
			$publishToInterestsResponse = $pushNotifications->publishToInterests(
				array("car" . $user->id),
				array(
					"fcm" => array(
						"data" => array(
							"id" => $car->id,
							"type" => 7,

							"titleEn" => "Car " . $carUnlisted->car_status . ".",
							"bodyEn" => "Your " . $car->car_manufacturer . " " . $car->car_model . " is " . $carUnlisted->car_status . ".",
							"titleAr" => "تم إزالة السيارة",
							"bodyAr" => "تم إزالة سيارتكم " . $car->car_manufacturer . " " . $car->car_model . " من قائمة العرض.",
						)
					),
					"apns" => array(
						"aps" => array(
							"alert" => array(
								"title-loc-key" => "Car unlisted",
								"loc-key" => "CAR_UNLISTED",
								"loc-args" => array(
									$car->car_manufacturer,
									$car->car_model,
									$carUnlisted->car_status
								)
							),
							"badge" => 1,
							"sound" => "chime.aiff",
						),

						"data" => array(
							"id" => $car->id,
							"type" => 7,
						)
					)
				));
		}
		if($carUnlisted->car_status == 'snoozed')
		{
			$pushNotifications = new PushNotifications([
				'instanceId' => config('values.pusher_pn_instance_id'),
				'secretKey' => config('values.pusher_pn_secret_key'),
			]);
			$publishToInterestsResponse = $pushNotifications->publishToInterests(
				array("car" . $user->id),
				array(
					"fcm" => array(
						"data" => array(
							"id" => $car->id,
							"type" => 7,

							"titleEn" => "Car " . $carUnlisted->car_status . ".",
							"bodyEn" => "Your " . $car->car_manufacturer . " " . $car->car_model . " is " . $carUnlisted->car_status . ".",
							"titleAr" => "تم إخفاء السيارة",
							"bodyAr" => "سيارتكم " . $car->car_manufacturer . " " . $car->car_model . " الان مخفية في الفترة المحددة ولا يستطيع المستأجرين مشاهدتها.",
						)
					),
					"apns" => array(
						"aps" => array(
							"alert" => array(
								"title-loc-key" => "Car snoozed",
								"loc-key" => "CAR_SNOOZED",
								"loc-args" => array(
									$car->car_manufacturer,
									$car->car_model,
									$carUnlisted->car_status
								)
							),
							"badge" => 1,
							"sound" => "chime.aiff",
						),

						"data" => array(
							"id" => $car->id,
							"type" => 7,
						)
					)
				));
		}
		if($carUnlisted->car_status == 'listed')
		{
			$pushNotifications = new PushNotifications([
				'instanceId' => config('values.pusher_pn_instance_id'),
				'secretKey' => config('values.pusher_pn_secret_key'),
			]);
			$publishToInterestsResponse = $pushNotifications->publishToInterests(
				array("car" . $user->id),
				array(
					"fcm" => array(
						"data" => array(
							"id" => $car->id,
							"type" => 7,

							"titleEn" => "Car " . $carUnlisted->car_status . ".",
							"bodyEn" => "Your " . $car->car_manufacturer . " " . $car->car_model . " is " . $carUnlisted->car_status . ".",
							"titleAr" => "تم إعادة عرض السيارة",
							"bodyAr" => "السيارة  " . $car->car_manufacturer . " " . $car->car_model . " تم إعادة عرضها و سوف تظهر للمستأجرين في البحث.",
						)
					),
					"apns" => array(
						"aps" => array(
							"alert" => array(
								"title-loc-key" => "Car listed",
								"loc-key" => "CAR_LISTED",
								"loc-args" => array(
									$car->car_manufacturer,
									$car->car_model,
									$carUnlisted->car_status
								)
							),
							"badge" => 1,
							"sound" => "chime.aiff",
						),

						"data" => array(
							"id" => $car->id,
							"type" => 7,
						)
					)
				));
		}
		if($carUnlisted->car_status == 'deleted')
		{
			$pushNotifications = new PushNotifications([
				'instanceId' => config('values.pusher_pn_instance_id'),
				'secretKey' => config('values.pusher_pn_secret_key'),
			]);
			$publishToInterestsResponse = $pushNotifications->publishToInterests(
				array("car" . $user->id),
				array(
					"fcm" => array(
						"data" => array(
							"id" => $car->id,
							"type" => 7,

							"titleEn" => "Car " . $carUnlisted->car_status . ".",
							"bodyEn" => "Your " . $car->car_manufacturer . " " . $car->car_model . " is " . $carUnlisted->car_status . ".",
							"titleAr" => "تم حذف السيارة",
							"bodyAr" => "السيارة " . $car->car_manufacturer . " " . $car->car_model . " تم حذفها من المنصة بنجاح.",
						)
					),
					"apns" => array(
						"aps" => array(
							"alert" => array(
								"title-loc-key" => "Car deleted",
								"loc-key" => "CAR_DELETED",
								"loc-args" => array(
									$car->car_manufacturer,
									$car->car_model,
									$carUnlisted->car_status
								)
							),
							"badge" => 1,
							"sound" => "chime.aiff",
						),

						"data" => array(
							"id" => $car->id,
							"type" => 7,
						)
					)
				));
		}
	}

	public static function insuranceExpired($car)
	{
		$pushNotifications = new PushNotifications([
			'instanceId' => config('values.pusher_pn_instance_id'),
			'secretKey' => config('values.pusher_pn_secret_key'),
		]);
		$publishToInterestsResponse = $pushNotifications->publishToInterests(
			array("car" . $car->user_id),
			array(
				"fcm" => array(
					"data" => array(
						"id" => $car->id,
						"type" => 8,

						"titleEn" => "Insurance is expired",
						"bodyEn" => "Insurance for your " . $car->car_manufacturer . " " . $car->car_model . " is expired. Car is removed from search until you upload a new insurance card.",
						"titleAr" => "التأمين سوف ينتهي قريباً",
						"bodyAr" => "التأمين الخاص بسيارتك " . $car->car_manufacturer . " " . $car->car_model . " سوف ينتهي قريباً علما أنك لن تستطيع تأجير السيارة حتى تقوم بتحميل تأمين ساري المفعول.",
					)
				),
				"apns" => array(
					"aps" => array(
						"alert" => array(
							"title-loc-key" => "Insurance is expired",
							"loc-key" => "INSURANCE_EXPIRES_SOON",
							"loc-args" => array(
								$car->car_manufacturer,
								$car->car_model,
							)
						),
						"badge" => 1,
						"sound" => "chime.aiff",
					),

					"data" => array(
						"id" => $car->id,
						"type" => 8,
					)
				)
			));
	}

	public static function registrationExpired($car)
	{
		$pushNotifications = new PushNotifications([
			'instanceId' => config('values.pusher_pn_instance_id'),
			'secretKey' => config('values.pusher_pn_secret_key'),
		]);
		$publishToInterestsResponse = $pushNotifications->publishToInterests(
			array("car" . $car->user_id),
			array(
				"fcm" => array(
					"data" => array(
						"id" => $car->id,
						"type" => 9,

						"titleEn" => "Car registration is expired",
						"bodyEn" => "Car registration for your  " . $car->car_manufacturer . " " . $car->car_model . " is expired. Car is removed from search until you upload a new registration card.",
						"titleAr" => "رخصة سير السيارة سوف تنتهي قريباً",
						"bodyAr" => "رخصة السير الخاصة بسيارتك " . $car->car_manufacturer . " " . $car->car_model . " سوف تنتهي  قريباً  علما أنك لن تستطيع تأجير السيارة حتى تقوم بتحميل رخصة سير سارية المفعول.",
					)
				),
				"apns" => array(
					"aps" => array(
						"alert" => array(
							"title-loc-key" => "Car registration is expired",
							"loc-key" => "CAR_REGISTRATION_EXPIRES_SOON",
							"loc-args" => array(
								$car->car_manufacturer,
								$car->car_model,
							)
						),
						"badge" => 1,
						"sound" => "chime.aiff",
					),

					"data" => array(
						"id" => $car->id,
						"type" => 9,
					)
				)
			));
	}

	public static function licenceExpired($user)
	{
		$pushNotifications = new PushNotifications([
			'instanceId' => config('values.pusher_pn_instance_id'),
			'secretKey' => config('values.pusher_pn_secret_key'),
		]);
		$publishToInterestsResponse = $pushNotifications->publishToInterests(
			array("account" . $user->id),
			array(
				"fcm" => array(
					"data" => array(
						"id" => $user->id,
						"type" => 10,

						"titleEn" => "Driver’s license is expired",
						"bodyEn" => "Your driver’s license is expired. You can't book any trip until you upload your new driver's license.",
						"titleAr" => "رخصة القيادة سوف تنتهي قريبا",
						"bodyAr" => "رخصة القيادة الخاصة بك سوف تنتهي قريباً. علما أنك لن تستطيع حجز أي سيارة حتى تقوم بتحميل رخصة سارية المفعول.",
					)
				),
				"apns" => array(
					"aps" => array(
						"alert" => array(
							"title-loc-key" => "Driver’s license is expired",
							"loc-key" => "Your driver’s license is expired. You can't book any trip until you upload your new driver's license."
						),
						"badge" => 1,
						"sound" => "chime.aiff",
					),

					"data" => array(
						"id" => $user->id,
						"type" => 10,
					)
				)
			));
	}

	public static function idCardExpired($user)
	{
		$pushNotifications = new PushNotifications([
			'instanceId' => config('values.pusher_pn_instance_id'),
			'secretKey' => config('values.pusher_pn_secret_key'),
		]);
		$publishToInterestsResponse = $pushNotifications->publishToInterests(
			array("account" . $user->id),
			array(
				"fcm" => array(
					"data" => array(
						"id" => $user->id,
						"type" => 30,

						"titleEn" => "ID is expired",
						"bodyEn" => "Your ID is expired. You can't book any trip or rent out any of your cars until you upload your new ID.",
						"titleAr" => "الهوية سوف تنتهي قريباً",
						"bodyAr" => "بطاقة الهوية سوف تنتهي  قريباً علما أنك لن تستطيع حجز أي سيارة حتى تقوم بتحميل بطاقة هوية سارية المفعول ",
					)
				),
				"apns" => array(
					"aps" => array(
						"alert" => array(
							"title-loc-key" => "ID is expired",
							"loc-key" => "Your ID is expired. You can't book any trip or rent out any of your cars until you upload your new ID."
						),
						"badge" => 1,
						"sound" => "chime.aiff",
					),

					"data" => array(
						"id" => $user->id,
						"type" => 30,
					)
				)
			));
	}


	public static function acceptedTripOwner($trip)
	{
		$car = Car::find($trip->car_id);
		$owner = User::find($trip->owner_id);
		$renter = User::find($trip->renter_id);
		//$bill = TripBill::where('trip_id', $this->trip->id)->first();

		$pushNotifications = new PushNotifications([
			'instanceId' => config('values.pusher_pn_instance_id'),
			'secretKey' => config('values.pusher_pn_secret_key'),
		]);
		$publishToInterestsResponse = $pushNotifications->publishToInterests(
			array("trip" . $owner->id),
			array(
				"fcm" => array(
					"data" => array(
						"id" => $trip->id,
						"type" => 19,
						'chat_id' => $trip->chat_id,
						"titleEn" => "Confirmed trip",
						"bodyEn" => $renter->first_name . " trip with your "  . $car->car_manufacturer . " " . $car->car_model . " is booked.",
						"titleAr" => "حجز مؤكد",
						"bodyAr" => "جز " . $renter->first_name . " لسيارتك "  . $car->car_manufacturer . " " . $car->car_model . "حجز مؤكد.",
					)
				),
				"apns" => array(
					"aps" => array(
						"alert" => array(
							"title-loc-key" => "Confirmed trip",
							"loc-key" => "BOOKED_TRIP",
							"loc-args" => array(
								$renter->first_name,
								$car->car_manufacturer,
								$car->car_model
							)
						),
						"badge" => 1,
						"sound" => "chime.aiff",
					),

					"data" => array(
						"id" => $trip->id,
						"type" => 19,
						'chat_id' => $trip->chat_id
					)
				)
			));
	}

	public static function acceptedTripRenter($trip)
	{
		$car = Car::find($trip->car_id);
		$owner = User::find($trip->owner_id);
		$renter = User::find($trip->renter_id);
		//$bill = TripBill::where('trip_id', $this->trip->id)->first();

		$pushNotifications = new PushNotifications([
			'instanceId' => config('values.pusher_pn_instance_id'),
			'secretKey' => config('values.pusher_pn_secret_key'),
		]);
		$publishToInterestsResponse = $pushNotifications->publishToInterests(
			array("trip" . $renter->id),
			array(
				"fcm" => array(
					"data" => array(
						"id" => $trip->id,
						"type" => 11,
						'chat_id' => $trip->chat_id,
						"titleEn" => "Confirmed trip",
						"bodyEn" => "Your trip with " . $owner->first_name . " "  . $car->car_manufacturer . " " . $car->car_model . " is booked. We’ve charged your payment method for the full trip cost.",
						"titleAr" => "تم تأكيد الحجز",
						"bodyAr" => "حجزك تم تأكيده مع" . $car->car_manufacturer . " " . $car->car_model . " " . $owner->first_name . "كما نحيطكم علما أنه تم تحصيل كامل مبلغ الحجز من بطاقتكم.",
					)
				),
				"apns" => array(
					"aps" => array(
						"alert" => array(
							"title-loc-key" => "Confirmed trip",
							"loc-key" => "BOOKED_TRIP_WITH_PAYMENT",
							"loc-args" => array(
								$owner->first_name,
								$car->car_manufacturer,
								$car->car_model
							)
						),
						"badge" => 1,
						"sound" => "chime.aiff",
					),

					"data" => array(
						"id" => $trip->id,
						"type" => 11,
						'chat_id' => $trip->chat_id
					)
				)
			));
	}

	public static function declinedTripChangeOwner($trip)
	{
		$car = Car::find($trip->car_id);
		$owner = User::find($trip->owner_id);
		$renter = User::find($trip->renter_id);
		//$bill = TripBill::where('trip_id', $this->trip->id)->first();

		$pushNotifications = new PushNotifications([
			'instanceId' => config('values.pusher_pn_instance_id'),
			'secretKey' => config('values.pusher_pn_secret_key'),
		]);
		$publishToInterestsResponse = $pushNotifications->publishToInterests(
			array("trip" . $owner->id),
			array(
				"fcm" => array(
					"data" => array(
						"id" => $trip->id,
						"type" => 29,
						'chat_id' => $trip->chat_id,
						"titleEn" => "Change request rejected",
						"bodyEn" => "You rejected " . $renter->first_name . " request to change his trip with your "  . $car->car_manufacturer . " " . $car->car_model . ".",
						"titleAr" => "طلب تعديل الحجز تم رفضه",
						"bodyAr" => "انت رفضت طلب " . $renter->first_name . " لتعديل حجز سيارتك "  . $car->car_manufacturer . " " . $car->car_model . " علما انه تفاصيل هذا الحجز سوف تبقى كما هي دون تغيير.",
					)
				),
				"apns" => array(
					"aps" => array(
						"alert" => array(
							"title-loc-key" => "Change request rejected",
							"loc-key" => "MODIFY_REJECT_1",
							"loc-args" => array(
								$renter->first_name,
								$car->car_manufacturer,
								$car->car_model
							)
						),
						"badge" => 1,
						"sound" => "chime.aiff",
					),

					"data" => array(
						"id" => $trip->id,
						"type" => 29,
						'chat_id' => $trip->chat_id
					)
				)
			));
	}

	public static function declinedTripChangeRenter($trip)
	{
		$car = Car::find($trip->car_id);
		$owner = User::find($trip->owner_id);
		$renter = User::find($trip->renter_id);
		//$bill = TripBill::where('trip_id', $this->trip->id)->first();

		$pushNotifications = new PushNotifications([
			'instanceId' => config('values.pusher_pn_instance_id'),
			'secretKey' => config('values.pusher_pn_secret_key'),
		]);
		$publishToInterestsResponse = $pushNotifications->publishToInterests(
			array("trip" . $owner->id),
			array(
				"fcm" => array(
					"data" => array(
						"id" => $trip->id,
						"type" => 14,
						'chat_id' => $trip->chat_id,
						"titleEn" => "Change request rejected",
						"bodyEn" => $owner->first_name . " rejected your change request with his "  . $car->car_manufacturer . " " . $car->car_model . ".",
						"titleAr" => "طلب تعديل الحجز تم رفضه",
						"bodyAr" => "انت رفضت طلب " . $renter->first_name . " لتعديل حجز سيارتك "  . $car->car_manufacturer . " " . $car->car_model . " علما انه تفاصيل هذا الحجز سوف تبقى كما هي دون تغيير.",
					)
				),
				"apns" => array(
					"aps" => array(
						"alert" => array(
							"title-loc-key" => "Change request rejected",
							"loc-key" => "MODIFY_REJECT_2",
							"loc-args" => array(
								$owner->first_name,
								$car->car_manufacturer,
								$car->car_model
							)
						),
						"badge" => 1,
						"sound" => "chime.aiff",
					),

					"data" => array(
						"id" => $trip->id,
						"type" => 14,
						'chat_id' => $trip->chat_id
					)
				)
			));
	}

	public static function tripFinishedOwner($trip)
	{
		$car = Car::find($trip->car_id);
		$owner = User::find($trip->owner_id);
		$renter = User::find($trip->renter_id);
		//$bill = TripBill::where('trip_id', $this->trip->id)->first();

		$pushNotifications = new PushNotifications([
			'instanceId' => config('values.pusher_pn_instance_id'),
			'secretKey' => config('values.pusher_pn_secret_key'),
		]);
		$publishToInterestsResponse = $pushNotifications->publishToInterests(
			array("trip" . $owner->id),
			array(
				"fcm" => array(
					"data" => array(
						"id" => $trip->id,
						"type" => 25,
						'chat_id' => $trip->chat_id,
						"titleEn" => "Trip finished",
						"bodyEn" => $renter->first_name . " trip with your "  . $car->car_manufacturer . " " . $car->car_model . " is finished. Please rate your guest to let him know what he did well, help him improve, and help future owners choose him as renter",
						"titleAr" => "لديك رحلة انتهت",
						"bodyAr" => "أنت أنهيت رحلة " . $renter->first_name . " مع سيارتك "  . $car->car_manufacturer . " " . $car->car_model . " .كما نرجوا منك تقييم المستأجر" . $renter->first_name . " حتى يستفيد من رأيكم وأيضاً مساعدة المؤجرين الاخرين في اختيار المستأجر المناسب لهم.",

					)
				),
				"apns" => array(
					"aps" => array(
						"alert" => array(
							"title-loc-key" => "Trip finished",
							"loc-key" => "TRIP_FINISHED_1",
							"loc-args" => array(
								$renter->first_name,
								$car->car_manufacturer,
								$car->car_model
							)
						),
						"badge" => 1,
						"sound" => "chime.aiff",
					),

					"data" => array(
						"id" => $trip->id,
						"type" => 25,
						'chat_id' => $trip->chat_id
					)
				)
			));
	}

	public static function tripFinishedRenter($trip)
	{
		$car = Car::find($trip->car_id);
		$owner = User::find($trip->owner_id);
		$renter = User::find($trip->renter_id);
		//$bill = TripBill::where('trip_id', $this->trip->id)->first();

		$pushNotifications = new PushNotifications([
			'instanceId' => config('values.pusher_pn_instance_id'),
			'secretKey' => config('values.pusher_pn_secret_key'),
		]);
		$publishToInterestsResponse = $pushNotifications->publishToInterests(
			array("trip" . $renter->id),
			array(
				"fcm" => array(
					"data" => array(
						"id" => $trip->id,
						"type" => 15,
						'chat_id' => $trip->chat_id,
						"titleEn" => "Your trip is finished",
						"bodyEn" => "Your trip with " . $owner->first_name . " " . $car->car_manufacturer . " " . $car->car_model . "  is finished. Please rate your host and his car to let him know what he did well, help him improve, and help future travelers choose the right car.",
						"titleAr" => "رحلتك انتهت",
						"bodyAr" => "رحلتك مع " . $owner->first_name . " للسيارة "  . $car->car_manufacturer . " " . $car->car_model . " .انتهت . كما نرجوا منك تقييم حجزكم الاخير مع" . $owner->first_name . " " . $car->car_manufacturer . " " . $car->car_model . " حتى يستفيد من رأيكم و مساعدته في الارتقاء بخدمته وأيضاً مساعدة المستأجرين الاخرين في اختيار السيارة المناسبة لهم.",

					)
				),
				"apns" => array(
					"aps" => array(
						"alert" => array(
							"title-loc-key" => "Trip finished",
							"loc-key" => "TRIP_FINISHED_2",
							"loc-args" => array(
								$owner->first_name,
								$car->car_manufacturer,
								$car->car_model
							)
						),
						"badge" => 1,
						"sound" => "chime.aiff",
					),

					"data" => array(
						"id" => $trip->id,
						"type" => 15,
						'chat_id' => $trip->chat_id
					)
				)
			));
	}

	public static function tripStartedOwner($trip)
	{
		$car = Car::find($trip->car_id);
		$owner = User::find($trip->owner_id);
		$renter = User::find($trip->renter_id);
		//$bill = TripBill::where('trip_id', $this->trip->id)->first();

		$pushNotifications = new PushNotifications([
			'instanceId' => config('values.pusher_pn_instance_id'),
			'secretKey' => config('values.pusher_pn_secret_key'),
		]);
		$publishToInterestsResponse = $pushNotifications->publishToInterests(
			array("trip" . $owner->id),
			array(
				"fcm" => array(
					"data" => array(
						"id" => $trip->id,
						"type" => 26,
						'chat_id' => $trip->chat_id,
						"titleEn" => "Trip started",
						"bodyEn" => $renter->first_name . " trip with your "  . $car->car_manufacturer . " " . $car->car_model . " has started.",
						"titleAr" => "لديك رحلة بدأت",
						"bodyAr" => "انت بدأت رحلة " . $renter->first_name . " مع سيارتك " . $car->car_manufacturer . " " . $car->car_model . ".",

					)
				),
				"apns" => array(
					"aps" => array(
						"alert" => array(
							"title-loc-key" => "Trip started",
							"loc-key" => "TRIP_STARTED_1",
							"loc-args" => array(
								$renter->first_name,
								$car->car_manufacturer,
								$car->car_model
							)
						),
						"badge" => 1,
						"sound" => "chime.aiff",
					),

					"data" => array(
						"id" => $trip->id,
						"type" => 26,
						'chat_id' => $trip->chat_id
					)
				)
			));
	}

	public static function tripStartedRenter($trip)
	{
		$car = Car::find($trip->car_id);
		$owner = User::find($trip->owner_id);
		$renter = User::find($trip->renter_id);
		//$bill = TripBill::where('trip_id', $this->trip->id)->first();

		$pushNotifications = new PushNotifications([
			'instanceId' => config('values.pusher_pn_instance_id'),
			'secretKey' => config('values.pusher_pn_secret_key'),
		]);
		$publishToInterestsResponse = $pushNotifications->publishToInterests(
			array("trip" . $renter->id),
			array(
				"fcm" => array(
					"data" => array(
						"id" => $trip->id,
						"type" => 16,
						'chat_id' => $trip->chat_id,
						"titleEn" => "Trip started",
						"bodyEn" => "Your trip with " . $owner->first_name . " " . $car->car_manufacturer . " " . $car->car_model . " started.",
						"titleAr" => "رحلتك بدأت",
						"bodyAr" => "رحلتك مع" . $owner->first_name . " وسيارته " . $car->car_manufacturer . " " . $car->car_model .  " بدأت. نتمنى لك رحلة سعيدة.",

					)
				),
				"apns" => array(
					"aps" => array(
						"alert" => array(
							"title-loc-key" => "Trip started",
							"loc-key" => "TRIP_STARTED_2",
							"loc-args" => array(
								$owner->first_name,
								$car->car_manufacturer,
								$car->car_model
							)
						),
						"badge" => 1,
						"sound" => "chime.aiff",
					),

					"data" => array(
						"id" => $trip->id,
						"type" => 16,
						'chat_id' => $trip->chat_id
					)
				)
			));
	}

	public static function upcomingTripOwner($trip)
	{
		$car = Car::find($trip->car_id);
		$owner = User::find($trip->owner_id);
		$renter = User::find($trip->renter_id);
		//$bill = TripBill::where('trip_id', $this->trip->id)->first();

		$pushNotifications = new PushNotifications([
			'instanceId' => config('values.pusher_pn_instance_id'),
			'secretKey' => config('values.pusher_pn_secret_key'),
		]);
		$publishToInterestsResponse = $pushNotifications->publishToInterests(
			array("trip" . $owner->id),
			array(
				"fcm" => array(
					"data" => array(
						"id" => $trip->id,
						"type" => 27,
						'chat_id' => $trip->chat_id,
						"titleEn" => "Upcoming trip",
						"bodyEn" => $renter->first_name . " trip with your "  . $car->car_manufacturer . " " . $car->car_model . " starts soon. Verify your guest's driver's license and use trip photos to document fuel level, mileage and vehicle condition.",
						"titleAr" => "لديك رحلة تبدأ غداً ",
						"bodyAr" => "حجز " . $renter->first_name . " لسيارتك "  . $car->car_manufacturer . " " . $car->car_model . " يبدأ غداً . الرجاء تجهيز السيارة والتواصل مع " . $renter->first_name . " في أقرب فرصة لتنسيق تسليم السيارة.",

					)
				),
				"apns" => array(
					"aps" => array(
						"alert" => array(
							"title-loc-key" => "Upcoming trip",
							"loc-key" => "TRIP_START_TOMORROW_1",
							"loc-args" => array(
								$renter->first_name,
								$car->car_manufacturer,
								$car->car_model
							)
						),
						"badge" => 1,
						"sound" => "chime.aiff",
					),

					"data" => array(
						"id" => $trip->id,
						"type" => 27,
						'chat_id' => $trip->chat_id
					)
				)
			));
	}

	public static function upcomingTripRenter($trip)
	{
		$car = Car::find($trip->car_id);
		$owner = User::find($trip->owner_id);
		$renter = User::find($trip->renter_id);
		//$bill = TripBill::where('trip_id', $this->trip->id)->first();

		$pushNotifications = new PushNotifications([
			'instanceId' => config('values.pusher_pn_instance_id'),
			'secretKey' => config('values.pusher_pn_secret_key'),
		]);
		$publishToInterestsResponse = $pushNotifications->publishToInterests(
			array("trip" . $renter->id),
			array(
				"fcm" => array(
					"data" => array(
						"id" => $trip->id,
						"type" => 17,
						'chat_id' => $trip->chat_id,
						"titleEn" => "Upcoming trip",
						"bodyEn" => "Your trip with " . $owner->first_name . " " . $car->car_manufacturer . " " . $car->car_model . " starts tomorrow  Please contact " . $owner->first_name . " soon to coordinate the key handoff.",
						"titleAr" => "رحلتك تبدأ غداً",
						"bodyAr" => "حجزك يبدأ غداً الرجاء التواصل مع" . $owner->first_name . " في أقرب فرصة لتنسيق استلام السيارة.",
					)
				),
				"apns" => array(
					"aps" => array(
						"alert" => array(
							"title-loc-key" => "Upcoming trip",
							"loc-key" => "TRIP_START_TOMORROW_2",
							"loc-args" => array(
								$owner->first_name,
								$car->car_manufacturer,
								$car->car_model
							)
						),
						"badge" => 1,
						"sound" => "chime.aiff",
					),

					"data" => array(
						"id" => $trip->id,
						"type" => 17,
						'chat_id' => $trip->chat_id
					)
				)
			));
	}

	public static function changeTripRequestOwner($trip)
	{
		$car = Car::find($trip->car_id);
		$owner = User::find($trip->owner_id);
		$renter = User::find($trip->renter_id);
		//$bill = TripBill::where('trip_id', $this->trip->id)->first();

		$pushNotifications = new PushNotifications([
			'instanceId' => config('values.pusher_pn_instance_id'),
			'secretKey' => config('values.pusher_pn_secret_key'),
		]);
		$publishToInterestsResponse = $pushNotifications->publishToInterests(
			array("trip" . $owner->id),
			array(
				"fcm" => array(
					"data" => array(
						"id" => $trip->id,
						"type" => 28,
						'chat_id' => $trip->chat_id,
						"titleEn" => "Change request pending",
						"bodyEn" => $renter->first_name . " has requested to change his trip with your "  . $car->car_manufacturer . " " . $car->car_model . ".",
						"titleAr" => "طلب تعديل الحج",
						"bodyAr" => "طلب " . $renter->first_name . " تعديل الحجز لسيارتك "  . $car->car_manufacturer . " " . $car->car_model . ".",
					)
				),
				"apns" => array(
					"aps" => array(
						"alert" => array(
							"title-loc-key" => "Change request pending",
							"loc-key" => "INCOMING_MODIFY_REQUEST",
							"loc-args" => array(
								$renter->first_name,
								$car->car_manufacturer,
								$car->car_model
							)
						),
						"badge" => 1,
						"sound" => "chime.aiff",
					),

					"data" => array(
						"id" => $trip->id,
						"type" => 28,
						'chat_id' => $trip->chat_id
					)
				)
			));
	}

	public static function changeTripRequestRenter($trip)
	{
		$car = Car::find($trip->car_id);
		$owner = User::find($trip->owner_id);
		$renter = User::find($trip->renter_id);
		//$bill = TripBill::where('trip_id', $this->trip->id)->first();

		$pushNotifications = new PushNotifications([
			'instanceId' => config('values.pusher_pn_instance_id'),
			'secretKey' => config('values.pusher_pn_secret_key'),
		]);
		$publishToInterestsResponse = $pushNotifications->publishToInterests(
			array("trip" . $renter->id),
			array(
				"fcm" => array(
					"data" => array(
						"id" => $trip->id,
						"type" => 18,
						'chat_id' => $trip->chat_id,
						"titleEn" => "Change request pending",
						"bodyEn" => "You’ve requested to change your trip with " . $owner->first_name . " " . $car->car_manufacturer . " " . $car->car_model . ". Your request was sent and " . $owner->first_name . " need some time to confirm.",
						"titleAr" => "طلب تعديل الحجز تحت الاجراء",
						"bodyAr" => "انت طلبت تعديل حجزك مع " . $owner->first_name . " " . $car->car_manufacturer . " " . $car->car_model . ". نفيدكم انه تم ارسال الطلب ويحتاج " . $owner->first_name . "بعض الوقت للتأكيد",
					)
				),
				"apns" => array(
					"aps" => array(
						"alert" => array(
							"title-loc-key" => "Change request pending",
							"loc-key" => "OUTGOING_MODIFY_REQUEST",
							"loc-args" => array(
								$owner->first_name,
								$car->car_manufacturer,
								$car->car_model
							)
						),
						"badge" => 1,
						"sound" => "chime.aiff",
					),

					"data" => array(
						"id" => $trip->id,
						"type" => 18,
						'chat_id' => $trip->chat_id
					)
				)
			));
	}

	public static function acceptChangeTripRequestOwner($trip)
	{
		$car = Car::find($trip->car_id);
		$owner = User::find($trip->owner_id);
		$renter = User::find($trip->renter_id);
		//$bill = TripBill::where('trip_id', $this->trip->id)->first();

		$pushNotifications = new PushNotifications([
			'instanceId' => config('values.pusher_pn_instance_id'),
			'secretKey' => config('values.pusher_pn_secret_key'),
		]);
		$publishToInterestsResponse = $pushNotifications->publishToInterests(
			array("trip" . $owner->id),
			array(
				"fcm" => array(
					"data" => array(
						"id" => $trip->id,
						"type" => 20,
						'chat_id' => $trip->chat_id,
						"titleEn" => "Change request confirmed",
						"bodyEn" =>  "You accepted trip modification with your "  . $car->car_manufacturer . " " . $car->car_model . ".",
						"titleAr" => "طلب تعديل الحجز تم تأكيده ",
						"bodyAr" => "انت وافقت على طلب تعديل الحجز لسيارتك "  . $car->car_manufacturer . " " . $car->car_model . ".",
					)
				),
				"apns" => array(
					"aps" => array(
						"alert" => array(
							"title-loc-key" => "Change request confirmed",
							"loc-key" => "OWNER_MODIFICATION_ACCEPTED",
							"loc-args" => array(
								$car->car_manufacturer,
								$car->car_model,
							)
						),
						"badge" => 1,
						"sound" => "chime.aiff",
					),

					"data" => array(
						"id" => $trip->id,
						"type" => 20,
						'chat_id' => $trip->chat_id
					)
				)
			));
	}

	public static function acceptChangeTripRequestRenter($trip)
	{
		$car = Car::find($trip->car_id);
		$owner = User::find($trip->owner_id);
		$renter = User::find($trip->renter_id);
		//$bill = TripBill::where('trip_id', $this->trip->id)->first();

		$pushNotifications = new PushNotifications([
			'instanceId' => config('values.pusher_pn_instance_id'),
			'secretKey' => config('values.pusher_pn_secret_key'),
		]);
		$publishToInterestsResponse = $pushNotifications->publishToInterests(
			array("trip" . $renter->id),
			array(
				"fcm" => array(
					"data" => array(
						"id" => $trip->id,
						"type" => 13,
						'chat_id' => $trip->chat_id,
						"titleEn" => "Change request confirmed",
						"bodyEn" => $owner->first_name . " accepted your change request with his " . $car->car_manufacturer . " " . $car->car_model . ".",
						"titleAr" => "طلب تعديل الحجز تم تأكيده",
						"bodyAr" => "طلب تعديل الحجز تم تأكيده مع " . $owner->first_name . " وسيارته " . $car->car_manufacturer . " " . $car->car_model . ".",
					)
				),
				"apns" => array(
					"aps" => array(
						"alert" => array(
							"title-loc-key" => "Change request confirmed",
							"loc-key" => "RENTER_MODIFICATION_ACCEPTED",
							"loc-args" => array(
								$owner->first_name,
								$car->car_manufacturer,
								$car->car_model
							)
						),
						"badge" => 1,
						"sound" => "chime.aiff",
					),

					"data" => array(
						"id" => $trip->id,
						"type" => 13,
						'chat_id' => $trip->chat_id
					)
				)
			));
	}

	public static function newMessage($user, $chat)
	{
		if($user->id == $chat->renter_id)
		{
			$pushNotifications = new PushNotifications([
				'instanceId' => config('values.pusher_pn_instance_id'),
				'secretKey' => config('values.pusher_pn_secret_key'),
			]);
			$publishToInterestsResponse = $pushNotifications->publishToInterests(
				array("message" . $chat->owner_id),
				array(
					"fcm" => array(
						"data" => array(
							"id" => $chat->trip_id,
							"type" => 31,
							"chat_id" => $chat->id,
							"titleEn" => "New message",
							"bodyEn" => $user->first_name . " has sent you a message.",
							"titleAr" => "رسالة جديدة",
							"bodyAr" => $user->first_name . " ارسل لك رسالة جديدة بخصوص" ,
						)
					),
					"apns" => array(
						"aps" => array(
							"alert" => array(
								"title-loc-key" => "New message",
								"loc-key" => "NEW_MESSAGE",
								"loc-args" => array(
									$user->first_name
								)
							),
							"badge" => 1,
							"sound" => "chime.aiff",
						),

						"data" => array(
							"id" => $chat->trip_id,
							"type" => 31,
							'chat_id' => $chat->id
						)
					)
				));
		}
		if($user->id == $chat->owner_id)
		{
			$pushNotifications = new PushNotifications([
				'instanceId' => config('values.pusher_pn_instance_id'),
				'secretKey' => config('values.pusher_pn_secret_key'),
			]);
			$publishToInterestsResponse = $pushNotifications->publishToInterests(
				array("message" . $chat->renter_id),
				array(
					"fcm" => array(
						"data" => array(
							"id" => $chat->trip_id,
							"type" => 31,
							"chat_id" => $chat->id,
							"titleEn" => "New message",
							"bodyEn" => $user->first_name . " has sent you a message.",
							"titleAr" => "رسالة جديدة",
							"bodyAr" => $user->first_name . " ارسل لك رسالة جديدة بخصوص" ,
						)
					),
					"apns" => array(
						"aps" => array(
							"alert" => array(
								"title-loc-key" => "New message",
								"loc-key" => "NEW_MESSAGE",
								"loc-args" => array(
									$user->first_name
								)
							),
							"badge" => 1,
							"sound" => "chime.aiff",
						),

						"data" => array(
							"id" => $chat->trip_id,
							"type" => 31,
							'chat_id' => $chat->id
						)
					)
				));
		}
	}

	public static function renterCancelBeforeStartRenter($trip)
	{
		$car = Car::find($trip->car_id);
		$owner = User::find($trip->owner_id);
		$renter = User::find($trip->renter_id);

		$pushNotifications = new PushNotifications([
			'instanceId' => config('values.pusher_pn_instance_id'),
			'secretKey' => config('values.pusher_pn_secret_key'),
		]);
		$publishToInterestsResponse = $pushNotifications->publishToInterests(
			array("trip" . $renter->id),
			array(
				"fcm" => array(
					"data" => array(
						"id" => $trip->id,
						"type" => 33,
						'chat_id' => $trip->chat_id,
						"titleEn" => "Cancelled trip",
						"bodyEn" =>  "You canceled your trip with " . $owner->first_name . " " . $car->car_manufacturer . " " . $car->car_model . ". We’re sorry things didn’t work out. We’ve removed the temporary payment authorization for this trip",
						"titleAr" => "حجز ملغي",
						"bodyAr" => "انت قمت بإلغاء حجزك مع " . $owner->first_name . " وسيارته". $car->car_manufacturer . " " . $car->car_model . " نحن نأسف بأن الأمور لم تسير كما هو مخطط لها . وبما أنك ألغيت الحجز خلال ساعة واحدة سوف يتم إرجاع جميع المبالغ المدفوعة إلى بطاقتكم. ",
					)
				),
				"apns" => array(
					"aps" => array(
						"alert" => array(
							"title-loc-key" => "Cancelled trip",
							"loc-key" => "CANCELLED_TRIP_RENTER",
							"loc-args" => array(
								$owner->first_name,
								$car->car_manufacturer,
								$car->car_model
							)
						),
						"badge" => 1,
						"sound" => "chime.aiff",
					),

					"data" => array(
						"id" => $trip->id,
						"type" => 33,
						'chat_id' => $trip->chat_id
					)
				)
			));
	}

	public static function renterCancelBeforeStartOwner($trip)
	{
		$car = Car::find($trip->car_id);
		$owner = User::find($trip->owner_id);
		$renter = User::find($trip->renter_id);

		$pushNotifications = new PushNotifications([
			'instanceId' => config('values.pusher_pn_instance_id'),
			'secretKey' => config('values.pusher_pn_secret_key'),
		]);
		$publishToInterestsResponse = $pushNotifications->publishToInterests(
			array("trip" . $owner->id),
			array(
				"fcm" => array(
					"data" => array(
						"id" => $trip->id,
						"type" => 34,
						'chat_id' => $trip->chat_id,
						"titleEn" => "Cancelled trip",
						"bodyEn" =>  $renter->first_name . " canceled his trip with your "  . $car->car_manufacturer . " " . $car->car_model . ".",
						"titleAr" => "تم إلغاء الحجز ",
						"bodyAr" => "قام " .  $renter->first_name . " بإلغاء الحجز لسيارتك" . $car->car_manufacturer . " " . $car->car_model . ".",
					)
				),
				"apns" => array(
					"aps" => array(
						"alert" => array(
							"title-loc-key" => "Cancelled trip",
							"loc-key" => "CANCELLED_TRIP_OWNER",
							"loc-args" => array(
								$renter->first_name,
								$car->car_manufacturer,
								$car->car_model
							)
						),
						"badge" => 1,
						"sound" => "chime.aiff",
					),

					"data" => array(
						"id" => $trip->id,
						"type" => 34,
						'chat_id' => $trip->chat_id
					)
				)
			));
	}

	public static function ownerCancelBeforeStartOwner($trip)
	{
		$car = Car::find($trip->car_id);
		$owner = User::find($trip->owner_id);
		$renter = User::find($trip->renter_id);

		$pushNotifications = new PushNotifications([
			'instanceId' => config('values.pusher_pn_instance_id'),
			'secretKey' => config('values.pusher_pn_secret_key'),
		]);
		$publishToInterestsResponse = $pushNotifications->publishToInterests(
			array("trip" . $owner->id),
			array(
				"fcm" => array(
					"data" => array(
						"id" => $trip->id,
						"type" => 35,
						'chat_id' => $trip->chat_id,
						"titleEn" => "Cancelled trip",
						"bodyEn" => "You cancelled " . $renter->first_name . " trip with your "  . $car->car_manufacturer . " " . $car->car_model . ". Your car’s calendar has been marked unavailable for the dates of this trip. You may be charged based on our cancellation policy.",
						"titleAr" => "تم إلغاء الحجز ",
						"bodyAr" => "انت الغيت حجز " . $renter->first_name . " لسيارتك " .  $car->car_manufacturer . " " . $car->car_model . " سيارتك سوف تكون غير متاحة في جدول المواعيد لهذه الأيام .كما نود تذكيركم أن إلغاء الحجز المتكرر قد يعرضكم للغرامات المالية حسب سياسات المنصة." ,
					)
				),
				"apns" => array(
					"aps" => array(
						"alert" => array(
							"title-loc-key" => "Cancelled trip",
							"loc-key" => "CANCELLED_TRIP_RENTER_2",
							"loc-args" => array(
								$renter->first_name,
								$car->car_manufacturer,
								$car->car_model
							)
						),
						"badge" => 1,
						"sound" => "chime.aiff",
					),

					"data" => array(
						"id" => $trip->id,
						"type" => 35,
						'chat_id' => $trip->chat_id
					)
				)
			));
	}

	public static function ownerCancelBeforeStartRenter($trip)
	{
		$car = Car::find($trip->car_id);
		$owner = User::find($trip->owner_id);
		$renter = User::find($trip->renter_id);

		$pushNotifications = new PushNotifications([
			'instanceId' => config('values.pusher_pn_instance_id'),
			'secretKey' => config('values.pusher_pn_secret_key'),
		]);
		$publishToInterestsResponse = $pushNotifications->publishToInterests(
			array("trip" . $renter->id),
			array(
				"fcm" => array(
					"data" => array(
						"id" => $trip->id,
						"type" => 36,
						'chat_id' => $trip->chat_id,
						"titleEn" => "Cancelled trip",
						"bodyEn" => $owner->first_name . " canceled your trip with his "  . $car->car_manufacturer . " " . $car->car_model . ". We’re sorry things didn’t work out. Because owner cancelled your trip, all charges to your card will be refunded.",
						"titleAr" => "تم إلغاء الحجز",
						"bodyAr" => $owner->first_name . " قام بإلغاء حجزك لسيارته " .  $car->car_manufacturer . " " . $car->car_model . " نحن نأسف بأن الأمور لم تسير كما هو مخطط لها . ولان المؤجر قام بإلغاء الحجز نفيدكم بأن جميع المبالغ المدفوعة سوف يتم إرجاعها إلى بطاقتكم." ,
					)
				),
				"apns" => array(
					"aps" => array(
						"alert" => array(
							"title-loc-key" => "Cancelled trip",
							"loc-key" => "CANCALLED_TRIP_OWNER_2",
							"loc-args" => array(
								$owner->first_name,
								$car->car_manufacturer,
								$car->car_model
							)
						),
						"badge" => 1,
						"sound" => "chime.aiff",
					),

					"data" => array(
						"id" => $trip->id,
						"type" => 36,
						'chat_id' => $trip->chat_id
					)
				)
			));
	}

	public static function cancelAfterStartRenter($trip)
	{
		$car = Car::find($trip->car_id);
		$owner = User::find($trip->owner_id);
		$renter = User::find($trip->renter_id);

		$pushNotifications = new PushNotifications([
			'instanceId' => config('values.pusher_pn_instance_id'),
			'secretKey' => config('values.pusher_pn_secret_key'),
		]);
		$publishToInterestsResponse = $pushNotifications->publishToInterests(
			array("trip" . $renter->id),
			array(
				"fcm" => array(
					"data" => array(
						"id" => $trip->id,
						"type" => 37,
						'chat_id' => $trip->chat_id,
						"titleEn" => "Cancelled trip",
						"bodyEn" => "You've requested to cancel your trip with " . $owner->first_name . " "  . $car->car_manufacturer . " " . $car->car_model . ". Please contact " . $owner->first_name . " soon to coordinate the key handoff.",
						"titleAr" => "تم إلغاء الحجز",
						"bodyAr" => "انت طلبت إلغاء حجزك مع " . $owner->first_name . " "  . $car->car_manufacturer . " " . $car->car_model . ". نفيدكم انه تم ارسال الطلب. ويحتاج " . $owner->first_name . " لبعض الوقت للتأكيد." ,
					)
				),
				"apns" => array(
					"aps" => array(
						"alert" => array(
							"title-loc-key" => "Cancelled trip",
							"loc-key" => "CANCEL_TRIP_REQUEST_RENTER",
							"loc-args" => array(
								$owner->first_name,
								$car->car_manufacturer,
								$car->car_model
							)
						),
						"badge" => 1,
						"sound" => "chime.aiff",
					),

					"data" => array(
						"id" => $trip->id,
						"type" => 37,
						'chat_id' => $trip->chat_id
					)
				)
			));
	}

	public static function cancelAfterStartOwner($trip)
	{
		$car = Car::find($trip->car_id);
		$owner = User::find($trip->owner_id);
		$renter = User::find($trip->renter_id);

		$pushNotifications = new PushNotifications([
			'instanceId' => config('values.pusher_pn_instance_id'),
			'secretKey' => config('values.pusher_pn_secret_key'),
		]);
		$publishToInterestsResponse = $pushNotifications->publishToInterests(
			array("trip" . $owner->id),
			array(
				"fcm" => array(
					"data" => array(
						"id" => $trip->id,
						"type" => 38,
						'chat_id' => $trip->chat_id,
						"titleEn" => "Cancelled trip",
						"bodyEn" => $renter->first_name . " has requested to cancel his trip with your "  . $car->car_manufacturer . " " . $car->car_model . ". Please contact " . $renter->first_name . " soon to coordinate the key handoff.",
						"titleAr" => "تم إلغاء الحجز",
						"bodyAr" => "طلب " . $renter->first_name . " إلغاء الحجز لسيارتك "  . $car->car_manufacturer . " " . $car->car_model . ".",
					)
				),
				"apns" => array(
					"aps" => array(
						"alert" => array(
							"title-loc-key" => "Cancelled trip",
							"loc-key" => "CANCEL_TRIP_REQUEST_OWNER",
							"loc-args" => array(
								$renter->first_name,
								$car->car_manufacturer,
								$car->car_model
							)
						),
						"badge" => 1,
						"sound" => "chime.aiff",
					),

					"data" => array(
						"id" => $trip->id,
						"type" => 38,
						'chat_id' => $trip->chat_id
					)
				)
			));
	}

	public static function tripEndsSoonOwner($trip)
	{
		$car = Car::find($trip->car_id);
		$owner = User::find($trip->owner_id);
		$renter = User::find($trip->renter_id);

		$pushNotifications = new PushNotifications([
			'instanceId' => config('values.pusher_pn_instance_id'),
			'secretKey' => config('values.pusher_pn_secret_key'),
		]);
		$publishToInterestsResponse = $pushNotifications->publishToInterests(
			array("trip" . $owner->id),
			array(
				"fcm" => array(
					"data" => array(
						"id" => $trip->id,
						"type" => 39,
						'chat_id' => $trip->chat_id,
						"titleEn" => "Trip ends tomorrow",
						"bodyEn" => $renter->first_name . " trip with your "  . $car->car_manufacturer . " " . $car->car_model . " ends tomorrow . Check your car and make sure everything’s in order.",
						"titleAr" => "لديك رحلة تنتهي غداً",
						"bodyAr" => "حجز " . $renter->first_name . " لسيارتك "  . $car->car_manufacturer . " " . $car->car_model . ". ينتهي غداً الرجاء التواصل مع" . $renter->first_name . " في أقرب فرصة لتنسيق استلام السيارة.",
					)
				),
				"apns" => array(
					"aps" => array(
						"alert" => array(
							"title-loc-key" => "Trip ends tomorrow",
							"loc-key" => "TRIP_ENDS_OWNER",
							"loc-args" => array(
								$renter->first_name,
								$car->car_manufacturer,
								$car->car_model
							)
						),
						"badge" => 1,
						"sound" => "chime.aiff",
					),

					"data" => array(
						"id" => $trip->id,
						"type" => 39,
						'chat_id' => $trip->chat_id
					)
				)
			));
	}

	public static function tripEndsSoonRenter($trip)
	{
		$car = Car::find($trip->car_id);
		$owner = User::find($trip->owner_id);
		$renter = User::find($trip->renter_id);

		$pushNotifications = new PushNotifications([
			'instanceId' => config('values.pusher_pn_instance_id'),
			'secretKey' => config('values.pusher_pn_secret_key'),
		]);
		$publishToInterestsResponse = $pushNotifications->publishToInterests(
			array("trip" . $renter->id),
			array(
				"fcm" => array(
					"data" => array(
						"id" => $trip->id,
						"type" => 40,
						'chat_id' => $trip->chat_id,
						"titleEn" => "Your trip ends tomorrow",
						"bodyEn" => "Your trip ends . Please contact "  . $owner->first_name . " soon to coordinate the key handoff.", 
						"titleAr" => "رحلتك تنتهي غداً",
						"bodyAr" => "حجزك ينتهي  غداً الرجاء التواصل مع " . $owner->first_name . " في أقرب فرصة لتنسيق تسليم السيارة.",
					)
				),
				"apns" => array(
					"aps" => array(
						"alert" => array(
							"title-loc-key" => "Your trip ends tomorrow",
							"loc-key" => "TRIP_ENDS_RENTER",
							"loc-args" => array(
								$renter->first_name,
								$car->car_manufacturer,
								$car->car_model
							)
						),
						"badge" => 1,
						"sound" => "chime.aiff",
					),

					"data" => array(
						"id" => $trip->id,
						"type" => 40,
						'chat_id' => $trip->chat_id
					)
				)
			));
	}

}