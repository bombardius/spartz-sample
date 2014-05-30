<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the Closure to execute when that URI is requested.
|
*/

/*
 *  -List all cities in a state
 *  GET /v1/states/<STATE>/cities.json
 */
Route::get( 'v1/states/{state}/cities.json', 'CityController@show' )
->where( 'state', '[A-Z][A-Z]' );

/*
 *  -List cities within a 100 mile radius of a city
 *  GET /v1/states/<STATE>/cities/<CITY>.json?radius=100
 */
Route::get( 'v1/states/{state}/cities/{city}.json', 'CityController@showRadius' )
  ->where( 'state', '[A-Z][A-Z]' )
  ->where( 'city', '[a-zA-Z]+' );

/*
 *  - Return a list of cities the user has visited
 *  GET /v1/users/<USER_ID>/visits
 *
 *  - Allow a user to update a row of data to indicate they have visited a particular city.
 *  POST /v1/users/<USER_ID>/visits
 *
 *  {
 *  ‘city’ : <CITY>,
 * ‘state’ : <STATE>
 *  }
 */
Route::get( 'v1/users/{id}/visits', 'UserVisitController@show' )
  ->where( 'id', '[0-9]+' );

Route::post( 'v1/users/{id}/visits', 'UserVisitController@store' )
  ->where( 'id', '[0-9]+' );
