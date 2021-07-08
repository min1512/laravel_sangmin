<?php
class exampleChannelAdvisorAuth
{
    public $DeveloperKey;
    public $Password;

    public function __construct($key, $pass)
    {
        $this->DeveloperKey = $key;
        $this->Password = $pass;
    }
}

$devKey        = "";
$password    = "";
$accountId    = "";

// Create the SoapClient instance
$url         = "";
$client     = new SoapClient($url, array("trace" => 1, "exception" => 0));

// Create the header
$auth         = new ChannelAdvisorAuth($devKey, $password);
$header     = new SoapHeader("http://www.example.com/webservices/", "APICredentials", $auth, false);

// Call wsdl function
$result = $client->__soapCall("DeleteMarketplaceAd", array(
    "DeleteMarketplaceAd" => array(
        "accountID"        => $accountId,
        "marketplaceAdID"    => "9938745"        // The ads ID
    )
), NULL, $header);

// Echo the result
echo "<pre>".print_r($result, true)."</pre>";
if($result->DeleteMarketplaceAdResult->Status == "Success")
{
    echo "Item deleted!";
}
?>