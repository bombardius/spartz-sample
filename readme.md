Create a REST Controller to handle the following HTTP requests based on the information included in cities.csv and users.csv.  Provide a code sample as well as the database structure you use to implement your solution.  Please consider how to deal with bad requests, how to respond to requests with large datasets, and what additional structures may be needed to track user visits.
 
- List all cities in a state
  - GET /v1/states/<STATE>/cities.json
- List cities within a 100 mile radius of a city
  - GET /v1/states/<STATE>/cities/<CITY>.json?radius=100
- Allow a user to update a row of data to indicate they have visited a particular city.
- Return a list of cities the user has visited
  - GET /v1/users/<USER_ID>/visits
- POST /v1/users/<USER_ID>/visits
```javascript 
{
‘city’ : <CITY>,
‘state’ : <STATE>
}
```
 
