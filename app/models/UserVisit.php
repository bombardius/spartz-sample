<?php

class UserVisit extends Eloquent {

	protected $table = 'user_visits';
  protected $fillable = array( 'user_id', 'city_id' );
  protected $with = array( 'city' );
  protected $visible = array( 'id', 'city' );
  public $timestamps = false;

  public function user()
  {
    return $this->belongsTo( 'User' );
  }

  public function city()
  {
    return $this->belongsTo( 'City', 'city_id' );
  }

  public function getIdAttribute( $value )
  {
    return (int) $value;
  }

  public function getCityIdAttribute( $value )
  {
    return (int) $value;
  }

  public function getUserIdAttribute( $value )
  {
    return (int) $value;
  }
}
