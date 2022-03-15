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

Route::get('/', function () {
    return view('dashboard');
});


Route::get('/ppc', function () {
    return view('ppc');
});

Route::get('/grinding_receiving', function () {
    return view('grinding_receiving');
});
Route::get('/grinding_asset', function () {
    return view('grinding_asset');
});

Route::get('/administrator', function () {
    return view('administrator');
});

Route::get('/transaction_history', function () {
    return view('transaction_history');
});


Route::get('/export', 'InvExcelController@export')->name('export');


// PPC Route
Route::get('/get_basemold_info', 'PPCController@get_basemold_info');
Route::post('/add_basemold', 'PPCController@add_basemold');
Route::get('/get_basemold_for_view', 'PPCController@get_basemold_for_view');
Route::get('/get_code', 'PPCController@get_code');
Route::get('/get_partname_by_code', 'PPCController@get_partname_by_code');
Route::get('/get_basemold_info_for_edit', 'PPCController@get_basemold_info_for_edit');
Route::get('/delete_basemold', 'PPCController@delete_basemold');
Route::post('/import_basemold', 'PPCController@import_basemold');
Route::post('/import_ts_basemold', 'PPCController@import_ts_basemold');

Route::get('/download_file', 'PPCController@download_file');




//Grinding Route
Route::get('/get_basemold_info_grinding', 'GrindingController@get_basemold_info_grinding');
Route::post('/accept_basemold', 'GrindingController@accept_basemold');
Route::post('/disapprove_basemold', 'GrindingController@disapprove_basemold');

Route::get('/get_wip_basemold', 'GrindingController@get_wip_basemold');
Route::get('/getWipBasemoldInfo', 'GrindingController@getWipBasemoldInfo');
Route::get('/getWipBasemoldInfoForTransaction', 'GrindingController@getWipBasemoldInfoForTransaction');
Route::post('/wipTransaction', 'GrindingController@wipTransaction');
Route::get('/get_fgs_code', 'GrindingController@get_fgs_code');
Route::get('/get_fgs_name', 'GrindingController@get_fgs_name');

Route::get('/get_fgs_details', 'GrindingController@get_fgs_details');
Route::get('/get_fgs_info', 'GrindingController@get_fgs_info');
Route::get('/get_fgs_info_for_transaction', 'GrindingController@get_fgs_info_for_transaction');


Route::get('/get_rework_visual_details', 'GrindingController@get_rework_visual_details');
Route::get('/get_rework_visual_info_by_id', 'GrindingController@get_rework_visual_info_by_id');


Route::get('/get_rework_visual_transaction', 'GrindingController@get_rework_visual_transaction');
Route::get('/get_data_for_rework_visual_transaction', 'GrindingController@get_data_for_rework_visual_transaction');


Route::post('/inset_rework_visual_transaction', 'GrindingController@inset_rework_visual_transaction');


Route::get('/get_rework_visual_info_for_edit', 'GrindingController@get_rework_visual_info_for_edit');
Route::post('/insert_rework_visual_edit', 'GrindingController@insert_rework_visual_edit');

Route::get('/get_fgs_details_for_remarks', 'GrindingController@get_fgs_details_for_remarks');
Route::post('/add_remarks_fgs', 'GrindingController@add_remarks_fgs');

Route::get('/get_wip_details_for_remarks', 'GrindingController@get_wip_details_for_remarks');
Route::post('/add_remarks_wip', 'GrindingController@add_remarks_wip');




//ADMIN Route
Route::get('/get_rapidx_userlist', 'UserController@get_rapidx_userlist');
Route::post('/add_user', 'UserController@add_user');
Route::get('/get_user', 'UserController@get_user');
Route::get('/get_user_list', 'UserController@get_user_list');
Route::get('/disable_user', 'UserController@disable_user');
Route::get('/enable_user', 'UserController@enable_user');
Route::get('/get_user_id_for_edit', 'UserController@get_user_id_for_edit');
Route::post('/edit_user', 'UserController@edit_user');
Route::get('/get_user_log', 'UserController@get_user_log');



Route::get('/get_shipout', 'GrindingController@get_shipout');
Route::get('/getFgsShipment', 'GrindingController@getFgsShipment');
Route::post('/insert_fgs_transaction', 'GrindingController@insert_fgs_transaction');



Route::get('/get_transaction', 'TransactionController@get_transaction');

Route::get('/get_setup_transaction', 'TransactionController@get_setup_transaction');
Route::get('/get_setup_transaction_details', 'TransactionController@get_setup_transaction_details');
Route::get('/get_rework_visual_transaction_history', 'TransactionController@get_rework_visual_transaction');
Route::get('/get_rework_visual_transaction_details', 'TransactionController@get_rework_visual_transaction_details');
Route::get('/get_buyoff_transaction_history', 'TransactionController@get_buyoff_transaction_history');
Route::get('/get_buyoff_transaction_details', 'TransactionController@get_buyoff_transaction_details');








