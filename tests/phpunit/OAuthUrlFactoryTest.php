<?php

namespace MediaWiki\Extension\WikibaseManifest;

use Config;
use ExtensionRegistry;
use MediaWiki\Extension\OAuth\Frontend\SpecialPages\SpecialMWOAuthConsumerRegistration;
use MediaWiki\SpecialPage\SpecialPageFactory;
use PHPUnit\Framework\TestCase;

/**
 * @covers \MediaWiki\Extension\WikibaseManifest\OAuthUrlFactory
 */
class OAuthUrlFactoryTest extends TestCase {

	public function testGetOAuthUrl_returnsNullOAuthIfExtensionMissing() {
		$config = $this->createMock( Config::class );
		$extensionRegistry = $this->createMock( ExtensionRegistry::class );
		$specialPageFactory = $this->createMock( SpecialPageFactory::class );
		$OAuthUrlFactory = new OAuthUrlFactory( $config, $extensionRegistry, $specialPageFactory );
		$this->assertInstanceOf( NullOAuthUrl::class, $OAuthUrlFactory->getOAuthUrl() );
	}

	public function testGetOAuthUrl_returnsSpecialPageOAuthIfPresent() {
		$config = $this->createMock( Config::class );
		$extensionRegistry = $this->createMock( ExtensionRegistry::class );
		$specialPageFactory = $this->createMock( SpecialPageFactory::class );
		$mockSpecialPage = $this->createMock( SpecialMWOAuthConsumerRegistration::class );
		$specialPageFactory->expects( $this->atLeastOnce() )
			->method( 'getPage' )->willReturn( $mockSpecialPage );
		$extensionRegistry->expects( $this->atLeastOnce() )
			->method( 'isLoaded' )->willReturn( true );
		$OAuthUrlFactory = new OAuthUrlFactory( $config, $extensionRegistry, $specialPageFactory );
		$this->assertInstanceOf( SpecialPageOAuthUrl::class, $OAuthUrlFactory->getOAuthUrl() );
	}
}
