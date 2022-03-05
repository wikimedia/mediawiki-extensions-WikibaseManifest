<?php

namespace WikibaseManifest\Test;

use ExtensionRegistry;
use MediaWiki\Extension\OAuth\Frontend\SpecialPages\SpecialMWOAuthConsumerRegistration;
use MediaWiki\Extension\WikibaseManifest\SpecialPageOAuthUrl;
use MediaWikiIntegrationTestCase;
use WikiMap;

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
		$specialPage = new SpecialMWOAuthConsumerRegistration(
			$this->getServiceContainer()->getGrantsInfo(),
			$this->getServiceContainer()->getGrantsLocalization()
		);
		$OAuthUrl = new SpecialPageOAuthUrl( $specialPage );
		$this->assertStringEndsWith( 'Special:OAuthConsumerRegistration', $OAuthUrl->getValue() );
	}

	private function mockThisWikiToBeAnOAuthCentralWiki(): void {
		$this->setMwGlobals(
			[
				'wgMWOAuthCentralWiki' => WikiMap::getCurrentWikiId(),
			]
		);
	}
}
