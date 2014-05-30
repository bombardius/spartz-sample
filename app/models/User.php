<?php

class User extends Eloquent {

	protected $table = 'users';
  protected $fillable = array( 'first_name', 'last_name' );
  public $timestamps = false;

  public function visits()
  {
    return $this->hasMany( 'UserVisit' );
  }

  public function getIdAttribute( $value )
  {
    return (int) $value;
  }

}
