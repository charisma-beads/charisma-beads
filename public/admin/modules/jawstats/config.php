<?php

  // core config parameters
  $sDefaultLanguage      = "en-gb";
  $sConfigDefaultView    = "thismonth.all";
  $bConfigChangeSites    = true;
  $bConfigUpdateSites    = true;
  $sUpdateSiteFilename   = "xml_update.php";

  // individual site configuration
  $aConfig["charismabeads.co.uk-http"] = array(
    "statspath"   => "../../../../stats/",
    "updatepath"  => "/../../../cgi-bin/awstats.pl",
    "siteurl"     => "http://www.charismabeads.co.uk",
    "sitename"    => "charismabeads.co.uk",
    "theme"       => "default",
    "fadespeed"   => 250,
    "password"    => "gr82bead",
    "includes"    => "",
    "language"    => "en-gb"
  );
?>
