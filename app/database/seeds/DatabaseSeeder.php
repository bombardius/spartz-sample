<?php

class DatabaseSeeder extends Seeder {

	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run()
	{
		Eloquent::unguard();

    // NOTE: there is a certain level of 'trust' here that the data is valid
    $this->command->info( 'Seeding User table from users.csv' );
    $this->call( 'UserTableSeeder' );

    // NOTE: there is a certain level of 'trust' here that the data is valid
    $this->command->info( 'Seeding Cities table from cities.csv' );
    $this->call( 'CityTableSeeder' );
	}

}

class UserTableSeeder extends Seeder {

  // source file provided by Spartz
  const CSV_FILE = 'csv/users.csv';

  public function run()
  {
    DB::table( 'users' )->delete();

    if( ( $handle = fopen( self::CSV_FILE, 'r' ) ) !== false )
    {
      while( ( $data = fgetcsv( $handle, 1000, ',' ) ) !== false )
      {
        if( is_numeric( $data[0] ) )
        {
          User::create( array( 'first_name' => $data[1], 'last_name' => $data[2] ) );
        }
        else
        {
          $this->command->comment( 'Omitted line: ' . json_encode( $data ) );
        }
      }

      fclose( $handle );
    }
    else
    {
      $this->command->error( 'Could not open' . self::CSV_FILE . ' for reading' );
    }
  }
}

class CityTableSeeder extends Seeder {

  // source file provided by Spartz
  const CSV_FILE = 'csv/cities.csv';

  public function run()
  {
    DB::table( 'cities' )->delete();

    if( ( $handle = fopen( self::CSV_FILE, 'r' ) ) !== false )
    {
      while( ( $data = fgetcsv( $handle, 1000, ',' ) ) !== false )
      {
        if( is_numeric( $data[0] ) )
        {
          City::create( array( 
            'name' => $data[1],
            'state' => $data[2],
            'is_verified' => ( $data[3] == 'verified' ),
            'latitude' => (double) $data[4],
            'longitude' => (double) $data[5],
          ) );
        }
        else
        {
          $this->command->comment( 'Omitted line: ' . json_encode( $data ) );
        }
      }

      fclose( $handle );
    }
    else
    {
      $this->command->error( 'Could not open ' . self::CSV_FILE . ' for reading' );
    }
  }
}
