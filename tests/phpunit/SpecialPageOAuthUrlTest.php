<?php

namespace WikibaseManifest\Test;

use ExtensionRegistry;
use MediaWiki\Extension\OAuth\Frontend\SpecialPages\SpecialMWOAuthConsumerRegistration;
use MediaWiki\Extension\WikibaseManifest\SpecialPageOAuthUrl;
use MediaWiki\WikiMap\WikiMap;
use MediaWikiIntegrationTestCase;

/**
 * @covers \MediaWiki\Extension\WikibaseManifest\SpecialPageOAuthUrl
 */
class SpecialPageOAuthUrlTest extends MediaWikiIntegrationTestCase {

	public function testGetValue() {
		if ( !ExtensionRegistry::getInstance()->isLoaded(
			'OAuth' ) ) {
			$this->markTestSkipped( 'OAuth is not enabled' );
		}
		$this->mockThisWikiToBeAnOAuthCentralWiki();
		$services = $this->getServiceContainer();
		$specialPage = new SpecialMWOAuthConsumerRegistration(
			$services->getPermissionManager(),
			$services->getGrantsInfo(),
			$services->getGrantsLocalization(),
			$services->getUrlUtils(),
		);
		$OAuthUrl = new SpecialPageOAuthUrl(
			$services->getMainConfig(),
			$specialPage
		);
		$this->assertStringEndsWith( 'Special:OAuthConsumerRegistration', $OAuthUrl->getValue() );
	}

	private function mockThisWikiToBeAnOAuthCentralWiki(): void {
		$this->overrideConfigValues( [
			'MWOAuthCentralWiki' => WikiMap::getCurrentWikiId(),
		] );
	}
}
