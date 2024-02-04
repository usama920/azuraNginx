<?php

$whmcsUrl = "https://portal.casthost.net/";
$api_identifier = "s1xS6qAtUE0z5HoYdFVnE2wO3HXfHQ2g";
$api_secret = "XzBYD7151kGeMaU7ApoFKkLgXZKEc9QC";

$postfields = array(
    'identifier' => $api_identifier,
    'secret' => $api_secret,
    'action' => 'GetProducts',
    'pid' => "240, 204, 318, 317, 284",
    'responsetype' => 'json',
);

$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $whmcsUrl . 'includes/api.php');
curl_setopt($ch, CURLOPT_POST, 1);
curl_setopt($ch, CURLOPT_TIMEOUT, 30);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 1);
curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 2);
curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($postfields));
$response = curl_exec($ch);
curl_close($ch);

// echo "<pre>";
// print_r($response);
// die;

include('language_info.php');

try {
    $product_data = "whmcs/products.json";
    $jsondata = file_get_contents($product_data);
    $priceList = json_decode($jsondata);

    $current_domain = $_SERVER['HTTP_HOST'];

    $response = json_decode($response, true);
    foreach ($response['products']['product'] as $dkey => $products) {
        $product_id = $products['pid'];
        if (strpos($current_domain, 'casthost.ca') !== false) {
            $currency = 'CAD'; // Set currency to CAD for casthost.ca
        } else {
            $currency = 'USD'; // Set currency to USD for all other domains
        }
        if ($product_id == 240) {     //stream_packages - STARTER PLAN
            $configoptions = $products['configoptions'];
            $price_stream_starter_monthly = $configoptions['configoption'][0]['options']['option'][0]['pricing'][$currency]['monthly'];
            $price_stream_starter_quarterly = $configoptions['configoption'][0]['options']['option'][0]['pricing'][$currency]['quarterly'];
            $price_stream_starter_semiannually = $configoptions['configoption'][0]['options']['option'][0]['pricing'][$currency]['semiannually'];
            $price_stream_starter_annually = $configoptions['configoption'][0]['options']['option'][0]['pricing'][$currency]['annually'];
        }
        if ($product_id == 204) {    //stream_packages - UNLIMITED PLAN
            $configoptions = $products['configoptions'];
            $price_stream_unlimited_monthly = $configoptions['configoption'][0]['options']['option'][0]['pricing'][$currency]['monthly'];
            $price_stream_unlimited_quarterly = $configoptions['configoption'][0]['options']['option'][0]['pricing'][$currency]['quarterly'];
            $price_stream_unlimited_semiannually = $configoptions['configoption'][0]['options']['option'][0]['pricing'][$currency]['semiannually'];
            $price_stream_unlimited_annually = $configoptions['configoption'][0]['options']['option'][0]['pricing'][$currency]['annually'];
        }

        if ($product_id == 318) {    // cpanel_hosting - STARTER PLAN
            $pricing = json_decode(json_encode($products), true);
            $price_cpanel_starter_monthly = $pricing['pricing'][$currency]['monthly'];
            $price_cpanel_starter_quarterly = $pricing['pricing'][$currency]['quarterly'];
            $price_cpanel_starter_semiannually = $pricing['pricing'][$currency]['semiannually'];
            $price_cpanel_starter_annually = $pricing['pricing'][$currency]['annually'];
        }
        if ($product_id == 317) {    // cpanel_hosting - UNLIMITED PLAN
            $pricing = json_decode(json_encode($products), true);
            $price_cpanel_unlimited_monthly = $pricing['pricing'][$currency]['monthly'];
            $price_cpanel_unlimited_quarterly = $pricing['pricing'][$currency]['quarterly'];
            $price_cpanel_unlimited_semiannually = $pricing['pricing'][$currency]['semiannually'];
            $price_cpanel_unlimited_annually = $pricing['pricing'][$currency]['annually'];
        }
        if ($product_id == 284) {    // streamurl - PLAN
            $pricing = json_decode(json_encode($products), true);
            $price_streamurl_monthly = $pricing['pricing'][$currency]['monthly'];
            $price_streamurl_quarterly = $pricing['pricing'][$currency]['quarterly'];
            $price_streamurl_semiannually = $pricing['pricing'][$currency]['semiannually'];
            $price_streamurl_annually = $pricing['pricing'][$currency]['annually'];
        }
    }

    foreach ($priceList->product as $dkey => $products) {
        $products = json_decode(json_encode($products), true);

        $product_id = $products['pid'];

        // Check if the current domain is casthost.ca
        if (strpos($current_domain, 'casthost.ca') !== false) {
            $currency = 'CAD'; // Set currency to CAD for casthost.ca
        } else {
            $currency = 'USD'; // Set currency to USD for all other domains
        }

        if ($product_id == 279) {    // seoservices - PLAN
            $pricing = json_decode(json_encode($products), true);
            $price_seo_monthly = $pricing['pricing'][$currency]['monthly'];
            $price_seo_quarterly = $pricing['pricing'][$currency]['quarterly'];
            $price_seo_semiannually = $pricing['pricing'][$currency]['semiannually'];
            $price_seo_annually = $pricing['pricing'][$currency]['annually'];
        }
    }
} catch (Exception $e) {
    echo "error";
}
?>

<!DOCTYPE html>
<html class="no-js" lang="en">

<head>
    <?php if ($language == "fr") { ?>
        <title>Plans tarifaires - Forfaits de streaming radio | CastHost</title>
        <meta name="title" content="Plans tarifaires - Forfaits de streaming radio | CastHost" />
        <meta name="description" content="Démarrer votre propre station de radio facilement avec CastHost. Obtenez des services d'hébergement de streaming radio en ligne abordables au Canada. Découvrez nos forfaits attractifs.">
    <?php } else { ?>
        <title>Pricing Plans - Radio Stream Packages | CastHost</title>
        <meta name="description" content="Starting your own radio station made easy with CastHost. Get affordable online radio stream hosting services in Canada. Know more about our attractive packages.">
    <?php } ?>
    <meta charset="utf-8">

    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="author" content="CastHost">
    <meta name="viewport" content="width=device-width,initial-scale=1.0,maximum-scale=1" />

    <!-- favicon icon -->
    <link rel="shortcut icon" href="images/favicon.png">
    <link rel="apple-touch-icon" href="images/apple-touch-icon-57x57.png">
    <link rel="apple-touch-icon" sizes="72x72" href="images/apple-touch-icon-72x72.png">
    <link rel="apple-touch-icon" sizes="114x114" href="images/apple-touch-icon-114x114.png">
    <link rel=“canonical” href=“https://www.casthost.net/pricing.php” />
</head>

<body data-mobile-nav-style="classic">
    <!-- start header -->
    <?php include('header.php'); ?>
    <!-- end header -->
    <?php if ($language == "fr") { ?>
        <div class="main-content" style="margin-bottom: 460.938px;">
            <!-- start page title -->
            <section class="parallax bg-extra-dark-gray" data-parallax-background-ratio="0.5" style="background-image:url('./images/webp/banner-section.webp');">
                <div class="opacity-extra-medium bg-extra-dark-gray"></div>
                <div class="container">
                    <div class="row align-items-stretch justify-content-center small-screen">
                        <div class="col-12 col-xl-6 col-lg-7 col-md-8 page-title-extra-small text-center d-flex justify-content-center flex-column">
                            <h1 class="alt-font text-white opacity-6 margin-20px-bottom">Tarification</h1>
                            <h2 class="text-white alt-font font-weight-500 letter-spacing-minus-1px line-height-50 sm-line-height-45 xs-line-height-30 no-margin-bottom">Forfaits tarifaires</h2>
                        </div>
                        <div class="down-section text-center"><a href="#down-section" class="section-link"><i class="ti-arrow-down icon-extra-small text-white bg-transparent-black padding-15px-all xs-padding-10px-all border-radius-100"></i></a></div>
                    </div>
                </div>
            </section>
            <!-- end page title -->
            <!-- start section -->
            <section class="bg-white" style="padding:1rem 0px">
                <div class="container">
                    <div class="row justify-content-center" id="down-section">
                        <div class="tab-syle-02">
                            <div class="col-12 tab-style-02">
                                <!-- start tab navigation -->
                                <ul class="nav nav-tabs justify-content-center text-center alt-font sm-margin-3-rem-bottom">
                                    <li class="nav-item"><a data-toggle="tab" href="#research" class="nav-link active"><i class="feather icon-feather-radio icon-small "></i>Forfaits de streaming</a></li>
                                    <li class="nav-item"><a class="nav-link" data-toggle="tab" href="#strategy"><i class="feather icon-feather-server icon-small "></i>Hébergement cPanel</a></li>
                                    <!-- <li class="nav-item"><a class="nav-link" data-toggle="tab" href="#management"><i class="feather icon-feather-bar-chart-2 icon-small"></i>SEO Services</a></li>-->
                                    <li class="nav-item"><a class="nav-link" data-toggle="tab" href="#concept"><i class="feather icon-feather-activity icon-small"></i>URL de flux sécurisé</a></li>
                                </ul>
                                <!-- end tab navigation -->
                            </div>

                        </div>

                    </div>

                </div>
            </section>
            <section class="big-section bg-light-gray   animate__fadeIn" style="visibility: visible; animation-name: fadeIn; padding: 3rem 0;">
                <div class="container">
                    <div class="row">
                        <div class="col-12 tab-style-02">

                            <div class="tab-content">
                                <!-- start tab item -->
                                <div id="research" class="tab-pane fade in active show">

                                    <div class="container">
                                        <div class="row justify-content-center">
                                            <div class="col-12 col-xl-10 col-lg-11 tab-style-04">
                                                <ul class="nav nav-tabs text-uppercase justify-content-center text-center alt-font margin-3-half-rem-bottom sm-margin-20px-bottom   animate__fadeIn" style="visibility: visible; animation-name: fadeIn;">
                                                    <li class="nav-item bg-white border-color-extra-light-gray"><a class="nav-link active" data-toggle="tab" href="#monthly-tab">Mensuel</a><span class="tab-bg-active bg-fast-blue"></span></li>
                                                    <li class="nav-item bg-white border-color-extra-light-gray"><a class="nav-link" data-toggle="tab" href="#quarterly-tab">Trimestriel</a><span class="tab-bg-active bg-fast-blue"></span></li>
                                                    <li class="nav-item bg-white border-color-extra-light-gray"><a class="nav-link" data-toggle="tab" href="#semiannually-tab">Semi-annuel</a><span class="tab-bg-active bg-fast-blue"></span></li>
                                                    <li class="nav-item bg-white border-color-extra-light-gray"><a class="nav-link" data-toggle="tab" href="#yearly-tab">Annuel</a><span class="tab-bg-active bg-fast-blue"></span></li>
                                                </ul>

                                            </div>
                                        </div>
                                    </div>

                                    <div class="tab-content">
                                        <div id="monthly-tab" class="tab-pane fade in active show">
                                            <div class="row row-cols-1 row-cols-md-4 align-items-center">
                                                <div class="col pricing-table-style-02 text-center px-md-0 sm-margin-30px-bottom xs-margin-15px-bottom wow animate__fadeInRight" data-wow-delay="0.4s" style="visibility: visible; animation-delay: 0.4s; animation-name: fadeInRight;">
                                                    <!-- start pricing table -->
                                                    <div class="pricing-table bg-white border-all border-color-medium-gray border-radius-6px">
                                                        <!-- start pricing header -->
                                                        <div class="pricing-header bg-light-gray padding-20px-tb">
                                                            <div class="alt-font font-weight-500 text-small text-extra-dark-gray text-uppercase letter-spacing-minus-1-half">Plan gratuit</div>
                                                        </div>
                                                        <!-- end pricing header -->
                                                        <!-- start pricing body -->
                                                        <div class="pricing-body padding-40px-tb">
                                                            <i class="line-icon-Old-Cassette icon-medium text-fast-blue margin-20px-bottom"></i>

                                                            <h4 class="font-weight-500 text-extra-dark-gray letter-spacing-minus-2px mb-0">7 jours</h4>
                                                            <p class=" font-weight-500 margin-15px-bottom">Essai gratuit</p>
                                                            <ul class="list-style-03">
                                                                <li class="border-color-medium-gray p-0">
                                                                    <audio controls style="width: 110%;" controlsList="nodownload">
                                                                        <source class="audiobitrate" src="https://securestream.casthost.net:8223/128" type="audio/mpeg">
                                                                        Your browser does not support the audio element.
                                                                    </audio>
                                                                </li>
                                                                <li class="border-color-medium-gray"><span class="text-extra-dark-gray font-weight-500"> 128 </span> Débit binaire kbps</li>
                                                                <li class="border-color-medium-gray"><span class="text-extra-dark-gray font-weight-500">512</span> Mo</li>
                                                                <li class="border-color-medium-gray"><span class="text-extra-dark-gray font-weight-500">50</span> Auditeurs max</li>
                                                                <li class="border-color-medium-gray"><span class="text-extra-dark-gray font-weight-500">Panneau </span>de contrôle Centova</li>
                                                                <li class="border-color-medium-gray"><span class="text-extra-dark-gray font-weight-500">Rapports </span>détaillés avancés</li>
                                                                <li class="border-color-medium-gray"><span class="text-extra-dark-gray font-weight-500">Bande </span>passante illimitée</li>
                                                            </ul>
                                                        </div>
                                                        <!-- end pricing body -->
                                                        <!-- start pricing footer -->
                                                        <div class="pricing-footer margin-55px-bottom">
                                                            <a class="buynow btn btn-medium btn-transparent-dark-gray btn-round-edge popup-with-zoom-anim" href="#provider" data-link1="https://portal.casthost.net/cart.php?a=add&pid=76&billingcycle=monthly" data-link2="https://portal.casthost.net/cart.php?a=add&pid=75&billingcycle=monthly" shoutcanada="https://portal.casthost.net/cart.php?a=add&pid=308&billingcycle=monthly" icecanada="https://portal.casthost.net/cart.php?a=add&pid=307&billingcycle=monthly">Inscrivez-vous maintenant</a>

                                                        </div>
                                                        <!-- end pricing footer -->
                                                    </div>
                                                    <!-- end pricing table -->
                                                </div>
                                                <div class="col pricing-table-style-02 text-center px-md-0 sm-margin-30px-bottom xs-margin-15px-bottom wow animate__fadeInRight" data-wow-delay="0.4s" style="visibility: visible; animation-delay: 0.4s; animation-name: fadeInRight;">
                                                    <!-- start pricing table -->
                                                    <div class="pricing-table bg-white border-all border-color-medium-gray border-radius-6px">
                                                        <!-- start pricing header -->
                                                        <div class="pricing-header bg-light-gray padding-20px-tb">
                                                            <div class="alt-font font-weight-500 text-small text-extra-dark-gray text-uppercase letter-spacing-minus-1-half ptype">Plan Starter</div>
                                                        </div>
                                                        <!-- end pricing header -->
                                                        <!-- start pricing body -->
                                                        <div class="pricing-body padding-40px-tb">
                                                            <i class="line-icon-Old-TV icon-medium text-fast-blue margin-20px-bottom"></i>
                                                            <h4 class="font-weight-500 text-extra-dark-gray letter-spacing-minus-2px margin-15px-bottom">$ <span class="price1"><?php echo $price_stream_starter_monthly; ?></span></h4>
                                                            <input class="hiddenval1" type="text" style="display: none;" value="<?php echo $price_stream_starter_monthly; ?>">
                                                            <ul class="list-style-03">
                                                                <li class="border-color-medium-gray p-0">
                                                                    <audio controls style="width: 110%;" controlsList="nodownload">

                                                                        <source class="audiobitrate" src="https://securestream.casthost.net:8223/64" type="audio/mpeg">
                                                                        Your browser does not support the audio element.
                                                                    </audio>
                                                                </li>
                                                                <li class="border-color-medium-gray">
                                                                    <div class="row">
                                                                        <div class="col-4 text-right minusicon" onclick="bitrateminus('1');">
                                                                            <i class="fas disable fa-minus-circle text-gray quantity-left-minus"></i>
                                                                        </div>
                                                                        <div class="col-4" style="padding: 0;">
                                                                            <span id="quantity1" class="text-extra-dark-gray font-weight-500 configbit">64</span> kbps
                                                                        </div>
                                                                        <div class="col-4 text-left plusicon" onclick="bitrateplus('1');">
                                                                            <i class="fas fa-plus-circle text-gray quantity-right-plus"></i>

                                                                        </div>
                                                                    </div>
                                                                </li>

                                                                <li class="border-color-medium-gray">
                                                                    <div class="dropdown">
                                                                        <button class="btn btn-block storagebtn1 dropdown-toggle text-center" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                                            <span class='storagevalue1  configdj'>512 Mo</span>
                                                                            <i class="fa fa-chevron-down margin-20px-left"></i>
                                                                        </button>
                                                                        <div class="dropdown-menu dropdown-menu-center storagedd  text-center" aria-labelledby="dropdownMenuButton">
                                                                            <a class="dropdown-item" onclick="storageprice('1','512 MB','0');">512 Mo</a>
                                                                            <a class="dropdown-item" onclick="storageprice('1','2 GB','1.00');">2 Go</a>
                                                                            <a class="dropdown-item" onclick="storageprice('1','5 GB','2.50');">5 Go</a>
                                                                            <a class="dropdown-item" onclick="storageprice('1','10 GB','4.75');">10 Go</a>
                                                                            <a class="dropdown-item" onclick="storageprice('1','25 GB','10.00');">25 Go</a>
                                                                            <a class="dropdown-item" onclick="storageprice('1','50 GB','17.25');">50 Go</a>

                                                                        </div>
                                                                    </div>
                                                                </li>
                                                                <li class="border-color-medium-gray"><span class="text-extra-dark-gray font-weight-500">75</span> Auditeurs max</li>
                                                                <li class="border-color-medium-gray"><span class="text-extra-dark-gray font-weight-500">Hébergement </span>Web gratuit</li>

                                                                <li class="border-color-medium-gray"><span class="text-extra-dark-gray font-weight-500">Rapports </span>détaillés avancés</li>
                                                                <li class="border-color-medium-gray"><span class="text-extra-dark-gray font-weight-500">Bande </span>passante illimitée</li>
                                                            </ul>
                                                        </div>
                                                        <!-- end pricing body -->
                                                        <!-- start pricing footer -->
                                                        <div class="pricing-footer margin-55px-bottom">
                                                            <a class="buynow btn btn-medium btn-transparent-dark-gray btn-round-edge popup-with-zoom-anim" href="#provider" data-link1="https://portal.casthost.net/cart.php?a=add&pid=240&billingcycle=monthly" data-link2="https://portal.casthost.net/cart.php?a=add&pid=241&billingcycle=monthly" shoutcanada="https://portal.casthost.net/cart.php?a=add&pid=312&billingcycle=monthly" icecanada="https://portal.casthost.net/cart.php?a=add&pid=311&billingcycle=monthly">Inscrivez-vous maintenant</a>
                                                        </div>
                                                        <!-- end pricing footer -->
                                                    </div>
                                                    <!-- end pricing table -->
                                                </div>
                                                <div class="col pricing-table-style-02 text-center px-md-0 sm-margin-30px-bottom xs-margin-15px-bottom wow animate__fadeIn z-index-1" style="visibility: visible; animation-name: fadeIn;">
                                                    <!-- start pricing table -->
                                                    <div class="pricing-table pricing-popular bg-white box-shadow-large border-radius-6px">
                                                        <!-- start pricing header -->
                                                        <div class="pricing-header bg-extra-dark-gray padding-20px-tb">
                                                            <div class="alt-font font-weight-500 text-small text-white text-uppercase letter-spacing-minus-1-half ptype">Plan Illimité</div>
                                                        </div>
                                                        <!-- end pricing header -->
                                                        <!-- start pricing body -->
                                                        <div class="pricing-body padding-60px-tb">
                                                            <i class="line-icon-Communication-Tower icon-medium text-fast-blue margin-20px-bottom"></i>
                                                            <h4 class="font-weight-500 text-extra-dark-gray letter-spacing-minus-2px margin-15px-bottom">$ <span class="price2"><?php echo $price_stream_unlimited_monthly; ?></span></h4>
                                                            <input class="hiddenval2" type="text" style="display: none;" value="<?php echo $price_stream_unlimited_monthly; ?>">
                                                            <ul class="list-style-03">
                                                                <li class="border-color-medium-gray p-0">
                                                                    <audio controls style="width: 110%;" controlsList="nodownload">

                                                                        <source class="audiobitrate" src="https://securestream.casthost.net:8223/64" type="audio/mpeg">
                                                                        Your browser does not support the audio element.
                                                                    </audio>
                                                                </li>
                                                                <li class="border-color-medium-gray">
                                                                    <div class="row">
                                                                        <div class="col-4 text-right minusicon" onclick="bitrateminus('2');">
                                                                            <i class="fas disable fa-minus-circle text-gray quantity-left-minus"></i>

                                                                        </div>
                                                                        <div class="col-4" style="padding: 0;">
                                                                            <span id="quantity2" class="text-extra-dark-gray font-weight-500 configbit">64</span> kbps
                                                                        </div>
                                                                        <div class="col-4 text-left plusicon" onclick="bitrateplus('2');">
                                                                            <i class="fas fa-plus-circle text-gray quantity-right-plus"></i>

                                                                        </div>
                                                                    </div>
                                                                </li>

                                                                <li class="border-color-medium-gray">
                                                                    <div class="dropdown">
                                                                        <button class="btn btn-block storagebtn2 dropdown-toggle text-center" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                                            <span class='storagevalue2  configdj'>5 Go</span>
                                                                            <i class="fa fa-chevron-down margin-20px-left"></i>
                                                                        </button>
                                                                        <div class="dropdown-menu dropdown-menu-center storagedd  text-center" aria-labelledby="dropdownMenuButton">
                                                                            <a class="dropdown-item" onclick="storageprice('2','5 GB','0');">5 Go</a>
                                                                            <a class="dropdown-item" onclick="storageprice('2','10 GB','2.50');">10 Go</a>
                                                                            <a class="dropdown-item" onclick="storageprice('2','25 GB','8.25');">25 Go</a>
                                                                            <a class="dropdown-item" onclick="storageprice('2','50 GB','15.75');">50 Go</a>
                                                                            <a class="dropdown-item" onclick="storageprice('2','100 GB','28.50');">100 Go</a>
                                                                        </div>
                                                                    </div>
                                                                </li>
                                                                <li class="border-color-medium-gray"><span class="text-extra-dark-gray font-weight-500">Nombre</span> d'auditeurs maximum illimité</li>
                                                                <li class="border-color-medium-gray"><span class="text-extra-dark-gray font-weight-500">Hébergement </span>Web gratuit</li>

                                                                <li class="border-color-medium-gray"><span class="text-extra-dark-gray font-weight-500">Rapports </span>détaillés avancés</li>
                                                                <li class="border-color-medium-gray"><span class="text-extra-dark-gray font-weight-500">Bande </span>passante illimitée</li>
                                                            </ul>
                                                        </div>
                                                        <!-- end pricing body -->
                                                        <!-- start pricing footer -->
                                                        <div class="pricing-footer margin-5px-top margin-55px-bottom">
                                                            <a class="buynow btn btn-medium btn-transparent-dark-gray btn-round-edge popup-with-zoom-anim" href="#provider" data-link1="https://portal.casthost.net/cart.php?a=add&pid=204&billingcycle=monthly" data-link2="https://portal.casthost.net/cart.php?a=add&pid=205&billingcycle=monthly" shoutcanada="https://portal.casthost.net/cart.php?a=add&pid=310&billingcycle=monthly" icecanada="https://portal.casthost.net/cart.php?a=add&pid=309&billingcycle=monthly">Inscrivez-vous maintenant</a>
                                                        </div>
                                                        <!-- end pricing footer -->
                                                    </div>
                                                    <!-- end pricing table -->
                                                </div>
                                                <div class="col pricing-table-style-02 text-center px-md-0 wow animate__fadeInLeft" data-wow-delay="0.4s" style="visibility: visible; animation-delay: 0.4s; animation-name: fadeInLeft;">
                                                    <!-- start pricing table -->
                                                    <div class="pricing-table bg-white border-all border-color-medium-gray border-radius-6px">
                                                        <!-- start pricing header -->
                                                        <div class="pricing-header bg-light-gray padding-20px-tb">
                                                            <div class="alt-font font-weight-500 text-small text-extra-dark-gray text-uppercase letter-spacing-minus-1-half">Plan revendeur</div>
                                                        </div>
                                                        <!-- end pricing header -->
                                                        <!-- start pricing body -->
                                                        <div class="pricing-body padding-40px-tb">
                                                            <i class="line-icon-Headset  icon-medium text-fast-blue margin-20px-bottom"></i>
                                                            <h4 class="font-weight-500 text-extra-dark-gray letter-spacing-minus-2px margin-15px-bottom">Nous contacter</h4>
                                                            <ul class="list-style-03">
                                                                <li class="border-color-medium-gray p-0">
                                                                    <audio controls style="width: 110%;" controlsList="nodownload">

                                                                        <source class="audiobitrate" src="https://securestream.casthost.net:8223/64" type="audio/mpeg">
                                                                        Your browser does not support the audio element.
                                                                    </audio>
                                                                </li>
                                                                <li class="border-color-medium-gray"><span class="text-extra-dark-gray font-weight-500"> 64-320 </span> Débit binaire kbps</li>
                                                                <li class="border-color-medium-gray"><span class="text-extra-dark-gray font-weight-500">Espace </span>disque personnalisé</li>
                                                                <li class="border-color-medium-gray"><span class="text-extra-dark-gray font-weight-500">Nombre</span> d'auditeurs maximum illimité</li>
                                                                <li class="border-color-medium-gray"><span class="text-extra-dark-gray font-weight-500">Hébergement </span>Web gratuit</li>
                                                                <li class="border-color-medium-gray"><span class="text-extra-dark-gray font-weight-500">Rapports </span>détaillés avancés</li>
                                                                <li class="border-color-medium-gray"><span class="text-extra-dark-gray font-weight-500">Bande </span>passante illimitée</li>
                                                            </ul>
                                                        </div>
                                                        <!-- end pricing body -->
                                                        <!-- start pricing footer -->
                                                        <div class="pricing-footer margin-55px-bottom">
                                                            <a class="btn btn-medium btn-transparent-dark-gray btn-round-edge" href="https://portal.casthost.net/submitticket.php?step=2&deptid=2">Nous contacter</a>
                                                        </div>
                                                        <!-- end pricing footer -->
                                                    </div>
                                                    <!-- end pricing table -->
                                                </div>
                                            </div>
                                        </div>
                                        <div id="quarterly-tab" class="tab-pane fade  ">
                                            <div class="row row-cols-1 row-cols-md-4 align-items-center">
                                                <div class="col pricing-table-style-02 text-center px-md-0 sm-margin-30px-bottom xs-margin-15px-bottom wow animate__fadeInRight" data-wow-delay="0.4s" style="visibility: visible; animation-delay: 0.4s; animation-name: fadeInRight;">
                                                    <!-- start pricing table -->
                                                    <div class="pricing-table bg-white border-all border-color-medium-gray border-radius-6px">
                                                        <!-- start pricing header -->
                                                        <div class="pricing-header bg-light-gray padding-20px-tb">
                                                            <div class="alt-font font-weight-500 text-small text-extra-dark-gray text-uppercase letter-spacing-minus-1-half">Plan gratuit</div>

                                                        </div>
                                                        <!-- end pricing header -->
                                                        <!-- start pricing body -->
                                                        <div class="pricing-body padding-40px-tb">
                                                            <i class="line-icon-Old-Cassette icon-medium text-fast-blue margin-20px-bottom"></i>

                                                            <h4 class="font-weight-500 text-extra-dark-gray letter-spacing-minus-2px mb-0">7 jours</h4>
                                                            <p class=" font-weight-500 margin-15px-bottom">Essai gratuit</p>
                                                            <ul class="list-style-03">
                                                                <li class="border-color-medium-gray p-0">
                                                                    <audio controls style="width: 110%;" controlsList="nodownload">

                                                                        <source class="audiobitrate" src="https://securestream.casthost.net:8223/128" type="audio/mpeg">
                                                                        Your browser does not support the audio element.
                                                                    </audio>
                                                                </li>
                                                                <li class="border-color-medium-gray"><span class="text-extra-dark-gray font-weight-500"> 128 </span> Débit binaire kbps</li>
                                                                <li class="border-color-medium-gray"><span class="text-extra-dark-gray font-weight-500">512</span> Mo</li>
                                                                <li class="border-color-medium-gray"><span class="text-extra-dark-gray font-weight-500">50</span> Auditeurs max</li>
                                                                <li class="border-color-medium-gray"><span class="text-extra-dark-gray font-weight-500">Panneau </span>de contrôle Centova</li>
                                                                <li class="border-color-medium-gray"><span class="text-extra-dark-gray font-weight-500">Rapports </span>détaillés avancés</li>
                                                                <li class="border-color-medium-gray"><span class="text-extra-dark-gray font-weight-500">Bande </span>passante illimitée</li>

                                                            </ul>
                                                        </div>
                                                        <!-- end pricing body -->
                                                        <!-- start pricing footer -->
                                                        <div class="pricing-footer margin-55px-bottom">
                                                            <a class="buynow btn btn-medium btn-transparent-dark-gray btn-round-edge popup-with-zoom-anim" href="#provider" data-link1="https://portal.casthost.net/cart.php?a=add&pid=76&billingcycle=quarterly" data-link2="https://portal.casthost.net/cart.php?a=add&pid=75&billingcycle=quarterly" shoutcanada="https://portal.casthost.net/cart.php?a=add&pid=308&billingcycle=quarterly" icecanada="https://portal.casthost.net/cart.php?a=add&pid=307&billingcycle=quarterly">Inscrivez-vous maintenant</a>

                                                        </div>
                                                        <!-- end pricing footer -->
                                                    </div>
                                                    <!-- end pricing table -->
                                                </div>
                                                <div class="col pricing-table-style-02 text-center px-md-0 sm-margin-30px-bottom xs-margin-15px-bottom wow animate__fadeInRight" data-wow-delay="0.4s" style="visibility: visible; animation-delay: 0.4s; animation-name: fadeInRight;">
                                                    <!-- start pricing table -->
                                                    <div class="pricing-table bg-white border-all border-color-medium-gray border-radius-6px">
                                                        <!-- start pricing header -->
                                                        <div class="pricing-header bg-light-gray padding-20px-tb">
                                                            <div class="alt-font font-weight-500 text-small text-extra-dark-gray text-uppercase letter-spacing-minus-1-half ptype">Plan de Démarrage</div>
                                                        </div>
                                                        <!-- end pricing header -->
                                                        <!-- start pricing body -->
                                                        <div class="pricing-body padding-40px-tb">

                                                            <i class="line-icon-Old-Radio icon-medium text-fast-blue margin-20px-bottom"></i>
                                                            <h4 class="font-weight-500 text-extra-dark-gray letter-spacing-minus-2px margin-15px-bottom">$ <span class="price3"><?php echo $price_stream_starter_quarterly; ?></span></h4>
                                                            <input class="hiddenval3" type="text" style="display: none;" value="<?php echo $price_stream_starter_quarterly; ?>">
                                                            <ul class="list-style-03">
                                                                <li class="border-color-medium-gray p-0">
                                                                    <audio controls style="width: 110%;" controlsList="nodownload">

                                                                        <source class="audiobitrate" src="https://securestream.casthost.net:8223/64" type="audio/mpeg">
                                                                        Your browser does not support the audio element.
                                                                    </audio>
                                                                </li>
                                                                <li class="border-color-medium-gray">
                                                                    <div class="row">
                                                                        <div class="col-4 text-right minusicon" onclick="bitrateminus('3');">
                                                                            <i class="fas disable fa-minus-circle text-gray quantity-left-minus"></i>
                                                                        </div>
                                                                        <div class="col-4" style="padding: 0;">
                                                                            <span id="quantity3" class="text-extra-dark-gray font-weight-500 configbit">64</span> kbps
                                                                        </div>
                                                                        <div class="col-4 text-left plusicon" onclick="bitrateplus('3');">
                                                                            <i class="fas fa-plus-circle text-gray quantity-right-plus"></i>

                                                                        </div>
                                                                    </div>
                                                                </li>
                                                                <li class="border-color-medium-gray">
                                                                    <div class="dropdown">
                                                                        <button class="btn btn-block storagebtn3 dropdown-toggle text-center" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                                            <span class='storagevalue3 configdj'>512 Mo</span>
                                                                            <i class="fa fa-chevron-down margin-20px-left"></i>
                                                                        </button>
                                                                        <div class="dropdown-menu dropdown-menu-center storagedd  text-center" aria-labelledby="dropdownMenuButton">
                                                                            <a class="dropdown-item" onclick="storageprice('3','512 MB','0');">512 Mo</a>
                                                                            <a class="dropdown-item" onclick="storageprice('3','2 GB','3.00');">2 Go</a>
                                                                            <a class="dropdown-item" onclick="storageprice('3','5 GB','7.50');">5 Go</a>
                                                                            <a class="dropdown-item" onclick="storageprice('3','10 GB','14.25');">10 Go</a>
                                                                            <a class="dropdown-item" onclick="storageprice('3','25 GB','30.00');">25 Go</a>
                                                                            <a class="dropdown-item" onclick="storageprice('3','50 GB','51.75');">50 Go</a>

                                                                        </div>
                                                                    </div>
                                                                </li>
                                                                <li class="border-color-medium-gray"><span class="text-extra-dark-gray font-weight-500">75</span> Auditeurs max</li>
                                                                <li class="border-color-medium-gray"><span class="text-extra-dark-gray font-weight-500">Hébergement </span>Web gratuit</li>

                                                                <li class="border-color-medium-gray"><span class="text-extra-dark-gray font-weight-500">Rapports </span>détaillés avancés</li>
                                                                <li class="border-color-medium-gray"><span class="text-extra-dark-gray font-weight-500">Bande </span>passante illimitée</li>


                                                            </ul>
                                                        </div>
                                                        <!-- end pricing body -->
                                                        <!-- start pricing footer -->
                                                        <div class="pricing-footer margin-55px-bottom">
                                                            <a class="buynow btn btn-medium btn-transparent-dark-gray btn-round-edge popup-with-zoom-anim" href="#provider" data-link1="https://portal.casthost.net/cart.php?a=add&pid=240&billingcycle=quarterly" data-link2="https://portal.casthost.net/cart.php?a=add&pid=241&billingcycle=quarterly" shoutcanada="https://portal.casthost.net/cart.php?a=add&pid=312&billingcycle=quarterly" icecanada="https://portal.casthost.net/cart.php?a=add&pid=311&billingcycle=quarterly">Inscrivez-vous maintenant</a>
                                                        </div>
                                                        <!-- end pricing footer -->
                                                    </div>
                                                    <!-- end pricing table -->
                                                </div>
                                                <div class="col pricing-table-style-02 text-center px-md-0 sm-margin-30px-bottom xs-margin-15px-bottom wow animate__fadeIn z-index-1" style="visibility: visible; animation-name: fadeIn;">
                                                    <!-- start pricing table -->
                                                    <div class="pricing-table pricing-popular bg-white box-shadow-large border-radius-6px">
                                                        <!-- start pricing header -->
                                                        <div class="pricing-header bg-extra-dark-gray padding-20px-tb">
                                                            <div class="alt-font font-weight-500 text-small text-white text-uppercase letter-spacing-minus-1-half ptype">Plan Illimité</div>
                                                        </div>
                                                        <!-- end pricing header -->
                                                        <!-- start pricing body -->
                                                        <div class="pricing-body padding-60px-tb">
                                                            <i class="line-icon-Communication-Tower icon-medium text-fast-blue margin-20px-bottom"></i>
                                                            <h4 class="font-weight-500 text-extra-dark-gray letter-spacing-minus-2px margin-15px-bottom">$ <span class="price4"><?php echo $price_stream_unlimited_quarterly; ?></span></h4>
                                                            <input class="hiddenval4" type="text" style="display: none;" value="<?php echo $price_stream_unlimited_quarterly; ?>">
                                                            <ul class="list-style-03">
                                                                <li class="border-color-medium-gray p-0">
                                                                    <audio controls style="width: 110%;" controlsList="nodownload">

                                                                        <source class="audiobitrate" src="https://securestream.casthost.net:8223/64" type="audio/mpeg">
                                                                        Your browser does not support the audio element.
                                                                    </audio>
                                                                </li>
                                                                <li class="border-color-medium-gray">
                                                                    <div class="row">
                                                                        <div class="col-4 text-right minusicon" onclick="bitrateminus('4');">
                                                                            <i class="fas disable fa-minus-circle text-gray quantity-left-minus"></i>

                                                                        </div>
                                                                        <div class="col-4" style="padding: 0;">
                                                                            <span id="quantity4" class="text-extra-dark-gray font-weight-500 configbit">64</span> kbps
                                                                        </div>
                                                                        <div class="col-4 text-left plusicon" onclick="bitrateplus('4');">
                                                                            <i class="fas fa-plus-circle text-gray quantity-right-plus"></i>

                                                                        </div>
                                                                    </div>
                                                                </li>

                                                                <li class="border-color-medium-gray">
                                                                    <div class="dropdown">
                                                                        <button class="btn btn-block storagebtn4 dropdown-toggle text-center" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                                            <span class='storagevalue4 configdj'>5 Go</span>
                                                                            <i class="fa fa-chevron-down margin-20px-left"></i>
                                                                        </button>
                                                                        <div class="dropdown-menu dropdown-menu-center storagedd  text-center" aria-labelledby="dropdownMenuButton">
                                                                            <a class="dropdown-item" onclick="storageprice('4','5 GB','0');">5 Go</a>
                                                                            <a class="dropdown-item" onclick="storageprice('4','10 GB','7.50');">10 Go</a>
                                                                            <a class="dropdown-item" onclick="storageprice('4','25 GB','24.75');">25 Go</a>
                                                                            <a class="dropdown-item" onclick="storageprice('4','50 GB','47.25');">50 Go</a>
                                                                            <a class="dropdown-item" onclick="storageprice('4','100 GB','85.50');">100 Go</a>
                                                                        </div>
                                                                    </div>
                                                                </li>
                                                                <li class="border-color-medium-gray"><span class="text-extra-dark-gray font-weight-500">Nombre</span> d'auditeurs maximum illimité</li>
                                                                <li class="border-color-medium-gray"><span class="text-extra-dark-gray font-weight-500">Hébergement </span>Web gratuit</li>
                                                                <li class="border-color-medium-gray"><span class="text-extra-dark-gray font-weight-500">Rapports </span>détaillés avancés</li>
                                                                <li class="border-color-medium-gray"><span class="text-extra-dark-gray font-weight-500">Bande </span>passante illimitée </li>
                                                            </ul>
                                                        </div>
                                                        <!-- end pricing body -->
                                                        <!-- start pricing footer -->
                                                        <div class="pricing-footer margin-5px-top margin-55px-bottom">
                                                            <a class="buynow btn btn-medium btn-transparent-dark-gray btn-round-edge popup-with-zoom-anim" href="#provider" data-link1="https://portal.casthost.net/cart.php?a=add&pid=204&billingcycle=quarterly" data-link2="https://portal.casthost.net/cart.php?a=add&pid=205&billingcycle=quarterly" shoutcanada="https://portal.casthost.net/cart.php?a=add&pid=310&billingcycle=quarterly" icecanada="https://portal.casthost.net/cart.php?a=add&pid=309&billingcycle=quarterly">Inscrivez-vous maintenant</a>
                                                        </div>
                                                        <!-- end pricing footer -->
                                                    </div>
                                                    <!-- end pricing table -->
                                                </div>
                                                <div class="col pricing-table-style-02 text-center px-md-0 wow animate__fadeInLeft" data-wow-delay="0.4s" style="visibility: visible; animation-delay: 0.4s; animation-name: fadeInLeft;">
                                                    <!-- start pricing table -->
                                                    <div class="pricing-table bg-white border-all border-color-medium-gray border-radius-6px">
                                                        <!-- start pricing header -->
                                                        <div class="pricing-header bg-light-gray padding-20px-tb">
                                                            <div class="alt-font font-weight-500 text-small text-extra-dark-gray text-uppercase letter-spacing-minus-1-half">Plan revendeur</div>
                                                        </div>
                                                        <!-- end pricing header -->
                                                        <!-- start pricing body -->
                                                        <div class="pricing-body padding-40px-tb">
                                                            <i class="line-icon-Headset  icon-medium text-fast-blue margin-20px-bottom"></i>
                                                            <h4 class="font-weight-500 text-extra-dark-gray letter-spacing-minus-2px margin-15px-bottom">Nous contacter</h4>
                                                            <ul class="list-style-03">
                                                                <li class="border-color-medium-gray p-0">
                                                                    <audio controls style="width: 110%;" controlsList="nodownload">

                                                                        <source class="audiobitrate" src="https://securestream.casthost.net:8223/64" type="audio/mpeg">
                                                                        Your browser does not support the audio element.
                                                                    </audio>
                                                                </li>
                                                                <li class="border-color-medium-gray"><span class="text-extra-dark-gray font-weight-500"> 64-320 </span> kbps Bitrate</li>
                                                                <li class="border-color-medium-gray"><span class="text-extra-dark-gray font-weight-500">Espace </span>disque personnalisé</li>
                                                                <li class="border-color-medium-gray"><span class="text-extra-dark-gray font-weight-500">Nombre </span>d'auditeurs maximum illimité</li>
                                                                <li class="border-color-medium-gray"><span class="text-extra-dark-gray font-weight-500">Hébergement </span>Web gratuit</li>

                                                                <li class="border-color-medium-gray"><span class="text-extra-dark-gray font-weight-500">Rapports </span>détaillés avancés</li>
                                                                <li class="border-color-medium-gray"><span class="text-extra-dark-gray font-weight-500">Bande </span>passante illimitée </li>


                                                            </ul>
                                                        </div>
                                                        <!-- end pricing body -->
                                                        <!-- start pricing footer -->
                                                        <div class="pricing-footer margin-55px-bottom">
                                                            <a class="btn btn-medium btn-transparent-dark-gray btn-round-edge" href="https://portal.casthost.net/submitticket.php?step=2&deptid=2">Nous contacter</a>
                                                        </div>
                                                        <!-- end pricing footer -->
                                                    </div>
                                                    <!-- end pricing table -->
                                                </div>
                                            </div>
                                        </div>
                                        <div id="semiannually-tab" class="tab-pane fade">
                                            <div class="row row-cols-1 row-cols-md-4 align-items-center">
                                                <div class="col pricing-table-style-02 text-center px-md-0 sm-margin-30px-bottom xs-margin-15px-bottom wow animate__fadeInRight" data-wow-delay="0.4s" style="visibility: visible; animation-delay: 0.4s; animation-name: fadeInRight;">
                                                    <!-- start pricing table -->
                                                    <div class="pricing-table bg-white border-all border-color-medium-gray border-radius-6px">
                                                        <!-- start pricing header -->
                                                        <div class="pricing-header bg-light-gray padding-20px-tb">
                                                            <div class="alt-font font-weight-500 text-small text-extra-dark-gray text-uppercase letter-spacing-minus-1-half">Plan gratuit</div>

                                                        </div>
                                                        <!-- end pricing header -->
                                                        <!-- start pricing body -->
                                                        <div class="pricing-body padding-40px-tb">
                                                            <i class="line-icon-Old-Cassette icon-medium text-fast-blue margin-20px-bottom"></i>

                                                            <h4 class="font-weight-500 text-extra-dark-gray letter-spacing-minus-2px mb-0">7 jours</h4>
                                                            <p class=" font-weight-500 margin-15px-bottom">Essai gratuit</p>
                                                            <ul class="list-style-03">
                                                                <li class="border-color-medium-gray p-0">
                                                                    <audio controls style="width: 110%;" controlsList="nodownload">

                                                                        <source class="audiobitrate" src="https://securestream.casthost.net:8223/128" type="audio/mpeg">
                                                                        Your browser does not support the audio element.
                                                                    </audio>
                                                                </li>
                                                                <li class="border-color-medium-gray"><span class="text-extra-dark-gray font-weight-500"> 128 </span> kbps Bitrate</li>
                                                                <li class="border-color-medium-gray"><span class="text-extra-dark-gray font-weight-500">512</span> MB</li>
                                                                <li class="border-color-medium-gray"><span class="text-extra-dark-gray font-weight-500">50</span> Max Listeners</li>
                                                                <li class="border-color-medium-gray"><span class="text-extra-dark-gray font-weight-500">Centova</span> Control Panel</li>

                                                                <li class="border-color-medium-gray"><span class="text-extra-dark-gray font-weight-500">Rapports </span>détaillés avancés</li>
                                                                <li class="border-color-medium-gray"><span class="text-extra-dark-gray font-weight-500">Bande </span>passante illimitée </li>

                                                            </ul>
                                                        </div>
                                                        <!-- end pricing body -->
                                                        <!-- start pricing footer -->
                                                        <div class="pricing-footer margin-55px-bottom">
                                                            <a class="buynow btn btn-medium btn-transparent-dark-gray btn-round-edge popup-with-zoom-anim" href="#provider" data-link1="https://portal.casthost.net/cart.php?a=add&pid=76&billingcycle=semiannually" data-link2="https://portal.casthost.net/cart.php?a=add&pid=75&billingcycle=semiannually" shoutcanada="https://portal.casthost.net/cart.php?a=add&pid=308&billingcycle=semiannually" icecanada="https://portal.casthost.net/cart.php?a=add&pid=307&billingcycle=semiannually">Register Now</a>

                                                        </div>
                                                        <!-- end pricing footer -->
                                                    </div>
                                                    <!-- end pricing table -->
                                                </div>
                                                <div class="col pricing-table-style-02 text-center px-md-0 sm-margin-30px-bottom xs-margin-15px-bottom wow animate__fadeInRight" data-wow-delay="0.4s" style="visibility: visible; animation-delay: 0.4s; animation-name: fadeInRight;">
                                                    <!-- start pricing table -->
                                                    <div class="pricing-table bg-white border-all border-color-medium-gray border-radius-6px">
                                                        <!-- start pricing header -->
                                                        <div class="pricing-header bg-light-gray padding-20px-tb">
                                                            <div class="alt-font font-weight-500 text-small text-extra-dark-gray text-uppercase letter-spacing-minus-1-half ptype">Plan de démarrage</div>
                                                        </div>
                                                        <!-- end pricing header -->
                                                        <!-- start pricing body -->
                                                        <div class="pricing-body padding-40px-tb">

                                                            <i class="line-icon-Old-Radio icon-medium text-fast-blue margin-20px-bottom"></i>
                                                            <h4 class="font-weight-500 text-extra-dark-gray letter-spacing-minus-2px margin-15px-bottom">$ <span class="price5"><?php echo $price_stream_starter_semiannually; ?></span></h4>
                                                            <input class="hiddenval5" type="text" style="display: none;" value="<?php echo $price_stream_starter_semiannually; ?>">
                                                            <ul class="list-style-03">
                                                                <li class="border-color-medium-gray p-0">
                                                                    <audio controls style="width: 110%;" controlsList="nodownload">

                                                                        <source class="audiobitrate" src="https://securestream.casthost.net:8223/64" type="audio/mpeg">
                                                                        Your browser does not support the audio element.
                                                                    </audio>
                                                                </li>
                                                                <li class="border-color-medium-gray">
                                                                    <div class="row">
                                                                        <div class="col-4 text-right minusicon" onclick="bitrateminus('5');">
                                                                            <i class="fas disable fa-minus-circle text-gray quantity-left-minus"></i>
                                                                        </div>
                                                                        <div class="col-4" style="padding: 0;">
                                                                            <span id="quantity5" class="text-extra-dark-gray font-weight-500 configbit">64</span> kbps
                                                                        </div>
                                                                        <div class="col-4 text-left plusicon" onclick="bitrateplus('5');">
                                                                            <i class="fas fa-plus-circle text-gray quantity-right-plus"></i>

                                                                        </div>
                                                                    </div>
                                                                </li>
                                                                <li class="border-color-medium-gray">
                                                                    <div class="dropdown">
                                                                        <button class="btn btn-block storagebtn5 dropdown-toggle text-center" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                                            <span class='storagevalue5 configdj'>512 MB</span>
                                                                            <i class="fa fa-chevron-down margin-20px-left"></i>
                                                                        </button>
                                                                        <div class="dropdown-menu dropdown-menu-center storagedd  text-center" aria-labelledby="dropdownMenuButton">
                                                                            <a class="dropdown-item" onclick="storageprice('5','512 MB','0');">512 MB</a>
                                                                            <a class="dropdown-item" onclick="storageprice('5','2 GB','6.00');">2 GB</a>
                                                                            <a class="dropdown-item" onclick="storageprice('5','5 GB','15.00');">5 GB</a>
                                                                            <a class="dropdown-item" onclick="storageprice('5','10 GB','28.50');">10 GB</a>
                                                                            <a class="dropdown-item" onclick="storageprice('5','25 GB','60.00');">25 GB</a>
                                                                            <a class="dropdown-item" onclick="storageprice('5','50 GB','102.50');">50 GB</a>

                                                                        </div>
                                                                    </div>
                                                                </li>
                                                                <li class="border-color-medium-gray"><span class="text-extra-dark-gray font-weight-500">75</span> Max Listeners</li>
                                                                <li class="border-color-medium-gray"><span class="text-extra-dark-gray font-weight-500">Hébergement </span>Web gratuit</li>

                                                                <li class="border-color-medium-gray"><span class="text-extra-dark-gray font-weight-500">Rapports </span>détaillés avancés</li>
                                                                <li class="border-color-medium-gray"><span class="text-extra-dark-gray font-weight-500">Bande </span>passante illimitée </li>


                                                            </ul>
                                                        </div>
                                                        <!-- end pricing body -->
                                                        <!-- start pricing footer -->
                                                        <div class="pricing-footer margin-55px-bottom">
                                                            <a class="buynow btn btn-medium btn-transparent-dark-gray btn-round-edge popup-with-zoom-anim" href="#provider" data-link1="https://portal.casthost.net/cart.php?a=add&pid=240&billingcycle=semiannually" data-link2="https://portal.casthost.net/cart.php?a=add&pid=241&billingcycle=semiannually" shoutcanada="https://portal.casthost.net/cart.php?a=add&pid=312&billingcycle=semiannually" icecanada="https://portal.casthost.net/cart.php?a=add&pid=311&billingcycle=semiannually">Register Now</a>
                                                        </div>
                                                        <!-- end pricing footer -->
                                                    </div>
                                                    <!-- end pricing table -->
                                                </div>
                                                <div class="col pricing-table-style-02 text-center px-md-0 sm-margin-30px-bottom xs-margin-15px-bottom wow animate__fadeIn z-index-1" style="visibility: visible; animation-name: fadeIn;">
                                                    <!-- start pricing table -->
                                                    <div class="pricing-table pricing-popular bg-white box-shadow-large border-radius-6px">
                                                        <!-- start pricing header -->
                                                        <div class="pricing-header bg-extra-dark-gray padding-20px-tb">
                                                            <div class="alt-font font-weight-500 text-small text-white text-uppercase letter-spacing-minus-1-half ptype">Plan Illimité</div>
                                                        </div>
                                                        <!-- end pricing header -->
                                                        <!-- start pricing body -->
                                                        <div class="pricing-body padding-60px-tb">
                                                            <i class="line-icon-Communication-Tower icon-medium text-fast-blue margin-20px-bottom"></i>
                                                            <h4 class="font-weight-500 text-extra-dark-gray letter-spacing-minus-2px margin-15px-bottom">$ <span class="price6"><?php echo $price_stream_unlimited_semiannually; ?></span></h4>
                                                            <input class="hiddenval6" type="text" style="display: none;" value="<?php echo $price_stream_unlimited_semiannually; ?>">
                                                            <ul class="list-style-03">
                                                                <li class="border-color-medium-gray p-0">
                                                                    <audio controls style="width: 110%;" controlsList="nodownload">

                                                                        <source class="audiobitrate" src="https://securestream.casthost.net:8223/64" type="audio/mpeg">
                                                                        Your browser does not support the audio element.
                                                                    </audio>
                                                                </li>
                                                                <li class="border-color-medium-gray">
                                                                    <div class="row">
                                                                        <div class="col-4 text-right minusicon" onclick="bitrateminus('6');">
                                                                            <i class="fas disable fa-minus-circle text-gray quantity-left-minus"></i>

                                                                        </div>
                                                                        <div class="col-4" style="padding: 0;">
                                                                            <span id="quantity6" class="text-extra-dark-gray font-weight-500 configbit">64</span> kbps
                                                                        </div>
                                                                        <div class="col-4 text-left plusicon" onclick="bitrateplus('6');">
                                                                            <i class="fas fa-plus-circle text-gray quantity-right-plus"></i>

                                                                        </div>
                                                                    </div>
                                                                </li>

                                                                <li class="border-color-medium-gray">
                                                                    <div class="dropdown">
                                                                        <button class="btn btn-block storagebtn6 dropdown-toggle text-center" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                                            <span class='storagevalue6 configdj'>5 GB</span>
                                                                            <i class="fa fa-chevron-down margin-20px-left"></i>
                                                                        </button>
                                                                        <div class="dropdown-menu dropdown-menu-center storagedd  text-center" aria-labelledby="dropdownMenuButton">
                                                                            <a class="dropdown-item" onclick="storageprice('6','5 GB','0');">5 GB</a>
                                                                            <a class="dropdown-item" onclick="storageprice('6','10 GB','15.00');">10 GB</a>
                                                                            <a class="dropdown-item" onclick="storageprice('6','25 GB','49.50');">25 GB</a>
                                                                            <a class="dropdown-item" onclick="storageprice('6','50 GB','94.50');">50 GB</a>
                                                                            <a class="dropdown-item" onclick="storageprice('6','100 GB','171.00');">100 GB</a>
                                                                        </div>
                                                                    </div>
                                                                </li>
                                                                <li class="border-color-medium-gray"><span class="text-extra-dark-gray font-weight-500">Nombre </span>d'auditeurs maximum illimité </li>
                                                                <li class="border-color-medium-gray"><span class="text-extra-dark-gray font-weight-500">Hébergement </span>Web gratuit</li>

                                                                <li class="border-color-medium-gray"><span class="text-extra-dark-gray font-weight-500">Rapports </span>détaillés avancés</li>
                                                                <li class="border-color-medium-gray"><span class="text-extra-dark-gray font-weight-500">Bande </span>passante illimitée </li>
                                                            </ul>
                                                        </div>
                                                        <!-- end pricing body -->
                                                        <!-- start pricing footer -->
                                                        <div class="pricing-footer margin-5px-top margin-55px-bottom">
                                                            <a class="buynow btn btn-medium btn-transparent-dark-gray btn-round-edge popup-with-zoom-anim" href="#provider" data-link1="https://portal.casthost.net/cart.php?a=add&pid=204&billingcycle=semiannually" data-link2="https://portal.casthost.net/cart.php?a=add&pid=205&billingcycle=semiannually" shoutcanada="https://portal.casthost.net/cart.php?a=add&pid=310&billingcycle=semiannually" icecanada="https://portal.casthost.net/cart.php?a=add&pid=309&billingcycle=semiannually">Register Now</a>
                                                        </div>
                                                        <!-- end pricing footer -->
                                                    </div>
                                                    <!-- end pricing table -->
                                                </div>
                                                <div class="col pricing-table-style-02 text-center px-md-0 wow animate__fadeInLeft" data-wow-delay="0.4s" style="visibility: visible; animation-delay: 0.4s; animation-name: fadeInLeft;">
                                                    <!-- start pricing table -->
                                                    <div class="pricing-table bg-white border-all border-color-medium-gray border-radius-6px">
                                                        <!-- start pricing header -->
                                                        <div class="pricing-header bg-light-gray padding-20px-tb">
                                                            <div class="alt-font font-weight-500 text-small text-extra-dark-gray text-uppercase letter-spacing-minus-1-half">Plan revendeur</div>
                                                        </div>
                                                        <!-- end pricing header -->
                                                        <!-- start pricing body -->
                                                        <div class="pricing-body padding-40px-tb">
                                                            <i class="line-icon-Headset  icon-medium text-fast-blue margin-20px-bottom"></i>
                                                            <h4 class="font-weight-500 text-extra-dark-gray letter-spacing-minus-2px margin-15px-bottom">Nous contacter</h4>
                                                            <ul class="list-style-03">
                                                                <li class="border-color-medium-gray p-0">
                                                                    <audio controls style="width: 110%;" controlsList="nodownload">

                                                                        <source class="audiobitrate" src="https://securestream.casthost.net:8223/64" type="audio/mpeg">
                                                                        Your browser does not support the audio element.
                                                                    </audio>
                                                                </li>
                                                                <li class="border-color-medium-gray"><span class="text-extra-dark-gray font-weight-500"> 64-320 </span> Débit binaire kbps</li>
                                                                <li class="border-color-medium-gray"><span class="text-extra-dark-gray font-weight-500">Custom</span> Disk Space</li>
                                                                <li class="border-color-medium-gray"><span class="text-extra-dark-gray font-weight-500">Nombre </span>d'auditeurs maximum illimité</li>
                                                                <li class="border-color-medium-gray"><span class="text-extra-dark-gray font-weight-500">Hébergement </span>Web gratuit</li>

                                                                <li class="border-color-medium-gray"><span class="text-extra-dark-gray font-weight-500">Rapports </span>détaillés avancés</li>
                                                                <li class="border-color-medium-gray"><span class="text-extra-dark-gray font-weight-500">Bande </span>passante illimitée </li>


                                                            </ul>
                                                        </div>
                                                        <!-- end pricing body -->
                                                        <!-- start pricing footer -->
                                                        <div class="pricing-footer margin-55px-bottom">
                                                            <a class="btn btn-medium btn-transparent-dark-gray btn-round-edge" href="https://portal.casthost.net/submitticket.php?step=2&deptid=2">Nous contacter</a>
                                                        </div>
                                                        <!-- end pricing footer -->
                                                    </div>
                                                    <!-- end pricing table -->
                                                </div>
                                            </div>
                                        </div>
                                        <div id="yearly-tab" class="tab-pane fade">
                                            <div class="row row-cols-1 row-cols-md-4 align-items-center">
                                                <div class="col pricing-table-style-02 text-center px-md-0 sm-margin-30px-bottom xs-margin-15px-bottom wow animate__fadeInRight" data-wow-delay="0.4s" style="visibility: visible; animation-delay: 0.4s; animation-name: fadeInRight;">
                                                    <!-- start pricing table -->
                                                    <div class="pricing-table bg-white border-all border-color-medium-gray border-radius-6px">
                                                        <!-- start pricing header -->
                                                        <div class="pricing-header bg-light-gray padding-20px-tb">
                                                            <div class="alt-font font-weight-500 text-small text-extra-dark-gray text-uppercase letter-spacing-minus-1-half">Plan gratuit</div>

                                                        </div>
                                                        <!-- end pricing header -->
                                                        <!-- start pricing body -->
                                                        <div class="pricing-body padding-40px-tb">
                                                            <i class="line-icon-Old-Cassette icon-medium text-fast-blue margin-20px-bottom"></i>

                                                            <h4 class="font-weight-500 text-extra-dark-gray letter-spacing-minus-2px mb-0">7 jours</h4>
                                                            <p class=" font-weight-500 margin-15px-bottom">Essai gratuit</p>
                                                            <ul class="list-style-03">
                                                                <li class="border-color-medium-gray p-0">
                                                                    <audio controls style="width: 110%;" controlsList="nodownload">

                                                                        <source class="audiobitrate" src="https://securestream.casthost.net:8223/128" type="audio/mpeg">
                                                                        Your browser does not support the audio element.
                                                                    </audio>
                                                                </li>
                                                                <li class="border-color-medium-gray"><span class="text-extra-dark-gray font-weight-500"> 128 </span> Débit binaire kbps</li>
                                                                <li class="border-color-medium-gray"><span class="text-extra-dark-gray font-weight-500">512</span> Mo</li>
                                                                <li class="border-color-medium-gray"><span class="text-extra-dark-gray font-weight-500">50</span> Auditeurs max</li>
                                                                <li class="border-color-medium-gray"><span class="text-extra-dark-gray font-weight-500">Panneau </span>de contrôle Centova</li>

                                                                <li class="border-color-medium-gray"><span class="text-extra-dark-gray font-weight-500">Rapports </span>détaillés avancés</li>
                                                                <li class="border-color-medium-gray"><span class="text-extra-dark-gray font-weight-500">Bande </span>passante illimitée </li>

                                                            </ul>
                                                        </div>
                                                        <!-- end pricing body -->
                                                        <!-- start pricing footer -->
                                                        <div class="pricing-footer margin-55px-bottom">
                                                            <a class="buynow btn btn-medium btn-transparent-dark-gray btn-round-edge popup-with-zoom-anim" href="#provider" data-link1="https://portal.casthost.net/cart.php?a=add&pid=76&billingcycle=annually" data-link2="https://portal.casthost.net/cart.php?a=add&pid=75&billingcycle=annually" shoutcanada="https://portal.casthost.net/cart.php?a=add&pid=308&billingcycle=annually" icecanada="https://portal.casthost.net/cart.php?a=add&pid=307&billingcycle=annually">Inscrivez-vous maintenant</a>
                                                        </div>
                                                        <!-- end pricing footer -->
                                                    </div>
                                                    <!-- end pricing table -->
                                                </div>
                                                <div class="col pricing-table-style-02 text-center px-md-0 sm-margin-30px-bottom xs-margin-15px-bottom wow animate__fadeInRight" data-wow-delay="0.4s" style="visibility: visible; animation-delay: 0.4s; animation-name: fadeInRight;">
                                                    <!-- start pricing table -->
                                                    <div class="pricing-table bg-white border-all border-color-medium-gray border-radius-6px">
                                                        <!-- start pricing header -->
                                                        <div class="pricing-header bg-light-gray padding-20px-tb">
                                                            <div class="alt-font font-weight-500 text-small text-extra-dark-gray text-uppercase letter-spacing-minus-1-half ptype">Plan de Démarrage</div>
                                                        </div>
                                                        <!-- end pricing header -->
                                                        <!-- start pricing body -->
                                                        <div class="pricing-body padding-40px-tb">
                                                            <i class="line-icon-Old-TV icon-medium text-fast-blue margin-20px-bottom"></i>
                                                            <h4 class="font-weight-500 text-extra-dark-gray letter-spacing-minus-2px margin-15px-bottom">$ <span class="price7"><?php echo $price_stream_starter_annually; ?></span></h4>
                                                            <input class="hiddenval7" type="text" style="display: none;" value="<?php echo $price_stream_starter_annually; ?>">
                                                            <ul class="list-style-03">
                                                                <li class="border-color-medium-gray p-0">
                                                                    <audio controls style="width: 110%;" controlsList="nodownload">

                                                                        <source class="audiobitrate" src="https://securestream.casthost.net:8223/64" type="audio/mpeg">
                                                                        Your browser does not support the audio element.
                                                                    </audio>
                                                                </li>
                                                                <li class="border-color-medium-gray">
                                                                    <div class="row">
                                                                        <div class="col-4 text-right minusicon" onclick="bitrateminus('7');">
                                                                            <i class="fas disable fa-minus-circle text-gray quantity-left-minus"></i>
                                                                        </div>
                                                                        <div class="col-4" style="padding: 0;">
                                                                            <span id="quantity7" class="text-extra-dark-gray font-weight-500 configbit">64</span> kbps
                                                                        </div>
                                                                        <div class="col-4 text-left plusicon" onclick="bitrateplus('7');">
                                                                            <i class="fas fa-plus-circle text-gray quantity-right-plus"></i>

                                                                        </div>
                                                                    </div>
                                                                </li>
                                                                <li class="border-color-medium-gray">
                                                                    <div class="dropdown">
                                                                        <button class="btn btn-block storagebtn7 dropdown-toggle text-center" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                                            <span class='storagevalue7 configdj'>512 Mo</span>
                                                                            <i class="fa fa-chevron-down margin-20px-left"></i>
                                                                        </button>
                                                                        <div class="dropdown-menu dropdown-menu-center storagedd  text-center" aria-labelledby="dropdownMenuButton">
                                                                            <a class="dropdown-item" onclick="storageprice('7','512 MB','0');">512 Mo</a>
                                                                            <a class="dropdown-item" onclick="storageprice('7','2 GB','12.00');">2 Go</a>
                                                                            <a class="dropdown-item" onclick="storageprice('7','5 GB','30.00');">5 Go</a>
                                                                            <a class="dropdown-item" onclick="storageprice('7','10 GB','57.00');">10 Go</a>
                                                                            <a class="dropdown-item" onclick="storageprice('7','25 GB','120.00');">25 Go</a>
                                                                            <a class="dropdown-item" onclick="storageprice('7','50 GB','205.00');">50 Go</a>

                                                                        </div>
                                                                    </div>
                                                                </li>

                                                                <li class="border-color-medium-gray"><span class="text-extra-dark-gray font-weight-500">75</span> Auditeurs max</li>
                                                                <li class="border-color-medium-gray"><span class="text-extra-dark-gray font-weight-500">Hébergement </span>Web gratuit</li>

                                                                <li class="border-color-medium-gray"><span class="text-extra-dark-gray font-weight-500">Rapports </span>détaillés avancés</li>
                                                                <li class="border-color-medium-gray"><span class="text-extra-dark-gray font-weight-500">Bande </span>passante illimitée </li>


                                                            </ul>
                                                        </div>
                                                        <!-- end pricing body -->
                                                        <!-- start pricing footer -->
                                                        <div class="pricing-footer margin-55px-bottom">
                                                            <a class="buynow btn btn-medium btn-transparent-dark-gray btn-round-edge popup-with-zoom-anim" href="#provider" data-link1="https://portal.casthost.net/cart.php?a=add&pid=240&billingcycle=annually" data-link2="https://portal.casthost.net/cart.php?a=add&pid=241&billingcycle=annually" shoutcanada="https://portal.casthost.net/cart.php?a=add&pid=312&billingcycle=annually" icecanada="https://portal.casthost.net/cart.php?a=add&pid=311&billingcycle=annually">Inscrivez-vous maintenant</a>
                                                        </div>
                                                        <!-- end pricing footer -->
                                                    </div>
                                                    <!-- end pricing table -->
                                                </div>
                                                <div class="col pricing-table-style-02 text-center px-md-0 sm-margin-30px-bottom xs-margin-15px-bottom wow animate__fadeIn z-index-1" style="visibility: visible; animation-name: fadeIn;">
                                                    <!-- start pricing table -->
                                                    <div class="pricing-table pricing-popular bg-white box-shadow-large border-radius-6px">
                                                        <!-- start pricing header -->
                                                        <div class="pricing-header bg-extra-dark-gray padding-20px-tb">
                                                            <div class="alt-font font-weight-500 text-small text-white text-uppercase letter-spacing-minus-1-half ptype">Plan Illimité</div>
                                                        </div>
                                                        <!-- end pricing header -->
                                                        <!-- start pricing body -->
                                                        <div class="pricing-body padding-60px-tb">
                                                            <i class="line-icon-Communication-Tower icon-medium text-fast-blue margin-20px-bottom"></i>
                                                            <h4 class="font-weight-500 text-extra-dark-gray letter-spacing-minus-2px margin-15px-bottom">$ <span class="price8"><?php echo $price_stream_unlimited_annually; ?></span></h4>
                                                            <input class="hiddenval8" type="text" style="display: none;" value="<?php echo $price_stream_unlimited_annually; ?>">
                                                            <ul class="list-style-03">
                                                                <li class="border-color-medium-gray p-0">
                                                                    <audio controls style="width: 110%;" controlsList="nodownload">

                                                                        <source class="audiobitrate" src="https://securestream.casthost.net:8223/64" type="audio/mpeg">
                                                                        Your browser does not support the audio element.
                                                                    </audio>
                                                                </li>
                                                                <li class="border-color-medium-gray">
                                                                    <div class="row">
                                                                        <div class="col-4 text-right minusicon" onclick="bitrateminus('8');">
                                                                            <i class="fas disable fa-minus-circle text-gray quantity-left-minus"></i>

                                                                        </div>
                                                                        <div class="col-4" style="padding: 0;">
                                                                            <span id="quantity8" class="text-extra-dark-gray font-weight-500 configbit">64</span> kbps
                                                                        </div>
                                                                        <div class="col-4 text-left plusicon" onclick="bitrateplus('8');">
                                                                            <i class="fas fa-plus-circle text-gray quantity-right-plus"></i>

                                                                        </div>
                                                                    </div>
                                                                </li>

                                                                <li class="border-color-medium-gray">
                                                                    <div class="dropdown">
                                                                        <button class="btn btn-block storagebtn8 dropdown-toggle text-center" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                                            <span class='storagevalue8 configdj'>5 Go</span>
                                                                            <i class="fa fa-chevron-down margin-20px-left"></i>
                                                                        </button>
                                                                        <div class="dropdown-menu dropdown-menu-center storagedd  text-center" aria-labelledby="dropdownMenuButton">
                                                                            <a class="dropdown-item" onclick="storageprice('8','5 GB','0');">5 Go</a>
                                                                            <a class="dropdown-item" onclick="storageprice('8','10 GB','30.00');">10 Go</a>
                                                                            <a class="dropdown-item" onclick="storageprice('8','25 GB','99.00');">25 Go</a>
                                                                            <a class="dropdown-item" onclick="storageprice('8','50 GB','189.00');">50 Go</a>
                                                                            <a class="dropdown-item" onclick="storageprice('8','100 GB','342.00');">100 Go</a>
                                                                        </div>
                                                                    </div>
                                                                </li>

                                                                <li class="border-color-medium-gray"><span class="text-extra-dark-gray font-weight-500">Nombre </span>d'auditeurs maximum illimité </li>
                                                                <li class="border-color-medium-gray"><span class="text-extra-dark-gray font-weight-500">Hébergement </span>Web gratuit</li>

                                                                <li class="border-color-medium-gray"><span class="text-extra-dark-gray font-weight-500">Rapports </span>détaillés avancés</li>
                                                                <li class="border-color-medium-gray"><span class="text-extra-dark-gray font-weight-500">Bande </span>passante illimitée </li>
                                                            </ul>
                                                        </div>
                                                        <!-- end pricing body -->
                                                        <!-- start pricing footer -->
                                                        <div class="pricing-footer margin-5px-top margin-55px-bottom">
                                                            <a class="buynow btn btn-medium btn-transparent-dark-gray btn-round-edge popup-with-zoom-anim" href="#provider" data-link1="https://portal.casthost.net/cart.php?a=add&pid=204&billingcycle=annually" data-link2="https://portal.casthost.net/cart.php?a=add&pid=205&billingcycle=annually" shoutcanada="https://portal.casthost.net/cart.php?a=add&pid=310&billingcycle=annually" icecanada="https://portal.casthost.net/cart.php?a=add&pid=309&billingcycle=annually">Inscrivez-vous maintenant</a>
                                                        </div>
                                                        <!-- end pricing footer -->
                                                    </div>
                                                    <!-- end pricing table -->
                                                </div>
                                                <div class="col pricing-table-style-02 text-center px-md-0 wow animate__fadeInLeft" data-wow-delay="0.4s" style="visibility: visible; animation-delay: 0.4s; animation-name: fadeInLeft;">
                                                    <!-- start pricing table -->
                                                    <div class="pricing-table bg-white border-all border-color-medium-gray border-radius-6px">
                                                        <!-- start pricing header -->
                                                        <div class="pricing-header bg-light-gray padding-20px-tb">
                                                            <div class="alt-font font-weight-500 text-small text-extra-dark-gray text-uppercase letter-spacing-minus-1-half">Plan revendeur</div>
                                                        </div>
                                                        <!-- end pricing header -->
                                                        <!-- start pricing body -->
                                                        <div class="pricing-body padding-40px-tb">
                                                            <i class="line-icon-Headset  icon-medium text-fast-blue margin-20px-bottom"></i>
                                                            <h4 class="font-weight-500 text-extra-dark-gray letter-spacing-minus-2px margin-15px-bottom">Nous contacter</h4>
                                                            <ul class="list-style-03">
                                                                <li class="border-color-medium-gray p-0">
                                                                    <audio controls style="width: 110%;" controlsList="nodownload">

                                                                        <source class="audiobitrate" src="https://securestream.casthost.net:8223/64" type="audio/mpeg">
                                                                        Your browser does not support the audio element.
                                                                    </audio>
                                                                </li>
                                                                <li class="border-color-medium-gray"><span class="text-extra-dark-gray font-weight-500"> 64-320 </span> kbps Bitrate</li>
                                                                <li class="border-color-medium-gray"><span class="text-extra-dark-gray font-weight-500">Custom</span> Disk Space</li>
                                                                <li class="border-color-medium-gray"><span class="text-extra-dark-gray font-weight-500">Nombre </span>d'auditeurs maximum illimité</li>
                                                                <li class="border-color-medium-gray"><span class="text-extra-dark-gray font-weight-500">Hébergement </span>Web gratuit</li>

                                                                <li class="border-color-medium-gray"><span class="text-extra-dark-gray font-weight-500">Rapports </span>détaillés avancés</li>
                                                                <li class="border-color-medium-gray"><span class="text-extra-dark-gray font-weight-500">Bande </span>passante illimitée</li>


                                                            </ul>
                                                        </div>
                                                        <!-- end pricing body -->
                                                        <!-- start pricing footer -->
                                                        <div class="pricing-footer margin-55px-bottom">
                                                            <a class="btn btn-medium btn-transparent-dark-gray btn-round-edge" href="https://portal.casthost.net/submitticket.php?step=2&deptid=2">Nous contacter</a>
                                                        </div>
                                                        <!-- end pricing footer -->
                                                    </div>
                                                    <!-- end pricing table -->
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                </div>
                                <!-- end tab item -->
                                <!-- start tab item -->
                                <div id="strategy" class="tab-pane fade">
                                    <div class="container">
                                        <div class="row justify-content-center">
                                            <div class="col-12 col-xl-10 col-lg-11 tab-style-04">
                                                <ul class="nav nav-tabs text-uppercase justify-content-center text-center alt-font margin-3-half-rem-bottom sm-margin-20px-bottom " style="visibility: visible; animation-name: fadeIn;">
                                                    <li class="nav-item bg-white border-color-extra-light-gray"><a class="nav-link active" data-toggle="tab" href="#monthly-cpanel">Mensuel</a><span class="tab-bg-active bg-fast-blue"></span></li>
                                                    <li class="nav-item bg-white border-color-extra-light-gray"><a class="nav-link" data-toggle="tab" href="#quarterly-cpanel">Trimestriel</a><span class="tab-bg-active bg-fast-blue"></span></li>
                                                    <li class="nav-item bg-white border-color-extra-light-gray"><a class="nav-link" data-toggle="tab" href="#semiannually-cpanel">Semi-annuel</a><span class="tab-bg-active bg-fast-blue"></span></li>
                                                    <li class="nav-item bg-white border-color-extra-light-gray"><a class="nav-link" data-toggle="tab" href="#yearly-cpanel">Annuel</a><span class="tab-bg-active bg-fast-blue"></span></li>
                                                </ul>

                                            </div>
                                        </div>
                                    </div>

                                    <div class="tab-content">
                                        <div id="monthly-cpanel" class="tab-pane fade  active show">
                                            <div class="row row-cols-1 row-cols-md-5 align-items-center">
                                                <div class="col pricing-table-style-02 text-center px-md-0 sm-margin-30px-bottom xs-margin-15px-bottom  animate__fadeInRight" data- -delay="0.4s" style="visibility: visible; animation-delay: 0.4s; animation-name: fadeIn;">
                                                    <!-- start pricing table -->
                                                    <div class="pricing-table bg-white border-all border-color-medium-gray border-radius-6px " style="margin-top: 55px;">
                                                        <!-- start pricing header -->
                                                        <!-- <div class="pricing-header bg-light-gray padding-20px-tb">
                                                                <div class="alt-font font-weight-500 text-small text-extra-dark-gray text-uppercase letter-spacing-minus-1-half">Basic plan</div>
                                                            </div> -->
                                                        <!-- end pricing header -->
                                                        <!-- start pricing body -->
                                                        <div class="pricing-body ">
                                                            <!-- <i class="line-icon-Administrator icon-medium text-fast-blue margin-20px-bottom"></i>
                                                                <h4 class="font-weight-500 text-extra-dark-gray letter-spacing-minus-2px margin-15px-bottom">$9.99</h4> -->
                                                            <ul class="list-style-03 text-left">
                                                                <!-- <li class="border-color-medium-gray" style="padding-left: 1rem;"><span class="text-extra-dark-gray font-weight-500">Disk Storage Space</span> </li>
                                                                <li class="border-color-medium-gray" style="padding-left: 1rem;"><span class="text-extra-dark-gray font-weight-500">Bandwidth</span> </li>
                                                                <li class="border-color-medium-gray" style="padding-left: 1rem;"><span class="text-extra-dark-gray font-weight-500">Sub Domains</span> </li>
                                                                <li class="border-color-medium-gray" style="padding-left: 1rem;"><span class="text-extra-dark-gray font-weight-500">Email Accounts</span> </li>
                                                                <li class="border-color-medium-gray" style="padding-left: 1rem;"><span class="text-extra-dark-gray font-weight-500">MySQL Databases</span> </li>
                                                                <li class="border-color-medium-gray" style="padding-left: 1rem;"><span class="text-extra-dark-gray font-weight-500">Addon Domains</span> </li>
                                                                <li class="border-color-medium-gray" style="padding-left: 1rem;"><span class="text-extra-dark-gray font-weight-500">Parked Domains</span> </li>
                                                                <li class="border-color-medium-gray" style="padding-left: 1rem;"><span class="text-extra-dark-gray font-weight-500">FTP Accounts</span> </li>
                                                                <li class="border-color-medium-gray " style="padding-bottom: 15px; padding-left: 1rem;"><span class="text-extra-dark-gray font-weight-500">cPanel</span></li>-->
                                                                <li class="border-color-medium-gray" style="padding-left: 1rem;">
                                                                    <span class="text-extra-dark-gray font-weight-500">Sites web</span>
                                                                </li>

                                                                <li class="border-color-medium-gray" style="padding-left: 1rem;">
                                                                    <span class="text-extra-dark-gray font-weight-500">Stockage</span>
                                                                </li>

                                                                <li class="border-color-medium-gray" style="padding-left: 1rem;">
                                                                    <span class="text-extra-dark-gray font-weight-500">Base de données</span>
                                                                </li>


                                                                <li class="border-color-medium-gray" style="padding-left: 1rem;">
                                                                    <span class="text-extra-dark-gray font-weight-500">Bande passante</span>
                                                                </li>
                                                                <li class="border-color-medium-gray" style="padding-left: 1rem;">
                                                                    <span class="text-extra-dark-gray font-weight-500">SSL</span>
                                                                </li>

                                                                <li class="border-color-medium-gray" style="padding-left: 1rem;">
                                                                    <span class="text-extra-dark-gray font-weight-500">Script Softaculous</span>
                                                                </li>

                                                                <li class="border-color-medium-gray" style="padding-left: 1rem;">
                                                                    <span class="text-extra-dark-gray font-weight-500">Domaine gratuit</span>
                                                                </li>

                                                            </ul>
                                                        </div>
                                                        <!-- end pricing body -->

                                                    </div>
                                                    <!-- end pricing table -->
                                                </div>
                                                <div class="col pricing-table-style-02 text-center px-md-0 sm-margin-30px-bottom xs-margin-15px-bottom  animate__fadeInRight" data- -delay="0.4s" style="visibility: visible; animation-delay: 0.4s; animation-name: fadeInRight;">
                                                    <!-- start pricing table -->
                                                    <div class="pricing-table bg-white border-all border-color-medium-gray border-radius-6px">
                                                        <!-- start pricing header -->
                                                        <div class="pricing-header bg-light-gray padding-20px-tb">
                                                            <div class="alt-font font-weight-500 text-small text-extra-dark-gray text-uppercase letter-spacing-minus-1-half ptype">Plan de Démarrage</div>
                                                        </div>
                                                        <!-- end pricing header -->
                                                        <!-- start pricing body -->
                                                        <div class="pricing-body padding-40px-tb">
                                                            <i class="line-icon-Data-Storage icon-medium text-fast-blue margin-20px-bottom"></i>
                                                            <h4 class="font-weight-500 text-extra-dark-gray letter-spacing-minus-2px margin-15px-bottom">$
                                                                <?php echo $price_cpanel_starter_monthly; ?>
                                                            </h4>
                                                            <ul class="list-style-03">
                                                                <!-- <li class="border-color-medium-gray"><span class="text-extra-dark-gray font-weight-500">1000 MB  </span> </li>
                                                                <li class="border-color-medium-gray"><span class="text-extra-dark-gray font-weight-500">10 GB  </span> </li>
                                                                <li class="border-color-medium-gray"><span class="text-extra-dark-gray font-weight-500">Unlimited  </span> </li>
                                                                <li class="border-color-medium-gray"><span class="text-extra-dark-gray font-weight-500">10  </span> </li>
                                                                <li class="border-color-medium-gray"><span class="text-extra-dark-gray font-weight-500">4 MySQL   </span> </li>
                                                                <li class="border-color-medium-gray"><span class="text-extra-dark-gray font-weight-500">4 Addon  </span> </li>
                                                                <li class="border-color-medium-gray"><span class="text-extra-dark-gray font-weight-500">4 Parked  </span> </li>
                                                                <li class="border-color-medium-gray"><span class="text-extra-dark-gray font-weight-500">Unlimited  </span> </li>
                                                                <li class="border-color-medium-gray"><span class="text-extra-dark-gray font-weight-500">Free  </span> </li>-->
                                                                <li class="border-color-medium-gray">
                                                                    <span class="text-extra-dark-gray font-weight-500">1 </span>
                                                                </li>
                                                                <li class="border-color-medium-gray">
                                                                    <span class="text-extra-dark-gray font-weight-500">50Go </span>
                                                                </li>
                                                                <li class="border-color-medium-gray">
                                                                    <span class="text-extra-dark-gray font-weight-500">15 </span>
                                                                </li>
                                                                <li class="border-color-medium-gray">
                                                                    <span class="text-extra-dark-gray font-weight-500">Illimité </span>
                                                                </li>
                                                                <li class="border-color-medium-gray">
                                                                    <span class="text-extra-dark-gray font-weight-500">Gratuit </span>
                                                                </li>
                                                                <li class="border-color-medium-gray">
                                                                    <span class="text-extra-dark-gray font-weight-500">Installation en 1 clic de 382 apps </span>
                                                                </li>
                                                                <li class="border-color-medium-gray">
                                                                    <span class="text-extra-dark-gray font-weight-500"> avec l'achat d'un <br> plan de 12 mois+ </span>
                                                                </li>

                                                            </ul>
                                                        </div>
                                                        <!-- end pricing body -->
                                                        <!-- start pricing footer -->
                                                        <div class="pricing-footer margin-55px-bottom">
                                                            <a class="btn btn-medium btn-transparent-dark-gray btn-round-edge" href="https://portal.casthost.net/cart.php?a=add&pid=318&billingcycle=monthly">Inscrivez-vous maintenant</a>
                                                        </div>
                                                        <!-- end pricing footer -->
                                                    </div>
                                                    <!-- end pricing table -->
                                                </div>
                                                <div class="col pricing-table-style-02 text-center px-md-0 sm-margin-30px-bottom xs-margin-15px-bottom  animate__fadeIn z-index-1" style="visibility: visible; animation-name: fadeIn;">
                                                    <!-- start pricing table -->
                                                    <div class="pricing-table pricing-popular bg-white box-shadow-large border-radius-6px">
                                                        <!-- start pricing header -->
                                                        <div class="pricing-header bg-extra-dark-gray padding-20px-tb">
                                                            <div class="alt-font font-weight-500 text-small text-white text-uppercase letter-spacing-minus-1-half">Plan Illimité</div>
                                                        </div>
                                                        <!-- end pricing header -->
                                                        <!-- start pricing body -->
                                                        <div class="pricing-body padding-60px-tb">
                                                            <i class="line-icon-Server-2 icon-medium text-fast-blue margin-20px-bottom"></i>
                                                            <h4 class="font-weight-500 text-extra-dark-gray letter-spacing-minus-2px margin-15px-bottom">$
                                                                <?php echo $price_cpanel_unlimited_monthly; ?>
                                                            </h4>
                                                            <ul class="list-style-03">

                                                                <li class="border-color-medium-gray">
                                                                    <span class="text-extra-dark-gray font-weight-500">Illimité </span>
                                                                </li>
                                                                <li class="border-color-medium-gray">
                                                                    <span class="text-extra-dark-gray font-weight-500">Illimité </span>
                                                                </li>
                                                                <li class="border-color-medium-gray">
                                                                    <span class="text-extra-dark-gray font-weight-500">Illimité </span>
                                                                </li>
                                                                <li class="border-color-medium-gray">
                                                                    <span class="text-extra-dark-gray font-weight-500">Illimité </span>
                                                                </li>
                                                                <li class="border-color-medium-gray">
                                                                    <span class="text-extra-dark-gray font-weight-500">Gratuit </span>
                                                                </li>
                                                                <li class="border-color-medium-gray">
                                                                    <span class="text-extra-dark-gray font-weight-500">Installation en 1 clic de 382 apps </span>
                                                                </li>
                                                                <li class="border-color-medium-gray">
                                                                    <span class="text-extra-dark-gray font-weight-500"> avec l'achat d'un <br> plan de 12 mois+</span>
                                                                </li>
                                                            </ul>
                                                        </div>
                                                        <!-- end pricing body -->
                                                        <!-- start pricing footer -->
                                                        <div class="pricing-footer margin-5px-top margin-55px-bottom">
                                                            <a class="btn btn-medium btn-dark-gray btn-round-edge" href="https://portal.casthost.net/cart.php?a=add&pid=317&billingcycle=monthly">Inscrivez-vous maintenant</a>
                                                        </div>
                                                        <!-- end pricing footer -->
                                                    </div>
                                                    <!-- end pricing table -->
                                                </div>
                                            </div>
                                        </div>
                                        <div id="quarterly-cpanel" class="tab-pane fade">
                                            <div class="row row-cols-1 row-cols-md-5 align-items-center">
                                                <div class="col pricing-table-style-02 text-center px-md-0 sm-margin-30px-bottom xs-margin-15px-bottom  animate__fadeInRight" data- -delay="0.4s" style="visibility: visible; animation-delay: 0.4s; animation-name: fadeIn;">
                                                    <!-- start pricing table -->
                                                    <div class="pricing-table bg-white border-all border-color-medium-gray border-radius-6px " style="margin-top: 55px;">
                                                        <!-- start pricing header -->
                                                        <!-- <div class="pricing-header bg-light-gray padding-20px-tb">
                                                                <div class="alt-font font-weight-500 text-small text-extra-dark-gray text-uppercase letter-spacing-minus-1-half">Basic plan</div>
                                                            </div> -->
                                                        <!-- end pricing header -->
                                                        <!-- start pricing body -->
                                                        <div class="pricing-body ">
                                                            <!-- <i class="line-icon-Administrator icon-medium text-fast-blue margin-20px-bottom"></i>
                                                                <h4 class="font-weight-500 text-extra-dark-gray letter-spacing-minus-2px margin-15px-bottom">$9.99</h4> -->
                                                            <ul class="list-style-03 text-left">
                                                                <li class="border-color-medium-gray" style="padding-left: 1rem;">
                                                                    <span class="text-extra-dark-gray font-weight-500">Sites web</span>
                                                                </li>

                                                                <li class="border-color-medium-gray" style="padding-left: 1rem;">
                                                                    <span class="text-extra-dark-gray font-weight-500">Stockage</span>
                                                                </li>

                                                                <li class="border-color-medium-gray" style="padding-left: 1rem;">
                                                                    <span class="text-extra-dark-gray font-weight-500">Base de données</span>
                                                                </li>


                                                                <li class="border-color-medium-gray" style="padding-left: 1rem;">
                                                                    <span class="text-extra-dark-gray font-weight-500">Bande passante</span>
                                                                </li>

                                                                <li class="border-color-medium-gray" style="padding-left: 1rem;">
                                                                    <span class="text-extra-dark-gray font-weight-500">SSL</span>
                                                                </li>

                                                                <li class="border-color-medium-gray" style="padding-left: 1rem;">
                                                                    <span class="text-extra-dark-gray font-weight-500">Script Softaculous</span>
                                                                </li>

                                                                <li class="border-color-medium-gray" style="padding-left: 1rem;">
                                                                    <span class="text-extra-dark-gray font-weight-500">Domaine gratuit</span>
                                                                </li>
                                                            </ul>
                                                        </div>
                                                        <!-- end pricing body -->

                                                    </div>
                                                    <!-- end pricing table -->
                                                </div>
                                                <div class="col pricing-table-style-02 text-center px-md-0 sm-margin-30px-bottom xs-margin-15px-bottom  animate__fadeInRight" data- -delay="0.4s" style="visibility: visible; animation-delay: 0.4s; animation-name: fadeInRight;">
                                                    <!-- start pricing table -->
                                                    <div class="pricing-table bg-white border-all border-color-medium-gray border-radius-6px">
                                                        <!-- start pricing header -->
                                                        <div class="pricing-header bg-light-gray padding-20px-tb">
                                                            <div class="alt-font font-weight-500 text-small text-extra-dark-gray text-uppercase letter-spacing-minus-1-half ptype">Plan de Démarrage</div>
                                                        </div>
                                                        <!-- end pricing header -->
                                                        <!-- start pricing body -->
                                                        <div class="pricing-body padding-40px-tb">
                                                            <i class="line-icon-Data-Storage icon-medium text-fast-blue margin-20px-bottom"></i>
                                                            <h4 class="font-weight-500 text-extra-dark-gray letter-spacing-minus-2px margin-15px-bottom">$
                                                                <?php echo $price_cpanel_starter_quarterly; ?>
                                                            </h4>
                                                            <ul class="list-style-03">

                                                                <li class="border-color-medium-gray">
                                                                    <span class="text-extra-dark-gray font-weight-500">1 </span>
                                                                </li>
                                                                <li class="border-color-medium-gray">
                                                                    <span class="text-extra-dark-gray font-weight-500">50Go </span>
                                                                </li>
                                                                <li class="border-color-medium-gray">
                                                                    <span class="text-extra-dark-gray font-weight-500">15 </span>
                                                                </li>
                                                                <li class="border-color-medium-gray">
                                                                    <span class="text-extra-dark-gray font-weight-500">Illimité </span>
                                                                </li>
                                                                <li class="border-color-medium-gray">
                                                                    <span class="text-extra-dark-gray font-weight-500">Gratuit </span>
                                                                </li>
                                                                <li class="border-color-medium-gray">
                                                                    <span class="text-extra-dark-gray font-weight-500">Installation en 1 clic de 382 apps </span>
                                                                </li>
                                                                <li class="border-color-medium-gray">
                                                                    <span class="text-extra-dark-gray font-weight-500"> avec l'achat d'un <br> plan de 12 mois+ </span>
                                                                </li>
                                                            </ul>
                                                        </div>
                                                        <!-- end pricing body -->
                                                        <!-- start pricing footer -->
                                                        <div class="pricing-footer margin-55px-bottom">
                                                            <a class="btn btn-medium btn-transparent-dark-gray btn-round-edge" href="https://portal.casthost.net/cart.php?a=add&pid=318&billingcycle=quarterly">Inscrivez-vous maintenant</a>
                                                        </div>
                                                        <!-- end pricing footer -->
                                                    </div>
                                                    <!-- end pricing table -->
                                                </div>
                                                <div class="col pricing-table-style-02 text-center px-md-0 sm-margin-30px-bottom xs-margin-15px-bottom  animate__fadeIn z-index-1" style="visibility: visible; animation-name: fadeIn;">
                                                    <!-- start pricing table -->
                                                    <div class="pricing-table pricing-popular bg-white box-shadow-large border-radius-6px">
                                                        <!-- start pricing header -->
                                                        <div class="pricing-header bg-extra-dark-gray padding-20px-tb">
                                                            <div class="alt-font font-weight-500 text-small text-white text-uppercase letter-spacing-minus-1-half">Plan Illimité</div>
                                                        </div>
                                                        <!-- end pricing header -->
                                                        <!-- start pricing body -->
                                                        <div class="pricing-body padding-60px-tb">
                                                            <i class="line-icon-Server-2 icon-medium text-fast-blue margin-20px-bottom"></i>
                                                            <h4 class="font-weight-500 text-extra-dark-gray letter-spacing-minus-2px margin-15px-bottom">$
                                                                <?php echo $price_cpanel_unlimited_quarterly; ?>
                                                            </h4>
                                                            <ul class="list-style-03">
                                                                <li class="border-color-medium-gray">
                                                                    <span class="text-extra-dark-gray font-weight-500">Illimité </span>
                                                                </li>
                                                                <li class="border-color-medium-gray">
                                                                    <span class="text-extra-dark-gray font-weight-500">Illimité </span>
                                                                </li>
                                                                <li class="border-color-medium-gray">
                                                                    <span class="text-extra-dark-gray font-weight-500">Illimité </span>
                                                                </li>
                                                                <li class="border-color-medium-gray">
                                                                    <span class="text-extra-dark-gray font-weight-500">Illimité </span>
                                                                </li>
                                                                <li class="border-color-medium-gray">
                                                                    <span class="text-extra-dark-gray font-weight-500">Gratuit </span>
                                                                </li>
                                                                <li class="border-color-medium-gray">
                                                                    <span class="text-extra-dark-gray font-weight-500">Installation en 1 clic de 382 apps </span>
                                                                </li>
                                                                <li class="border-color-medium-gray">
                                                                    <span class="text-extra-dark-gray font-weight-500"> avec l'achat d'un <br> plan de 12 mois+ </span>
                                                                </li>
                                                            </ul>
                                                        </div>
                                                        <!-- end pricing body -->
                                                        <!-- start pricing footer -->
                                                        <div class="pricing-footer margin-5px-top margin-55px-bottom">
                                                            <a class="btn btn-medium btn-dark-gray btn-round-edge" href="https://portal.casthost.net/cart.php?a=add&pid=317">Inscrivez-vous maintenant</a>
                                                        </div>
                                                        <!-- end pricing footer -->
                                                    </div>
                                                    <!-- end pricing table -->
                                                </div>
                                            </div>
                                        </div>
                                        <div id="semiannually-cpanel" class="tab-pane fade">
                                            <div class="row row-cols-1 row-cols-md-5 align-items-center">
                                                <div class="col pricing-table-style-02 text-center px-md-0 sm-margin-30px-bottom xs-margin-15px-bottom   animate__fadeInRight" data- -delay="0.4s" style="visibility: visible; animation-delay: 0.4s; animation-name: fadeIn;">
                                                    <!-- start pricing table -->
                                                    <div class="pricing-table bg-white border-all border-color-medium-gray border-radius-6px " style="margin-top: 55px;">
                                                        <!-- start pricing header -->
                                                        <!-- <div class="pricing-header bg-light-gray padding-20px-tb">
                                                                <div class="alt-font font-weight-500 text-small text-extra-dark-gray text-uppercase letter-spacing-minus-1-half">Basic plan</div>
                                                            </div> -->
                                                        <!-- end pricing header -->
                                                        <!-- start pricing body -->
                                                        <div class="pricing-body ">
                                                            <!-- <i class="line-icon-Administrator icon-medium text-fast-blue margin-20px-bottom"></i>
                                                                <h4 class="font-weight-500 text-extra-dark-gray letter-spacing-minus-2px margin-15px-bottom">$9.99</h4> -->
                                                            <ul class="list-style-03 text-left">
                                                                <li class="border-color-medium-gray" style="padding-left: 1rem;">
                                                                    <span class="text-extra-dark-gray font-weight-500">Sites web</span>
                                                                </li>

                                                                <li class="border-color-medium-gray" style="padding-left: 1rem;">
                                                                    <span class="text-extra-dark-gray font-weight-500">Stockage</span>
                                                                </li>

                                                                <li class="border-color-medium-gray" style="padding-left: 1rem;">
                                                                    <span class="text-extra-dark-gray font-weight-500">Base de données</span>
                                                                </li>
                                                                <li class="border-color-medium-gray" style="padding-left: 1rem;">
                                                                    <span class="text-extra-dark-gray font-weight-500">Bande passante</span>
                                                                </li>
                                                                <li class="border-color-medium-gray" style="padding-left: 1rem;">
                                                                    <span class="text-extra-dark-gray font-weight-500">SSL</span>
                                                                </li>
                                                                <li class="border-color-medium-gray" style="padding-left: 1rem;">
                                                                    <span class="text-extra-dark-gray font-weight-500">Script Softaculous</span>
                                                                </li>

                                                                <li class="border-color-medium-gray" style="padding-left: 1rem;">
                                                                    <span class="text-extra-dark-gray font-weight-500">Domaine gratuit</span>
                                                                </li>

                                                            </ul>
                                                        </div>
                                                        <!-- end pricing body -->

                                                    </div>
                                                    <!-- end pricing table -->
                                                </div>
                                                <div class="col pricing-table-style-02 text-center px-md-0 sm-margin-30px-bottom xs-margin-15px-bottom   animate__fadeInRight" data- -delay="0.4s" style="visibility: visible; animation-delay: 0.4s; animation-name: fadeInRight;">
                                                    <!-- start pricing table -->
                                                    <div class="pricing-table bg-white border-all border-color-medium-gray border-radius-6px">
                                                        <!-- start pricing header -->
                                                        <div class="pricing-header bg-light-gray padding-20px-tb">
                                                            <div class="alt-font font-weight-500 text-small text-extra-dark-gray text-uppercase letter-spacing-minus-1-half ptype">Plan de Démarrage</div>
                                                        </div>
                                                        <!-- end pricing header -->
                                                        <!-- start pricing body -->
                                                        <div class="pricing-body padding-40px-tb">
                                                            <i class="line-icon-Data-Storage icon-medium text-fast-blue margin-20px-bottom"></i>
                                                            <h4 class="font-weight-500 text-extra-dark-gray letter-spacing-minus-2px margin-15px-bottom">$
                                                                <?php echo $price_cpanel_starter_semiannually; ?>
                                                            </h4>
                                                            <ul class="list-style-03">

                                                                <li class="border-color-medium-gray">
                                                                    <span class="text-extra-dark-gray font-weight-500">1 </span>
                                                                </li>
                                                                <li class="border-color-medium-gray">
                                                                    <span class="text-extra-dark-gray font-weight-500">50Go </span>
                                                                </li>
                                                                <li class="border-color-medium-gray">
                                                                    <span class="text-extra-dark-gray font-weight-500">15 </span>
                                                                </li>
                                                                <li class="border-color-medium-gray">
                                                                    <span class="text-extra-dark-gray font-weight-500">Illimité </span>
                                                                </li>
                                                                <li class="border-color-medium-gray">
                                                                    <span class="text-extra-dark-gray font-weight-500">Gratuit </span>
                                                                </li>
                                                                <li class="border-color-medium-gray">
                                                                    <span class="text-extra-dark-gray font-weight-500">Installation en 1 clic de 382 apps </span>
                                                                </li>
                                                                <li class="border-color-medium-gray">
                                                                    <span class="text-extra-dark-gray font-weight-500"> avec l'achat d'un <br>plan de 12 mois+ </span>
                                                                </li>
                                                            </ul>
                                                        </div>
                                                        <!-- end pricing body -->
                                                        <!-- start pricing footer -->
                                                        <div class="pricing-footer margin-55px-bottom">
                                                            <a class="btn btn-medium btn-transparent-dark-gray btn-round-edge" href="https://portal.casthost.net/cart.php?a=add&pid=318&billingcycle=semiannually">Inscrivez-vous maintenant</a>
                                                        </div>
                                                        <!-- end pricing footer -->
                                                    </div>
                                                    <!-- end pricing table -->
                                                </div>
                                                <div class="col pricing-table-style-02 text-center px-md-0 sm-margin-30px-bottom xs-margin-15px-bottom   animate__fadeIn z-index-1" style="visibility: visible; animation-name: fadeIn;">
                                                    <!-- start pricing table -->
                                                    <div class="pricing-table pricing-popular bg-white box-shadow-large border-radius-6px">
                                                        <!-- start pricing header -->
                                                        <div class="pricing-header bg-extra-dark-gray padding-20px-tb">
                                                            <div class="alt-font font-weight-500 text-small text-white text-uppercase letter-spacing-minus-1-half">Plan Illimité</div>
                                                        </div>
                                                        <!-- end pricing header -->
                                                        <!-- start pricing body -->
                                                        <div class="pricing-body padding-60px-tb">
                                                            <i class="line-icon-Server-2 icon-medium text-fast-blue margin-20px-bottom"></i>
                                                            <h4 class="font-weight-500 text-extra-dark-gray letter-spacing-minus-2px margin-15px-bottom">$
                                                                <?php echo $price_cpanel_unlimited_semiannually; ?>
                                                            </h4>
                                                            <ul class="list-style-03">
                                                                <li class="border-color-medium-gray">
                                                                    <span class="text-extra-dark-gray font-weight-500">Illimité </span>
                                                                </li>
                                                                <li class="border-color-medium-gray">
                                                                    <span class="text-extra-dark-gray font-weight-500">Illimité </span>
                                                                </li>
                                                                <li class="border-color-medium-gray">
                                                                    <span class="text-extra-dark-gray font-weight-500">Illimité </span>
                                                                </li>
                                                                <li class="border-color-medium-gray">
                                                                    <span class="text-extra-dark-gray font-weight-500">Unmetered </span>
                                                                </li>
                                                                <li class="border-color-medium-gray">
                                                                    <span class="text-extra-dark-gray font-weight-500">Free </span>
                                                                </li>
                                                                <li class="border-color-medium-gray">
                                                                    <span class="text-extra-dark-gray font-weight-500">Installation en 1 clic de 382 apps </span>
                                                                </li>
                                                                <li class="border-color-medium-gray">
                                                                    <span class="text-extra-dark-gray font-weight-500"> avec l'achat d'un <br>plan de 12 mois+ </span>
                                                                </li>
                                                            </ul>
                                                        </div>
                                                        <!-- end pricing body -->
                                                        <!-- start pricing footer -->
                                                        <div class="pricing-footer margin-5px-top margin-55px-bottom">
                                                            <a class="btn btn-medium btn-dark-gray btn-round-edge" href="https://portal.casthost.net/cart.php?a=add&pid=317&billingcycle=semiannually">Inscrivez-vous maintenant</a>
                                                        </div>
                                                        <!-- end pricing footer -->
                                                    </div>
                                                    <!-- end pricing table -->
                                                </div>
                                            </div>
                                        </div>

                                        <div id="yearly-cpanel" class="tab-pane fade">
                                            <div class="row row-cols-1 row-cols-md-5 align-items-center">
                                                <div class="col pricing-table-style-02 text-center px-md-0 sm-margin-30px-bottom xs-margin-15px-bottom   animate__fadeInRight" data- -delay="0.4s" style="visibility: visible; animation-delay: 0.4s; animation-name: fadeIn;">
                                                    <!-- start pricing table -->
                                                    <div class="pricing-table bg-white border-all border-color-medium-gray border-radius-6px " style="margin-top: 55px;">
                                                        <!-- start pricing header -->
                                                        <!-- <div class="pricing-header bg-light-gray padding-20px-tb">
                                                                <div class="alt-font font-weight-500 text-small text-extra-dark-gray text-uppercase letter-spacing-minus-1-half">Basic plan</div>
                                                            </div> -->
                                                        <!-- end pricing header -->
                                                        <!-- start pricing body -->
                                                        <div class="pricing-body ">
                                                            <!-- <i class="line-icon-Administrator icon-medium text-fast-blue margin-20px-bottom"></i>
                                                                <h4 class="font-weight-500 text-extra-dark-gray letter-spacing-minus-2px margin-15px-bottom">$9.99</h4> -->
                                                            <ul class="list-style-03 text-left">
                                                                <li class="border-color-medium-gray" style="padding-left: 1rem;">
                                                                    <span class="text-extra-dark-gray font-weight-500">Sites web</span>
                                                                </li>

                                                                <li class="border-color-medium-gray" style="padding-left: 1rem;">
                                                                    <span class="text-extra-dark-gray font-weight-500">Stockage</span>
                                                                </li>

                                                                <li class="border-color-medium-gray" style="padding-left: 1rem;">
                                                                    <span class="text-extra-dark-gray font-weight-500">Base de données</span>
                                                                </li>
                                                                <li class="border-color-medium-gray" style="padding-left: 1rem;">
                                                                    <span class="text-extra-dark-gray font-weight-500">ande passante</span>
                                                                </li>
                                                                <li class="border-color-medium-gray" style="padding-left: 1rem;">
                                                                    <span class="text-extra-dark-gray font-weight-500">SSL</span>
                                                                </li>
                                                                <li class="border-color-medium-gray" style="padding-left: 1rem;">
                                                                    <span class="text-extra-dark-gray font-weight-500">Script Softaculous</span>
                                                                </li>

                                                                <li class="border-color-medium-gray" style="padding-left: 1rem;">
                                                                    <span class="text-extra-dark-gray font-weight-500">Domaine gratuit</span>
                                                                </li>

                                                            </ul>
                                                        </div>
                                                        <!-- end pricing body -->

                                                    </div>
                                                    <!-- end pricing table -->
                                                </div>
                                                <div class="col pricing-table-style-02 text-center px-md-0 sm-margin-30px-bottom xs-margin-15px-bottom   animate__fadeInRight" data- -delay="0.4s" style="visibility: visible; animation-delay: 0.4s; animation-name: fadeInRight;">
                                                    <!-- start pricing table -->
                                                    <div class="pricing-table bg-white border-all border-color-medium-gray border-radius-6px">
                                                        <!-- start pricing header -->
                                                        <div class="pricing-header bg-light-gray padding-20px-tb">
                                                            <div class="alt-font font-weight-500 text-small text-extra-dark-gray text-uppercase letter-spacing-minus-1-half ptype">Plan de Démarrage</div>
                                                        </div>
                                                        <!-- end pricing header -->
                                                        <!-- start pricing body -->
                                                        <div class="pricing-body padding-40px-tb">
                                                            <i class="line-icon-Data-Storage icon-medium text-fast-blue margin-20px-bottom"></i>
                                                            <h4 class="font-weight-500 text-extra-dark-gray letter-spacing-minus-2px margin-15px-bottom">$
                                                                <?php echo $price_cpanel_starter_annually; ?>
                                                            </h4>
                                                            <ul class="list-style-03">

                                                                <li class="border-color-medium-gray">
                                                                    <span class="text-extra-dark-gray font-weight-500">1 </span>
                                                                </li>
                                                                <li class="border-color-medium-gray">
                                                                    <span class="text-extra-dark-gray font-weight-500">50Go </span>
                                                                </li>
                                                                <li class="border-color-medium-gray">
                                                                    <span class="text-extra-dark-gray font-weight-500">15 </span>
                                                                </li>
                                                                <li class="border-color-medium-gray">
                                                                    <span class="text-extra-dark-gray font-weight-500">Illimité </span>
                                                                </li>
                                                                <li class="border-color-medium-gray">
                                                                    <span class="text-extra-dark-gray font-weight-500">Gratuit </span>
                                                                </li>
                                                                <li class="border-color-medium-gray">
                                                                    <span class="text-extra-dark-gray font-weight-500">Installation en 1 clic de 382 apps </span>
                                                                </li>
                                                                <li class="border-color-medium-gray">
                                                                    <span class="text-extra-dark-gray font-weight-500"> avec l'achat d'un <br>plan de 12 mois+ </span>
                                                                </li>
                                                            </ul>
                                                        </div>
                                                        <!-- end pricing body -->
                                                        <!-- start pricing footer -->
                                                        <div class="pricing-footer margin-55px-bottom">
                                                            <a class="btn btn-medium btn-transparent-dark-gray btn-round-edge" href="https://portal.casthost.net/cart.php?a=add&pid=318&billingcycle=annually">Inscrivez-vous maintenant</a>
                                                        </div>
                                                        <!-- end pricing footer -->
                                                    </div>
                                                    <!-- end pricing table -->
                                                </div>
                                                <div class="col pricing-table-style-02 text-center px-md-0 sm-margin-30px-bottom xs-margin-15px-bottom   animate__fadeIn z-index-1" style="visibility: visible; animation-name: fadeIn;">
                                                    <!-- start pricing table -->
                                                    <div class="pricing-table pricing-popular bg-white box-shadow-large border-radius-6px">
                                                        <!-- start pricing header -->
                                                        <div class="pricing-header bg-extra-dark-gray padding-20px-tb">
                                                            <div class="alt-font font-weight-500 text-small text-white text-uppercase letter-spacing-minus-1-half">Plan Illimité</div>
                                                        </div>
                                                        <!-- end pricing header -->
                                                        <!-- start pricing body -->
                                                        <div class="pricing-body padding-60px-tb">
                                                            <i class="line-icon-Server-2 icon-medium text-fast-blue margin-20px-bottom"></i>
                                                            <h4 class="font-weight-500 text-extra-dark-gray letter-spacing-minus-2px margin-15px-bottom">$
                                                                <?php echo $price_cpanel_unlimited_annually; ?>
                                                            </h4>
                                                            <ul class="list-style-03">
                                                                <li class="border-color-medium-gray">
                                                                    <span class="text-extra-dark-gray font-weight-500">Illimité </span>
                                                                </li>
                                                                <li class="border-color-medium-gray">
                                                                    <span class="text-extra-dark-gray font-weight-500">Illimité </span>
                                                                </li>
                                                                <li class="border-color-medium-gray">
                                                                    <span class="text-extra-dark-gray font-weight-500">Illimité </span>
                                                                </li>
                                                                <li class="border-color-medium-gray">
                                                                    <span class="text-extra-dark-gray font-weight-500">Illimité </span>
                                                                </li>
                                                                <li class="border-color-medium-gray">
                                                                    <span class="text-extra-dark-gray font-weight-500">Gratuit </span>
                                                                </li>
                                                                <li class="border-color-medium-gray">
                                                                    <span class="text-extra-dark-gray font-weight-500">Installation en 1 clic de 382 apps </span>
                                                                </li>
                                                                <li class="border-color-medium-gray">
                                                                    <span class="text-extra-dark-gray font-weight-500"> avec l'achat d'un <br>plan de 12 mois+ </span>
                                                                </li>
                                                            </ul>
                                                        </div>
                                                        <!-- end pricing body -->
                                                        <!-- start pricing footer -->
                                                        <div class="pricing-footer margin-5px-top margin-55px-bottom">
                                                            <a class="btn btn-medium btn-dark-gray btn-round-edge" href="https://portal.casthost.net/cart.php?a=add&pid=317&billingcycle=annually">Inscrivez-vous maintenant</a>
                                                        </div>
                                                        <!-- end pricing footer -->
                                                    </div>
                                                    <!-- end pricing table -->
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                </div>
                                <!-- end tab item -->
                                <!-- start tab item -->
                                <div id="management" class="tab-pane fade">
                                    <div class="container">
                                        <div class="tab-content">
                                            <div id="monthly-tab" class="tab-pane fade in active show">
                                                <div class="row row-cols-1 row-cols-md-4 align-items-center">
                                                    <div class="col pricing-table-style-02 text-center px-md-0 sm-margin-30px-bottom xs-margin-15px-bottom   animate__fadeInRight" data- -delay="0.4s" style="visibility: visible; animation-delay: 0.4s; animation-name: fadeInRight;">
                                                        <!-- start pricing table -->
                                                        <div class="pricing-table bg-white border-all border-color-medium-gray border-radius-6px">
                                                            <!-- start pricing header -->
                                                            <div class="pricing-header bg-light-gray padding-20px-tb">
                                                                <div class="alt-font font-weight-500 text-small text-extra-dark-gray text-uppercase letter-spacing-minus-1-half">Mensuel</div>
                                                            </div>
                                                            <!-- end pricing header -->
                                                            <!-- start pricing body -->
                                                            <div class="pricing-body padding-40px-tb">
                                                                <i class="line-icon-Line-Chart2   icon-medium text-fast-blue margin-20px-bottom"></i>
                                                                <h4 class="font-weight-500 text-extra-dark-gray letter-spacing-minus-2px margin-15px-bottom">$
                                                                    <?php echo $price_seo_monthly; ?>
                                                                </h4>
                                                                <ul class="list-style-03">
                                                                    <li class="border-color-medium-gray"><span class="text-extra-dark-gray font-weight-500"> </span> Recherche de mots-clés</li>
                                                                    <li class="border-color-medium-gray"><span class="text-extra-dark-gray font-weight-500"> </span> Optimisation des détails méta</li>
                                                                    <li class="border-color-medium-gray"><span class="text-extra-dark-gray font-weight-500"> </span> Optimisation des balises d'en-tête</li>
                                                                    <li class="border-color-medium-gray"><span class="text-extra-dark-gray font-weight-500"> </span> Amélioration des performances du site</li>
                                                                    <li class="border-color-medium-gray"><span class="text-extra-dark-gray font-weight-500"> </span> Maillage interne </li>
                                                                    <li class="border-color-medium-gray"><span class="text-extra-dark-gray font-weight-500"> </span> Optimisation du contenu </li>
                                                                    <li class="border-color-medium-gray"><span class="text-extra-dark-gray font-weight-500"> </span> Vérification de plagiat </li>
                                                                    <li class="border-color-medium-gray"><span class="text-extra-dark-gray font-weight-500"> </span>Intégration des analyses</li>
                                                                    <li class="border-color-medium-gray"><span class="text-extra-dark-gray font-weight-500"> </span>Optimisation des URL</li>
                                                                    <li><span class="text-extra-dark-gray font-weight-500"></span> Création de liens retour</li>
                                                                </ul>
                                                            </div>
                                                            <!-- end pricing body -->
                                                            <!-- start pricing footer -->
                                                            <div class="pricing-footer margin-55px-bottom">
                                                                <a class="btn btn-medium btn-transparent-dark-gray btn-round-edge" href="https://portal.casthost.net/cart.php?a=add&pid=279&billingcycle=monthly">Inscrivez-vous maintenant</a>
                                                            </div>
                                                            <!-- end pricing footer -->
                                                        </div>
                                                        <!-- end pricing table -->
                                                    </div>
                                                    <div class="col pricing-table-style-02 text-center px-md-0 sm-margin-30px-bottom xs-margin-15px-bottom   animate__fadeInRight" data- -delay="0.4s" style="visibility: visible; animation-delay: 0.4s; animation-name: fadeInRight;">
                                                        <!-- start pricing table -->
                                                        <div class="pricing-table bg-white border-all border-color-medium-gray border-radius-6px">
                                                            <!-- start pricing header -->
                                                            <div class="pricing-header bg-light-gray padding-20px-tb">
                                                                <div class="alt-font font-weight-500 text-small text-extra-dark-gray text-uppercase letter-spacing-minus-1-half">Trimestriellement</div>
                                                            </div>
                                                            <!-- end pricing header -->
                                                            <!-- start pricing body -->
                                                            <div class="pricing-body padding-40px-tb">
                                                                <i class="line-icon-Bar-Chart4  icon-medium text-fast-blue margin-20px-bottom"></i>
                                                                <h4 class="font-weight-500 text-extra-dark-gray letter-spacing-minus-2px margin-15px-bottom">$
                                                                    <?php echo $price_seo_quarterly; ?>
                                                                </h4>
                                                                <ul class="list-style-03">
                                                                    <li class="border-color-medium-gray"><span class="text-extra-dark-gray font-weight-500"> </span> Recherche de mots-clés</li>
                                                                    <li class="border-color-medium-gray"><span class="text-extra-dark-gray font-weight-500"> </span> Optimisation des détails méta </li>
                                                                    <li class="border-color-medium-gray"><span class="text-extra-dark-gray font-weight-500"> </span> Optimisation des balises d'en-tête</li>
                                                                    <li class="border-color-medium-gray"><span class="text-extra-dark-gray font-weight-500"> </span> Amélioration des performances du site</li>
                                                                    <li class="border-color-medium-gray"><span class="text-extra-dark-gray font-weight-500"> </span> Maillage interne</li>
                                                                    <li class="border-color-medium-gray"><span class="text-extra-dark-gray font-weight-500"> </span> Optimisation du contenu</li>
                                                                    <li class="border-color-medium-gray"><span class="text-extra-dark-gray font-weight-500"> </span> Vérification de plagiat</li>
                                                                    <li class="border-color-medium-gray"><span class="text-extra-dark-gray font-weight-500"> </span>Intégration des analyses</li>
                                                                    <li class="border-color-medium-gray"><span class="text-extra-dark-gray font-weight-500"> </span>Optimisation des URL</li>
                                                                    <li><span class="text-extra-dark-gray font-weight-500"></span> Création de liens retour</li>
                                                                </ul>
                                                            </div>
                                                            <!-- end pricing body -->
                                                            <!-- start pricing footer -->
                                                            <div class="pricing-footer margin-55px-bottom">
                                                                <a class="btn btn-medium btn-transparent-dark-gray btn-round-edge" href="https://portal.casthost.net/cart.php?a=add&pid=279&billingcycle=quarterly">Inscrivez-vous maintenant</a>
                                                            </div>
                                                            <!-- end pricing footer -->
                                                        </div>
                                                        <!-- end pricing table -->
                                                    </div>
                                                    <div class="col pricing-table-style-02 text-center px-md-0 sm-margin-30px-bottom xs-margin-15px-bottom   animate__fadeIn z-index-1" style="visibility: visible; animation-name: fadeIn;">
                                                        <!-- start pricing table -->
                                                        <div class="pricing-table pricing-popular bg-white box-shadow-large border-radius-6px">
                                                            <!-- start pricing header -->
                                                            <div class="pricing-header bg-extra-dark-gray padding-20px-tb">
                                                                <div class="alt-font font-weight-500 text-small text-white text-uppercase letter-spacing-minus-1-half">Semi-annuel</div>
                                                            </div>
                                                            <!-- end pricing header -->
                                                            <!-- start pricing body -->
                                                            <div class="pricing-body padding-60px-tb">
                                                                <i class="line-icon-Bar-Chart5  icon-medium text-fast-blue margin-20px-bottom"></i>
                                                                <h4 class="font-weight-500 text-extra-dark-gray letter-spacing-minus-2px margin-15px-bottom">$
                                                                    <?php echo $price_seo_semiannually; ?>
                                                                </h4>
                                                                <ul class="list-style-03">
                                                                    <li class="border-color-medium-gray"><span class="text-extra-dark-gray font-weight-500"> </span> Recherche de mots-clés</li>
                                                                    <li class="border-color-medium-gray"><span class="text-extra-dark-gray font-weight-500"> </span> Meta Details Optimization </li>
                                                                    <li class="border-color-medium-gray"><span class="text-extra-dark-gray font-weight-500"> </span> Optimisation des balises d'en-tête</li>
                                                                    <li class="border-color-medium-gray"><span class="text-extra-dark-gray font-weight-500"> </span> Amélioration des performances du site</li>
                                                                    <li class="border-color-medium-gray"><span class="text-extra-dark-gray font-weight-500"> </span> Maillage interne </li>
                                                                    <li class="border-color-medium-gray"><span class="text-extra-dark-gray font-weight-500"> </span> Optimisation du contenu </li>
                                                                    <li class="border-color-medium-gray"><span class="text-extra-dark-gray font-weight-500"> </span> Vérification de plagiat </li>
                                                                    <li class="border-color-medium-gray"><span class="text-extra-dark-gray font-weight-500"> </span>Intégration des analyses</li>
                                                                    <li class="border-color-medium-gray"><span class="text-extra-dark-gray font-weight-500"> </span>Optimisation des URL</li>
                                                                    <li><span class="text-extra-dark-gray font-weight-500"></span> Création de liens retour</li>
                                                                </ul>
                                                            </div>
                                                            <!-- end pricing body -->
                                                            <!-- start pricing footer -->
                                                            <div class="pricing-footer margin-5px-top margin-55px-bottom">
                                                                <a class="btn btn-medium btn-dark-gray btn-round-edge" href="https://portal.casthost.net/cart.php?a=add&pid=279&billingcycle=semiannually">Inscrivez-vous maintenant</a>
                                                            </div>
                                                            <!-- end pricing footer -->
                                                        </div>
                                                        <!-- end pricing table -->
                                                    </div>
                                                    <div class="col pricing-table-style-02 text-center px-md-0   animate__fadeInLeft" data- -delay="0.4s" style="visibility: visible; animation-delay: 0.4s; animation-name: fadeInLeft;">
                                                        <!-- start pricing table -->
                                                        <div class="pricing-table bg-white border-all border-color-medium-gray border-radius-6px">
                                                            <!-- start pricing header -->
                                                            <div class="pricing-header bg-light-gray padding-20px-tb">
                                                                <div class="alt-font font-weight-500 text-small text-extra-dark-gray text-uppercase letter-spacing-minus-1-half">Annuel</div>
                                                            </div>
                                                            <!-- end pricing header -->
                                                            <!-- start pricing body -->
                                                            <div class="pricing-body padding-40px-tb">
                                                                <i class="line-icon-Bar-Chart icon-medium text-fast-blue margin-20px-bottom"></i>
                                                                <h4 class="font-weight-500 text-extra-dark-gray letter-spacing-minus-2px margin-15px-bottom">$
                                                                    <?php echo $price_seo_annually; ?>
                                                                </h4>
                                                                <ul class="list-style-03">
                                                                    <li class="border-color-medium-gray"><span class="text-extra-dark-gray font-weight-500"> </span> Recherche de mots-clés</li>
                                                                    <li class="border-color-medium-gray"><span class="text-extra-dark-gray font-weight-500"> </span> Optimisation des détails méta </li>
                                                                    <li class="border-color-medium-gray"><span class="text-extra-dark-gray font-weight-500"> </span> Optimisation des balises d'en-tête</li>
                                                                    <li class="border-color-medium-gray"><span class="text-extra-dark-gray font-weight-500"> </span> Amélioration des performances du site</li>
                                                                    <li class="border-color-medium-gray"><span class="text-extra-dark-gray font-weight-500"> </span> Maillage interne </li>
                                                                    <li class="border-color-medium-gray"><span class="text-extra-dark-gray font-weight-500"> </span> Optimisation du contenu </li>
                                                                    <li class="border-color-medium-gray"><span class="text-extra-dark-gray font-weight-500"> </span> Vérification de plagiat</li>
                                                                    <li class="border-color-medium-gray"><span class="text-extra-dark-gray font-weight-500"> </span>Intégration des analyses</li>
                                                                    <li class="border-color-medium-gray"><span class="text-extra-dark-gray font-weight-500"> </span>Optimisation des URL</li>
                                                                    <li><span class="text-extra-dark-gray font-weight-500"></span> Création de liens retour</li>
                                                                </ul>
                                                            </div>
                                                            <!-- end pricing body -->
                                                            <!-- start pricing footer -->
                                                            <div class="pricing-footer margin-55px-bottom">
                                                                <a class="btn btn-medium btn-transparent-dark-gray btn-round-edge" href="https://portal.casthost.net/cart.php?a=add&pid=279&billingcycle=annually">Inscrivez-vous maintenant</a>
                                                            </div>
                                                            <!-- end pricing footer -->
                                                        </div>
                                                        <!-- end pricing table -->
                                                    </div>
                                                </div>
                                            </div>

                                        </div>
                                    </div>

                                </div>
                                <!-- end tab item -->
                                <!-- start tab item -->
                                <div id="concept" class="tab-pane fade">
                                    <div class="container">
                                        <div class="tab-content">
                                            <div id="monthly-tab" class="tab-pane fade in active show">
                                                <div class="row row-cols-1 row-cols-md-4 align-items-center">
                                                    <div class="col pricing-table-style-02 text-center px-md-0 sm-margin-30px-bottom xs-margin-15px-bottom   animate__fadeInRight" data- -delay="0.4s" style="visibility: visible; animation-delay: 0.4s; animation-name: fadeInRight;">
                                                        <!-- start pricing table -->
                                                        <div class="pricing-table bg-white border-all border-color-medium-gray border-radius-6px">
                                                            <!-- start pricing header -->
                                                            <div class="pricing-header bg-light-gray padding-20px-tb">
                                                                <div class="alt-font font-weight-500 text-small text-extra-dark-gray text-uppercase letter-spacing-minus-1-half">Mensuel</div>
                                                            </div>
                                                            <!-- end pricing header -->
                                                            <!-- start pricing body -->
                                                            <div class="pricing-body padding-40px-tb">
                                                                <!-- <i class="line-icon-Line-Chart2   icon-medium text-fast-blue margin-20px-bottom"></i> -->



                                                                <h4 class="font-weight-500 text-extra-dark-gray letter-spacing-minus-2px margin-15px-bottom">$
                                                                    <?php echo $price_streamurl_monthly; ?>
                                                                </h4>

                                                                <p class="margin-5px-bottom">1 Mois</p>

                                                                <!-- <ul class="list-style-03">
                                                            <li class="border-color-medium-gray"><span class="text-extra-dark-gray font-weight-500"> </span> Keyword Research</li>
                                                            <li class="border-color-medium-gray"><span class="text-extra-dark-gray font-weight-500"> </span> Meta Details Optimization </li>
                                                            <li class="border-color-medium-gray"><span class="text-extra-dark-gray font-weight-500"> </span> Heading Tag Optimization</li>
                                                            <li class="border-color-medium-gray"><span class="text-extra-dark-gray font-weight-500"> </span> Site Performance Improvement</li>
                                                            <li class="border-color-medium-gray"><span class="text-extra-dark-gray font-weight-500">  </span> Internal Linking </li>
                                                            <li class="border-color-medium-gray"><span class="text-extra-dark-gray font-weight-500"> </span> Content Optimization </li>
                                                            <li class="border-color-medium-gray"><span class="text-extra-dark-gray font-weight-500"> </span> Plagiarism check </li>
                                                            <li class="border-color-medium-gray"><span class="text-extra-dark-gray font-weight-500"> </span>Analytics Integration</li>
                                                            <li class="border-color-medium-gray"><span class="text-extra-dark-gray font-weight-500"> </span>URL Optimization</li>               
                                                            <li><span class="text-extra-dark-gray font-weight-500"></span> Backlink Building</li>
                                                        </ul> -->
                                                            </div>
                                                            <!-- end pricing body -->
                                                            <!-- start pricing footer -->
                                                            <div class="pricing-footer margin-55px-bottom">
                                                                <a class="btn btn-medium btn-transparent-dark-gray btn-round-edge" href="https://portal.casthost.net/cart.php?a=add&pid=284&billingcycle=monthly">Inscrivez-vous maintenant</a>
                                                            </div>
                                                            <!-- end pricing footer -->
                                                        </div>
                                                        <!-- end pricing table -->
                                                    </div>
                                                    <div class="col pricing-table-style-02 text-center px-md-0 sm-margin-30px-bottom xs-margin-15px-bottom   animate__fadeInRight" data- -delay="0.4s" style="visibility: visible; animation-delay: 0.4s; animation-name: fadeInRight;">
                                                        <!-- start pricing table -->
                                                        <div class="pricing-table bg-white border-all border-color-medium-gray border-radius-6px">
                                                            <!-- start pricing header -->
                                                            <div class="pricing-header bg-light-gray padding-20px-tb">
                                                                <div class="alt-font font-weight-500 text-small text-extra-dark-gray text-uppercase letter-spacing-minus-1-half">Trimestriel</div>
                                                            </div>
                                                            <!-- end pricing header -->
                                                            <!-- start pricing body -->
                                                            <div class="pricing-body padding-40px-tb">
                                                                <h4 class="font-weight-500 text-extra-dark-gray letter-spacing-minus-2px margin-15px-bottom">$
                                                                    <?php echo $price_streamurl_quarterly; ?>
                                                                </h4>

                                                                <p class="margin-5px-bottom">3 Mois</p>

                                                                <!-- <ul class="list-style-03">
                                                        <li class="border-color-medium-gray"><span class="text-extra-dark-gray font-weight-500"> </span> Keyword Research</li>
                                                            <li class="border-color-medium-gray"><span class="text-extra-dark-gray font-weight-500"> </span> Meta Details Optimization </li>
                                                            <li class="border-color-medium-gray"><span class="text-extra-dark-gray font-weight-500"> </span> Heading Tag Optimization</li>
                                                            <li class="border-color-medium-gray"><span class="text-extra-dark-gray font-weight-500"> </span> Site Performance Improvement</li>
                                                            <li class="border-color-medium-gray"><span class="text-extra-dark-gray font-weight-500">  </span> Internal Linking </li>
                                                            <li class="border-color-medium-gray"><span class="text-extra-dark-gray font-weight-500"> </span> Content Optimization </li>
                                                            <li class="border-color-medium-gray"><span class="text-extra-dark-gray font-weight-500"> </span> Plagiarism check </li>
                                                            <li class="border-color-medium-gray"><span class="text-extra-dark-gray font-weight-500"> </span>Analytics Integration</li>
                                                            <li class="border-color-medium-gray"><span class="text-extra-dark-gray font-weight-500"> </span>URL Optimization</li>               
                                                            <li><span class="text-extra-dark-gray font-weight-500"></span> Backlink Building</li>
                                                        </ul> -->
                                                            </div>
                                                            <!-- end pricing body -->
                                                            <!-- start pricing footer -->
                                                            <div class="pricing-footer margin-55px-bottom">
                                                                <a class="btn btn-medium btn-transparent-dark-gray btn-round-edge" href="https://portal.casthost.net/cart.php?a=add&pid=284&billingcycle=quarterly">Inscrivez-vous maintenant</a>
                                                            </div>
                                                            <!-- end pricing footer -->
                                                        </div>
                                                        <!-- end pricing table -->
                                                    </div>
                                                    <div class="col pricing-table-style-02 text-center px-md-0 sm-margin-30px-bottom xs-margin-15px-bottom   animate__fadeIn z-index-1" style="visibility: visible; animation-name: fadeIn;">
                                                        <!-- start pricing table -->
                                                        <div class="pricing-table pricing-popular bg-white box-shadow-large border-radius-6px">
                                                            <!-- start pricing header -->
                                                            <div class="pricing-header bg-extra-dark-gray padding-20px-tb">
                                                                <div class="alt-font font-weight-500 text-small text-white text-uppercase letter-spacing-minus-1-half">Semi-annuel</div>
                                                            </div>
                                                            <!-- end pricing header -->
                                                            <!-- start pricing body -->
                                                            <div class="pricing-body padding-60px-tb">
                                                                <h4 class="font-weight-500 text-extra-dark-gray letter-spacing-minus-2px margin-15px-bottom">$
                                                                    <?php echo $price_streamurl_semiannually; ?>
                                                                </h4>

                                                                <p class="margin-5px-bottom">6 Mois</p>

                                                                <!-- <ul class="list-style-03">
                                                        <li class="border-color-medium-gray"><span class="text-extra-dark-gray font-weight-500"> </span> Keyword Research</li>
                                                            <li class="border-color-medium-gray"><span class="text-extra-dark-gray font-weight-500"> </span> Meta Details Optimization </li>
                                                            <li class="border-color-medium-gray"><span class="text-extra-dark-gray font-weight-500"> </span> Heading Tag Optimization</li>
                                                            <li class="border-color-medium-gray"><span class="text-extra-dark-gray font-weight-500"> </span> Site Performance Improvement</li>
                                                            <li class="border-color-medium-gray"><span class="text-extra-dark-gray font-weight-500">  </span> Internal Linking </li>
                                                            <li class="border-color-medium-gray"><span class="text-extra-dark-gray font-weight-500"> </span> Content Optimization </li>
                                                            <li class="border-color-medium-gray"><span class="text-extra-dark-gray font-weight-500"> </span> Plagiarism check </li>
                                                            <li class="border-color-medium-gray"><span class="text-extra-dark-gray font-weight-500"> </span>Analytics Integration</li>
                                                            <li class="border-color-medium-gray"><span class="text-extra-dark-gray font-weight-500"> </span>URL Optimization</li>               
                                                            <li><span class="text-extra-dark-gray font-weight-500"></span> Backlink Building</li>
                                                        </ul> -->
                                                            </div>
                                                            <!-- end pricing body -->
                                                            <!-- start pricing footer -->
                                                            <div class="pricing-footer margin-5px-top margin-55px-bottom">
                                                                <a class="btn btn-medium btn-dark-gray btn-round-edge" href="https://portal.casthost.net/cart.php?a=add&pid=284&billingcycle=semiannually">Inscrivez-vous maintenant</a>
                                                            </div>
                                                            <!-- end pricing footer -->
                                                        </div>
                                                        <!-- end pricing table -->
                                                    </div>
                                                    <div class="col pricing-table-style-02 text-center px-md-0   animate__fadeInLeft" data- -delay="0.4s" style="visibility: visible; animation-delay: 0.4s; animation-name: fadeInLeft;">
                                                        <!-- start pricing table -->
                                                        <div class="pricing-table bg-white border-all border-color-medium-gray border-radius-6px">
                                                            <!-- start pricing header -->
                                                            <div class="pricing-header bg-light-gray padding-20px-tb">
                                                                <div class="alt-font font-weight-500 text-small text-extra-dark-gray text-uppercase letter-spacing-minus-1-half">Annuel</div>
                                                            </div>
                                                            <!-- end pricing header -->
                                                            <!-- start pricing body -->
                                                            <div class="pricing-body padding-40px-tb">
                                                                <h4 class="font-weight-500 text-extra-dark-gray letter-spacing-minus-2px margin-15px-bottom">$
                                                                    <?php echo $price_streamurl_annually; ?>
                                                                </h4>

                                                                <p class="margin-5px-bottom">1 An</p>

                                                                <!-- <ul class="list-style-03">
                                                        <li class="border-color-medium-gray"><span class="text-extra-dark-gray font-weight-500"> </span> Keyword Research</li>
                                                            <li class="border-color-medium-gray"><span class="text-extra-dark-gray font-weight-500"> </span> Meta Details Optimization </li>
                                                            <li class="border-color-medium-gray"><span class="text-extra-dark-gray font-weight-500"> </span> Heading Tag Optimization</li>
                                                            <li class="border-color-medium-gray"><span class="text-extra-dark-gray font-weight-500"> </span> Site Performance Improvement</li>
                                                            <li class="border-color-medium-gray"><span class="text-extra-dark-gray font-weight-500">  </span> Internal Linking </li>
                                                            <li class="border-color-medium-gray"><span class="text-extra-dark-gray font-weight-500"> </span> Content Optimization </li>
                                                            <li class="border-color-medium-gray"><span class="text-extra-dark-gray font-weight-500"> </span> Plagiarism check </li>
                                                            <li class="border-color-medium-gray"><span class="text-extra-dark-gray font-weight-500"> </span>Analytics Integration</li>
                                                            <li class="border-color-medium-gray"><span class="text-extra-dark-gray font-weight-500"> </span>URL Optimization</li>               
                                                            <li><span class="text-extra-dark-gray font-weight-500"></span> Backlink Building</li>
                                                        </ul> -->
                                                            </div>
                                                            <!-- end pricing body -->
                                                            <!-- start pricing footer -->
                                                            <div class="pricing-footer margin-55px-bottom">
                                                                <a class="btn btn-medium btn-transparent-dark-gray btn-round-edge" href="https://portal.casthost.net/cart.php?a=add&pid=284&billingcycle=annually">Inscrivez-vous maintenant</a>
                                                            </div>
                                                            <!-- end pricing footer -->
                                                        </div>
                                                        <!-- end pricing table -->
                                                    </div>
                                                </div>
                                            </div>

                                        </div>
                                    </div>

                                </div>
                                <!-- end tab item -->
                            </div>
                        </div>
                    </div>
                </div>
            </section>
            <!-- end section -->


            <!-- start modal pop-up -->
            <div id="provider" class="  zoom-anim-dialog col-lg-6 col-sm-12 mx-auto bg-white text-center white-popup-block padding-4-half-rem-all border-radius-6px sm-padding-2-half-rem-lr mfp-hide">

                <div class="dashboard_selection">

                    <span class="text-extra-dark-gray text-uppercase alt-font text-extra-large font-weight-600 margin-15px-bottom d-block">Veuillez sélectionner le logiciel pour votre compte de streaming</span>
                    <p>Sélectionnez l'un des logiciels</p>
                    <div class="row row-cols-2 row-cols-lg-2 row-cols-md-2 justify-content-center margin-2-rem-bottom">
                        <!-- start feature box item -->
                        <div class="col col-sm-8 md-margin-30px-bottom xs-margin-15px-bottom " style="visibility: visible; animation-name: fadeIn;">

                            <div class=" feature-box feature-box-show-hover box-shadow-large-hover border-radius-6px feature-box-bg-white-hover border-all border-color-medium-gray overflow-hidden last-paragraph-no-margin">
                                <div class="feature-box-move-bottom-top padding-3-rem-all">
                                    <span class="text-fast-blue margin-25px-bottom">
                                        <img src="./images/shoutcast (1).png" alt="CastHost shoutcast hosting services" style="width: 80%;"></span>
                                    <div class="feature-box-content last-paragraph-no-margin pt-3">
                                        <label for="">Sélectionner l'emplacement</label>
                                        <select name="dashboard_country" onchange="updateURL('shout', this.value)" class="form-control form-control-lg" id="shout_dropdown">
                                            <option value="usa" selected>USA</option>
                                            <option value="canada">Canada</option>
                                        </select>
                                    </div>
                                    <div class="move-bottom-top margin-15px-top">
                                        <a id="shoutcastlink" href="#" class="btn btn-link thin btn-large text-fast-blue">Select Shoutcast</a>
                                    </div>
                                </div>
                            </div>

                        </div>
                        <!-- end feature box item -->
                        <!-- start feature box item -->
                        <div class="col col-sm-8 md-margin-30px-bottom xs-margin-15px-bottom " style="visibility: visible; animation-name: fadeIn;">

                            <div class="feature-box feature-box-show-hover box-shadow-large-hover border-radius-6px feature-box-bg-white-hover border-all border-color-medium-gray overflow-hidden last-paragraph-no-margin">
                                <div class="feature-box-move-bottom-top padding-3-rem-all">
                                    <span class="text-fast-blue margin-25px-bottom">
                                        <img src="./images/icecast.png" alt="icecast server hosting" style="width: 80%;"></span>
                                    <div class="feature-box-content last-paragraph-no-margin pt-3">
                                        <label for="">Sélectionner l'emplacement</label>
                                        <select onchange="updateURL('ice', this.value)" name="dashboard_country" class="form-control form-control-lg" id="ice_dropdown">

                                            <option value="usa" selected>USA</option>
                                            <option value="canada">Canada</option>
                                        </select>
                                    </div>
                                    <div class="move-bottom-top margin-15px-top">
                                        <a id="icecastlink" href="#" class="btn btn-link thin btn-large text-fast-blue">Select Icecast</a>
                                    </div>
                                </div>
                            </div>

                        </div>
                        <!-- end feature box item -->


                    </div>
                    <a class="btn btn-fancy btn-small btn-transparent-light-gray popup-modal-dismiss" href="#">Fermer</a>
                    <!-- <a class="btn btn-large btn-fast-blue" href="#">Next <i class="ml-2 fas fa-arrow-right"></i></a> -->

                </div>


                <!-- <a class="btn btn-large btn-fast-blue" href="#">Next <i class="ml-2 fas fa-arrow-right"></i></a> -->
            </div>
            <!-- end modal pop-up -->



            <!-- start section -->
            <section class="parallax one-half-screen md-h-450px sm-h-350px" data-parallax-background-ratio="0.5" style="background: url('./images/webp/banner-section.webp')">
            </section>
            <!-- end section -->

            <!--start section-->
            <section class="big-section bg-light-gray   animate__fadeIn overflow-visible" style="visibility: visible; animation-name: fadeIn;">
                <div class="container">
                    <div class="overlap-section">
                        <div class="z-index-6 bg-white box-shadow-small border-radius-5px padding-60px-tb md-padding-40px-all xs-padding-20px-lr">
                            <div class="row no-gutters align-items-center">
                                <div class="col-12 col-lg-4 offset-lg-1 col-md-6 text-center text-md-left sm-margin-20px-bottom">
                                    <h6 class="alt-font font-weight-500 text-extra-dark-gray w-85 mb-0 lg-w-100">L'hébergement de flux radio facilité avec CastHost! </h6>
                                </div>
                                <div class="col-12 col-xl-3 offset-xl-3 col-lg-4 offset-lg-2 col-md-6 text-center text-md-right">
                                    <a href="#provider" data-link1="https://portal.casthost.net/cart.php?a=add&pid=76&billingcycle=monthly" data-link2="https://portal.casthost.net/cart.php?a=add&pid=75&billingcycle=monthly" class="buynow btn btn-medium btn-round-edge btn-gradient-fast-blue-purple popup-with-form">Commencez votre essai gratuit</a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row justify-content-center   animate__fadeIn" style="visibility: visible; animation-name: fadeIn;">
                        <div class="col-12 col-xl-5 col-lg-6 col-sm-7 text-center margin-5-rem-top  margin-5-rem-bottom md-margin-3-rem-bottom">
                            <span class="alt-font font-weight-500 text-fast-blue text-extra-medium d-block margin-20px-bottom sm-margin-10px-bottom">Nos Partenaires</span>
                            <h5 class="alt-font font-weight-600 text-extra-dark-gray d-inline-block letter-spacing-minus-1-half">Nous avons des partenaires pour répondre à vos besoins.</h5>
                        </div>
                    </div>

                    <div class="row row-cols-1 row-cols-lg-5 row-cols-md-3 row-cols-sm-2 justify-content-center client-logo-style-04">
                        <!-- start client item -->
                        <div class="col text-center sm-no-margin   animate__fadeInUp" data- -delay="0.2s" style="visibility: visible; animation-delay: 0.2s; animation-name: fadeInUp;">
                            <div class="client-box padding-25px-all text-center">
                                <a href="#"><img alt="shoutcast streaming hosting" src="images/shoutcast.png" data-no-retina=""></a>
                                <span class="client-overlay bg-white box-shadow-small border-radius-4px"></span>
                            </div>
                        </div>
                        <!-- end client item -->
                        <!-- start client item -->
                        <div class="col text-center sm-no-margin   animate__fadeInUp" data- -delay="0.3s" style="visibility: visible; animation-delay: 0.3s; animation-name: fadeInUp;">
                            <div class="client-box padding-25px-all text-center">
                                <a href="#"><img alt="icecast server hosting" src="images/icecast.png" data-no-retina=""></a>
                                <span class="client-overlay bg-white box-shadow-small border-radius-4px"></span>
                            </div>
                        </div>
                        <!-- end client item -->
                        <!-- start client item -->
                        <div class="col text-center sm-no-margin   animate__fadeInUp" data- -delay="0.4s" style="visibility: visible; animation-delay: 0.4s; animation-name: fadeInUp;">
                            <div class="client-box padding-25px-all text-center">
                                <a href="#"><img alt="shoutcast icecast" src="images/centova.png" data-no-retina=""></a>
                                <span class="client-overlay bg-white box-shadow-small border-radius-4px"></span>
                            </div>
                        </div>
                        <!-- end client item -->
                    </div>
                </div>
            </section>
            <!--end section-->


            <?php include('form.php'); ?>

        </div>
    <?php } else { ?>
        <div class="main-content" style="margin-bottom: 460.938px;">
            <!-- start page title -->
            <section class="parallax bg-extra-dark-gray" data-parallax-background-ratio="0.5" style="background-image:url('./images/webp/banner-section.webp');">
                <div class="opacity-extra-medium bg-extra-dark-gray"></div>
                <div class="container">
                    <div class="row align-items-stretch justify-content-center small-screen">
                        <div class="col-12 col-xl-6 col-lg-7 col-md-8 page-title-extra-small text-center d-flex justify-content-center flex-column">
                            <h1 class="alt-font text-white opacity-6 margin-20px-bottom">Pricing</h1>
                            <h2 class="text-white alt-font font-weight-500 letter-spacing-minus-1px line-height-50 sm-line-height-45 xs-line-height-30 no-margin-bottom">Pricing Packages</h2>
                        </div>
                        <div class="down-section text-center"><a href="#down-section" class="section-link"><i class="ti-arrow-down icon-extra-small text-white bg-transparent-black padding-15px-all xs-padding-10px-all border-radius-100"></i></a></div>
                    </div>
                </div>
            </section>
            <!-- end page title -->
            <!-- start section -->
            <section class="bg-white" style="padding:1rem 0px">
                <div class="container">
                    <div class="row justify-content-center" id="down-section">
                        <div class="tab-syle-02">
                            <div class="col-12 tab-style-02">
                                <!-- start tab navigation -->
                                <ul class="nav nav-tabs justify-content-center text-center alt-font sm-margin-3-rem-bottom">
                                    <li class="nav-item"><a data-toggle="tab" href="#research" class="nav-link active"><i class="feather icon-feather-radio icon-small "></i>Stream Packages</a></li>
                                    <li class="nav-item"><a class="nav-link" data-toggle="tab" href="#strategy"><i class="feather icon-feather-server icon-small "></i>cPanel Hosting</a></li>
                                    <!-- <li class="nav-item"><a class="nav-link" data-toggle="tab" href="#management"><i class="feather icon-feather-bar-chart-2 icon-small"></i>SEO Services</a></li>-->
                                    <li class="nav-item"><a class="nav-link" data-toggle="tab" href="#concept"><i class="feather icon-feather-activity icon-small"></i>Secure Stream URL</a></li>
                                </ul>
                                <!-- end tab navigation -->
                            </div>

                        </div>

                    </div>

                </div>
            </section>
            <section class="big-section bg-light-gray   animate__fadeIn" style="visibility: visible; animation-name: fadeIn; padding: 3rem 0;">
                <div class="container">
                    <div class="row">
                        <div class="col-12 tab-style-02">

                            <div class="tab-content">
                                <!-- start tab item -->
                                <div id="research" class="tab-pane fade in active show">

                                    <div class="container">
                                        <div class="row justify-content-center">
                                            <div class="col-12 col-xl-10 col-lg-11 tab-style-04">
                                                <ul class="nav nav-tabs text-uppercase justify-content-center text-center alt-font margin-3-half-rem-bottom sm-margin-20px-bottom   animate__fadeIn" style="visibility: visible; animation-name: fadeIn;">
                                                    <li class="nav-item bg-white border-color-extra-light-gray"><a class="nav-link active" data-toggle="tab" href="#monthly-tab">Monthly</a><span class="tab-bg-active bg-fast-blue"></span></li>
                                                    <li class="nav-item bg-white border-color-extra-light-gray"><a class="nav-link" data-toggle="tab" href="#quarterly-tab">Quarterly</a><span class="tab-bg-active bg-fast-blue"></span></li>
                                                    <li class="nav-item bg-white border-color-extra-light-gray"><a class="nav-link" data-toggle="tab" href="#semiannually-tab">Semi Annually</a><span class="tab-bg-active bg-fast-blue"></span></li>
                                                    <li class="nav-item bg-white border-color-extra-light-gray"><a class="nav-link" data-toggle="tab" href="#yearly-tab">Annually</a><span class="tab-bg-active bg-fast-blue"></span></li>
                                                </ul>

                                            </div>
                                        </div>
                                    </div>

                                    <div class="tab-content">
                                        <div id="monthly-tab" class="tab-pane fade in active show">
                                            <div class="row row-cols-1 row-cols-md-4 align-items-center">
                                                <div class="col pricing-table-style-02 text-center px-md-0 sm-margin-30px-bottom xs-margin-15px-bottom wow animate__fadeInRight" data-wow-delay="0.4s" style="visibility: visible; animation-delay: 0.4s; animation-name: fadeInRight;">
                                                    <!-- start pricing table -->
                                                    <div class="pricing-table bg-white border-all border-color-medium-gray border-radius-6px">
                                                        <!-- start pricing header -->
                                                        <div class="pricing-header bg-light-gray padding-20px-tb">
                                                            <div class="alt-font font-weight-500 text-small text-extra-dark-gray text-uppercase letter-spacing-minus-1-half">Free plan</div>
                                                        </div>
                                                        <!-- end pricing header -->
                                                        <!-- start pricing body -->
                                                        <div class="pricing-body padding-40px-tb">
                                                            <i class="line-icon-Old-Cassette icon-medium text-fast-blue margin-20px-bottom"></i>

                                                            <h4 class="font-weight-500 text-extra-dark-gray letter-spacing-minus-2px mb-0">7 Days</h4>
                                                            <p class=" font-weight-500 margin-15px-bottom">Free Trial</p>
                                                            <ul class="list-style-03">
                                                                <li class="border-color-medium-gray p-0">
                                                                    <audio controls style="width: 110%;" controlsList="nodownload">
                                                                        <source class="audiobitrate" src="https://securestream.casthost.net:8223/128" type="audio/mpeg">
                                                                        Your browser does not support the audio element.
                                                                    </audio>
                                                                </li>
                                                                <li class="border-color-medium-gray"><span class="text-extra-dark-gray font-weight-500"> 128 </span> kbps Bitrate</li>
                                                                <li class="border-color-medium-gray"><span class="text-extra-dark-gray font-weight-500">512</span> MB</li>
                                                                <li class="border-color-medium-gray"><span class="text-extra-dark-gray font-weight-500">50</span> Max Listeners</li>
                                                                <li class="border-color-medium-gray"><span class="text-extra-dark-gray font-weight-500">Centova</span> Control Panel</li>
                                                                <li class="border-color-medium-gray"><span class="text-extra-dark-gray font-weight-500">Advanced</span> Detailed Reports</li>
                                                                <li class="border-color-medium-gray"><span class="text-extra-dark-gray font-weight-500">Unlimited</span> Bandwidth </li>

                                                            </ul>
                                                        </div>
                                                        <!-- end pricing body -->
                                                        <!-- start pricing footer -->
                                                        <div class="pricing-footer margin-55px-bottom">
                                                            <a class="buynow btn btn-medium btn-transparent-dark-gray btn-round-edge popup-with-zoom-anim" href="#provider" data-link1="https://portal.casthost.net/cart.php?a=add&pid=76&billingcycle=monthly" data-link2="https://portal.casthost.net/cart.php?a=add&pid=75&billingcycle=monthly" shoutcanada="https://portal.casthost.net/cart.php?a=add&pid=308&billingcycle=monthly" icecanada="https://portal.casthost.net/cart.php?a=add&pid=307&billingcycle=monthly">Register Now</a>

                                                        </div>
                                                        <!-- end pricing footer -->
                                                    </div>
                                                    <!-- end pricing table -->
                                                </div>
                                                <div class="col pricing-table-style-02 text-center px-md-0 sm-margin-30px-bottom xs-margin-15px-bottom wow animate__fadeInRight" data-wow-delay="0.4s" style="visibility: visible; animation-delay: 0.4s; animation-name: fadeInRight;">
                                                    <!-- start pricing table -->
                                                    <div class="pricing-table bg-white border-all border-color-medium-gray border-radius-6px">
                                                        <!-- start pricing header -->
                                                        <div class="pricing-header bg-light-gray padding-20px-tb">
                                                            <div class="alt-font font-weight-500 text-small text-extra-dark-gray text-uppercase letter-spacing-minus-1-half ptype">Starter plan</div>
                                                        </div>
                                                        <!-- end pricing header -->
                                                        <!-- start pricing body -->
                                                        <div class="pricing-body padding-40px-tb">
                                                            <i class="line-icon-Old-TV icon-medium text-fast-blue margin-20px-bottom"></i>
                                                            <h4 class="font-weight-500 text-extra-dark-gray letter-spacing-minus-2px margin-15px-bottom">$ <span class="price1"><?php echo $price_stream_starter_monthly; ?></span></h4>
                                                            <input class="hiddenval1" type="text" style="display: none;" value="<?php echo $price_stream_starter_monthly; ?>">
                                                            <ul class="list-style-03">
                                                                <li class="border-color-medium-gray p-0">
                                                                    <audio controls style="width: 110%;" controlsList="nodownload">

                                                                        <source class="audiobitrate" src="https://securestream.casthost.net:8223/64" type="audio/mpeg">
                                                                        Your browser does not support the audio element.
                                                                    </audio>
                                                                </li>
                                                                <li class="border-color-medium-gray">
                                                                    <div class="row">
                                                                        <div class="col-4 text-right minusicon" onclick="bitrateminus('1');">
                                                                            <i class="fas disable fa-minus-circle text-gray quantity-left-minus"></i>
                                                                        </div>
                                                                        <div class="col-4" style="padding: 0;">
                                                                            <span id="quantity1" class="text-extra-dark-gray font-weight-500 configbit">64</span> kbps
                                                                        </div>
                                                                        <div class="col-4 text-left plusicon" onclick="bitrateplus('1');">
                                                                            <i class="fas fa-plus-circle text-gray quantity-right-plus"></i>

                                                                        </div>
                                                                    </div>
                                                                </li>

                                                                <li class="border-color-medium-gray">
                                                                    <div class="dropdown">
                                                                        <button class="btn btn-block storagebtn1 dropdown-toggle text-center" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                                            <span class='storagevalue1  configdj'>512 MB</span>
                                                                            <i class="fa fa-chevron-down margin-20px-left"></i>
                                                                        </button>
                                                                        <div class="dropdown-menu dropdown-menu-center storagedd  text-center" aria-labelledby="dropdownMenuButton">
                                                                            <a class="dropdown-item" onclick="storageprice('1','512 MB','0');">512 MB</a>
                                                                            <a class="dropdown-item" onclick="storageprice('1','2 GB','1.00');">2 GB</a>
                                                                            <a class="dropdown-item" onclick="storageprice('1','5 GB','2.50');">5 GB</a>
                                                                            <a class="dropdown-item" onclick="storageprice('1','10 GB','4.75');">10 GB</a>
                                                                            <a class="dropdown-item" onclick="storageprice('1','25 GB','10.00');">25 GB</a>
                                                                            <a class="dropdown-item" onclick="storageprice('1','50 GB','17.25');">50 GB</a>

                                                                        </div>
                                                                    </div>
                                                                </li>
                                                                <li class="border-color-medium-gray"><span class="text-extra-dark-gray font-weight-500">75</span> Max Listeners</li>
                                                                <li class="border-color-medium-gray"><span class="text-extra-dark-gray font-weight-500">Free </span>Web Hosting</li>

                                                                <li class="border-color-medium-gray"><span class="text-extra-dark-gray font-weight-500">Advanced</span> Detailed Reports</li>
                                                                <li class="border-color-medium-gray"><span class="text-extra-dark-gray font-weight-500">Unlimited</span> Bandwidth </li>
                                                            </ul>
                                                        </div>
                                                        <!-- end pricing body -->
                                                        <!-- start pricing footer -->
                                                        <div class="pricing-footer margin-55px-bottom">
                                                            <a class="buynow btn btn-medium btn-transparent-dark-gray btn-round-edge popup-with-zoom-anim" href="#provider" data-link1="https://portal.casthost.net/cart.php?a=add&pid=240&billingcycle=monthly" data-link2="https://portal.casthost.net/cart.php?a=add&pid=241&billingcycle=monthly" shoutcanada="https://portal.casthost.net/cart.php?a=add&pid=312&billingcycle=monthly" icecanada="https://portal.casthost.net/cart.php?a=add&pid=311&billingcycle=monthly">Register Now</a>
                                                        </div>
                                                        <!-- end pricing footer -->
                                                    </div>
                                                    <!-- end pricing table -->
                                                </div>
                                                <div class="col pricing-table-style-02 text-center px-md-0 sm-margin-30px-bottom xs-margin-15px-bottom wow animate__fadeIn z-index-1" style="visibility: visible; animation-name: fadeIn;">
                                                    <!-- start pricing table -->
                                                    <div class="pricing-table pricing-popular bg-white box-shadow-large border-radius-6px">
                                                        <!-- start pricing header -->
                                                        <div class="pricing-header bg-extra-dark-gray padding-20px-tb">
                                                            <div class="alt-font font-weight-500 text-small text-white text-uppercase letter-spacing-minus-1-half ptype">Unlimited plan</div>
                                                        </div>
                                                        <!-- end pricing header -->
                                                        <!-- start pricing body -->
                                                        <div class="pricing-body padding-60px-tb">
                                                            <i class="line-icon-Communication-Tower icon-medium text-fast-blue margin-20px-bottom"></i>
                                                            <h4 class="font-weight-500 text-extra-dark-gray letter-spacing-minus-2px margin-15px-bottom">$ <span class="price2"><?php echo $price_stream_unlimited_monthly; ?></span></h4>
                                                            <input class="hiddenval2" type="text" style="display: none;" value="<?php echo $price_stream_unlimited_monthly; ?>">
                                                            <ul class="list-style-03">
                                                                <li class="border-color-medium-gray p-0">
                                                                    <audio controls style="width: 110%;" controlsList="nodownload">

                                                                        <source class="audiobitrate" src="https://securestream.casthost.net:8223/64" type="audio/mpeg">
                                                                        Your browser does not support the audio element.
                                                                    </audio>
                                                                </li>
                                                                <li class="border-color-medium-gray">
                                                                    <div class="row">
                                                                        <div class="col-4 text-right minusicon" onclick="bitrateminus('2');">
                                                                            <i class="fas disable fa-minus-circle text-gray quantity-left-minus"></i>

                                                                        </div>
                                                                        <div class="col-4" style="padding: 0;">
                                                                            <span id="quantity2" class="text-extra-dark-gray font-weight-500 configbit">64</span> kbps
                                                                        </div>
                                                                        <div class="col-4 text-left plusicon" onclick="bitrateplus('2');">
                                                                            <i class="fas fa-plus-circle text-gray quantity-right-plus"></i>

                                                                        </div>
                                                                    </div>
                                                                </li>

                                                                <li class="border-color-medium-gray">
                                                                    <div class="dropdown">
                                                                        <button class="btn btn-block storagebtn2 dropdown-toggle text-center" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                                            <span class='storagevalue2  configdj'>5 GB</span>
                                                                            <i class="fa fa-chevron-down margin-20px-left"></i>
                                                                        </button>
                                                                        <div class="dropdown-menu dropdown-menu-center storagedd  text-center" aria-labelledby="dropdownMenuButton">
                                                                            <a class="dropdown-item" onclick="storageprice('2','5 GB','0');">5 GB</a>
                                                                            <a class="dropdown-item" onclick="storageprice('2','10 GB','2.50');">10 GB</a>
                                                                            <a class="dropdown-item" onclick="storageprice('2','25 GB','8.25');">25 GB</a>
                                                                            <a class="dropdown-item" onclick="storageprice('2','50 GB','15.75');">50 GB</a>
                                                                            <a class="dropdown-item" onclick="storageprice('2','100 GB','28.50');">100 GB</a>
                                                                        </div>
                                                                    </div>
                                                                </li>
                                                                <li class="border-color-medium-gray"><span class="text-extra-dark-gray font-weight-500">Nombre </span>d'auditeurs maximum illimité </li>
                                                                <li class="border-color-medium-gray"><span class="text-extra-dark-gray font-weight-500">Free </span>Web Hosting</li>

                                                                <li class="border-color-medium-gray"><span class="text-extra-dark-gray font-weight-500">Advanced</span> Detailed Reports</li>
                                                                <li class="border-color-medium-gray"><span class="text-extra-dark-gray font-weight-500">Unlimited</span> Bandwidth </li>
                                                            </ul>
                                                        </div>
                                                        <!-- end pricing body -->
                                                        <!-- start pricing footer -->
                                                        <div class="pricing-footer margin-5px-top margin-55px-bottom">
                                                            <a class="buynow btn btn-medium btn-transparent-dark-gray btn-round-edge popup-with-zoom-anim" href="#provider" data-link1="https://portal.casthost.net/cart.php?a=add&pid=204&billingcycle=monthly" data-link2="https://portal.casthost.net/cart.php?a=add&pid=205&billingcycle=monthly" shoutcanada="https://portal.casthost.net/cart.php?a=add&pid=310&billingcycle=monthly" icecanada="https://portal.casthost.net/cart.php?a=add&pid=309&billingcycle=monthly">Register Now</a>
                                                        </div>
                                                        <!-- end pricing footer -->
                                                    </div>
                                                    <!-- end pricing table -->
                                                </div>
                                                <div class="col pricing-table-style-02 text-center px-md-0 wow animate__fadeInLeft" data-wow-delay="0.4s" style="visibility: visible; animation-delay: 0.4s; animation-name: fadeInLeft;">
                                                    <!-- start pricing table -->
                                                    <div class="pricing-table bg-white border-all border-color-medium-gray border-radius-6px">
                                                        <!-- start pricing header -->
                                                        <div class="pricing-header bg-light-gray padding-20px-tb">
                                                            <div class="alt-font font-weight-500 text-small text-extra-dark-gray text-uppercase letter-spacing-minus-1-half">Reseller plan</div>
                                                        </div>
                                                        <!-- end pricing header -->
                                                        <!-- start pricing body -->
                                                        <div class="pricing-body padding-40px-tb">
                                                            <i class="line-icon-Headset  icon-medium text-fast-blue margin-20px-bottom"></i>
                                                            <h4 class="font-weight-500 text-extra-dark-gray letter-spacing-minus-2px margin-15px-bottom">Contact Us</h4>
                                                            <ul class="list-style-03">
                                                                <li class="border-color-medium-gray p-0">
                                                                    <audio controls style="width: 110%;" controlsList="nodownload">

                                                                        <source class="audiobitrate" src="https://securestream.casthost.net:8223/64" type="audio/mpeg">
                                                                        Your browser does not support the audio element.
                                                                    </audio>
                                                                </li>
                                                                <li class="border-color-medium-gray"><span class="text-extra-dark-gray font-weight-500"> 64-320 </span> kbps Bitrate</li>
                                                                <li class="border-color-medium-gray"><span class="text-extra-dark-gray font-weight-500">Custom</span> Disk Space</li>
                                                                <li class="border-color-medium-gray"><span class="text-extra-dark-gray font-weight-500">Unlimited</span> Max Listeners</li>
                                                                <li class="border-color-medium-gray"><span class="text-extra-dark-gray font-weight-500">Free </span>Web Hosting</li>

                                                                <li class="border-color-medium-gray"><span class="text-extra-dark-gray font-weight-500">Advanced</span> Detailed Reports</li>
                                                                <li class="border-color-medium-gray"><span class="text-extra-dark-gray font-weight-500">Unlimited</span> Bandwidth </li>


                                                            </ul>
                                                        </div>
                                                        <!-- end pricing body -->
                                                        <!-- start pricing footer -->
                                                        <div class="pricing-footer margin-55px-bottom">
                                                            <a class="btn btn-medium btn-transparent-dark-gray btn-round-edge" href="https://portal.casthost.net/submitticket.php?step=2&deptid=2">Contact Us</a>
                                                        </div>
                                                        <!-- end pricing footer -->
                                                    </div>
                                                    <!-- end pricing table -->
                                                </div>
                                            </div>
                                        </div>
                                        <div id="quarterly-tab" class="tab-pane fade  ">
                                            <div class="row row-cols-1 row-cols-md-4 align-items-center">
                                                <div class="col pricing-table-style-02 text-center px-md-0 sm-margin-30px-bottom xs-margin-15px-bottom wow animate__fadeInRight" data-wow-delay="0.4s" style="visibility: visible; animation-delay: 0.4s; animation-name: fadeInRight;">
                                                    <!-- start pricing table -->
                                                    <div class="pricing-table bg-white border-all border-color-medium-gray border-radius-6px">
                                                        <!-- start pricing header -->
                                                        <div class="pricing-header bg-light-gray padding-20px-tb">
                                                            <div class="alt-font font-weight-500 text-small text-extra-dark-gray text-uppercase letter-spacing-minus-1-half">Free plan</div>

                                                        </div>
                                                        <!-- end pricing header -->
                                                        <!-- start pricing body -->
                                                        <div class="pricing-body padding-40px-tb">
                                                            <i class="line-icon-Old-Cassette icon-medium text-fast-blue margin-20px-bottom"></i>

                                                            <h4 class="font-weight-500 text-extra-dark-gray letter-spacing-minus-2px mb-0">7 Days</h4>
                                                            <p class=" font-weight-500 margin-15px-bottom">Free Trial</p>
                                                            <ul class="list-style-03">
                                                                <li class="border-color-medium-gray p-0">
                                                                    <audio controls style="width: 110%;" controlsList="nodownload">

                                                                        <source class="audiobitrate" src="https://securestream.casthost.net:8223/128" type="audio/mpeg">
                                                                        Your browser does not support the audio element.
                                                                    </audio>
                                                                </li>
                                                                <li class="border-color-medium-gray"><span class="text-extra-dark-gray font-weight-500"> 128 </span> kbps Bitrate</li>
                                                                <li class="border-color-medium-gray"><span class="text-extra-dark-gray font-weight-500">512</span> MB</li>
                                                                <li class="border-color-medium-gray"><span class="text-extra-dark-gray font-weight-500">50</span> Max Listeners</li>
                                                                <li class="border-color-medium-gray"><span class="text-extra-dark-gray font-weight-500">Centova</span> Control Panel</li>

                                                                <li class="border-color-medium-gray"><span class="text-extra-dark-gray font-weight-500">Advanced</span> Detailed Reports</li>
                                                                <li class="border-color-medium-gray"><span class="text-extra-dark-gray font-weight-500">Unlimited</span> Bandwidth </li>

                                                            </ul>
                                                        </div>
                                                        <!-- end pricing body -->
                                                        <!-- start pricing footer -->
                                                        <div class="pricing-footer margin-55px-bottom">
                                                            <a class="buynow btn btn-medium btn-transparent-dark-gray btn-round-edge popup-with-zoom-anim" href="#provider" data-link1="https://portal.casthost.net/cart.php?a=add&pid=76&billingcycle=quarterly" data-link2="https://portal.casthost.net/cart.php?a=add&pid=75&billingcycle=quarterly" shoutcanada="https://portal.casthost.net/cart.php?a=add&pid=308&billingcycle=quarterly" icecanada="https://portal.casthost.net/cart.php?a=add&pid=307&billingcycle=quarterly">Register Now</a>

                                                        </div>
                                                        <!-- end pricing footer -->
                                                    </div>
                                                    <!-- end pricing table -->
                                                </div>
                                                <div class="col pricing-table-style-02 text-center px-md-0 sm-margin-30px-bottom xs-margin-15px-bottom wow animate__fadeInRight" data-wow-delay="0.4s" style="visibility: visible; animation-delay: 0.4s; animation-name: fadeInRight;">
                                                    <!-- start pricing table -->
                                                    <div class="pricing-table bg-white border-all border-color-medium-gray border-radius-6px">
                                                        <!-- start pricing header -->
                                                        <div class="pricing-header bg-light-gray padding-20px-tb">
                                                            <div class="alt-font font-weight-500 text-small text-extra-dark-gray text-uppercase letter-spacing-minus-1-half ptype">Starter plan</div>
                                                        </div>
                                                        <!-- end pricing header -->
                                                        <!-- start pricing body -->
                                                        <div class="pricing-body padding-40px-tb">

                                                            <i class="line-icon-Old-Radio icon-medium text-fast-blue margin-20px-bottom"></i>
                                                            <h4 class="font-weight-500 text-extra-dark-gray letter-spacing-minus-2px margin-15px-bottom">$ <span class="price3"><?php echo $price_stream_starter_quarterly; ?></span></h4>
                                                            <input class="hiddenval3" type="text" style="display: none;" value="<?php echo $price_stream_starter_quarterly; ?>">
                                                            <ul class="list-style-03">
                                                                <li class="border-color-medium-gray p-0">
                                                                    <audio controls style="width: 110%;" controlsList="nodownload">

                                                                        <source class="audiobitrate" src="https://securestream.casthost.net:8223/64" type="audio/mpeg">
                                                                        Your browser does not support the audio element.
                                                                    </audio>
                                                                </li>
                                                                <li class="border-color-medium-gray">
                                                                    <div class="row">
                                                                        <div class="col-4 text-right minusicon" onclick="bitrateminus('3');">
                                                                            <i class="fas disable fa-minus-circle text-gray quantity-left-minus"></i>
                                                                        </div>
                                                                        <div class="col-4" style="padding: 0;">
                                                                            <span id="quantity3" class="text-extra-dark-gray font-weight-500 configbit">64</span> kbps
                                                                        </div>
                                                                        <div class="col-4 text-left plusicon" onclick="bitrateplus('3');">
                                                                            <i class="fas fa-plus-circle text-gray quantity-right-plus"></i>

                                                                        </div>
                                                                    </div>
                                                                </li>
                                                                <li class="border-color-medium-gray">
                                                                    <div class="dropdown">
                                                                        <button class="btn btn-block storagebtn3 dropdown-toggle text-center" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                                            <span class='storagevalue3 configdj'>512 MB</span>
                                                                            <i class="fa fa-chevron-down margin-20px-left"></i>
                                                                        </button>
                                                                        <div class="dropdown-menu dropdown-menu-center storagedd  text-center" aria-labelledby="dropdownMenuButton">
                                                                            <a class="dropdown-item" onclick="storageprice('3','512 MB','0');">512 MB</a>
                                                                            <a class="dropdown-item" onclick="storageprice('3','2 GB','3.00');">2 GB</a>
                                                                            <a class="dropdown-item" onclick="storageprice('3','5 GB','7.50');">5 GB</a>
                                                                            <a class="dropdown-item" onclick="storageprice('3','10 GB','14.25');">10 GB</a>
                                                                            <a class="dropdown-item" onclick="storageprice('3','25 GB','30.00');">25 GB</a>
                                                                            <a class="dropdown-item" onclick="storageprice('3','50 GB','51.75');">50 GB</a>

                                                                        </div>
                                                                    </div>
                                                                </li>
                                                                <li class="border-color-medium-gray"><span class="text-extra-dark-gray font-weight-500">75</span> Max Listeners</li>
                                                                <li class="border-color-medium-gray"><span class="text-extra-dark-gray font-weight-500">Free </span>Web Hosting</li>

                                                                <li class="border-color-medium-gray"><span class="text-extra-dark-gray font-weight-500">Advanced</span> Detailed Reports</li>
                                                                <li class="border-color-medium-gray"><span class="text-extra-dark-gray font-weight-500">Unlimited</span> Bandwidth </li>


                                                            </ul>
                                                        </div>
                                                        <!-- end pricing body -->
                                                        <!-- start pricing footer -->
                                                        <div class="pricing-footer margin-55px-bottom">
                                                            <a class="buynow btn btn-medium btn-transparent-dark-gray btn-round-edge popup-with-zoom-anim" href="#provider" data-link1="https://portal.casthost.net/cart.php?a=add&pid=240&billingcycle=quarterly" data-link2="https://portal.casthost.net/cart.php?a=add&pid=241&billingcycle=quarterly" shoutcanada="https://portal.casthost.net/cart.php?a=add&pid=312&billingcycle=quarterly" icecanada="https://portal.casthost.net/cart.php?a=add&pid=311&billingcycle=quarterly">Register Now</a>
                                                        </div>
                                                        <!-- end pricing footer -->
                                                    </div>
                                                    <!-- end pricing table -->
                                                </div>
                                                <div class="col pricing-table-style-02 text-center px-md-0 sm-margin-30px-bottom xs-margin-15px-bottom wow animate__fadeIn z-index-1" style="visibility: visible; animation-name: fadeIn;">
                                                    <!-- start pricing table -->
                                                    <div class="pricing-table pricing-popular bg-white box-shadow-large border-radius-6px">
                                                        <!-- start pricing header -->
                                                        <div class="pricing-header bg-extra-dark-gray padding-20px-tb">
                                                            <div class="alt-font font-weight-500 text-small text-white text-uppercase letter-spacing-minus-1-half ptype">Unlimited plan</div>
                                                        </div>
                                                        <!-- end pricing header -->
                                                        <!-- start pricing body -->
                                                        <div class="pricing-body padding-60px-tb">
                                                            <i class="line-icon-Communication-Tower icon-medium text-fast-blue margin-20px-bottom"></i>
                                                            <h4 class="font-weight-500 text-extra-dark-gray letter-spacing-minus-2px margin-15px-bottom">$ <span class="price4"><?php echo $price_stream_unlimited_quarterly; ?></span></h4>
                                                            <input class="hiddenval4" type="text" style="display: none;" value="<?php echo $price_stream_unlimited_quarterly; ?>">
                                                            <ul class="list-style-03">
                                                                <li class="border-color-medium-gray p-0">
                                                                    <audio controls style="width: 110%;" controlsList="nodownload">

                                                                        <source class="audiobitrate" src="https://securestream.casthost.net:8223/64" type="audio/mpeg">
                                                                        Your browser does not support the audio element.
                                                                    </audio>
                                                                </li>
                                                                <li class="border-color-medium-gray">
                                                                    <div class="row">
                                                                        <div class="col-4 text-right minusicon" onclick="bitrateminus('4');">
                                                                            <i class="fas disable fa-minus-circle text-gray quantity-left-minus"></i>

                                                                        </div>
                                                                        <div class="col-4" style="padding: 0;">
                                                                            <span id="quantity4" class="text-extra-dark-gray font-weight-500 configbit">64</span> kbps
                                                                        </div>
                                                                        <div class="col-4 text-left plusicon" onclick="bitrateplus('4');">
                                                                            <i class="fas fa-plus-circle text-gray quantity-right-plus"></i>

                                                                        </div>
                                                                    </div>
                                                                </li>

                                                                <li class="border-color-medium-gray">
                                                                    <div class="dropdown">
                                                                        <button class="btn btn-block storagebtn4 dropdown-toggle text-center" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                                            <span class='storagevalue4 configdj'>5 GB</span>
                                                                            <i class="fa fa-chevron-down margin-20px-left"></i>
                                                                        </button>
                                                                        <div class="dropdown-menu dropdown-menu-center storagedd  text-center" aria-labelledby="dropdownMenuButton">
                                                                            <a class="dropdown-item" onclick="storageprice('4','5 GB','0');">5 GB</a>
                                                                            <a class="dropdown-item" onclick="storageprice('4','10 GB','7.50');">10 GB</a>
                                                                            <a class="dropdown-item" onclick="storageprice('4','25 GB','24.75');">25 GB</a>
                                                                            <a class="dropdown-item" onclick="storageprice('4','50 GB','47.25');">50 GB</a>
                                                                            <a class="dropdown-item" onclick="storageprice('4','100 GB','85.50');">100 GB</a>
                                                                        </div>
                                                                    </div>
                                                                </li>
                                                                <li class="border-color-medium-gray"><span class="text-extra-dark-gray font-weight-500">Unlimited</span> Max Listeners </li>
                                                                <li class="border-color-medium-gray"><span class="text-extra-dark-gray font-weight-500">Free </span>Web Hosting</li>

                                                                <li class="border-color-medium-gray"><span class="text-extra-dark-gray font-weight-500">Advanced</span> Detailed Reports</li>
                                                                <li class="border-color-medium-gray"><span class="text-extra-dark-gray font-weight-500">Unlimited</span> Bandwidth </li>
                                                            </ul>
                                                        </div>
                                                        <!-- end pricing body -->
                                                        <!-- start pricing footer -->
                                                        <div class="pricing-footer margin-5px-top margin-55px-bottom">
                                                            <a class="buynow btn btn-medium btn-transparent-dark-gray btn-round-edge popup-with-zoom-anim" href="#provider" data-link1="https://portal.casthost.net/cart.php?a=add&pid=204&billingcycle=quarterly" data-link2="https://portal.casthost.net/cart.php?a=add&pid=205&billingcycle=quarterly" shoutcanada="https://portal.casthost.net/cart.php?a=add&pid=310&billingcycle=quarterly" icecanada="https://portal.casthost.net/cart.php?a=add&pid=309&billingcycle=quarterly">Register Now</a>
                                                        </div>
                                                        <!-- end pricing footer -->
                                                    </div>
                                                    <!-- end pricing table -->
                                                </div>
                                                <div class="col pricing-table-style-02 text-center px-md-0 wow animate__fadeInLeft" data-wow-delay="0.4s" style="visibility: visible; animation-delay: 0.4s; animation-name: fadeInLeft;">
                                                    <!-- start pricing table -->
                                                    <div class="pricing-table bg-white border-all border-color-medium-gray border-radius-6px">
                                                        <!-- start pricing header -->
                                                        <div class="pricing-header bg-light-gray padding-20px-tb">
                                                            <div class="alt-font font-weight-500 text-small text-extra-dark-gray text-uppercase letter-spacing-minus-1-half">Reseller plan</div>
                                                        </div>
                                                        <!-- end pricing header -->
                                                        <!-- start pricing body -->
                                                        <div class="pricing-body padding-40px-tb">
                                                            <i class="line-icon-Headset  icon-medium text-fast-blue margin-20px-bottom"></i>
                                                            <h4 class="font-weight-500 text-extra-dark-gray letter-spacing-minus-2px margin-15px-bottom">Contact Us</h4>
                                                            <ul class="list-style-03">
                                                                <li class="border-color-medium-gray p-0">
                                                                    <audio controls style="width: 110%;" controlsList="nodownload">

                                                                        <source class="audiobitrate" src="https://securestream.casthost.net:8223/64" type="audio/mpeg">
                                                                        Your browser does not support the audio element.
                                                                    </audio>
                                                                </li>
                                                                <li class="border-color-medium-gray"><span class="text-extra-dark-gray font-weight-500"> 64-320 </span> kbps Bitrate</li>
                                                                <li class="border-color-medium-gray"><span class="text-extra-dark-gray font-weight-500">Custom</span> Disk Space</li>
                                                                <li class="border-color-medium-gray"><span class="text-extra-dark-gray font-weight-500">Unlimited</span> Max Listeners</li>
                                                                <li class="border-color-medium-gray"><span class="text-extra-dark-gray font-weight-500">Free </span>Web Hosting</li>

                                                                <li class="border-color-medium-gray"><span class="text-extra-dark-gray font-weight-500">Advanced</span> Detailed Reports</li>
                                                                <li class="border-color-medium-gray"><span class="text-extra-dark-gray font-weight-500">Unlimited</span> Bandwidth </li>


                                                            </ul>
                                                        </div>
                                                        <!-- end pricing body -->
                                                        <!-- start pricing footer -->
                                                        <div class="pricing-footer margin-55px-bottom">
                                                            <a class="btn btn-medium btn-transparent-dark-gray btn-round-edge" href="https://portal.casthost.net/submitticket.php?step=2&deptid=2">Contact Us</a>
                                                        </div>
                                                        <!-- end pricing footer -->
                                                    </div>
                                                    <!-- end pricing table -->
                                                </div>
                                            </div>
                                        </div>
                                        <div id="semiannually-tab" class="tab-pane fade">
                                            <div class="row row-cols-1 row-cols-md-4 align-items-center">
                                                <div class="col pricing-table-style-02 text-center px-md-0 sm-margin-30px-bottom xs-margin-15px-bottom wow animate__fadeInRight" data-wow-delay="0.4s" style="visibility: visible; animation-delay: 0.4s; animation-name: fadeInRight;">
                                                    <!-- start pricing table -->
                                                    <div class="pricing-table bg-white border-all border-color-medium-gray border-radius-6px">
                                                        <!-- start pricing header -->
                                                        <div class="pricing-header bg-light-gray padding-20px-tb">
                                                            <div class="alt-font font-weight-500 text-small text-extra-dark-gray text-uppercase letter-spacing-minus-1-half">Free plan</div>

                                                        </div>
                                                        <!-- end pricing header -->
                                                        <!-- start pricing body -->
                                                        <div class="pricing-body padding-40px-tb">
                                                            <i class="line-icon-Old-Cassette icon-medium text-fast-blue margin-20px-bottom"></i>

                                                            <h4 class="font-weight-500 text-extra-dark-gray letter-spacing-minus-2px mb-0">7 Days</h4>
                                                            <p class=" font-weight-500 margin-15px-bottom">Free Trial</p>
                                                            <ul class="list-style-03">
                                                                <li class="border-color-medium-gray p-0">
                                                                    <audio controls style="width: 110%;" controlsList="nodownload">

                                                                        <source class="audiobitrate" src="https://securestream.casthost.net:8223/128" type="audio/mpeg">
                                                                        Your browser does not support the audio element.
                                                                    </audio>
                                                                </li>
                                                                <li class="border-color-medium-gray"><span class="text-extra-dark-gray font-weight-500"> 128 </span> kbps Bitrate</li>
                                                                <li class="border-color-medium-gray"><span class="text-extra-dark-gray font-weight-500">512</span> MB</li>
                                                                <li class="border-color-medium-gray"><span class="text-extra-dark-gray font-weight-500">50</span> Max Listeners</li>
                                                                <li class="border-color-medium-gray"><span class="text-extra-dark-gray font-weight-500">Centova</span> Control Panel</li>

                                                                <li class="border-color-medium-gray"><span class="text-extra-dark-gray font-weight-500">Advanced</span> Detailed Reports</li>
                                                                <li class="border-color-medium-gray"><span class="text-extra-dark-gray font-weight-500">Unlimited</span> Bandwidth </li>

                                                            </ul>
                                                        </div>
                                                        <!-- end pricing body -->
                                                        <!-- start pricing footer -->
                                                        <div class="pricing-footer margin-55px-bottom">
                                                            <a class="buynow btn btn-medium btn-transparent-dark-gray btn-round-edge popup-with-zoom-anim" href="#provider" data-link1="https://portal.casthost.net/cart.php?a=add&pid=76&billingcycle=semiannually" data-link2="https://portal.casthost.net/cart.php?a=add&pid=75&billingcycle=semiannually" shoutcanada="https://portal.casthost.net/cart.php?a=add&pid=308&billingcycle=semiannually" icecanada="https://portal.casthost.net/cart.php?a=add&pid=307&billingcycle=semiannually">Register Now</a>

                                                        </div>
                                                        <!-- end pricing footer -->
                                                    </div>
                                                    <!-- end pricing table -->
                                                </div>
                                                <div class="col pricing-table-style-02 text-center px-md-0 sm-margin-30px-bottom xs-margin-15px-bottom wow animate__fadeInRight" data-wow-delay="0.4s" style="visibility: visible; animation-delay: 0.4s; animation-name: fadeInRight;">
                                                    <!-- start pricing table -->
                                                    <div class="pricing-table bg-white border-all border-color-medium-gray border-radius-6px">
                                                        <!-- start pricing header -->
                                                        <div class="pricing-header bg-light-gray padding-20px-tb">
                                                            <div class="alt-font font-weight-500 text-small text-extra-dark-gray text-uppercase letter-spacing-minus-1-half ptype">Starter plan</div>
                                                        </div>
                                                        <!-- end pricing header -->
                                                        <!-- start pricing body -->
                                                        <div class="pricing-body padding-40px-tb">

                                                            <i class="line-icon-Old-Radio icon-medium text-fast-blue margin-20px-bottom"></i>
                                                            <h4 class="font-weight-500 text-extra-dark-gray letter-spacing-minus-2px margin-15px-bottom">$ <span class="price5"><?php echo $price_stream_starter_semiannually; ?></span></h4>
                                                            <input class="hiddenval5" type="text" style="display: none;" value="<?php echo $price_stream_starter_semiannually; ?>">
                                                            <ul class="list-style-03">
                                                                <li class="border-color-medium-gray p-0">
                                                                    <audio controls style="width: 110%;" controlsList="nodownload">

                                                                        <source class="audiobitrate" src="https://securestream.casthost.net:8223/64" type="audio/mpeg">
                                                                        Your browser does not support the audio element.
                                                                    </audio>
                                                                </li>
                                                                <li class="border-color-medium-gray">
                                                                    <div class="row">
                                                                        <div class="col-4 text-right minusicon" onclick="bitrateminus('5');">
                                                                            <i class="fas disable fa-minus-circle text-gray quantity-left-minus"></i>
                                                                        </div>
                                                                        <div class="col-4" style="padding: 0;">
                                                                            <span id="quantity5" class="text-extra-dark-gray font-weight-500 configbit">64</span> kbps
                                                                        </div>
                                                                        <div class="col-4 text-left plusicon" onclick="bitrateplus('5');">
                                                                            <i class="fas fa-plus-circle text-gray quantity-right-plus"></i>

                                                                        </div>
                                                                    </div>
                                                                </li>
                                                                <li class="border-color-medium-gray">
                                                                    <div class="dropdown">
                                                                        <button class="btn btn-block storagebtn5 dropdown-toggle text-center" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                                            <span class='storagevalue5 configdj'>512 MB</span>
                                                                            <i class="fa fa-chevron-down margin-20px-left"></i>
                                                                        </button>
                                                                        <div class="dropdown-menu dropdown-menu-center storagedd  text-center" aria-labelledby="dropdownMenuButton">
                                                                            <a class="dropdown-item" onclick="storageprice('5','512 MB','0');">512 MB</a>
                                                                            <a class="dropdown-item" onclick="storageprice('5','2 GB','6.00');">2 GB</a>
                                                                            <a class="dropdown-item" onclick="storageprice('5','5 GB','15.00');">5 GB</a>
                                                                            <a class="dropdown-item" onclick="storageprice('5','10 GB','28.50');">10 GB</a>
                                                                            <a class="dropdown-item" onclick="storageprice('5','25 GB','60.00');">25 GB</a>
                                                                            <a class="dropdown-item" onclick="storageprice('5','50 GB','102.50');">50 GB</a>

                                                                        </div>
                                                                    </div>
                                                                </li>
                                                                <li class="border-color-medium-gray"><span class="text-extra-dark-gray font-weight-500">75</span> Max Listeners</li>
                                                                <li class="border-color-medium-gray"><span class="text-extra-dark-gray font-weight-500">Free </span>Web Hosting</li>

                                                                <li class="border-color-medium-gray"><span class="text-extra-dark-gray font-weight-500">Advanced</span> Detailed Reports</li>
                                                                <li class="border-color-medium-gray"><span class="text-extra-dark-gray font-weight-500">Unlimited</span> Bandwidth </li>


                                                            </ul>
                                                        </div>
                                                        <!-- end pricing body -->
                                                        <!-- start pricing footer -->
                                                        <div class="pricing-footer margin-55px-bottom">
                                                            <a class="buynow btn btn-medium btn-transparent-dark-gray btn-round-edge popup-with-zoom-anim" href="#provider" data-link1="https://portal.casthost.net/cart.php?a=add&pid=240&billingcycle=semiannually" data-link2="https://portal.casthost.net/cart.php?a=add&pid=241&billingcycle=semiannually" shoutcanada="https://portal.casthost.net/cart.php?a=add&pid=312&billingcycle=semiannually" icecanada="https://portal.casthost.net/cart.php?a=add&pid=311&billingcycle=semiannually">Register Now</a>
                                                        </div>
                                                        <!-- end pricing footer -->
                                                    </div>
                                                    <!-- end pricing table -->
                                                </div>
                                                <div class="col pricing-table-style-02 text-center px-md-0 sm-margin-30px-bottom xs-margin-15px-bottom wow animate__fadeIn z-index-1" style="visibility: visible; animation-name: fadeIn;">
                                                    <!-- start pricing table -->
                                                    <div class="pricing-table pricing-popular bg-white box-shadow-large border-radius-6px">
                                                        <!-- start pricing header -->
                                                        <div class="pricing-header bg-extra-dark-gray padding-20px-tb">
                                                            <div class="alt-font font-weight-500 text-small text-white text-uppercase letter-spacing-minus-1-half ptype">Unlimited plan</div>
                                                        </div>
                                                        <!-- end pricing header -->
                                                        <!-- start pricing body -->
                                                        <div class="pricing-body padding-60px-tb">
                                                            <i class="line-icon-Communication-Tower icon-medium text-fast-blue margin-20px-bottom"></i>
                                                            <h4 class="font-weight-500 text-extra-dark-gray letter-spacing-minus-2px margin-15px-bottom">$ <span class="price6"><?php echo $price_stream_unlimited_semiannually; ?></span></h4>
                                                            <input class="hiddenval6" type="text" style="display: none;" value="<?php echo $price_stream_unlimited_semiannually; ?>">
                                                            <ul class="list-style-03">
                                                                <li class="border-color-medium-gray p-0">
                                                                    <audio controls style="width: 110%;" controlsList="nodownload">

                                                                        <source class="audiobitrate" src="https://securestream.casthost.net:8223/64" type="audio/mpeg">
                                                                        Your browser does not support the audio element.
                                                                    </audio>
                                                                </li>
                                                                <li class="border-color-medium-gray">
                                                                    <div class="row">
                                                                        <div class="col-4 text-right minusicon" onclick="bitrateminus('6');">
                                                                            <i class="fas disable fa-minus-circle text-gray quantity-left-minus"></i>

                                                                        </div>
                                                                        <div class="col-4" style="padding: 0;">
                                                                            <span id="quantity6" class="text-extra-dark-gray font-weight-500 configbit">64</span> kbps
                                                                        </div>
                                                                        <div class="col-4 text-left plusicon" onclick="bitrateplus('6');">
                                                                            <i class="fas fa-plus-circle text-gray quantity-right-plus"></i>

                                                                        </div>
                                                                    </div>
                                                                </li>

                                                                <li class="border-color-medium-gray">
                                                                    <div class="dropdown">
                                                                        <button class="btn btn-block storagebtn6 dropdown-toggle text-center" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                                            <span class='storagevalue6 configdj'>5 GB</span>
                                                                            <i class="fa fa-chevron-down margin-20px-left"></i>
                                                                        </button>
                                                                        <div class="dropdown-menu dropdown-menu-center storagedd  text-center" aria-labelledby="dropdownMenuButton">
                                                                            <a class="dropdown-item" onclick="storageprice('6','5 GB','0');">5 GB</a>
                                                                            <a class="dropdown-item" onclick="storageprice('6','10 GB','15.00');">10 GB</a>
                                                                            <a class="dropdown-item" onclick="storageprice('6','25 GB','49.50');">25 GB</a>
                                                                            <a class="dropdown-item" onclick="storageprice('6','50 GB','94.50');">50 GB</a>
                                                                            <a class="dropdown-item" onclick="storageprice('6','100 GB','171.00');">100 GB</a>
                                                                        </div>
                                                                    </div>
                                                                </li>
                                                                <li class="border-color-medium-gray"><span class="text-extra-dark-gray font-weight-500">Unlimited</span> Max Listeners </li>
                                                                <li class="border-color-medium-gray"><span class="text-extra-dark-gray font-weight-500">Free </span>Web Hosting</li>

                                                                <li class="border-color-medium-gray"><span class="text-extra-dark-gray font-weight-500">Advanced</span> Detailed Reports</li>
                                                                <li class="border-color-medium-gray"><span class="text-extra-dark-gray font-weight-500">Unlimited</span> Bandwidth </li>
                                                            </ul>
                                                        </div>
                                                        <!-- end pricing body -->
                                                        <!-- start pricing footer -->
                                                        <div class="pricing-footer margin-5px-top margin-55px-bottom">
                                                            <a class="buynow btn btn-medium btn-transparent-dark-gray btn-round-edge popup-with-zoom-anim" href="#provider" data-link1="https://portal.casthost.net/cart.php?a=add&pid=204&billingcycle=semiannually" data-link2="https://portal.casthost.net/cart.php?a=add&pid=205&billingcycle=semiannually" shoutcanada="https://portal.casthost.net/cart.php?a=add&pid=310&billingcycle=semiannually" icecanada="https://portal.casthost.net/cart.php?a=add&pid=309&billingcycle=semiannually">Register Now</a>
                                                        </div>
                                                        <!-- end pricing footer -->
                                                    </div>
                                                    <!-- end pricing table -->
                                                </div>
                                                <div class="col pricing-table-style-02 text-center px-md-0 wow animate__fadeInLeft" data-wow-delay="0.4s" style="visibility: visible; animation-delay: 0.4s; animation-name: fadeInLeft;">
                                                    <!-- start pricing table -->
                                                    <div class="pricing-table bg-white border-all border-color-medium-gray border-radius-6px">
                                                        <!-- start pricing header -->
                                                        <div class="pricing-header bg-light-gray padding-20px-tb">
                                                            <div class="alt-font font-weight-500 text-small text-extra-dark-gray text-uppercase letter-spacing-minus-1-half">Reseller plan</div>
                                                        </div>
                                                        <!-- end pricing header -->
                                                        <!-- start pricing body -->
                                                        <div class="pricing-body padding-40px-tb">
                                                            <i class="line-icon-Headset  icon-medium text-fast-blue margin-20px-bottom"></i>
                                                            <h4 class="font-weight-500 text-extra-dark-gray letter-spacing-minus-2px margin-15px-bottom">Contact Us</h4>
                                                            <ul class="list-style-03">
                                                                <li class="border-color-medium-gray p-0">
                                                                    <audio controls style="width: 110%;" controlsList="nodownload">

                                                                        <source class="audiobitrate" src="https://securestream.casthost.net:8223/64" type="audio/mpeg">
                                                                        Your browser does not support the audio element.
                                                                    </audio>
                                                                </li>
                                                                <li class="border-color-medium-gray"><span class="text-extra-dark-gray font-weight-500"> 64-320 </span> kbps Bitrate</li>
                                                                <li class="border-color-medium-gray"><span class="text-extra-dark-gray font-weight-500">Custom</span> Disk Space</li>
                                                                <li class="border-color-medium-gray"><span class="text-extra-dark-gray font-weight-500">Unlimited</span> Max Listeners</li>
                                                                <li class="border-color-medium-gray"><span class="text-extra-dark-gray font-weight-500">Free </span>Web Hosting</li>

                                                                <li class="border-color-medium-gray"><span class="text-extra-dark-gray font-weight-500">Advanced</span> Detailed Reports</li>
                                                                <li class="border-color-medium-gray"><span class="text-extra-dark-gray font-weight-500">Unlimited</span> Bandwidth </li>


                                                            </ul>
                                                        </div>
                                                        <!-- end pricing body -->
                                                        <!-- start pricing footer -->
                                                        <div class="pricing-footer margin-55px-bottom">
                                                            <a class="btn btn-medium btn-transparent-dark-gray btn-round-edge" href="https://portal.casthost.net/submitticket.php?step=2&deptid=2">Contact Us</a>
                                                        </div>
                                                        <!-- end pricing footer -->
                                                    </div>
                                                    <!-- end pricing table -->
                                                </div>
                                            </div>
                                        </div>
                                        <div id="yearly-tab" class="tab-pane fade">
                                            <div class="row row-cols-1 row-cols-md-4 align-items-center">
                                                <div class="col pricing-table-style-02 text-center px-md-0 sm-margin-30px-bottom xs-margin-15px-bottom wow animate__fadeInRight" data-wow-delay="0.4s" style="visibility: visible; animation-delay: 0.4s; animation-name: fadeInRight;">
                                                    <!-- start pricing table -->
                                                    <div class="pricing-table bg-white border-all border-color-medium-gray border-radius-6px">
                                                        <!-- start pricing header -->
                                                        <div class="pricing-header bg-light-gray padding-20px-tb">
                                                            <div class="alt-font font-weight-500 text-small text-extra-dark-gray text-uppercase letter-spacing-minus-1-half">Free plan</div>

                                                        </div>
                                                        <!-- end pricing header -->
                                                        <!-- start pricing body -->
                                                        <div class="pricing-body padding-40px-tb">
                                                            <i class="line-icon-Old-Cassette icon-medium text-fast-blue margin-20px-bottom"></i>

                                                            <h4 class="font-weight-500 text-extra-dark-gray letter-spacing-minus-2px mb-0">7 Days</h4>
                                                            <p class=" font-weight-500 margin-15px-bottom">Free Trial</p>
                                                            <ul class="list-style-03">
                                                                <li class="border-color-medium-gray p-0">
                                                                    <audio controls style="width: 110%;" controlsList="nodownload">

                                                                        <source class="audiobitrate" src="https://securestream.casthost.net:8223/128" type="audio/mpeg">
                                                                        Your browser does not support the audio element.
                                                                    </audio>
                                                                </li>
                                                                <li class="border-color-medium-gray"><span class="text-extra-dark-gray font-weight-500"> 128 </span> kbps Bitrate</li>
                                                                <li class="border-color-medium-gray"><span class="text-extra-dark-gray font-weight-500">512</span> MB</li>
                                                                <li class="border-color-medium-gray"><span class="text-extra-dark-gray font-weight-500">50</span> Max Listeners</li>
                                                                <li class="border-color-medium-gray"><span class="text-extra-dark-gray font-weight-500">Centova</span> Control Panel</li>

                                                                <li class="border-color-medium-gray"><span class="text-extra-dark-gray font-weight-500">Advanced</span> Detailed Reports</li>
                                                                <li class="border-color-medium-gray"><span class="text-extra-dark-gray font-weight-500">Unlimited</span> Bandwidth </li>

                                                            </ul>
                                                        </div>
                                                        <!-- end pricing body -->
                                                        <!-- start pricing footer -->
                                                        <div class="pricing-footer margin-55px-bottom">
                                                            <a class="buynow btn btn-medium btn-transparent-dark-gray btn-round-edge popup-with-zoom-anim" href="#provider" data-link1="https://portal.casthost.net/cart.php?a=add&pid=76&billingcycle=annually" data-link2="https://portal.casthost.net/cart.php?a=add&pid=75&billingcycle=annually" shoutcanada="https://portal.casthost.net/cart.php?a=add&pid=308&billingcycle=annually" icecanada="https://portal.casthost.net/cart.php?a=add&pid=307&billingcycle=annually">Register Now</a>
                                                        </div>
                                                        <!-- end pricing footer -->
                                                    </div>
                                                    <!-- end pricing table -->
                                                </div>
                                                <div class="col pricing-table-style-02 text-center px-md-0 sm-margin-30px-bottom xs-margin-15px-bottom wow animate__fadeInRight" data-wow-delay="0.4s" style="visibility: visible; animation-delay: 0.4s; animation-name: fadeInRight;">
                                                    <!-- start pricing table -->
                                                    <div class="pricing-table bg-white border-all border-color-medium-gray border-radius-6px">
                                                        <!-- start pricing header -->
                                                        <div class="pricing-header bg-light-gray padding-20px-tb">
                                                            <div class="alt-font font-weight-500 text-small text-extra-dark-gray text-uppercase letter-spacing-minus-1-half ptype">Starter plan</div>
                                                        </div>
                                                        <!-- end pricing header -->
                                                        <!-- start pricing body -->
                                                        <div class="pricing-body padding-40px-tb">
                                                            <i class="line-icon-Old-TV icon-medium text-fast-blue margin-20px-bottom"></i>
                                                            <h4 class="font-weight-500 text-extra-dark-gray letter-spacing-minus-2px margin-15px-bottom">$ <span class="price7"><?php echo $price_stream_starter_annually; ?></span></h4>
                                                            <input class="hiddenval7" type="text" style="display: none;" value="<?php echo $price_stream_starter_annually; ?>">
                                                            <ul class="list-style-03">
                                                                <li class="border-color-medium-gray p-0">
                                                                    <audio controls style="width: 110%;" controlsList="nodownload">

                                                                        <source class="audiobitrate" src="https://securestream.casthost.net:8223/64" type="audio/mpeg">
                                                                        Your browser does not support the audio element.
                                                                    </audio>
                                                                </li>
                                                                <li class="border-color-medium-gray">
                                                                    <div class="row">
                                                                        <div class="col-4 text-right minusicon" onclick="bitrateminus('7');">
                                                                            <i class="fas disable fa-minus-circle text-gray quantity-left-minus"></i>
                                                                        </div>
                                                                        <div class="col-4" style="padding: 0;">
                                                                            <span id="quantity7" class="text-extra-dark-gray font-weight-500 configbit">64</span> kbps
                                                                        </div>
                                                                        <div class="col-4 text-left plusicon" onclick="bitrateplus('7');">
                                                                            <i class="fas fa-plus-circle text-gray quantity-right-plus"></i>

                                                                        </div>
                                                                    </div>
                                                                </li>
                                                                <li class="border-color-medium-gray">
                                                                    <div class="dropdown">
                                                                        <button class="btn btn-block storagebtn7 dropdown-toggle text-center" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                                            <span class='storagevalue7 configdj'>512 MB</span>
                                                                            <i class="fa fa-chevron-down margin-20px-left"></i>
                                                                        </button>
                                                                        <div class="dropdown-menu dropdown-menu-center storagedd  text-center" aria-labelledby="dropdownMenuButton">
                                                                            <a class="dropdown-item" onclick="storageprice('7','512 MB','0');">512 MB</a>
                                                                            <a class="dropdown-item" onclick="storageprice('7','2 GB','12.00');">2 GB</a>
                                                                            <a class="dropdown-item" onclick="storageprice('7','5 GB','30.00');">5 GB</a>
                                                                            <a class="dropdown-item" onclick="storageprice('7','10 GB','57.00');">10 GB</a>
                                                                            <a class="dropdown-item" onclick="storageprice('7','25 GB','120.00');">25 GB</a>
                                                                            <a class="dropdown-item" onclick="storageprice('7','50 GB','205.00');">50 GB</a>

                                                                        </div>
                                                                    </div>
                                                                </li>

                                                                <li class="border-color-medium-gray"><span class="text-extra-dark-gray font-weight-500">75</span> Max Listeners</li>
                                                                <li class="border-color-medium-gray"><span class="text-extra-dark-gray font-weight-500">Free </span>Web Hosting</li>

                                                                <li class="border-color-medium-gray"><span class="text-extra-dark-gray font-weight-500">Advanced</span> Detailed Reports</li>
                                                                <li class="border-color-medium-gray"><span class="text-extra-dark-gray font-weight-500">Unlimited</span> Bandwidth </li>


                                                            </ul>
                                                        </div>
                                                        <!-- end pricing body -->
                                                        <!-- start pricing footer -->
                                                        <div class="pricing-footer margin-55px-bottom">
                                                            <a class="buynow btn btn-medium btn-transparent-dark-gray btn-round-edge popup-with-zoom-anim" href="#provider" data-link1="https://portal.casthost.net/cart.php?a=add&pid=240&billingcycle=annually" data-link2="https://portal.casthost.net/cart.php?a=add&pid=241&billingcycle=annually" shoutcanada="https://portal.casthost.net/cart.php?a=add&pid=312&billingcycle=annually" icecanada="https://portal.casthost.net/cart.php?a=add&pid=311&billingcycle=annually">Register Now</a>
                                                        </div>
                                                        <!-- end pricing footer -->
                                                    </div>
                                                    <!-- end pricing table -->
                                                </div>
                                                <div class="col pricing-table-style-02 text-center px-md-0 sm-margin-30px-bottom xs-margin-15px-bottom wow animate__fadeIn z-index-1" style="visibility: visible; animation-name: fadeIn;">
                                                    <!-- start pricing table -->
                                                    <div class="pricing-table pricing-popular bg-white box-shadow-large border-radius-6px">
                                                        <!-- start pricing header -->
                                                        <div class="pricing-header bg-extra-dark-gray padding-20px-tb">
                                                            <div class="alt-font font-weight-500 text-small text-white text-uppercase letter-spacing-minus-1-half ptype">Unlimited plan</div>
                                                        </div>
                                                        <!-- end pricing header -->
                                                        <!-- start pricing body -->
                                                        <div class="pricing-body padding-60px-tb">
                                                            <i class="line-icon-Communication-Tower icon-medium text-fast-blue margin-20px-bottom"></i>
                                                            <h4 class="font-weight-500 text-extra-dark-gray letter-spacing-minus-2px margin-15px-bottom">$ <span class="price8"><?php echo $price_stream_unlimited_annually; ?></span></h4>
                                                            <input class="hiddenval8" type="text" style="display: none;" value="<?php echo $price_stream_unlimited_annually; ?>">
                                                            <ul class="list-style-03">
                                                                <li class="border-color-medium-gray p-0">
                                                                    <audio controls style="width: 110%;" controlsList="nodownload">

                                                                        <source class="audiobitrate" src="https://securestream.casthost.net:8223/64" type="audio/mpeg">
                                                                        Your browser does not support the audio element.
                                                                    </audio>
                                                                </li>
                                                                <li class="border-color-medium-gray">
                                                                    <div class="row">
                                                                        <div class="col-4 text-right minusicon" onclick="bitrateminus('8');">
                                                                            <i class="fas disable fa-minus-circle text-gray quantity-left-minus"></i>

                                                                        </div>
                                                                        <div class="col-4" style="padding: 0;">
                                                                            <span id="quantity8" class="text-extra-dark-gray font-weight-500 configbit">64</span> kbps
                                                                        </div>
                                                                        <div class="col-4 text-left plusicon" onclick="bitrateplus('8');">
                                                                            <i class="fas fa-plus-circle text-gray quantity-right-plus"></i>

                                                                        </div>
                                                                    </div>
                                                                </li>

                                                                <li class="border-color-medium-gray">
                                                                    <div class="dropdown">
                                                                        <button class="btn btn-block storagebtn8 dropdown-toggle text-center" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                                            <span class='storagevalue8 configdj'>5 GB</span>
                                                                            <i class="fa fa-chevron-down margin-20px-left"></i>
                                                                        </button>
                                                                        <div class="dropdown-menu dropdown-menu-center storagedd  text-center" aria-labelledby="dropdownMenuButton">
                                                                            <a class="dropdown-item" onclick="storageprice('8','5 GB','0');">5 GB</a>
                                                                            <a class="dropdown-item" onclick="storageprice('8','10 GB','30.00');">10 GB</a>
                                                                            <a class="dropdown-item" onclick="storageprice('8','25 GB','99.00');">25 GB</a>
                                                                            <a class="dropdown-item" onclick="storageprice('8','50 GB','189.00');">50 GB</a>
                                                                            <a class="dropdown-item" onclick="storageprice('8','100 GB','342.00');">100 GB</a>
                                                                        </div>
                                                                    </div>
                                                                </li>

                                                                <li class="border-color-medium-gray"><span class="text-extra-dark-gray font-weight-500">Unlimited</span> Max Listeners </li>
                                                                <li class="border-color-medium-gray"><span class="text-extra-dark-gray font-weight-500">Free </span>Web Hosting</li>

                                                                <li class="border-color-medium-gray"><span class="text-extra-dark-gray font-weight-500">Advanced</span> Detailed Reports</li>
                                                                <li class="border-color-medium-gray"><span class="text-extra-dark-gray font-weight-500">Unlimited</span> Bandwidth </li>
                                                            </ul>
                                                        </div>
                                                        <!-- end pricing body -->
                                                        <!-- start pricing footer -->
                                                        <div class="pricing-footer margin-5px-top margin-55px-bottom">
                                                            <a class="buynow btn btn-medium btn-transparent-dark-gray btn-round-edge popup-with-zoom-anim" href="#provider" data-link1="https://portal.casthost.net/cart.php?a=add&pid=204&billingcycle=annually" data-link2="https://portal.casthost.net/cart.php?a=add&pid=205&billingcycle=annually" shoutcanada="https://portal.casthost.net/cart.php?a=add&pid=310&billingcycle=annually" icecanada="https://portal.casthost.net/cart.php?a=add&pid=309&billingcycle=annually">Register Now</a>
                                                        </div>
                                                        <!-- end pricing footer -->
                                                    </div>
                                                    <!-- end pricing table -->
                                                </div>
                                                <div class="col pricing-table-style-02 text-center px-md-0 wow animate__fadeInLeft" data-wow-delay="0.4s" style="visibility: visible; animation-delay: 0.4s; animation-name: fadeInLeft;">
                                                    <!-- start pricing table -->
                                                    <div class="pricing-table bg-white border-all border-color-medium-gray border-radius-6px">
                                                        <!-- start pricing header -->
                                                        <div class="pricing-header bg-light-gray padding-20px-tb">
                                                            <div class="alt-font font-weight-500 text-small text-extra-dark-gray text-uppercase letter-spacing-minus-1-half">Reseller plan</div>
                                                        </div>
                                                        <!-- end pricing header -->
                                                        <!-- start pricing body -->
                                                        <div class="pricing-body padding-40px-tb">
                                                            <i class="line-icon-Headset  icon-medium text-fast-blue margin-20px-bottom"></i>
                                                            <h4 class="font-weight-500 text-extra-dark-gray letter-spacing-minus-2px margin-15px-bottom">Contact Us</h4>
                                                            <ul class="list-style-03">
                                                                <li class="border-color-medium-gray p-0">
                                                                    <audio controls style="width: 110%;" controlsList="nodownload">

                                                                        <source class="audiobitrate" src="https://securestream.casthost.net:8223/64" type="audio/mpeg">
                                                                        Your browser does not support the audio element.
                                                                    </audio>
                                                                </li>
                                                                <li class="border-color-medium-gray"><span class="text-extra-dark-gray font-weight-500"> 64-320 </span> kbps Bitrate</li>
                                                                <li class="border-color-medium-gray"><span class="text-extra-dark-gray font-weight-500">Custom</span> Disk Space</li>
                                                                <li class="border-color-medium-gray"><span class="text-extra-dark-gray font-weight-500">Unlimited</span> Max Listeners</li>
                                                                <li class="border-color-medium-gray"><span class="text-extra-dark-gray font-weight-500">Free </span>Web Hosting</li>

                                                                <li class="border-color-medium-gray"><span class="text-extra-dark-gray font-weight-500">Advanced</span> Detailed Reports</li>
                                                                <li class="border-color-medium-gray"><span class="text-extra-dark-gray font-weight-500">Unlimited</span> Bandwidth </li>


                                                            </ul>
                                                        </div>
                                                        <!-- end pricing body -->
                                                        <!-- start pricing footer -->
                                                        <div class="pricing-footer margin-55px-bottom">
                                                            <a class="btn btn-medium btn-transparent-dark-gray btn-round-edge" href="https://portal.casthost.net/submitticket.php?step=2&deptid=2">Contact Us</a>
                                                        </div>
                                                        <!-- end pricing footer -->
                                                    </div>
                                                    <!-- end pricing table -->
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                </div>
                                <!-- end tab item -->
                                <!-- start tab item -->
                                <div id="strategy" class="tab-pane fade">
                                    <div class="container">
                                        <div class="row justify-content-center">
                                            <div class="col-12 col-xl-10 col-lg-11 tab-style-04">
                                                <ul class="nav nav-tabs text-uppercase justify-content-center text-center alt-font margin-3-half-rem-bottom sm-margin-20px-bottom " style="visibility: visible; animation-name: fadeIn;">
                                                    <li class="nav-item bg-white border-color-extra-light-gray"><a class="nav-link active" data-toggle="tab" href="#monthly-cpanel">Monthly</a><span class="tab-bg-active bg-fast-blue"></span></li>
                                                    <li class="nav-item bg-white border-color-extra-light-gray"><a class="nav-link" data-toggle="tab" href="#quarterly-cpanel">Quarterly</a><span class="tab-bg-active bg-fast-blue"></span></li>
                                                    <li class="nav-item bg-white border-color-extra-light-gray"><a class="nav-link" data-toggle="tab" href="#semiannually-cpanel">Semi Annually</a><span class="tab-bg-active bg-fast-blue"></span></li>
                                                    <li class="nav-item bg-white border-color-extra-light-gray"><a class="nav-link" data-toggle="tab" href="#yearly-cpanel">Annually</a><span class="tab-bg-active bg-fast-blue"></span></li>
                                                </ul>

                                            </div>
                                        </div>
                                    </div>

                                    <div class="tab-content">
                                        <div id="monthly-cpanel" class="tab-pane fade  active show">
                                            <div class="row row-cols-1 row-cols-md-5 align-items-center">
                                                <div class="col pricing-table-style-02 text-center px-md-0 sm-margin-30px-bottom xs-margin-15px-bottom  animate__fadeInRight" data- -delay="0.4s" style="visibility: visible; animation-delay: 0.4s; animation-name: fadeIn;">
                                                    <!-- start pricing table -->
                                                    <div class="pricing-table bg-white border-all border-color-medium-gray border-radius-6px " style="margin-top: 55px;">
                                                        <!-- start pricing header -->
                                                        <!-- <div class="pricing-header bg-light-gray padding-20px-tb">
                                                                <div class="alt-font font-weight-500 text-small text-extra-dark-gray text-uppercase letter-spacing-minus-1-half">Basic plan</div>
                                                            </div> -->
                                                        <!-- end pricing header -->
                                                        <!-- start pricing body -->
                                                        <div class="pricing-body ">
                                                            <!-- <i class="line-icon-Administrator icon-medium text-fast-blue margin-20px-bottom"></i>
                                                                <h4 class="font-weight-500 text-extra-dark-gray letter-spacing-minus-2px margin-15px-bottom">$9.99</h4> -->
                                                            <ul class="list-style-03 text-left">
                                                                <!-- <li class="border-color-medium-gray" style="padding-left: 1rem;"><span class="text-extra-dark-gray font-weight-500">Disk Storage Space</span> </li>
                                                                <li class="border-color-medium-gray" style="padding-left: 1rem;"><span class="text-extra-dark-gray font-weight-500">Bandwidth</span> </li>
                                                                <li class="border-color-medium-gray" style="padding-left: 1rem;"><span class="text-extra-dark-gray font-weight-500">Sub Domains</span> </li>
                                                                <li class="border-color-medium-gray" style="padding-left: 1rem;"><span class="text-extra-dark-gray font-weight-500">Email Accounts</span> </li>
                                                                <li class="border-color-medium-gray" style="padding-left: 1rem;"><span class="text-extra-dark-gray font-weight-500">MySQL Databases</span> </li>
                                                                <li class="border-color-medium-gray" style="padding-left: 1rem;"><span class="text-extra-dark-gray font-weight-500">Addon Domains</span> </li>
                                                                <li class="border-color-medium-gray" style="padding-left: 1rem;"><span class="text-extra-dark-gray font-weight-500">Parked Domains</span> </li>
                                                                <li class="border-color-medium-gray" style="padding-left: 1rem;"><span class="text-extra-dark-gray font-weight-500">FTP Accounts</span> </li>
                                                                <li class="border-color-medium-gray " style="padding-bottom: 15px; padding-left: 1rem;"><span class="text-extra-dark-gray font-weight-500">cPanel</span></li>-->
                                                                <li class="border-color-medium-gray" style="padding-left: 1rem;">
                                                                    <span class="text-extra-dark-gray font-weight-500">Websites</span>
                                                                </li>

                                                                <li class="border-color-medium-gray" style="padding-left: 1rem;">
                                                                    <span class="text-extra-dark-gray font-weight-500">Storage</span>
                                                                </li>

                                                                <li class="border-color-medium-gray" style="padding-left: 1rem;">
                                                                    <span class="text-extra-dark-gray font-weight-500">Database</span>
                                                                </li>


                                                                <li class="border-color-medium-gray" style="padding-left: 1rem;">
                                                                    <span class="text-extra-dark-gray font-weight-500">Bandwidth</span>
                                                                </li>
                                                                <li class="border-color-medium-gray" style="padding-left: 1rem;">
                                                                    <span class="text-extra-dark-gray font-weight-500">SSL</span>
                                                                </li>

                                                                <li class="border-color-medium-gray" style="padding-left: 1rem;">
                                                                    <span class="text-extra-dark-gray font-weight-500">Softaculous Script</span>
                                                                </li>

                                                                <li class="border-color-medium-gray" style="padding-left: 1rem;">
                                                                    <span class="text-extra-dark-gray font-weight-500">Free Domain</span>
                                                                </li>

                                                            </ul>
                                                        </div>
                                                        <!-- end pricing body -->

                                                    </div>
                                                    <!-- end pricing table -->
                                                </div>
                                                <div class="col pricing-table-style-02 text-center px-md-0 sm-margin-30px-bottom xs-margin-15px-bottom  animate__fadeInRight" data- -delay="0.4s" style="visibility: visible; animation-delay: 0.4s; animation-name: fadeInRight;">
                                                    <!-- start pricing table -->
                                                    <div class="pricing-table bg-white border-all border-color-medium-gray border-radius-6px">
                                                        <!-- start pricing header -->
                                                        <div class="pricing-header bg-light-gray padding-20px-tb">
                                                            <div class="alt-font font-weight-500 text-small text-extra-dark-gray text-uppercase letter-spacing-minus-1-half ptype">Starter plan</div>
                                                        </div>
                                                        <!-- end pricing header -->
                                                        <!-- start pricing body -->
                                                        <div class="pricing-body padding-40px-tb">
                                                            <i class="line-icon-Data-Storage icon-medium text-fast-blue margin-20px-bottom"></i>
                                                            <h4 class="font-weight-500 text-extra-dark-gray letter-spacing-minus-2px margin-15px-bottom">$
                                                                <?php echo $price_cpanel_starter_monthly; ?>
                                                            </h4>
                                                            <ul class="list-style-03">
                                                                <!-- <li class="border-color-medium-gray"><span class="text-extra-dark-gray font-weight-500">1000 MB  </span> </li>
                                                                <li class="border-color-medium-gray"><span class="text-extra-dark-gray font-weight-500">10 GB  </span> </li>
                                                                <li class="border-color-medium-gray"><span class="text-extra-dark-gray font-weight-500">Unlimited  </span> </li>
                                                                <li class="border-color-medium-gray"><span class="text-extra-dark-gray font-weight-500">10  </span> </li>
                                                                <li class="border-color-medium-gray"><span class="text-extra-dark-gray font-weight-500">4 MySQL   </span> </li>
                                                                <li class="border-color-medium-gray"><span class="text-extra-dark-gray font-weight-500">4 Addon  </span> </li>
                                                                <li class="border-color-medium-gray"><span class="text-extra-dark-gray font-weight-500">4 Parked  </span> </li>
                                                                <li class="border-color-medium-gray"><span class="text-extra-dark-gray font-weight-500">Unlimited  </span> </li>
                                                                <li class="border-color-medium-gray"><span class="text-extra-dark-gray font-weight-500">Free  </span> </li>-->
                                                                <li class="border-color-medium-gray">
                                                                    <span class="text-extra-dark-gray font-weight-500">1 </span>
                                                                </li>
                                                                <li class="border-color-medium-gray">
                                                                    <span class="text-extra-dark-gray font-weight-500">50GB </span>
                                                                </li>
                                                                <li class="border-color-medium-gray">
                                                                    <span class="text-extra-dark-gray font-weight-500">15 </span>
                                                                </li>
                                                                <li class="border-color-medium-gray">
                                                                    <span class="text-extra-dark-gray font-weight-500">Unmetered </span>
                                                                </li>
                                                                <li class="border-color-medium-gray">
                                                                    <span class="text-extra-dark-gray font-weight-500">Free </span>
                                                                </li>
                                                                <li class="border-color-medium-gray">
                                                                    <span class="text-extra-dark-gray font-weight-500">1-click install 382 apps </span>
                                                                </li>
                                                                <li class="border-color-medium-gray">
                                                                    <span class="text-extra-dark-gray font-weight-500"> with purchase of <br> 12 month+ plan </span>
                                                                </li>

                                                            </ul>
                                                        </div>
                                                        <!-- end pricing body -->
                                                        <!-- start pricing footer -->
                                                        <div class="pricing-footer margin-55px-bottom">
                                                            <a class="btn btn-medium btn-transparent-dark-gray btn-round-edge" href="https://portal.casthost.net/cart.php?a=add&pid=318&billingcycle=monthly">Register now</a>
                                                        </div>
                                                        <!-- end pricing footer -->
                                                    </div>
                                                    <!-- end pricing table -->
                                                </div>
                                                <div class="col pricing-table-style-02 text-center px-md-0 sm-margin-30px-bottom xs-margin-15px-bottom  animate__fadeIn z-index-1" style="visibility: visible; animation-name: fadeIn;">
                                                    <!-- start pricing table -->
                                                    <div class="pricing-table pricing-popular bg-white box-shadow-large border-radius-6px">
                                                        <!-- start pricing header -->
                                                        <div class="pricing-header bg-extra-dark-gray padding-20px-tb">
                                                            <div class="alt-font font-weight-500 text-small text-white text-uppercase letter-spacing-minus-1-half">Unlimted plan</div>
                                                        </div>
                                                        <!-- end pricing header -->
                                                        <!-- start pricing body -->
                                                        <div class="pricing-body padding-60px-tb">
                                                            <i class="line-icon-Server-2 icon-medium text-fast-blue margin-20px-bottom"></i>
                                                            <h4 class="font-weight-500 text-extra-dark-gray letter-spacing-minus-2px margin-15px-bottom">$
                                                                <?php echo $price_cpanel_unlimited_monthly; ?>
                                                            </h4>
                                                            <ul class="list-style-03">

                                                                <li class="border-color-medium-gray">
                                                                    <span class="text-extra-dark-gray font-weight-500">Unlimited </span>
                                                                </li>
                                                                <li class="border-color-medium-gray">
                                                                    <span class="text-extra-dark-gray font-weight-500">Unlimited </span>
                                                                </li>
                                                                <li class="border-color-medium-gray">
                                                                    <span class="text-extra-dark-gray font-weight-500">Unlimited </span>
                                                                </li>
                                                                <li class="border-color-medium-gray">
                                                                    <span class="text-extra-dark-gray font-weight-500">Unmetered </span>
                                                                </li>
                                                                <li class="border-color-medium-gray">
                                                                    <span class="text-extra-dark-gray font-weight-500">Free </span>
                                                                </li>
                                                                <li class="border-color-medium-gray">
                                                                    <span class="text-extra-dark-gray font-weight-500">1-click install 382 apps </span>
                                                                </li>
                                                                <li class="border-color-medium-gray">
                                                                    <span class="text-extra-dark-gray font-weight-500"> with purchase of <br> 12 month+ plan </span>
                                                                </li>
                                                            </ul>
                                                        </div>
                                                        <!-- end pricing body -->
                                                        <!-- start pricing footer -->
                                                        <div class="pricing-footer margin-5px-top margin-55px-bottom">
                                                            <a class="btn btn-medium btn-dark-gray btn-round-edge" href="https://portal.casthost.net/cart.php?a=add&pid=317&billingcycle=monthly">Register now</a>
                                                        </div>
                                                        <!-- end pricing footer -->
                                                    </div>
                                                    <!-- end pricing table -->
                                                </div>
                                            </div>
                                        </div>
                                        <div id="quarterly-cpanel" class="tab-pane fade">
                                            <div class="row row-cols-1 row-cols-md-5 align-items-center">
                                                <div class="col pricing-table-style-02 text-center px-md-0 sm-margin-30px-bottom xs-margin-15px-bottom  animate__fadeInRight" data- -delay="0.4s" style="visibility: visible; animation-delay: 0.4s; animation-name: fadeIn;">
                                                    <!-- start pricing table -->
                                                    <div class="pricing-table bg-white border-all border-color-medium-gray border-radius-6px " style="margin-top: 55px;">
                                                        <!-- start pricing header -->
                                                        <!-- <div class="pricing-header bg-light-gray padding-20px-tb">
                                                                <div class="alt-font font-weight-500 text-small text-extra-dark-gray text-uppercase letter-spacing-minus-1-half">Basic plan</div>
                                                            </div> -->
                                                        <!-- end pricing header -->
                                                        <!-- start pricing body -->
                                                        <div class="pricing-body ">
                                                            <!-- <i class="line-icon-Administrator icon-medium text-fast-blue margin-20px-bottom"></i>
                                                                <h4 class="font-weight-500 text-extra-dark-gray letter-spacing-minus-2px margin-15px-bottom">$9.99</h4> -->
                                                            <ul class="list-style-03 text-left">
                                                                <li class="border-color-medium-gray" style="padding-left: 1rem;">
                                                                    <span class="text-extra-dark-gray font-weight-500">Websites</span>
                                                                </li>

                                                                <li class="border-color-medium-gray" style="padding-left: 1rem;">
                                                                    <span class="text-extra-dark-gray font-weight-500">Storage</span>
                                                                </li>

                                                                <li class="border-color-medium-gray" style="padding-left: 1rem;">
                                                                    <span class="text-extra-dark-gray font-weight-500">Database</span>
                                                                </li>


                                                                <li class="border-color-medium-gray" style="padding-left: 1rem;">
                                                                    <span class="text-extra-dark-gray font-weight-500">Bandwidth</span>
                                                                </li>

                                                                <li class="border-color-medium-gray" style="padding-left: 1rem;">
                                                                    <span class="text-extra-dark-gray font-weight-500">SSL</span>
                                                                </li>

                                                                <li class="border-color-medium-gray" style="padding-left: 1rem;">
                                                                    <span class="text-extra-dark-gray font-weight-500">Softaculous Script</span>
                                                                </li>

                                                                <li class="border-color-medium-gray" style="padding-left: 1rem;">
                                                                    <span class="text-extra-dark-gray font-weight-500">Free Domain</span>
                                                                </li>
                                                            </ul>
                                                        </div>
                                                        <!-- end pricing body -->

                                                    </div>
                                                    <!-- end pricing table -->
                                                </div>
                                                <div class="col pricing-table-style-02 text-center px-md-0 sm-margin-30px-bottom xs-margin-15px-bottom  animate__fadeInRight" data- -delay="0.4s" style="visibility: visible; animation-delay: 0.4s; animation-name: fadeInRight;">
                                                    <!-- start pricing table -->
                                                    <div class="pricing-table bg-white border-all border-color-medium-gray border-radius-6px">
                                                        <!-- start pricing header -->
                                                        <div class="pricing-header bg-light-gray padding-20px-tb">
                                                            <div class="alt-font font-weight-500 text-small text-extra-dark-gray text-uppercase letter-spacing-minus-1-half ptype">Starter plan</div>
                                                        </div>
                                                        <!-- end pricing header -->
                                                        <!-- start pricing body -->
                                                        <div class="pricing-body padding-40px-tb">
                                                            <i class="line-icon-Data-Storage icon-medium text-fast-blue margin-20px-bottom"></i>
                                                            <h4 class="font-weight-500 text-extra-dark-gray letter-spacing-minus-2px margin-15px-bottom">$ <?php echo $price_cpanel_starter_quarterly; ?>
                                                            </h4>
                                                            <ul class="list-style-03">

                                                                <li class="border-color-medium-gray">
                                                                    <span class="text-extra-dark-gray font-weight-500">1 </span>
                                                                </li>
                                                                <li class="border-color-medium-gray">
                                                                    <span class="text-extra-dark-gray font-weight-500">50GB </span>
                                                                </li>
                                                                <li class="border-color-medium-gray">
                                                                    <span class="text-extra-dark-gray font-weight-500">15 </span>
                                                                </li>
                                                                <li class="border-color-medium-gray">
                                                                    <span class="text-extra-dark-gray font-weight-500">Unmetered </span>
                                                                </li>
                                                                <li class="border-color-medium-gray">
                                                                    <span class="text-extra-dark-gray font-weight-500">Free </span>
                                                                </li>
                                                                <li class="border-color-medium-gray">
                                                                    <span class="text-extra-dark-gray font-weight-500">1-click install 382 apps </span>
                                                                </li>
                                                                <li class="border-color-medium-gray">
                                                                    <span class="text-extra-dark-gray font-weight-500"> with purchase of <br> 12 month+ plan </span>
                                                                </li>
                                                            </ul>
                                                        </div>
                                                        <!-- end pricing body -->
                                                        <!-- start pricing footer -->
                                                        <div class="pricing-footer margin-55px-bottom">
                                                            <a class="btn btn-medium btn-transparent-dark-gray btn-round-edge" href="https://portal.casthost.net/cart.php?a=add&pid=318&billingcycle=quarterly">Register now</a>
                                                        </div>
                                                        <!-- end pricing footer -->
                                                    </div>
                                                    <!-- end pricing table -->
                                                </div>
                                                <div class="col pricing-table-style-02 text-center px-md-0 sm-margin-30px-bottom xs-margin-15px-bottom  animate__fadeIn z-index-1" style="visibility: visible; animation-name: fadeIn;">
                                                    <!-- start pricing table -->
                                                    <div class="pricing-table pricing-popular bg-white box-shadow-large border-radius-6px">
                                                        <!-- start pricing header -->
                                                        <div class="pricing-header bg-extra-dark-gray padding-20px-tb">
                                                            <div class="alt-font font-weight-500 text-small text-white text-uppercase letter-spacing-minus-1-half">Unlimited plan</div>
                                                        </div>
                                                        <!-- end pricing header -->
                                                        <!-- start pricing body -->
                                                        <div class="pricing-body padding-60px-tb">
                                                            <i class="line-icon-Server-2 icon-medium text-fast-blue margin-20px-bottom"></i>
                                                            <h4 class="font-weight-500 text-extra-dark-gray letter-spacing-minus-2px margin-15px-bottom">$
                                                                <?php echo $price_cpanel_unlimited_quarterly; ?>
                                                            </h4>
                                                            <ul class="list-style-03">
                                                                <li class="border-color-medium-gray">
                                                                    <span class="text-extra-dark-gray font-weight-500">Unlimited </span>
                                                                </li>
                                                                <li class="border-color-medium-gray">
                                                                    <span class="text-extra-dark-gray font-weight-500">Unlimited </span>
                                                                </li>
                                                                <li class="border-color-medium-gray">
                                                                    <span class="text-extra-dark-gray font-weight-500">Unlimited </span>
                                                                </li>
                                                                <li class="border-color-medium-gray">
                                                                    <span class="text-extra-dark-gray font-weight-500">Unmetered </span>
                                                                </li>
                                                                <li class="border-color-medium-gray">
                                                                    <span class="text-extra-dark-gray font-weight-500">Free </span>
                                                                </li>
                                                                <li class="border-color-medium-gray">
                                                                    <span class="text-extra-dark-gray font-weight-500">1-click install 382 apps </span>
                                                                </li>
                                                                <li class="border-color-medium-gray">
                                                                    <span class="text-extra-dark-gray font-weight-500"> with purchase of <br> 12 month+ plan </span>
                                                                </li>
                                                            </ul>
                                                        </div>
                                                        <!-- end pricing body -->
                                                        <!-- start pricing footer -->
                                                        <div class="pricing-footer margin-5px-top margin-55px-bottom">
                                                            <a class="btn btn-medium btn-dark-gray btn-round-edge" href="https://portal.casthost.net/cart.php?a=add&pid=317">Register now</a>
                                                        </div>
                                                        <!-- end pricing footer -->
                                                    </div>
                                                    <!-- end pricing table -->
                                                </div>
                                            </div>
                                        </div>
                                        <div id="semiannually-cpanel" class="tab-pane fade">
                                            <div class="row row-cols-1 row-cols-md-5 align-items-center">
                                                <div class="col pricing-table-style-02 text-center px-md-0 sm-margin-30px-bottom xs-margin-15px-bottom   animate__fadeInRight" data- -delay="0.4s" style="visibility: visible; animation-delay: 0.4s; animation-name: fadeIn;">
                                                    <!-- start pricing table -->
                                                    <div class="pricing-table bg-white border-all border-color-medium-gray border-radius-6px " style="margin-top: 55px;">
                                                        <!-- start pricing header -->
                                                        <!-- <div class="pricing-header bg-light-gray padding-20px-tb">
                                                                <div class="alt-font font-weight-500 text-small text-extra-dark-gray text-uppercase letter-spacing-minus-1-half">Basic plan</div>
                                                            </div> -->
                                                        <!-- end pricing header -->
                                                        <!-- start pricing body -->
                                                        <div class="pricing-body ">
                                                            <!-- <i class="line-icon-Administrator icon-medium text-fast-blue margin-20px-bottom"></i>
                                                                <h4 class="font-weight-500 text-extra-dark-gray letter-spacing-minus-2px margin-15px-bottom">$9.99</h4> -->
                                                            <ul class="list-style-03 text-left">
                                                                <li class="border-color-medium-gray" style="padding-left: 1rem;">
                                                                    <span class="text-extra-dark-gray font-weight-500">Websites</span>
                                                                </li>

                                                                <li class="border-color-medium-gray" style="padding-left: 1rem;">
                                                                    <span class="text-extra-dark-gray font-weight-500">Storage</span>
                                                                </li>

                                                                <li class="border-color-medium-gray" style="padding-left: 1rem;">
                                                                    <span class="text-extra-dark-gray font-weight-500">Database</span>
                                                                </li>
                                                                <li class="border-color-medium-gray" style="padding-left: 1rem;">
                                                                    <span class="text-extra-dark-gray font-weight-500">Bandwidth</span>
                                                                </li>
                                                                <li class="border-color-medium-gray" style="padding-left: 1rem;">
                                                                    <span class="text-extra-dark-gray font-weight-500">SSL</span>
                                                                </li>



                                                                <li class="border-color-medium-gray" style="padding-left: 1rem;">
                                                                    <span class="text-extra-dark-gray font-weight-500">Softaculous Script</span>
                                                                </li>

                                                                <li class="border-color-medium-gray" style="padding-left: 1rem;">
                                                                    <span class="text-extra-dark-gray font-weight-500">Free Domain</span>
                                                                </li>

                                                            </ul>
                                                        </div>
                                                        <!-- end pricing body -->

                                                    </div>
                                                    <!-- end pricing table -->
                                                </div>
                                                <div class="col pricing-table-style-02 text-center px-md-0 sm-margin-30px-bottom xs-margin-15px-bottom   animate__fadeInRight" data- -delay="0.4s" style="visibility: visible; animation-delay: 0.4s; animation-name: fadeInRight;">
                                                    <!-- start pricing table -->
                                                    <div class="pricing-table bg-white border-all border-color-medium-gray border-radius-6px">
                                                        <!-- start pricing header -->
                                                        <div class="pricing-header bg-light-gray padding-20px-tb">
                                                            <div class="alt-font font-weight-500 text-small text-extra-dark-gray text-uppercase letter-spacing-minus-1-half ptype">Starter plan</div>
                                                        </div>
                                                        <!-- end pricing header -->
                                                        <!-- start pricing body -->
                                                        <div class="pricing-body padding-40px-tb">
                                                            <i class="line-icon-Data-Storage icon-medium text-fast-blue margin-20px-bottom"></i>
                                                            <h4 class="font-weight-500 text-extra-dark-gray letter-spacing-minus-2px margin-15px-bottom">$
                                                                <?php echo $price_cpanel_starter_semiannually; ?>
                                                            </h4>
                                                            <ul class="list-style-03">

                                                                <li class="border-color-medium-gray">
                                                                    <span class="text-extra-dark-gray font-weight-500">1 </span>
                                                                </li>
                                                                <li class="border-color-medium-gray">
                                                                    <span class="text-extra-dark-gray font-weight-500">50GB </span>
                                                                </li>
                                                                <li class="border-color-medium-gray">
                                                                    <span class="text-extra-dark-gray font-weight-500">15 </span>
                                                                </li>
                                                                <li class="border-color-medium-gray">
                                                                    <span class="text-extra-dark-gray font-weight-500">Unmetered </span>
                                                                </li>
                                                                <li class="border-color-medium-gray">
                                                                    <span class="text-extra-dark-gray font-weight-500">Free </span>
                                                                </li>
                                                                <li class="border-color-medium-gray">
                                                                    <span class="text-extra-dark-gray font-weight-500">1-click install 382 apps </span>
                                                                </li>
                                                                <li class="border-color-medium-gray">
                                                                    <span class="text-extra-dark-gray font-weight-500"> with purchase of <br> 12 month+ plan </span>
                                                                </li>
                                                            </ul>
                                                        </div>
                                                        <!-- end pricing body -->
                                                        <!-- start pricing footer -->
                                                        <div class="pricing-footer margin-55px-bottom">
                                                            <a class="btn btn-medium btn-transparent-dark-gray btn-round-edge" href="https://portal.casthost.net/cart.php?a=add&pid=318&billingcycle=semiannually">Register now</a>
                                                        </div>
                                                        <!-- end pricing footer -->
                                                    </div>
                                                    <!-- end pricing table -->
                                                </div>
                                                <div class="col pricing-table-style-02 text-center px-md-0 sm-margin-30px-bottom xs-margin-15px-bottom   animate__fadeIn z-index-1" style="visibility: visible; animation-name: fadeIn;">
                                                    <!-- start pricing table -->
                                                    <div class="pricing-table pricing-popular bg-white box-shadow-large border-radius-6px">
                                                        <!-- start pricing header -->
                                                        <div class="pricing-header bg-extra-dark-gray padding-20px-tb">
                                                            <div class="alt-font font-weight-500 text-small text-white text-uppercase letter-spacing-minus-1-half">Unlimited plan</div>
                                                        </div>
                                                        <!-- end pricing header -->
                                                        <!-- start pricing body -->
                                                        <div class="pricing-body padding-60px-tb">
                                                            <i class="line-icon-Server-2 icon-medium text-fast-blue margin-20px-bottom"></i>
                                                            <h4 class="font-weight-500 text-extra-dark-gray letter-spacing-minus-2px margin-15px-bottom">$
                                                                <?php echo $price_cpanel_unlimited_semiannually; ?>
                                                            </h4>
                                                            <ul class="list-style-03">
                                                                <li class="border-color-medium-gray">
                                                                    <span class="text-extra-dark-gray font-weight-500">Unlimited </span>
                                                                </li>
                                                                <li class="border-color-medium-gray">
                                                                    <span class="text-extra-dark-gray font-weight-500">Unlimited </span>
                                                                </li>
                                                                <li class="border-color-medium-gray">
                                                                    <span class="text-extra-dark-gray font-weight-500">Unlimited </span>
                                                                </li>
                                                                <li class="border-color-medium-gray">
                                                                    <span class="text-extra-dark-gray font-weight-500">Unmetered </span>
                                                                </li>
                                                                <li class="border-color-medium-gray">
                                                                    <span class="text-extra-dark-gray font-weight-500">Free </span>
                                                                </li>
                                                                <li class="border-color-medium-gray">
                                                                    <span class="text-extra-dark-gray font-weight-500">1-click install 382 apps </span>
                                                                </li>
                                                                <li class="border-color-medium-gray">
                                                                    <span class="text-extra-dark-gray font-weight-500"> with purchase of <br> 12 month+ plan </span>
                                                                </li>
                                                            </ul>
                                                        </div>
                                                        <!-- end pricing body -->
                                                        <!-- start pricing footer -->
                                                        <div class="pricing-footer margin-5px-top margin-55px-bottom">
                                                            <a class="btn btn-medium btn-dark-gray btn-round-edge" href="https://portal.casthost.net/cart.php?a=add&pid=317&billingcycle=semiannually">Register now</a>
                                                        </div>
                                                        <!-- end pricing footer -->
                                                    </div>
                                                    <!-- end pricing table -->
                                                </div>
                                            </div>
                                        </div>

                                        <div id="yearly-cpanel" class="tab-pane fade">
                                            <div class="row row-cols-1 row-cols-md-5 align-items-center">
                                                <div class="col pricing-table-style-02 text-center px-md-0 sm-margin-30px-bottom xs-margin-15px-bottom   animate__fadeInRight" data- -delay="0.4s" style="visibility: visible; animation-delay: 0.4s; animation-name: fadeIn;">
                                                    <!-- start pricing table -->
                                                    <div class="pricing-table bg-white border-all border-color-medium-gray border-radius-6px " style="margin-top: 55px;">
                                                        <!-- start pricing header -->
                                                        <!-- <div class="pricing-header bg-light-gray padding-20px-tb">
                                                                <div class="alt-font font-weight-500 text-small text-extra-dark-gray text-uppercase letter-spacing-minus-1-half">Basic plan</div>
                                                            </div> -->
                                                        <!-- end pricing header -->
                                                        <!-- start pricing body -->
                                                        <div class="pricing-body ">
                                                            <!-- <i class="line-icon-Administrator icon-medium text-fast-blue margin-20px-bottom"></i>
                                                                <h4 class="font-weight-500 text-extra-dark-gray letter-spacing-minus-2px margin-15px-bottom">$9.99</h4> -->
                                                            <ul class="list-style-03 text-left">
                                                                <li class="border-color-medium-gray" style="padding-left: 1rem;">
                                                                    <span class="text-extra-dark-gray font-weight-500">Websites</span>
                                                                </li>

                                                                <li class="border-color-medium-gray" style="padding-left: 1rem;">
                                                                    <span class="text-extra-dark-gray font-weight-500">Storage</span>
                                                                </li>

                                                                <li class="border-color-medium-gray" style="padding-left: 1rem;">
                                                                    <span class="text-extra-dark-gray font-weight-500">Database</span>
                                                                </li>
                                                                <li class="border-color-medium-gray" style="padding-left: 1rem;">
                                                                    <span class="text-extra-dark-gray font-weight-500">Bandwidth</span>
                                                                </li>
                                                                <li class="border-color-medium-gray" style="padding-left: 1rem;">
                                                                    <span class="text-extra-dark-gray font-weight-500">SSL</span>
                                                                </li>



                                                                <li class="border-color-medium-gray" style="padding-left: 1rem;">
                                                                    <span class="text-extra-dark-gray font-weight-500">Softaculous Script</span>
                                                                </li>

                                                                <li class="border-color-medium-gray" style="padding-left: 1rem;">
                                                                    <span class="text-extra-dark-gray font-weight-500">Free Domain</span>
                                                                </li>

                                                            </ul>
                                                        </div>
                                                        <!-- end pricing body -->

                                                    </div>
                                                    <!-- end pricing table -->
                                                </div>
                                                <div class="col pricing-table-style-02 text-center px-md-0 sm-margin-30px-bottom xs-margin-15px-bottom   animate__fadeInRight" data- -delay="0.4s" style="visibility: visible; animation-delay: 0.4s; animation-name: fadeInRight;">
                                                    <!-- start pricing table -->
                                                    <div class="pricing-table bg-white border-all border-color-medium-gray border-radius-6px">
                                                        <!-- start pricing header -->
                                                        <div class="pricing-header bg-light-gray padding-20px-tb">
                                                            <div class="alt-font font-weight-500 text-small text-extra-dark-gray text-uppercase letter-spacing-minus-1-half ptype">Starter plan</div>
                                                        </div>
                                                        <!-- end pricing header -->
                                                        <!-- start pricing body -->
                                                        <div class="pricing-body padding-40px-tb">
                                                            <i class="line-icon-Data-Storage icon-medium text-fast-blue margin-20px-bottom"></i>
                                                            <h4 class="font-weight-500 text-extra-dark-gray letter-spacing-minus-2px margin-15px-bottom">$
                                                                <?php echo $price_cpanel_starter_annually; ?>
                                                            </h4>
                                                            <ul class="list-style-03">

                                                                <li class="border-color-medium-gray">
                                                                    <span class="text-extra-dark-gray font-weight-500">1 </span>
                                                                </li>
                                                                <li class="border-color-medium-gray">
                                                                    <span class="text-extra-dark-gray font-weight-500">50GB </span>
                                                                </li>
                                                                <li class="border-color-medium-gray">
                                                                    <span class="text-extra-dark-gray font-weight-500">15 </span>
                                                                </li>
                                                                <li class="border-color-medium-gray">
                                                                    <span class="text-extra-dark-gray font-weight-500">Unmetered </span>
                                                                </li>
                                                                <li class="border-color-medium-gray">
                                                                    <span class="text-extra-dark-gray font-weight-500">Free </span>
                                                                </li>
                                                                <li class="border-color-medium-gray">
                                                                    <span class="text-extra-dark-gray font-weight-500">1-click install 382 apps </span>
                                                                </li>
                                                                <li class="border-color-medium-gray">
                                                                    <span class="text-extra-dark-gray font-weight-500"> with purchase of <br> 12 month+ plan </span>
                                                                </li>
                                                            </ul>
                                                        </div>
                                                        <!-- end pricing body -->
                                                        <!-- start pricing footer -->
                                                        <div class="pricing-footer margin-55px-bottom">
                                                            <a class="btn btn-medium btn-transparent-dark-gray btn-round-edge" href="https://portal.casthost.net/cart.php?a=add&pid=318&billingcycle=annually">Register now</a>
                                                        </div>
                                                        <!-- end pricing footer -->
                                                    </div>
                                                    <!-- end pricing table -->
                                                </div>
                                                <div class="col pricing-table-style-02 text-center px-md-0 sm-margin-30px-bottom xs-margin-15px-bottom   animate__fadeIn z-index-1" style="visibility: visible; animation-name: fadeIn;">
                                                    <!-- start pricing table -->
                                                    <div class="pricing-table pricing-popular bg-white box-shadow-large border-radius-6px">
                                                        <!-- start pricing header -->
                                                        <div class="pricing-header bg-extra-dark-gray padding-20px-tb">
                                                            <div class="alt-font font-weight-500 text-small text-white text-uppercase letter-spacing-minus-1-half">Unlimited plan</div>
                                                        </div>
                                                        <!-- end pricing header -->
                                                        <!-- start pricing body -->
                                                        <div class="pricing-body padding-60px-tb">
                                                            <i class="line-icon-Server-2 icon-medium text-fast-blue margin-20px-bottom"></i>
                                                            <h4 class="font-weight-500 text-extra-dark-gray letter-spacing-minus-2px margin-15px-bottom">$
                                                                <?php echo $price_cpanel_unlimited_annually; ?>
                                                            </h4>
                                                            <ul class="list-style-03">
                                                                <li class="border-color-medium-gray">
                                                                    <span class="text-extra-dark-gray font-weight-500">Unlimited </span>
                                                                </li>
                                                                <li class="border-color-medium-gray">
                                                                    <span class="text-extra-dark-gray font-weight-500">Unlimited </span>
                                                                </li>
                                                                <li class="border-color-medium-gray">
                                                                    <span class="text-extra-dark-gray font-weight-500">Unlimited </span>
                                                                </li>
                                                                <li class="border-color-medium-gray">
                                                                    <span class="text-extra-dark-gray font-weight-500">Unmetered </span>
                                                                </li>
                                                                <li class="border-color-medium-gray">
                                                                    <span class="text-extra-dark-gray font-weight-500">Free </span>
                                                                </li>
                                                                <li class="border-color-medium-gray">
                                                                    <span class="text-extra-dark-gray font-weight-500">1-click install 382 apps </span>
                                                                </li>
                                                                <li class="border-color-medium-gray">
                                                                    <span class="text-extra-dark-gray font-weight-500"> with purchase of <br> 12 month+ plan </span>
                                                                </li>
                                                            </ul>
                                                        </div>
                                                        <!-- end pricing body -->
                                                        <!-- start pricing footer -->
                                                        <div class="pricing-footer margin-5px-top margin-55px-bottom">
                                                            <a class="btn btn-medium btn-dark-gray btn-round-edge" href="https://portal.casthost.net/cart.php?a=add&pid=317&billingcycle=annually">Register now</a>
                                                        </div>
                                                        <!-- end pricing footer -->
                                                    </div>
                                                    <!-- end pricing table -->
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                </div>
                                <!-- end tab item -->
                                <!-- start tab item -->
                                <div id="management" class="tab-pane fade">
                                    <div class="container">
                                        <div class="tab-content">
                                            <div id="monthly-tab" class="tab-pane fade in active show">
                                                <div class="row row-cols-1 row-cols-md-4 align-items-center">
                                                    <div class="col pricing-table-style-02 text-center px-md-0 sm-margin-30px-bottom xs-margin-15px-bottom   animate__fadeInRight" data- -delay="0.4s" style="visibility: visible; animation-delay: 0.4s; animation-name: fadeInRight;">
                                                        <!-- start pricing table -->
                                                        <div class="pricing-table bg-white border-all border-color-medium-gray border-radius-6px">
                                                            <!-- start pricing header -->
                                                            <div class="pricing-header bg-light-gray padding-20px-tb">
                                                                <div class="alt-font font-weight-500 text-small text-extra-dark-gray text-uppercase letter-spacing-minus-1-half">Monthly</div>
                                                            </div>
                                                            <!-- end pricing header -->
                                                            <!-- start pricing body -->
                                                            <div class="pricing-body padding-40px-tb">
                                                                <i class="line-icon-Line-Chart2   icon-medium text-fast-blue margin-20px-bottom"></i>
                                                                <h4 class="font-weight-500 text-extra-dark-gray letter-spacing-minus-2px margin-15px-bottom">$
                                                                    <?php echo $price_seo_monthly; ?>
                                                                </h4>
                                                                <ul class="list-style-03">
                                                                    <li class="border-color-medium-gray"><span class="text-extra-dark-gray font-weight-500"> </span> Keyword Research</li>
                                                                    <li class="border-color-medium-gray"><span class="text-extra-dark-gray font-weight-500"> </span> Meta Details Optimization </li>
                                                                    <li class="border-color-medium-gray"><span class="text-extra-dark-gray font-weight-500"> </span> Heading Tag Optimization</li>
                                                                    <li class="border-color-medium-gray"><span class="text-extra-dark-gray font-weight-500"> </span> Site Performance Improvement</li>
                                                                    <li class="border-color-medium-gray"><span class="text-extra-dark-gray font-weight-500"> </span> Internal Linking </li>
                                                                    <li class="border-color-medium-gray"><span class="text-extra-dark-gray font-weight-500"> </span> Content Optimization </li>
                                                                    <li class="border-color-medium-gray"><span class="text-extra-dark-gray font-weight-500"> </span> Plagiarism check </li>
                                                                    <li class="border-color-medium-gray"><span class="text-extra-dark-gray font-weight-500"> </span>Analytics Integration</li>
                                                                    <li class="border-color-medium-gray"><span class="text-extra-dark-gray font-weight-500"> </span>URL Optimization</li>
                                                                    <li><span class="text-extra-dark-gray font-weight-500"></span> Backlink Building</li>
                                                                </ul>
                                                            </div>
                                                            <!-- end pricing body -->
                                                            <!-- start pricing footer -->
                                                            <div class="pricing-footer margin-55px-bottom">
                                                                <a class="btn btn-medium btn-transparent-dark-gray btn-round-edge" href="https://portal.casthost.net/cart.php?a=add&pid=279&billingcycle=monthly">Register now</a>
                                                            </div>
                                                            <!-- end pricing footer -->
                                                        </div>
                                                        <!-- end pricing table -->
                                                    </div>
                                                    <div class="col pricing-table-style-02 text-center px-md-0 sm-margin-30px-bottom xs-margin-15px-bottom   animate__fadeInRight" data- -delay="0.4s" style="visibility: visible; animation-delay: 0.4s; animation-name: fadeInRight;">
                                                        <!-- start pricing table -->
                                                        <div class="pricing-table bg-white border-all border-color-medium-gray border-radius-6px">
                                                            <!-- start pricing header -->
                                                            <div class="pricing-header bg-light-gray padding-20px-tb">
                                                                <div class="alt-font font-weight-500 text-small text-extra-dark-gray text-uppercase letter-spacing-minus-1-half">Quarterly</div>
                                                            </div>
                                                            <!-- end pricing header -->
                                                            <!-- start pricing body -->
                                                            <div class="pricing-body padding-40px-tb">
                                                                <i class="line-icon-Bar-Chart4  icon-medium text-fast-blue margin-20px-bottom"></i>
                                                                <h4 class="font-weight-500 text-extra-dark-gray letter-spacing-minus-2px margin-15px-bottom">$
                                                                    <?php echo $price_seo_quarterly; ?>
                                                                </h4>
                                                                <ul class="list-style-03">
                                                                    <li class="border-color-medium-gray"><span class="text-extra-dark-gray font-weight-500"> </span> Keyword Research</li>
                                                                    <li class="border-color-medium-gray"><span class="text-extra-dark-gray font-weight-500"> </span> Meta Details Optimization </li>
                                                                    <li class="border-color-medium-gray"><span class="text-extra-dark-gray font-weight-500"> </span> Heading Tag Optimization</li>
                                                                    <li class="border-color-medium-gray"><span class="text-extra-dark-gray font-weight-500"> </span> Site Performance Improvement</li>
                                                                    <li class="border-color-medium-gray"><span class="text-extra-dark-gray font-weight-500"> </span> Internal Linking </li>
                                                                    <li class="border-color-medium-gray"><span class="text-extra-dark-gray font-weight-500"> </span> Content Optimization </li>
                                                                    <li class="border-color-medium-gray"><span class="text-extra-dark-gray font-weight-500"> </span> Plagiarism check </li>
                                                                    <li class="border-color-medium-gray"><span class="text-extra-dark-gray font-weight-500"> </span>Analytics Integration</li>
                                                                    <li class="border-color-medium-gray"><span class="text-extra-dark-gray font-weight-500"> </span>URL Optimization</li>
                                                                    <li><span class="text-extra-dark-gray font-weight-500"></span> Backlink Building</li>
                                                                </ul>
                                                            </div>
                                                            <!-- end pricing body -->
                                                            <!-- start pricing footer -->
                                                            <div class="pricing-footer margin-55px-bottom">
                                                                <a class="btn btn-medium btn-transparent-dark-gray btn-round-edge" href="https://portal.casthost.net/cart.php?a=add&pid=279&billingcycle=quarterly">Register now</a>
                                                            </div>
                                                            <!-- end pricing footer -->
                                                        </div>
                                                        <!-- end pricing table -->
                                                    </div>
                                                    <div class="col pricing-table-style-02 text-center px-md-0 sm-margin-30px-bottom xs-margin-15px-bottom   animate__fadeIn z-index-1" style="visibility: visible; animation-name: fadeIn;">
                                                        <!-- start pricing table -->
                                                        <div class="pricing-table pricing-popular bg-white box-shadow-large border-radius-6px">
                                                            <!-- start pricing header -->
                                                            <div class="pricing-header bg-extra-dark-gray padding-20px-tb">
                                                                <div class="alt-font font-weight-500 text-small text-white text-uppercase letter-spacing-minus-1-half">Semi Annually</div>
                                                            </div>
                                                            <!-- end pricing header -->
                                                            <!-- start pricing body -->
                                                            <div class="pricing-body padding-60px-tb">
                                                                <i class="line-icon-Bar-Chart5  icon-medium text-fast-blue margin-20px-bottom"></i>
                                                                <h4 class="font-weight-500 text-extra-dark-gray letter-spacing-minus-2px margin-15px-bottom">$
                                                                    <?php echo $price_seo_semiannually; ?>
                                                                </h4>
                                                                <ul class="list-style-03">
                                                                    <li class="border-color-medium-gray"><span class="text-extra-dark-gray font-weight-500"> </span> Keyword Research</li>
                                                                    <li class="border-color-medium-gray"><span class="text-extra-dark-gray font-weight-500"> </span> Meta Details Optimization </li>
                                                                    <li class="border-color-medium-gray"><span class="text-extra-dark-gray font-weight-500"> </span> Heading Tag Optimization</li>
                                                                    <li class="border-color-medium-gray"><span class="text-extra-dark-gray font-weight-500"> </span> Site Performance Improvement</li>
                                                                    <li class="border-color-medium-gray"><span class="text-extra-dark-gray font-weight-500"> </span> Internal Linking </li>
                                                                    <li class="border-color-medium-gray"><span class="text-extra-dark-gray font-weight-500"> </span> Content Optimization </li>
                                                                    <li class="border-color-medium-gray"><span class="text-extra-dark-gray font-weight-500"> </span> Plagiarism check </li>
                                                                    <li class="border-color-medium-gray"><span class="text-extra-dark-gray font-weight-500"> </span>Analytics Integration</li>
                                                                    <li class="border-color-medium-gray"><span class="text-extra-dark-gray font-weight-500"> </span>URL Optimization</li>
                                                                    <li><span class="text-extra-dark-gray font-weight-500"></span> Backlink Building</li>
                                                                </ul>
                                                            </div>
                                                            <!-- end pricing body -->
                                                            <!-- start pricing footer -->
                                                            <div class="pricing-footer margin-5px-top margin-55px-bottom">
                                                                <a class="btn btn-medium btn-dark-gray btn-round-edge" href="https://portal.casthost.net/cart.php?a=add&pid=279&billingcycle=semiannually">Register now</a>
                                                            </div>
                                                            <!-- end pricing footer -->
                                                        </div>
                                                        <!-- end pricing table -->
                                                    </div>
                                                    <div class="col pricing-table-style-02 text-center px-md-0   animate__fadeInLeft" data- -delay="0.4s" style="visibility: visible; animation-delay: 0.4s; animation-name: fadeInLeft;">
                                                        <!-- start pricing table -->
                                                        <div class="pricing-table bg-white border-all border-color-medium-gray border-radius-6px">
                                                            <!-- start pricing header -->
                                                            <div class="pricing-header bg-light-gray padding-20px-tb">
                                                                <div class="alt-font font-weight-500 text-small text-extra-dark-gray text-uppercase letter-spacing-minus-1-half">Yearly</div>
                                                            </div>
                                                            <!-- end pricing header -->
                                                            <!-- start pricing body -->
                                                            <div class="pricing-body padding-40px-tb">
                                                                <i class="line-icon-Bar-Chart icon-medium text-fast-blue margin-20px-bottom"></i>
                                                                <h4 class="font-weight-500 text-extra-dark-gray letter-spacing-minus-2px margin-15px-bottom">$
                                                                    <?php echo $price_seo_annually; ?>
                                                                </h4>
                                                                <ul class="list-style-03">
                                                                    <li class="border-color-medium-gray"><span class="text-extra-dark-gray font-weight-500"> </span> Keyword Research</li>
                                                                    <li class="border-color-medium-gray"><span class="text-extra-dark-gray font-weight-500"> </span> Meta Details Optimization </li>
                                                                    <li class="border-color-medium-gray"><span class="text-extra-dark-gray font-weight-500"> </span> Heading Tag Optimization</li>
                                                                    <li class="border-color-medium-gray"><span class="text-extra-dark-gray font-weight-500"> </span> Site Performance Improvement</li>
                                                                    <li class="border-color-medium-gray"><span class="text-extra-dark-gray font-weight-500"> </span> Internal Linking </li>
                                                                    <li class="border-color-medium-gray"><span class="text-extra-dark-gray font-weight-500"> </span> Content Optimization </li>
                                                                    <li class="border-color-medium-gray"><span class="text-extra-dark-gray font-weight-500"> </span> Plagiarism check </li>
                                                                    <li class="border-color-medium-gray"><span class="text-extra-dark-gray font-weight-500"> </span>Analytics Integration</li>
                                                                    <li class="border-color-medium-gray"><span class="text-extra-dark-gray font-weight-500"> </span>URL Optimization</li>
                                                                    <li><span class="text-extra-dark-gray font-weight-500"></span> Backlink Building</li>
                                                                </ul>
                                                            </div>
                                                            <!-- end pricing body -->
                                                            <!-- start pricing footer -->
                                                            <div class="pricing-footer margin-55px-bottom">
                                                                <a class="btn btn-medium btn-transparent-dark-gray btn-round-edge" href="https://portal.casthost.net/cart.php?a=add&pid=279&billingcycle=annually">Register now</a>
                                                            </div>
                                                            <!-- end pricing footer -->
                                                        </div>
                                                        <!-- end pricing table -->
                                                    </div>
                                                </div>
                                            </div>

                                        </div>
                                    </div>

                                </div>
                                <!-- end tab item -->
                                <!-- start tab item -->
                                <div id="concept" class="tab-pane fade">
                                    <div class="container">
                                        <div class="tab-content">
                                            <div id="monthly-tab" class="tab-pane fade in active show">
                                                <div class="row row-cols-1 row-cols-md-4 align-items-center">
                                                    <div class="col pricing-table-style-02 text-center px-md-0 sm-margin-30px-bottom xs-margin-15px-bottom   animate__fadeInRight" data- -delay="0.4s" style="visibility: visible; animation-delay: 0.4s; animation-name: fadeInRight;">
                                                        <!-- start pricing table -->
                                                        <div class="pricing-table bg-white border-all border-color-medium-gray border-radius-6px">
                                                            <!-- start pricing header -->
                                                            <div class="pricing-header bg-light-gray padding-20px-tb">
                                                                <div class="alt-font font-weight-500 text-small text-extra-dark-gray text-uppercase letter-spacing-minus-1-half">Monthly</div>
                                                            </div>
                                                            <!-- end pricing header -->
                                                            <!-- start pricing body -->
                                                            <div class="pricing-body padding-40px-tb">
                                                                <!-- <i class="line-icon-Line-Chart2   icon-medium text-fast-blue margin-20px-bottom"></i> -->



                                                                <h4 class="font-weight-500 text-extra-dark-gray letter-spacing-minus-2px margin-15px-bottom">$
                                                                    <?php echo $price_streamurl_monthly; ?>
                                                                </h4>

                                                                <p class="margin-5px-bottom">1 Month</p>

                                                                <!-- <ul class="list-style-03">
                                                            <li class="border-color-medium-gray"><span class="text-extra-dark-gray font-weight-500"> </span> Keyword Research</li>
                                                            <li class="border-color-medium-gray"><span class="text-extra-dark-gray font-weight-500"> </span> Meta Details Optimization </li>
                                                            <li class="border-color-medium-gray"><span class="text-extra-dark-gray font-weight-500"> </span> Heading Tag Optimization</li>
                                                            <li class="border-color-medium-gray"><span class="text-extra-dark-gray font-weight-500"> </span> Site Performance Improvement</li>
                                                            <li class="border-color-medium-gray"><span class="text-extra-dark-gray font-weight-500">  </span> Internal Linking </li>
                                                            <li class="border-color-medium-gray"><span class="text-extra-dark-gray font-weight-500"> </span> Content Optimization </li>
                                                            <li class="border-color-medium-gray"><span class="text-extra-dark-gray font-weight-500"> </span> Plagiarism check </li>
                                                            <li class="border-color-medium-gray"><span class="text-extra-dark-gray font-weight-500"> </span>Analytics Integration</li>
                                                            <li class="border-color-medium-gray"><span class="text-extra-dark-gray font-weight-500"> </span>URL Optimization</li>               
                                                            <li><span class="text-extra-dark-gray font-weight-500"></span> Backlink Building</li>
                                                        </ul> -->
                                                            </div>
                                                            <!-- end pricing body -->
                                                            <!-- start pricing footer -->
                                                            <div class="pricing-footer margin-55px-bottom">
                                                                <a class="btn btn-medium btn-transparent-dark-gray btn-round-edge" href="https://portal.casthost.net/cart.php?a=add&pid=284&billingcycle=monthly">Register now</a>
                                                            </div>
                                                            <!-- end pricing footer -->
                                                        </div>
                                                        <!-- end pricing table -->
                                                    </div>
                                                    <div class="col pricing-table-style-02 text-center px-md-0 sm-margin-30px-bottom xs-margin-15px-bottom   animate__fadeInRight" data- -delay="0.4s" style="visibility: visible; animation-delay: 0.4s; animation-name: fadeInRight;">
                                                        <!-- start pricing table -->
                                                        <div class="pricing-table bg-white border-all border-color-medium-gray border-radius-6px">
                                                            <!-- start pricing header -->
                                                            <div class="pricing-header bg-light-gray padding-20px-tb">
                                                                <div class="alt-font font-weight-500 text-small text-extra-dark-gray text-uppercase letter-spacing-minus-1-half">Quarterly</div>
                                                            </div>
                                                            <!-- end pricing header -->
                                                            <!-- start pricing body -->
                                                            <div class="pricing-body padding-40px-tb">
                                                                <h4 class="font-weight-500 text-extra-dark-gray letter-spacing-minus-2px margin-15px-bottom">$
                                                                    <?php echo $price_streamurl_quarterly; ?>
                                                                </h4>

                                                                <p class="margin-5px-bottom">3 Months</p>

                                                                <!-- <ul class="list-style-03">
                                                        <li class="border-color-medium-gray"><span class="text-extra-dark-gray font-weight-500"> </span> Keyword Research</li>
                                                            <li class="border-color-medium-gray"><span class="text-extra-dark-gray font-weight-500"> </span> Meta Details Optimization </li>
                                                            <li class="border-color-medium-gray"><span class="text-extra-dark-gray font-weight-500"> </span> Heading Tag Optimization</li>
                                                            <li class="border-color-medium-gray"><span class="text-extra-dark-gray font-weight-500"> </span> Site Performance Improvement</li>
                                                            <li class="border-color-medium-gray"><span class="text-extra-dark-gray font-weight-500">  </span> Internal Linking </li>
                                                            <li class="border-color-medium-gray"><span class="text-extra-dark-gray font-weight-500"> </span> Content Optimization </li>
                                                            <li class="border-color-medium-gray"><span class="text-extra-dark-gray font-weight-500"> </span> Plagiarism check </li>
                                                            <li class="border-color-medium-gray"><span class="text-extra-dark-gray font-weight-500"> </span>Analytics Integration</li>
                                                            <li class="border-color-medium-gray"><span class="text-extra-dark-gray font-weight-500"> </span>URL Optimization</li>               
                                                            <li><span class="text-extra-dark-gray font-weight-500"></span> Backlink Building</li>
                                                        </ul> -->
                                                            </div>
                                                            <!-- end pricing body -->
                                                            <!-- start pricing footer -->
                                                            <div class="pricing-footer margin-55px-bottom">
                                                                <a class="btn btn-medium btn-transparent-dark-gray btn-round-edge" href="https://portal.casthost.net/cart.php?a=add&pid=284&billingcycle=quarterly">Register now</a>
                                                            </div>
                                                            <!-- end pricing footer -->
                                                        </div>
                                                        <!-- end pricing table -->
                                                    </div>
                                                    <div class="col pricing-table-style-02 text-center px-md-0 sm-margin-30px-bottom xs-margin-15px-bottom   animate__fadeIn z-index-1" style="visibility: visible; animation-name: fadeIn;">
                                                        <!-- start pricing table -->
                                                        <div class="pricing-table pricing-popular bg-white box-shadow-large border-radius-6px">
                                                            <!-- start pricing header -->
                                                            <div class="pricing-header bg-extra-dark-gray padding-20px-tb">
                                                                <div class="alt-font font-weight-500 text-small text-white text-uppercase letter-spacing-minus-1-half">Semi Annually</div>
                                                            </div>
                                                            <!-- end pricing header -->
                                                            <!-- start pricing body -->
                                                            <div class="pricing-body padding-60px-tb">
                                                                <h4 class="font-weight-500 text-extra-dark-gray letter-spacing-minus-2px margin-15px-bottom">$
                                                                    <?php echo $price_streamurl_semiannually; ?>
                                                                </h4>

                                                                <p class="margin-5px-bottom">6 Months</p>

                                                                <!-- <ul class="list-style-03">
                                                        <li class="border-color-medium-gray"><span class="text-extra-dark-gray font-weight-500"> </span> Keyword Research</li>
                                                            <li class="border-color-medium-gray"><span class="text-extra-dark-gray font-weight-500"> </span> Meta Details Optimization </li>
                                                            <li class="border-color-medium-gray"><span class="text-extra-dark-gray font-weight-500"> </span> Heading Tag Optimization</li>
                                                            <li class="border-color-medium-gray"><span class="text-extra-dark-gray font-weight-500"> </span> Site Performance Improvement</li>
                                                            <li class="border-color-medium-gray"><span class="text-extra-dark-gray font-weight-500">  </span> Internal Linking </li>
                                                            <li class="border-color-medium-gray"><span class="text-extra-dark-gray font-weight-500"> </span> Content Optimization </li>
                                                            <li class="border-color-medium-gray"><span class="text-extra-dark-gray font-weight-500"> </span> Plagiarism check </li>
                                                            <li class="border-color-medium-gray"><span class="text-extra-dark-gray font-weight-500"> </span>Analytics Integration</li>
                                                            <li class="border-color-medium-gray"><span class="text-extra-dark-gray font-weight-500"> </span>URL Optimization</li>               
                                                            <li><span class="text-extra-dark-gray font-weight-500"></span> Backlink Building</li>
                                                        </ul> -->
                                                            </div>
                                                            <!-- end pricing body -->
                                                            <!-- start pricing footer -->
                                                            <div class="pricing-footer margin-5px-top margin-55px-bottom">
                                                                <a class="btn btn-medium btn-dark-gray btn-round-edge" href="https://portal.casthost.net/cart.php?a=add&pid=284&billingcycle=semiannually">Register now</a>
                                                            </div>
                                                            <!-- end pricing footer -->
                                                        </div>
                                                        <!-- end pricing table -->
                                                    </div>
                                                    <div class="col pricing-table-style-02 text-center px-md-0   animate__fadeInLeft" data- -delay="0.4s" style="visibility: visible; animation-delay: 0.4s; animation-name: fadeInLeft;">
                                                        <!-- start pricing table -->
                                                        <div class="pricing-table bg-white border-all border-color-medium-gray border-radius-6px">
                                                            <!-- start pricing header -->
                                                            <div class="pricing-header bg-light-gray padding-20px-tb">
                                                                <div class="alt-font font-weight-500 text-small text-extra-dark-gray text-uppercase letter-spacing-minus-1-half">Yearly</div>
                                                            </div>
                                                            <!-- end pricing header -->
                                                            <!-- start pricing body -->
                                                            <div class="pricing-body padding-40px-tb">
                                                                <h4 class="font-weight-500 text-extra-dark-gray letter-spacing-minus-2px margin-15px-bottom">$
                                                                    <?php echo $price_streamurl_annually; ?>
                                                                </h4>

                                                                <p class="margin-5px-bottom">1 Year</p>

                                                                <!-- <ul class="list-style-03">
                                                        <li class="border-color-medium-gray"><span class="text-extra-dark-gray font-weight-500"> </span> Keyword Research</li>
                                                            <li class="border-color-medium-gray"><span class="text-extra-dark-gray font-weight-500"> </span> Meta Details Optimization </li>
                                                            <li class="border-color-medium-gray"><span class="text-extra-dark-gray font-weight-500"> </span> Heading Tag Optimization</li>
                                                            <li class="border-color-medium-gray"><span class="text-extra-dark-gray font-weight-500"> </span> Site Performance Improvement</li>
                                                            <li class="border-color-medium-gray"><span class="text-extra-dark-gray font-weight-500">  </span> Internal Linking </li>
                                                            <li class="border-color-medium-gray"><span class="text-extra-dark-gray font-weight-500"> </span> Content Optimization </li>
                                                            <li class="border-color-medium-gray"><span class="text-extra-dark-gray font-weight-500"> </span> Plagiarism check </li>
                                                            <li class="border-color-medium-gray"><span class="text-extra-dark-gray font-weight-500"> </span>Analytics Integration</li>
                                                            <li class="border-color-medium-gray"><span class="text-extra-dark-gray font-weight-500"> </span>URL Optimization</li>               
                                                            <li><span class="text-extra-dark-gray font-weight-500"></span> Backlink Building</li>
                                                        </ul> -->
                                                            </div>
                                                            <!-- end pricing body -->
                                                            <!-- start pricing footer -->
                                                            <div class="pricing-footer margin-55px-bottom">
                                                                <a class="btn btn-medium btn-transparent-dark-gray btn-round-edge" href="https://portal.casthost.net/cart.php?a=add&pid=284&billingcycle=annually">Register now</a>
                                                            </div>
                                                            <!-- end pricing footer -->
                                                        </div>
                                                        <!-- end pricing table -->
                                                    </div>
                                                </div>
                                            </div>

                                        </div>
                                    </div>

                                </div>
                                <!-- end tab item -->
                            </div>
                        </div>
                    </div>
                </div>
            </section>
            <!-- end section -->


            <!-- start modal pop-up -->
            <div id="provider" class="  zoom-anim-dialog col-lg-6 col-sm-12 mx-auto bg-white text-center white-popup-block padding-4-half-rem-all border-radius-6px sm-padding-2-half-rem-lr mfp-hide">

                <div class="dashboard_selection">

                    <span class="text-extra-dark-gray text-uppercase alt-font text-extra-large font-weight-600 margin-15px-bottom d-block">Please select the Software for your Streaming account </span>
                    <p>Select one of the software</p>
                    <div class="row row-cols-2 row-cols-lg-2 row-cols-md-2 justify-content-center margin-2-rem-bottom">
                        <!-- start feature box item -->
                        <div class="col col-sm-8 md-margin-30px-bottom xs-margin-15px-bottom " style="visibility: visible; animation-name: fadeIn;">

                            <div class=" feature-box feature-box-show-hover box-shadow-large-hover border-radius-6px feature-box-bg-white-hover border-all border-color-medium-gray overflow-hidden last-paragraph-no-margin">
                                <div class="feature-box-move-bottom-top padding-3-rem-all">
                                    <span class="text-fast-blue margin-25px-bottom">
                                        <img src="./images/shoutcast (1).png" alt="CastHost shoutcast hosting services" style="width: 80%;"></span>
                                    <div class="feature-box-content last-paragraph-no-margin pt-3">
                                        <label for="">Select Location</label>
                                        <select name="dashboard_country" onchange="updateURL('shout', this.value)" class="form-control form-control-lg" id="shout_dropdown">
                                            <option value="usa" selected>USA</option>
                                            <option value="canada">Canada</option>
                                        </select>
                                    </div>
                                    <div class="move-bottom-top margin-15px-top">
                                        <a id="shoutcastlink" href="#" class="btn btn-link thin btn-large text-fast-blue">Select Shoutcast</a>
                                    </div>
                                </div>
                            </div>

                        </div>
                        <!-- end feature box item -->
                        <!-- start feature box item -->
                        <div class="col col-sm-8 md-margin-30px-bottom xs-margin-15px-bottom " style="visibility: visible; animation-name: fadeIn;">

                            <div class="feature-box feature-box-show-hover box-shadow-large-hover border-radius-6px feature-box-bg-white-hover border-all border-color-medium-gray overflow-hidden last-paragraph-no-margin">
                                <div class="feature-box-move-bottom-top padding-3-rem-all">
                                    <span class="text-fast-blue margin-25px-bottom">
                                        <img src="./images/icecast.png" alt="icecast server hosting" style="width: 80%;"></span>
                                    <div class="feature-box-content last-paragraph-no-margin pt-3">
                                        <label for="">Select Location</label>
                                        <select onchange="updateURL('ice', this.value)" name="dashboard_country" class="form-control form-control-lg" id="ice_dropdown">

                                            <option value="usa" selected>USA</option>
                                            <option value="canada">Canada</option>
                                        </select>
                                    </div>
                                    <div class="move-bottom-top margin-15px-top">
                                        <a id="icecastlink" href="#" class="btn btn-link thin btn-large text-fast-blue">Select Icecast</a>
                                    </div>
                                </div>
                            </div>

                        </div>
                        <!-- end feature box item -->


                    </div>
                    <a class="btn btn-fancy btn-small btn-transparent-light-gray popup-modal-dismiss" href="#">Dismiss</a>
                    <!-- <a class="btn btn-large btn-fast-blue" href="#">Next <i class="ml-2 fas fa-arrow-right"></i></a> -->

                </div>


                <!-- <a class="btn btn-large btn-fast-blue" href="#">Next <i class="ml-2 fas fa-arrow-right"></i></a> -->
            </div>
            <!-- end modal pop-up -->



            <!-- start section -->
            <section class="parallax one-half-screen md-h-450px sm-h-350px" data-parallax-background-ratio="0.5" style="background: url('./images/webp/banner-section.webp')">
            </section>
            <!-- end section -->

            <!--start section-->
            <section class="big-section bg-light-gray   animate__fadeIn overflow-visible" style="visibility: visible; animation-name: fadeIn;">
                <div class="container">
                    <div class="overlap-section">
                        <div class="z-index-6 bg-white box-shadow-small border-radius-5px padding-60px-tb md-padding-40px-all xs-padding-20px-lr">
                            <div class="row no-gutters align-items-center">
                                <div class="col-12 col-lg-4 offset-lg-1 col-md-6 text-center text-md-left sm-margin-20px-bottom">
                                    <h6 class="alt-font font-weight-500 text-extra-dark-gray w-85 mb-0 lg-w-100">Radio Stream Hosting Made Easy with CastHost! </h6>
                                </div>
                                <div class="col-12 col-xl-3 offset-xl-3 col-lg-4 offset-lg-2 col-md-6 text-center text-md-right">
                                    <a href="#provider" data-link1="https://portal.casthost.net/cart.php?a=add&pid=76&billingcycle=monthly" data-link2="https://portal.casthost.net/cart.php?a=add&pid=75&billingcycle=monthly" class="buynow btn btn-medium btn-round-edge btn-gradient-fast-blue-purple popup-with-form">Start Your Free Trial</a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row justify-content-center   animate__fadeIn" style="visibility: visible; animation-name: fadeIn;">
                        <div class="col-12 col-xl-5 col-lg-6 col-sm-7 text-center margin-5-rem-top  margin-5-rem-bottom md-margin-3-rem-bottom">
                            <span class="alt-font font-weight-500 text-fast-blue text-extra-medium d-block margin-20px-bottom sm-margin-10px-bottom">Our Partners</span>
                            <h5 class="alt-font font-weight-600 text-extra-dark-gray d-inline-block letter-spacing-minus-1-half">We have Partners to meet your needs.</h5>
                        </div>
                    </div>

                    <div class="row row-cols-1 row-cols-lg-5 row-cols-md-3 row-cols-sm-2 justify-content-center client-logo-style-04">
                        <!-- start client item -->
                        <div class="col text-center sm-no-margin   animate__fadeInUp" data- -delay="0.2s" style="visibility: visible; animation-delay: 0.2s; animation-name: fadeInUp;">
                            <div class="client-box padding-25px-all text-center">
                                <a href="#"><img alt="shoutcast streaming hosting" src="images/shoutcast.png" data-no-retina=""></a>
                                <span class="client-overlay bg-white box-shadow-small border-radius-4px"></span>
                            </div>
                        </div>
                        <!-- end client item -->
                        <!-- start client item -->
                        <div class="col text-center sm-no-margin   animate__fadeInUp" data- -delay="0.3s" style="visibility: visible; animation-delay: 0.3s; animation-name: fadeInUp;">
                            <div class="client-box padding-25px-all text-center">
                                <a href="#"><img alt="icecast server hosting" src="images/icecast.png" data-no-retina=""></a>
                                <span class="client-overlay bg-white box-shadow-small border-radius-4px"></span>
                            </div>
                        </div>
                        <!-- end client item -->
                        <!-- start client item -->
                        <div class="col text-center sm-no-margin   animate__fadeInUp" data- -delay="0.4s" style="visibility: visible; animation-delay: 0.4s; animation-name: fadeInUp;">
                            <div class="client-box padding-25px-all text-center">
                                <a href="#"><img alt="shoutcast icecast" src="images/centova.png" data-no-retina=""></a>
                                <span class="client-overlay bg-white box-shadow-small border-radius-4px"></span>
                            </div>
                        </div>
                        <!-- end client item -->
                    </div>
                </div>
            </section>
            <!--end section-->


            <?php include('form.php'); ?>

        </div>
    <?php } ?>

    <!-- start footer -->
    <?php include('footer.php'); ?>
    <!-- end footer -->
</body>

</html>