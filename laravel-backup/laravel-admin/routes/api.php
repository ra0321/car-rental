<?php

use Illuminate\Http\Request;

// header("Access-Control-Allow-Origin: *");
// header('Access-Control-Allow-Credentials: true');
// header('Access-Control-Allow-Methods: HEAD, POST, GET, OPTIONS, PUT');
// header("Access-Control-Allow-Headers: Authorization, X-Requested-With,  Content-Type, Accept");

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/


Route::get('reportSample/getCountsRecordsExport', 'ReportsController@getCountsRecordsExport');
Route::post('login', 'Auth\LoginController@login');
Route::get('cars', 'CarsController@getCars');
//Route::group(['middleware' => 'jwt.auth'], function($router){
	#######################
	##### CREATE USER #####
	#######################
	Route::post('registration', 'user\UserController@registration');
	
	
	
	
	//create roles and admins
	Route::group(['middleware' => 'level:5'], function($router){
		Route::get('getAdmin', 'AdminsController@getAdmin');
		Route::post('admin_user', 'AdminsController@createAdmin');
		// Route::post('superadmin', 'AdminsController@createSuperAdmin');
		Route::post('role', 'AdminsController@createRole');
		Route::post('EditRole/{id}', 'AdminsController@EditRole');
		Route::get('getRoles', 'AdminsController@getRoles');
		Route::post('editAdmin/{id}', 'AdminsController@editAdmin');
		Route::post('deleteAdmin/{id}', 'AdminsController@RemoveAdmin');
	});
	//Route::group(['middleware' => 'level:5'], function($router){

		//authentication
	    Route::post('logout', 'Auth\LoginController@logout');
	    Route::post('refresh', 'Auth\LoginController@refresh');
	    Route::post('me', 'Auth\LoginController@getAdmin');

	    //users
	    Route::get('user/{id}', 'UsersController@getUser');
	    Route::get('users/', 'UsersController@getUsers');
	    Route::get('users/favorites/{id}', 'UsersController@getUsersFavoriteCars');
	    Route::get('users/viewed/{id}', 'UsersController@getUsersRecentlyViewedCars');
	    Route::post('users/delete/{id}', 'UsersController@deleteUser');
		Route::post('users/restore/{id}', 'UsersController@restoreUser');
	    Route::post('users/approve/licence/{id}', 'UsersController@approveLicence');
	    Route::post('users/approve/id/{id}', 'UsersController@approveId');
	    Route::post('users/deny/licence/{id}', 'UsersController@denyLicence');
	    Route::post('users/deny/id/{id}', 'UsersController@denyId');
		Route::post('users/pay/{id}', 'UsersController@pay');
		//Dashboard Pop Data for users
		Route::get('popUsers/', 'UsersController@getUserDashboard');
		// UsersWithoutPaginationDownload
		Route::get('UsersExport/', 'UsersController@getUsersExport');
	    //cars
	    Route::get('car/{id}', 'CarsController@getCar');
	    Route::get('cars', 'CarsController@getCars');
	    Route::get('cars/{id}', 'CarsController@getCarsByUser');
	    Route::get('cars/images/{id}', 'CarsController@getImagesByCar');
	    Route::post('cars/delete/{id}', 'CarsController@deleteCar');
		Route::post('cars/restore/{id}', 'CarsController@restoreCar');
	    Route::get('car/insurance/{id}', 'CarsController@getCarInsurance');
	    Route::get('car/registration/{id}', 'CarsController@getCarRegistration');
	    Route::post('car/insurance/approve/{id}', 'CarsController@approveInsurance');
	    Route::post('car/registration/approve/{id}', 'CarsController@approveRegistration');
	    Route::post('car/insurance/deny/{id}', 'CarsController@denyInsurance');
	    Route::post('car/registration/deny/{id}', 'CarsController@denyRegistration');

		//car_datas
		Route::get('car_data', 'CarDataController@getEsarCar');
		Route::post('car_data', 'CarDataController@createCar');
		Route::post('car_data_update', 'CarDataController@updateCar');
		Route::post('car_data_delete/{id}', 'CarDataController@deleteCar');

		//car_list
		Route::get('car_owner', 'CarListController@getOwners');
		Route::get('choose-manufacturer/{id}', 'CarListController@chooseManufacturer');
		Route::post('choose-model', 'CarListController@chooseModel');
		Route::post('choose-transmission', 'CarListController@getTransmission');
		Route::post('choose-car', 'CarListController@getCarData');
		Route::post('add_car', 'CarListController@addCar');
		Route::post('car-notice/{id}', 'CarListController@updateNotice');
		Route::post('car-registration/{id}', 'CarListController@carRegistration');
		Route::post('car-protection/{id}', 'CarListController@carProtection');
		Route::post('car-photos/{id}', 'CarListController@carPhotos');

	    //trips
	    Route::get('trip/{id}', 'TripsController@getTrip');
	    Route::get('trips', 'TripsController@getTrips');
	    Route::get('trips/owner/{id}', 'TripsController@getTripsByOwner');
	    Route::get('trips/renter/{id}', 'TripsController@getTripsByRenter');
	    Route::get('trips/status/{status}', 'TripsController@getTripsByStatus');
	    Route::get('trips/onHold', 'TripsController@getAntiFraudTrips');
		Route::post('trips/stop/{id}', 'TripsController@changeStopStatue');
		Route::post('trips/waiting/{id}', 'TripsController@changeWaitingStatue');
		Route::post('trips/start/{id}', 'TripsController@changeStartStatue');
		Route::post('trips/cancel/{id}', 'TripsController@changeCancelStatue');

	    //chats
	    Route::get('chat/{id}', 'ChatsController@getChat');
	    Route::get('chat/trip/{id}', 'ChatsController@getChatByTripId');

	    //reports
		Route::get('report/sum', 'ReportsController@sum');
		Route::get('report/getCounts', 'ReportsController@getCounts');
		Route::get('report/getCountsRecords', 'ReportsController@getCountsRecords');
		Route::get('report/getCountsRecordsExport', 'ReportsController@getCountsRecordsExport');
	    Route::get('report/cars', 'ReportsController@carsByCities');
	    Route::get('report/earners/get/all', 'ReportsController@earners');
	    Route::get('report/earners/{id}', 'ReportsController@earner');

	    // rental calculator
		Route::get('calculator', 'RentalCalculatorController@index');
		
		//Notes
		Route::get('get_note_user/{request_id}', 'NoteController@getUserNotes');
		Route::get('get_note_trip/{request_id}', 'NoteController@getTripNotes');
		Route::post('add_note_user', 'NoteController@storeUserNote');
		Route::post('add_note_trip', 'NoteController@storeTripNote');
		Route::patch('edit_note_user/{request_id}', 'NoteController@editUserNote');
		Route::patch('edit_note_user/{request_id}', 'NoteController@editTripNote');
		Route::delete('delete_note_user/{request_id}', 'NoteController@deleteUserNote');
		Route::delete('delete_note_user/{request_id}', 'NoteController@deleteTripNote');
    //});
//});
