<?php
	// include i18n class and initialize it
	require_once 'i18n.class.php';
	$i18n = new i18n('lang/{LANGUAGE}.json', 'langcache/', 'en');
    $i18n->setForcedLang('en');
	$i18n->init();
?>

<!-- get applied language -->
<p>Applied Language: <?php echo $i18n->getAppliedLang(); ?> </p>

<!-- get the cache path -->
<p>Cache path: <?php echo $i18n->getCachePath(); ?></p>

<!-- Get some greetings -->
<p>A greeting: <?=TRANS::L1; ?></p>
<p>Something other: <?=TRANS::L2; ?></p><!-- normally sections in the ini are seperated with an underscore like here. -->