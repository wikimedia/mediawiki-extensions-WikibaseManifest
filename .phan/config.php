<?php

$cfg = require __DIR__ . '/../vendor/mediawiki/mediawiki-phan-config/src/config.php';

$cfg['directory_list'] = array_merge(
	$cfg['directory_list'],
	[
		'../../extensions/Scribunto',
		'../../extensions/Wikibase/client',
		'../../extensions/Wikibase/data-access',
		'../../extensions/Wikibase/lib',
		'../../extensions/Wikibase/repo',
		'../../extensions/Wikibase/view',
		'.phan/stubs',
	]
);

$cfg['exclude_analysis_directory_list'] = array_merge(
	$cfg['exclude_analysis_directory_list'],
	[
		'../../extensions/Scribunto',
		'../../extensions/Wikibase/client',
		'../../extensions/Wikibase/data-access',
		'../../extensions/Wikibase/lib',
		'../../extensions/Wikibase/repo',
		'../../extensions/Wikibase/view',
		'.phan/stubs',
	]
);

return $cfg;
