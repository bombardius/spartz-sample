<?php

class City extends Eloquent {

	protected $table = 'cities';
  protected $fillable = array( 'name', 'state', 'is_verified', 'latitude', 'longitude' );
  protected $visible = array( 'id', 'name', 'state' );
  public $timestamps = false;

  public function getIdAttribute( $value )
  {
    return (int) $value;
  }

  public function getIsVerifiedAttribute( $value )
  {
    return (bool) $value;
  }

  public function getLatitudeAttribute( $value )
  {
    return (double) $value;
  }

  public function getLongitudeAttribute( $value )
  {
    return (double) $value;
  }
}
