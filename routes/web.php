<?php

Route::get('/', function () {
    return view('welcome');
})->name('home');

Route::get('/login', "LoginController@login")->name('login');
Route::post('/login', "LoginController@postLogin");
Route::get('/logout', "LoginController@logout")->name('logout');

Route::group(['middleware' => ['auth', 'ieFix']], function () {
    Route::get('/home', "HomeController@dashboard")->name('dashboard');
    Route::get('/blank', "HomeController@blank")->name('blank');
    Route::get('/access_denied', "HomeController@access_denied")->name('access_denied');

    Route::get('/data_entry/index', "DataEntryController@data_entry")->name('data_entry');
    Route::get('/data_entry/edit/{id}', "DataEntryController@data_entry_edit")->name('data_entry.edit');
    Route::post('/data_entry/merge/{type}', "DataEntryController@data_entry_merge")->name('data_entry.merge');
    Route::post('/duplicate/check', "DataEntryController@duplicate")->name('duplicate_check');
    Route::post('/data_entry/customer', "DataEntryController@post_data_entry")->name('customer_entry');
    Route::post('/data_entry/vehicle', "DataEntryController@post_vehicle_entry")->name('vehicle_entry');
    Route::post('/data_entry/transaction', "DataEntryController@post_transaction_entry")->name('transaction_entry');
    Route::post('/data_entry/get_vehicles', "DataEntryController@get_vehicles")->name('customer_vehicles');

    Route::get('/data_lookup/customers', "DataLookupController@customers")->name('data_lookup.customers');
    Route::get('/data_lookup/vehicles', "DataLookupController@vehicles")->name('data_lookup.vehicles');
    Route::get('/data_lookup/transactions', "DataLookupController@transactions")->name('data_lookup.transactions');
    Route::get('/datatables_ajax/vehicles', "DataLookupController@datatables_ajax_vehicles")->name('datatables_ajax.vehicles');
    Route::get('/datatables_ajax/customers', "DataLookupController@datatables_ajax_customers")->name('datatables_ajax.customers');
    Route::get('/datatables_ajax/transactions', "DataLookupController@datatables_ajax_transactions")->name('datatables_ajax.transactions');

    Route::get('/users/index', "UsersController@index")->name('users.index');
    Route::post('/users/save', "UsersController@save_form")->name('users.save');
    Route::post('/users/delete', "UsersController@user_delete")->name('users.delete');
    Route::get('/datatables_ajax/users', "UsersController@datatables_ajax_users")->name('datatables_ajax.users');

    Route::get('/sessions/index', "SessionController@index")->name('sessions.index');
    Route::get('/datatables_ajax/sessions', "SessionController@datatables_ajax_sessions")->name('datatables_ajax.sessions');

    Route::get('/reports/index', "ReportsController@index")->name('reports.index');
    Route::post('/reports/raw_query', "ReportsController@raw_query")->name('reports.raw_query');
    Route::post('/reports/save', "ReportsController@save_report")->name('reports.save_report');
    Route::get('/reports/view', "ReportsController@view")->name('reports.view');
    Route::get('/reports/make/{id}', "ReportsController@make")->name('reports.generator');
    Route::get('/reports/pivot/{id}', "ReportsController@pivot")->name('reports.pivot');
    Route::get('/reports/csv/{id}', "ReportsController@csv")->name('reports.csv');
    Route::get('/reports/download/{id}', "ReportsController@download")->name('reports.download');
    Route::get('/reports/mail/{id}', "ReportsController@send_mail")->name('reports.mail');

    Route::get('/mailing/index', "MailingController@index")->name('mailing.index');
    Route::post('/mailing/save', "MailingController@save")->name('mailing.save');
    Route::post('/mailing/delete', "MailingController@delete")->name('mailing.delete');

    Route::get('/setting/index', "SettingController@index")->name('settings.index');
    Route::post('/setting/save', "SettingController@save_setting")->name('settings.save');

});
