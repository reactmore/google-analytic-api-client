# google-analytic-api-client


Installation :
```php
composer require reactmore/google-analytic-api-client 
```

Usage :

```php
require 'vendor/autoload.php';

use Reactmore\GoogleAnalyticApi\Analytics;
use Reactmore\GoogleAnalyticApi\Helpers\Period;

$Analytics = new Analytics();

echo '<pre>';
var_dump($Analytics->Fetching()->fetchUserTypes(Period::days(7)));
echo '</pre>';


// Method 
$Analytics = new Analytics();
$Analytics->Fetching()->fetchUserTypes(Period::days(7));
$Analytics->Fetching()->fetchTopBrowsers(Period::days(7));
$Analytics->Fetching()->fetchTopReferrers(Period::days(7));
$Analytics->Fetching()->fetchMostVisitedPages(Period::days(7));
$Analytics->Fetching()->fetchTotalVisitorsAndPageViews(Period::days(7));
```

Output Array : 
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



