<?php

class CityController extends BaseController {

  const DEFAULT_SEARCH_RADIUS = 100;

  /**
   * Handles the GET response for listing cities in a given state
   *
   * @param string $state The two character state representation ex: 'PA'
   * @return City
   */
  public function show( $state )
  {
    return City::where( 'state', $state )->paginate( self::ITEMS_PER_PAGE );
  }

  /**
   * Handle the GET response for searching within 100mi
   *
   * @param string $state The two character state representation ex: 'PA'
   * @param string $city The name of the city ex: 'Allentown'
   * @param GET radius The search radius (defaults to 100)
   * @return City
   */
  public function showRadius( $state, $city )
  {
    $city = City::where( 'name', $city)
      ->where( 'state', $state )
      ->firstOrFail();

    $radius = (float) Input::get( 'radius', self::DEFAULT_SEARCH_RADIUS );

    // convert input miles to meters
    $radius *= 1609.34;

    return City::whereRaw( 'earth_box( ll_to_earth( ?, ? ), ? ) @> ll_to_earth(cities.latitude, cities.longitude)', array( $city['latitude'], $city['longitude'], $radius ) )
    ->paginate( self::ITEMS_PER_PAGE );
  
    // ORDER BY eliminated because it slows things down significantly
    // and is not a project requirement
    //  ->orderByRaw( "earth_distance(ll_to_earth( ?, ? ), ll_to_earth(cities.latitude, cities.longitude))", array( $city['latitude'], $city['longitude'] ) )
  }
}
