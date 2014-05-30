<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDatabase extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
    Schema::create( 'cities', function( $table )
    {
      $table->bigIncrements( 'id' );
      $table->string( 'name' );
      $table->char( 'state', 2);
      $table->boolean( 'is_verified' );
      // +/-90 and 6 decimal places
      $table->double( 'latitude', 8, 6 );
      // +/-180 and 6 decimal places
      $table->double( 'longitude', 9, 6 );

      // index state, city for name search and state lists
      // further tweaking possible here with index sizing
      $table->index( array( 'state', 'name' ) );
    });

    // create the geospatial index (postres only)
    DB::statement( "CREATE INDEX cities_gist_idx ON cities USING gist( ll_to_earth( latitude, longitude ) )" );

    Schema::create( 'users', function( $table )
    {
      $table->bigIncrements( 'id' );
      $table->string( 'first_name' );
      $table->string( 'last_name' );
    });

    Schema::create( 'user_visits', function( $table )
    {
      // required because laravel doesn't like composite primary keys
      $table->bigIncrements( 'id' );
      $table->bigInteger( 'user_id' )->unsigned()->references( 'id' )->on( 'users' )->onDelete( 'cascade' )->onUpdate( 'cascade' );
      $table->bigInteger( 'city_id' )->unsigned()->references( 'id' )->on( 'cities' )->onDelete( 'cascade' )->onUpdate( 'cascade' );
    });
  }

  /**
   * Reverse the migrations.
   *
   * @return void
   */
  public function down()
  {
    Schema::dropIfExists( 'user_visits' );
    Schema::dropIfExists( 'users' );
    Schema::dropIfExists( 'cities' );
  }
}
