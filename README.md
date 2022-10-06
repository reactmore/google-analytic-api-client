# Google Analytic API Client
[![Latest Stable Version](http://poser.pugx.org/reactmore/google-analytic-api-client/v)](https://packagist.org/packages/reactmore/google-analytic-api-client) [![Total Downloads](http://poser.pugx.org/reactmore/google-analytic-api-client/downloads)](https://packagist.org/packages/reactmore/google-analytic-api-client) [![Latest Unstable Version](http://poser.pugx.org/reactmore/google-analytic-api-client/v/unstable)](https://packagist.org/packages/reactmore/google-analytic-api-client) [![License](http://poser.pugx.org/reactmore/google-analytic-api-client/license)](https://packagist.org/packages/reactmore/google-analytic-api-client) [![PHP Version Require](http://poser.pugx.org/reactmore/google-analytic-api-client/require/php)](https://packagist.org/packages/reactmore/google-analytic-api-client)

PHP library to help you integrate your system to API Google Analytics. 


## Installation 
```php
composer require reactmore/google-analytic-api-client 
```

Configuration .env optional : 
```
VIEW_ID=215165900
SERVICE_CREDENTIALS_JSON= 'google_analytic_services.json'
```

## Usage :

```php
require 'vendor/autoload.php';

use Reactmore\GoogleAnalyticApi\Analytics;
use Reactmore\GoogleAnalyticApi\Helpers\Period;

// Auto Get from Dotenv
$Analytics = new Analytics();
// or manual
$Analytics = new Analytics([
'view_id' => 21312312313,
'service_credentials_json' => 'path/to/google_analytic_services.json'
]);

echo '<pre>';
var_dump($Analytics->Fetching()->fetchUserTypes(Period::days(7)));
echo '</pre>';

// Method 
$Analytics = new Analytics();
// Fetch Users and New Users
$Analytics->Fetching()->fetchUserTypes(Period::days(7));
// Get Data Top Browser used visitor
$Analytics->Fetching()->fetchTopBrowsers(Period::days(7));
// Get Data Refferer Page
$Analytics->Fetching()->fetchTopReferrers(Period::days(7));
// Populer Pages
$Analytics->Fetching()->fetchMostVisitedPages(Period::days(7));
// Get Visitor and Pageviews
$Analytics->Fetching()->fetchTotalVisitorsAndPageViews(Period::days(7));
```

Example Output Array : 
```array
array(2) {
  [0]=>
  array(2) {
    ["type"]=>
    string(11) "New Visitor"
    ["sessions"]=>
    int(2581)
  }
  [1]=>
  array(2) {
    ["type"]=>
    string(17) "Returning Visitor"
    ["sessions"]=>
    int(1215)
  }
}
```

```php
// Custom Query
$Analytics->Fetching()->performQuery($period, $metrix, $other = array());
// Example
$Analytics->Fetching()->performQuery(Period::days(7), 'ga:sessions', ['dimensions' => 'ga:country', 'sort' => '-ga:sessions'])->getRows();
```

Example Output Raw Array : 
```
array(30) {
  [0]=>
  array(2) {
    [0]=>
    string(9) "Indonesia"
    [1]=>
    string(4) "3534"
  }
  [1]=>
  array(2) {
    [0]=>
    string(11) "Afghanistan"
    [1]=>
    string(2) "96"
  }
  [2]=>
  array(2) {
    [0]=>
    string(13) "United States"
    [1]=>
    string(2) "88"
  } 
}
```

Explore Query on this App [ga-dev-tools](https://ga-dev-tools.web.app/query-explorer/)

## Screenshot
![Backend](https://raw.githubusercontent.com/reactmore/google-analytic-api-client/master/screenshoot.png)





