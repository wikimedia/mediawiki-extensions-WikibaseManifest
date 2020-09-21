<?php

namespace WikibaseManifest\Test;

use InvalidArgumentException;
use MediaWiki\Extension\WikibaseManifest\EntityNamespaces;
use PHPUnit\Framework\TestCase;

class EntityNamespacesTest extends TestCase {

	public function dataProvider() {
		return [
			[ true, [ 'foo' => [ 'namespace_id' => 1, 'namespace_string' => '' ] ] ],
			[ true, [ 'foo' => [ 'namespace_id' => 120, 'namespace_string' => 'Foo' ] ] ],
			[ false, [ 'foo' => [] ] ],
			[ false, [ 'foo' => 123 ] ],
			[ false, [ 'foo' => [ 'namespace_id' => 1 ] ] ],
			[ false, [ 'foo' => [ 'namespace_id' => 'foo', 'namespace_string' => '' ] ] ],
			[ false, [ 'foo' => [ 'namespace_id' => 1, 'namespace_string' => 123 ] ] ],
		];
	}

	/**
	 * @dataProvider dataProvider
	 */
	public function test( $expectedSuccess, $mapping ) {
		if ( !$expectedSuccess ) {
			$this->expectException( InvalidArgumentException::class );
		}
		$value = new EntityNamespaces( $mapping );
		$this->assertEquals( $mapping, $value->toArray() );
	}
}
