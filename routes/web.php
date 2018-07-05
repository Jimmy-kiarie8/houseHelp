<?php

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

/*Route::get('/cv', function () {
return view('Cv');
});*/

Route::get('verifyEmailFirst', 'Auth\RegisterController@verifyEmailFirst')->name('verifyEmailFirst');
Route::get('/verify/{verifyToken}', 'EmailController@verify')->name('verify');

// Socialite
// Route::get('login/google', 'Auth\LoginController@redirectToProvider');
// Route::get('login/google/callback', 'Auth\LoginController@handleProviderCallback');
Route::get('login/{service}', 'Auth\LoginController@redirectToProvider');
Route::get('login/{service}/callback', 'Auth\LoginController@handleProviderCallback');

Auth::routes();
Route::group(['middleware' => ['auth']], function () {
	Route::get('/home', 'HomeController@index')->name('home');
	Route::get('/manage', function () {
		/*$newrole = Auth::user()->roles;
			    	foreach ($newrole as $name) {
			    		$rolename = $name->name;
		*/
		// return view('welcome', compact('rolename', 'company_logo'));
		return view('welcome');
	});

	Route::get('manage/${name}', function () {
		return redirect('/');
	})->where('name', '[A-Za-z]+');

	Route::resource('users', 'UserController');
	// Route::resource('file', 'HomeController');
	Route::resource('jobs', 'JobsController');
	Route::resource('email', 'EmailController');
	Route::resource('blog', 'BlogController');

	Route::post('/getUsers', 'UserController@getUsers')->name('getUsers');
	Route::post('/profile/{id}', 'UserController@profile')->name('profile');
	Route::post('/userUpdate', 'UserController@userUpdate')->name('userUpdate');
	Route::post('/fewUsers', 'UserController@fewUsers')->name('fewUsers');
	Route::post('/getRoles', 'UserController@getRoles')->name('getRoles');
	Route::post('/getClient', 'UserController@getClient')->name('getClient');
	Route::post('/getMechanics', 'UserController@getMechanics')->name('getMechanics');
	Route::post('/getAdmin', 'UserController@getAdmin')->name('getAdmin');

	// Route::post('/attachments/store', 'HomeController@store')->name('store-attachments');
	// Route::post('/attachments', 'HomeController@pullAttachments')->name('pull-attachments');
	// Route::delete('/attachments/', 'HomeController@deleteAttachment')->name('delete-attachment');
	// Route::post('/attachments/categories', 'HomeController@getCategories')->name('pull-categories');
	// Route::post('/categories', 'HomeController@storeCategories');
	// Route::post('/getCategory', 'HomeController@getCategory');

	Route::post('/download', 'CategoryController@download')->name('download');
	Route::post('/getLogedDocs', 'CategoryController@getLogedDocs')->name('getLogedDocs');

	Route::post('/comments/{id}', 'CommentsController@comments')->name('comments');
	Route::post('/getComments', 'CommentsController@getComments')->name('getComments');
	Route::post('/fewComments', 'CommentsController@fewComments')->name('fewComments');
	Route::post('/getAllComments/${id}', 'CommentsController@getAllComments')->name('getAllComments');

	// CV
	Route::post('/experience/{id}', 'ResumeController@experience')->name('experience');
	Route::post('/education/{id}', 'ResumeController@education')->name('education');
	Route::post('/personal/{id}', 'ResumeController@personal')->name('personal');
	Route::post('/skills/{id}', 'ResumeController@skills')->name('skills');

	Route::post('/getExperience', 'ResumeController@getExperience')->name('getExperience');
	Route::post('/getEducation', 'ResumeController@getEducation')->name('getEducation');
	Route::post('/getPersonal', 'ResumeController@getPersonal')->name('getPersonal');
	Route::post('/getSkills', 'ResumeController@getSkills')->name('getSkills');
	Route::post('/getMeckSkills', 'ResumeController@getMeckSkills')->name('getMeckSkills');

	Route::post('/updateJobFalse/{id}', 'JobsController@updateJobFalse')->name('updateJobFalse');
	Route::post('/updateJobTrue/{id}', 'JobsController@updateJobTrue')->name('updateJobTrue');
	Route::post('/getJobs/{id}', 'JobsController@getJobs')->name('getJobs');
	Route::post('/getJobInfo/{id}', 'JobsController@getJobInfo')->name('getJobInfo');
	Route::post('/updateReqTrue/{id}', 'JobsController@updateReqTrue')->name('updateReqTrue');
	Route::post('/updateReqFalse/{id}', 'JobsController@updateReqFalse')->name('updateReqFalse');

	// E-MAILS
	Route::post('/sendmail', 'EmailController@sendmail')->name('sendmail');
	Route::post('/getsubscribers', 'EmailController@getsubscribers')->name('getsubscribers');
	Route::post('/subscribe', 'EmailController@subscribe')->name('subscribe');
	Route::post('/fewSubs', 'EmailController@fewSubs')->name('fewSubs');
	Route::post('/refresh/{id}', 'EmailController@refresh')->name('refresh');

	Route::get('/slack', 'EmailController@slack');
	Route::get('/slacks', 'EmailController@slacks');

	Route::post('/getunsubscribed', 'EmailController@getunsubscribed')->name('getunsubscribed');
	// Blog
	Route::post('/getBlog', 'BlogController@getBlog')->name('getBlog');
	Route::post('/blogImage/{id}', 'BlogController@blogImage')->name('blogImage');
	Route::post('/getImgBlog/{id}', 'BlogController@getImgBlog')->name('getImgBlog');
	Route::post('/BlogImage', 'BlogController@BlogImage')->name('BlogImage');

	// Blog	Comments
	Route::post('/getPostCom', 'CommentsController@getPostCom')->name('getPostCom');
	Route::post('/getSingleCom/{id}', 'CommentsController@getSingleCom')->name('getSingleCom');
	Route::post('/Postcom/{id}', 'CommentsController@Postcom')->name('Postcom');
	Route::post('/getBlogC/{id}', 'CommentsController@getBlogC')->name('getBlogC');

});