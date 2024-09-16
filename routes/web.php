<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// Route::get('/', function () {
//     return view('welcome');
// });

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');


Route::middleware('auth')->group(function () {
    Route::get('/perfil', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/perfil', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/perfil', [ProfileController::class, 'destroy'])->name('profile.destroy');
});



Route::get('/admin/painel', [App\Http\Controllers\admin\DashboardController::class, 'index'])->middleware(['auth', 'verified'])->name('panel');

/* Admin - Dashboard */
Route::get('/admin/dashboard-bk', 'admin\DashboardController@index')->middleware('auth');

/* Sms */
Route::get('/admin/sms', 'App\Http\Controllers\admin\SmsController@index')->middleware('auth');
Route::get('/admin/sms/settings', 'App\Http\Controllers\admin\SmsController@settings')->middleware('auth');
Route::post('/admin/sms/settings/update', 'App\Http\Controllers\admin\SmsController@updateSettings')->middleware('auth');
Route::post('/admin/sms/settings/enable', 'App\Http\Controllers\admin\SmsController@enable')->middleware('auth');
Route::post('/admin/sms/settings/notify', 'App\Http\Controllers\admin\SmsController@notify')->middleware('auth');


/* Insights */
Route::get('/admin/insights', 'App\Http\Controllers\admin\InsightsController@index')->middleware('auth');

/* Settings */
Route::get('/admin/settings', 'App\Http\Controllers\admin\SettingsController@edit')->middleware('auth');
Route::post('/admin/settings/update', 'App\Http\Controllers\admin\SettingsController@update')->middleware('auth');

/* Website */
Route::get('/admin/website', 'App\Http\Controllers\admin\WebsiteController@edit')->middleware('auth');
Route::post('/admin/website/update', 'App\Http\Controllers\admin\WebsiteController@update')->middleware('auth');
Route::post('/admin/website/photo-upload', 'App\Http\Controllers\admin\WebsiteController@ImageUpload')->middleware('auth');

/* Photos */
Route::get('/admin/photos', 'App\Http\Controllers\admin\PhotosController@edit')->middleware('auth');
Route::post('/admin/photos/photo-upload/{id}', 'App\Http\Controllers\admin\PhotosController@ImageUpload')->where('id', '[1-9]|10')->middleware('auth');
Route::post('/admin/photos/delete', 'App\Http\Controllers\admin\PhotosController@destroy')->middleware('auth');

/* Profile */
Route::get('/admin/profile', 'App\Http\Controllers\admin\ProfileController@edit')->middleware('auth');
Route::post('/admin/profile/update', 'App\Http\Controllers\admin\ProfileController@update')->middleware('auth');
Route::post('/admin/profile/photo-upload', 'App\Http\Controllers\admin\ProfileController@ImageUpload')->middleware('auth');
Route::get('/admin/profile/change-password', 'App\Http\Controllers\admin\ProfileController@changePassword')->middleware('auth');
Route::post('/admin/profile/update-password', 'App\Http\Controllers\admin\ProfileController@updatePassword')->middleware('auth');

/* Salon Work Hours and holidays */
Route::get('/admin/work-hours', 'App\Http\Controllers\admin\WorkHoursController@index')->middleware('auth');
Route::get('/admin/salon-work-hours', 'App\Http\Controllers\admin\WorkHoursController@edit')->middleware('auth');
Route::post('/admin/salon-work-hours/update', 'App\Http\Controllers\admin\WorkHoursController@update')->middleware('auth');

Route::get('/admin/holidays', 'App\Http\Controllers\admin\HolidaysController@index')->middleware('auth');
Route::post('/admin/holidays/store', 'App\Http\Controllers\admin\HolidaysController@store')->middleware('auth');
Route::get('/admin/holidays/confirm-delete/{id}', 'App\Http\Controllers\admin\HolidaysController@confirmDelete')->where('id', '[0-9]+')->middleware('auth');
Route::post('/admin/holidays/delete', 'App\Http\Controllers\admin\HolidaysController@destroy')->middleware('auth');

/*
    App pages - from here on demand license validation
*/

/* Team */
Route::get('/admin/team', 'App\Http\Controllers\admin\TeamController@index')->middleware('auth');
Route::get('/admin/team/member/confirm-delete/{id}', 'App\Http\Controllers\admin\TeamController@destroyConfirm')->where('id', '[0-9]+')->middleware('auth');
Route::post('/admin/team/member/delete', 'App\Http\Controllers\admin\TeamController@destroy')->middleware('auth');
Route::any('admin/team/member/add', 'App\Http\Controllers\admin\TeamController@create')->middleware('auth');
Route::post('admin/team/member/store', 'App\Http\Controllers\admin\TeamController@store')->middleware('auth');

/* Customers */
Route::get('/admin/customers', 'App\Http\Controllers\admin\CustomersController@index')->middleware('auth');
Route::get('/admin/customers/ajax', 'App\Http\Controllers\admin\CustomersController@AjaxSearch')->middleware('auth');
Route::get('/admin/customers/add', 'App\Http\Controllers\admin\CustomersController@create')->middleware('auth');
Route::get('/admin/customers/edit/{id}', 'App\Http\Controllers\admin\CustomersController@edit')->where('id', '[0-9]+')->middleware('auth');
Route::post('/admin/customers/update/{id}', 'App\Http\Controllers\admin\CustomersController@update')->where('id', '[0-9]+')->middleware('auth');
Route::post('/admin/customers/store', 'App\Http\Controllers\admin\CustomersController@store')->middleware('auth');
Route::post('/admin/customers/store-ajax', 'App\Http\Controllers\admin\CustomersController@storeAjax')->middleware('auth');

/* Services categories */
Route::get('/admin/services-categories', 'App\Http\Controllers\admin\ServicesCategoriesController@index')->middleware('auth');
Route::get('/admin/services-categories/add', 'App\Http\Controllers\admin\ServicesCategoriesController@create')->middleware('auth');
Route::post('/admin/services-categories/store', 'App\Http\Controllers\admin\ServicesCategoriesController@store')->middleware('auth');
Route::get('/admin/services-categories/edit/{id}', 'App\Http\Controllers\admin\ServicesCategoriesController@edit')->where('id', '[0-9]+')->middleware('auth');
Route::post('/admin/services-categories/update/{id}', 'App\Http\Controllers\admin\ServicesCategoriesController@update')->where('id', '[0-9]+')->middleware('auth');
Route::get('/admin/services-categories/confirm-delete/{id}', 'App\Http\Controllers\admin\ServicesCategoriesController@confirmDelete')->where('id', '[0-9]+')->middleware('auth');
Route::post('/admin/services-categories/delete', 'App\Http\Controllers\admin\ServicesCategoriesController@destroy')->middleware('auth');

/* Services */
// Route::get('/admin/services', [App\Http\Controllers\admin\DashboardController::class, 'index'])->middleware(['auth', 'verified'])->name('panel');
// Route::get('/admin/services', 'App\Http\Controllers\admin\ServicesController@index')->middleware('auth');
Route::get('/admin/services', [App\Http\Controllers\admin\ServicesController::class, 'index'])->middleware(['auth', 'verified']);
Route::get('/admin/services/add', 'App\Http\Controllers\admin\ServicesController@create')->middleware('auth');
Route::post('/admin/services/store', 'App\Http\Controllers\admin\ServicesController@store')->middleware('auth');
Route::get('/admin/services/edit/{id}', 'App\Http\Controllers\admin\ServicesController@edit')->where('id', '[0-9]+')->middleware('auth');
Route::post('/admin/services/update/{id}', 'App\Http\Controllers\admin\ServicesController@update')->where('id', '[0-9]+')->middleware('auth');
Route::get('/admin/services/confirm-delete/{id}', 'App\Http\Controllers\admin\ServicesController@confirmDelete')->where('id', '[0-9]+')->middleware('auth');
Route::post('/admin/services/delete', 'App\Http\Controllers\admin\ServicesController@destroy')->middleware('auth');

/* Reviews */
Route::get('/admin/reviews', 'App\Http\Controllers\admin\ReviewsController@index')->middleware('auth');
Route::get('/admin/reviews/bin', 'App\Http\Controllers\admin\ReviewsController@bin')->middleware('auth');
Route::get('/admin/reviews/approved', 'App\Http\Controllers\admin\ReviewsController@approved')->middleware('auth');
Route::get('/admin/reviews/change-status/{id}/{status}', 'App\Http\Controllers\admin\ReviewsController@changeStatus')->where('id', '[0-9]+')->where('status', '[1-3]')->middleware('auth');
Route::get('/admin/reviews/edit/{id}', 'App\Http\Controllers\admin\ReviewsController@edit')->where('id', '[0-9]+')->middleware('auth');
Route::post('/admin/reviews/update/{id}', 'App\Http\Controllers\admin\ReviewsController@update')->where('id', '[0-9]+')->middleware('auth');

/* My services */
Route::get('/admin/my-services', 'App\Http\Controllers\admin\MyServicesController@index')->middleware('auth');
Route::post('/admin/my-services/update', 'App\Http\Controllers\admin\MyServicesController@update')->middleware('auth');

/* Schedule */
Route::get('/admin/schedule', 'App\Http\Controllers\admin\ScheduleController@index')->middleware('auth');
Route::get('/admin/schedule/member/{id}', 'App\Http\Controllers\admin\ScheduleController@show')->where('id', '[0-9]+')->middleware('auth');

/* Marketing */
Route::get('/admin/marketing', 'App\Http\Controllers\admin\MarketingController@index')->middleware('auth');
Route::get('/admin/marketing/new', 'App\Http\Controllers\admin\MarketingController@create')->middleware('auth');
Route::get('/admin/marketing/list', 'App\Http\Controllers\admin\MarketingController@edit')->middleware('auth');
Route::get('/admin/marketing/edit/{id}', 'App\Http\Controllers\admin\MarketingController@editList')->where('id', '[0-9]+')->middleware('auth');
Route::get('/admin/marketing/edit-item/{id}', 'App\Http\Controllers\admin\MarketingController@editItem')->where('id', '[0-9]+')->middleware('auth');
Route::post('/admin/marketing/store', 'App\Http\Controllers\admin\MarketingController@store')->middleware('auth');
Route::post('/admin/marketing/update/{id}', 'App\Http\Controllers\admin\MarketingController@update')->where('id', '[0-9]+')->middleware('auth');
Route::post('/admin/marketing/enable/{id}', 'App\Http\Controllers\admin\MarketingController@enableCampaign')->where('id', '[0-9]+')->middleware('auth');
Route::get('/admin/marketing/confirm-delete/{id}', 'App\Http\Controllers\admin\MarketingController@confirmDelete')->where('id', '[0-9]+')->middleware('auth');
Route::post('/admin/marketing/delete', 'App\Http\Controllers\admin\MarketingController@destroy')->middleware('auth');

/* Work time */
Route::get('/admin/schedule/work-time/{id}', 'App\Http\Controllers\admin\WorkTimeController@index')->where('id', '[0-9]+')->middleware('auth');
Route::post('/admin/schedule/work-time/store', 'App\Http\Controllers\admin\WorkTimeController@store')->middleware('auth');
Route::get('/admin/schedule/work-time/confirm-delete/{id}/{user}', 'App\Http\Controllers\admin\WorkTimeController@confirmDelete')->where('id', '[0-9]+')->where('user', '[0-9]+')->middleware('auth');
Route::post('/admin/schedule/work-time/delete', 'App\Http\Controllers\admin\WorkTimeController@destroy')->middleware('auth');
Route::get('/admin/schedule/generate/{id}', 'App\Http\Controllers\admin\WorkTimeController@generate')->where('id', '[0-9]+')->middleware('auth');
Route::post('/admin/schedule/generate/store', 'App\Http\Controllers\admin\WorkTimeController@generateStore')->middleware('auth');
Route::get('/admin/schedule/work-time/{user}/edit/{id}', 'App\Http\Controllers\admin\WorkTimeController@edit')->where('user', '[0-9]+')->where('id', '[0-9]+')->middleware('auth');
Route::post('/admin/schedule/work-time/update', 'App\Http\Controllers\admin\WorkTimeController@update')->middleware('auth');

/* Vacations */
Route::get('/admin/schedule/vacations/{id}', 'App\Http\Controllers\admin\VacationsController@index')->where('id', '[0-9]+')->middleware('auth');
Route::post('/admin/schedule/vacations/store', 'App\Http\Controllers\admin\VacationsController@store')->middleware('auth');
Route::get('/admin/schedule/vacations/confirm-delete/{id}/{user}', 'App\Http\Controllers\admin\VacationsController@confirmDelete')->where('id', '[0-9]+')->where('user', '[0-9]+')->middleware('auth');
Route::post('/admin/schedule/vacations/delete', 'App\Http\Controllers\admin\VacationsController@destroy')->middleware('auth');

/* Reservations */
// Route::get('/admin/reservations', 'admin\ReservationsController@index')->middleware('auth');
Route::get('/admin/reservations', [App\Http\Controllers\admin\ReservationsController::class, 'index'])->middleware('auth');
Route::get('/admin/reservations/reservation/{id}', 'App\Http\Controllers\admin\ReservationsController@get')->where('id', '[0-9]+')->middleware('auth');
Route::get('/admin/reservations/get-schedule-by-user', 'App\Http\Controllers\admin\ReservationsController@GetScheduleByUser')->middleware('auth');
Route::get('/admin/reservations/confirm-delete/{id}', 'App\Http\Controllers\admin\ReservationsController@confirmDelete')->where('id', '[0-9]+')->middleware('auth');
Route::post('/admin/reservations/delete', 'App\Http\Controllers\admin\ReservationsController@destroy')->middleware('auth');
Route::get('/admin/reservations/add', 'App\Http\Controllers\admin\ReservationsController@create')->middleware('auth');
Route::get('/admin/reservations/get-terms', 'App\Http\Controllers\admin\ReservationsController@GetTerms')->middleware('auth');
Route::post('/admin/reservations/store-ajax', 'App\Http\Controllers\admin\ReservationsController@storeAjax')->middleware('auth');

/* My Website */
Route::get('/admin/my-website', 'App\Http\Controllers\admin\MyWebsiteController@index')->middleware('auth');


/* Cron */
Route::get('/renewals/update', 'App\Http\Controllers\admin\RenewalsController@renew');
Route::get('/sms/send', 'App\Http\Controllers\admin\SmsController@send');
Route::get('/sms/balance', 'App\Http\Controllers\admin\SmsController@balance');
Route::get('/marketing/send', 'App\Http\Controllers\admin\MarketingController@send');

// Route::get('login', 'Auth\LoginController@showLoginForm')->name('login');
// Route::get('admin/login', [App\Http\Controllers\admin\LoginController::class, 'showLoginForm'])->name('login');
// Route::post('login', 'Auth\LoginController@login');
// Route::post('logout', 'Auth\LoginController@logout')->name('logout');

// Password Reset Routes...
Route::get('password/reset', 'Auth\ForgotPasswordController@showLinkRequestForm')->name('password.request');
Route::post('password/email', 'Auth\ForgotPasswordController@sendResetLinkEmail')->name('password.email');
Route::get('password/reset/{token}', 'Auth\ResetPasswordController@showResetForm')->name('password.reset');
Route::post('password/reset', 'Auth\ResetPasswordController@reset');

// checar se é um domínio
Route::group(['domain' => '{account}.agendero.site'], function()
{
    Route::get('/', [App\Http\Controllers\app\IndexController::class, 'indexSub']);
    Route::get('/reservar', [App\Http\Controllers\app\ReservationsController::class, 'indexSiteSub']);
    Route::get('/team', 'App\Http\Controllers\app\IndexController@aboutUsSub');
    Route::get('/services', 'App\Http\Controllers\app\IndexController@servicesSub');
    Route::get('/reviews', 'App\Http\Controllers\app\IndexController@recensionsSub');
    Route::get('/working-hours', 'App\Http\Controllers\app\IndexController@workTimeSub');
    Route::get('/contact', 'App\Http\Controllers\app\IndexController@contactSub');
    Route::post('/mail', 'App\Http\Controllers\app\IndexController@mailSub');
    Route::post('/recension', 'App\Http\Controllers\app\IndexController@recensionSub');
    Route::get('/booking', [App\Http\Controllers\app\ReservationsController::class, 'indexSiteSub']);
});

// teste de login diferente para subdominios
// Route::group(['domain' => '{account}.agendero.site'], function()
// {
//     Route::get('/booking', [App\Http\Controllers\app\ReservationsController::class, 'indexSiteSub']);
//     Route::get('admin/login', [App\Http\Controllers\admin\LoginController::class, 'showLoginForm'])->name('login');
// });

/* Website links */
Route::get('/', [App\Http\Controllers\app\IndexController::class, 'index']);
// Route::get('/', 'app\IndexController@index')->middleware('IfExpired', 'WhichApp');
Route::get('/team', 'App\Http\Controllers\app\IndexController@aboutUs');
Route::get('/services', 'App\Http\Controllers\app\IndexController@services');
Route::get('/reviews', 'App\Http\Controllers\app\IndexController@recensions');
Route::get('/working-hours', 'App\Http\Controllers\app\IndexController@workTime');
Route::get('/contact', 'App\Http\Controllers\app\IndexController@contact');
Route::post('/mail', 'App\Http\Controllers\app\IndexController@mail');
Route::post('/recension', 'App\Http\Controllers\app\IndexController@recension');
Route::get('/booking', [App\Http\Controllers\app\ReservationsController::class, 'indexSite']);
// Route::get('/booking', 'app\ReservationsController@indexSite');

/* App links */
Route::get('/book', 'app\ReservationsController@index');
Route::post('/customers/store-ajax', 'app\CustomersController@storeAjax');
Route::post('/customers/store-ajax-full', 'app\CustomersController@storeAjaxFull');
Route::get('/reservations/get-terms', 'app\ReservationsController@GetTerms');
Route::post('/reservations/store-ajax', 'app\ReservationsController@storeAjax');


/* API links */
Route::get('/api/index', 'api\IndexController@index');
Route::get('/api/team', 'api\IndexController@aboutUs');
Route::get('/api/services', 'api\IndexController@services');
Route::get('/api/working-hours', 'api\IndexController@workTime');
Route::get('/api/recensions', 'api\IndexController@recensions');
Route::post('/api/recensions/post', 'api\IndexController@recension');
Route::post('/api/mail', 'api\IndexController@mail');
Route::get('/api/book', 'api\ReservationsController@index');
Route::get('/api/days', 'api\ReservationsController@days');
Route::get('/api/reservations/get-terms', 'api\ReservationsController@GetTerms');
Route::get('/api/area-codes', 'api\IndexController@GetAreaCodes');
Route::post('/api/customers/store-ajax', 'api\CustomersController@storeAjax');
Route::post('/api/customers/store-ajax-full', 'api\CustomersController@storeAjaxFull');
Route::post('/api/reservations/store-ajax', 'api\ReservationsController@storeAjax');


require __DIR__.'/auth.php';
