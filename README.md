# ValidatedAddressWithSmartyStreetsAPI

A compact website that contains a table displaying information (columns headers: street, city, state, zip), an HTML form with 3 input fields (street, city, state) and 1 submit button. The input fields accept a U.S. address (e.g. 1600 Amphitheatre Parkway, Mountain View, CA.) Once the user has provided an address and clicked submit, an AJAX request will be made to a PHP file. This PHP file accepts the user's address input and make an external call to the APIs to validate the location. The API responds with a validated address and a zip code. The script store the user's inputted address and the API response in a MySQL database. If the same address is requested a 2nd time, no external API call is required to get the validated address data and the Zip code will be extracted from the already validated records from the database.

APIs
SmartyStreets: https://smartystreets.com/free-address-verification

Example call: https://api.smartystreets.com/street-address?auth-id=YOUR_ID&auth-token=YOUR_TOKEN&street=1600+amphitheatre+pkwy&city=mountain+view&state=CA
