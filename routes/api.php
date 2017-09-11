<?php

Route::group(['prefix' => '/v1', 'namespace' => 'Api\V1', 'as' => 'api.'], function () {
    Route::get('contacts/{patient_id?}', ['uses' => 'Admin\ContactsController@contactsByPatient', 'as' => 'contacts']);
});
