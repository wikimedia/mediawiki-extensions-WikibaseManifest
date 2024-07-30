<?php

namespace MediaWiki\Extension\WikibaseManifest;

use Config;
use MediaWiki\Extension\OAuth\Backend\Utils;
use MediaWiki\Extension\OAuth\Frontend\SpecialPages\SpecialMWOAuthConsumerRegistration;
use MediaWiki\WikiMap\WikiMap;

class SpecialPageOAuthUrl implements OAuthUrl {

	private Config $config;
	private $specialPage;

	public function __construct(
		Config $config,
		?SpecialMWOAuthConsumerRegistration $specialPage = null
	) {
		$this->config = $config;
		$this->specialPage = $specialPage;
	}

	public function getValue(): string {
		if ( Utils::isCentralWiki() ) {
			return $this->specialPage->getPageTitle()->getFullURL();
		}
		return WikiMap::getForeignURL(
			$this->config->get( 'MWOAuthCentralWiki' ),
			'Special:OAuthConsumerRegistration'
		);
	}
}
