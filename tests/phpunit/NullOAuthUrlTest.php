<?php

namespace MediaWiki\Extension\WikibaseManifest;

use PHPUnit\Framework\TestCase;

/**
 * @covers \MediaWiki\Extension\WikibaseManifest\NullOAuthUrl
 */
class NullOAuthUrlTest extends TestCase {

	public function testGetValue() {
		$OAuthUrl = new NullOAuthUrl();
		$this->assertNull( $OAuthUrl->getValue() );
	}
}
