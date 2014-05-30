<?php

class UserVisitController extends BaseController {

  /**
   * Shows city visits of a particular user
   *
   * @param int $id User id
   * @return UserVisit
   */
  public function show( $id )
  {
    return UserVisit::where( 'user_id', $id )->paginate( self::ITEMS_PER_PAGE );
  }

  /**
   * Adds a visit of a particular city to a user
   *
   * @param int $id User id
   * @param Input::JSON city The visited city ex: 'Allentown'
   * @param Input::JSON state The 2 char state ex: 'PA'
   * @return Response
   */
  public function store( $id )
  {
    $inputData = array(
      'user_id' => (int) $id,
      'city' => Input::json( 'city' ),
      'state' => Input::json( 'state' )
    );

    // ensure initial input is at least 'sort of' valid
    $validator = Validator::make(
      $inputData,
      array( 
        'user_id' => 'required|integer|exists:users,id',
        'city' => 'required',
        'state' => 'required'
      ),
      array(
        'user_id.required' => 'A user is required',
        'user_id.integer' => 'The user id must be an integer',
        'user_id.exists' => 'That user does not exist',
        'city.required' => 'A city is required',
        'state.required' => 'A state is required',
      ) );

    // if the basic validation fails, we can bail here
    if( $validator->fails() )
    {
      return Response::json( $validator->messages(), 400 );
    }

    // retrieve the cityId
    $city = City::where( 'name', '=', $inputData['city'] )
      ->where( 'state', '=', $inputData['state'] )
      ->firstOrFail();

    $userVisit = UserVisit::firstOrCreate( array(
      'user_id' => $inputData['user_id'],
      'city_id' => $city['id']
      ) );

    return Response::make( '', 200 );
  }
}
