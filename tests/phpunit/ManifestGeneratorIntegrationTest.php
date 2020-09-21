<?php

namespace WikibaseManifest\Test;

use MediaWiki\MediaWikiServices;
use MediaWikiTestCase;

class ManifestGeneratorIntegrationTest extends MediaWikiTestCase {

	private const NAME = 'name';
	private const ROOT_SCRIPT_URL = 'root_script_url';
	private const EQUIV_ENTITIES = 'equiv_entities';
	private const LOCAL_RDF_NAMESPACES = 'local_rdf_namespaces';
	private const EXTERNAL_SERVICES = 'external_services';
	private const ENTITY_SOURCES = 'entity_sources';

	public function testGenerate() {
		$siteString = 'manifestsite';
		$serverString = 'http://cat/dog';
		$scriptString = '/wikipath';
		$rootScriptUrlString = $serverString . $scriptString;
		$equivEntities = [ 'P1' => 'P2' ];
		$externalServices = [ 'quickstatements' => 'http://quickstatements.net' ];
		$this->setMwGlobals(
			[
			'wgServer' => $serverString,
			'wgSitename' => $siteString,
			'wgScriptPath' => $scriptString,
			'wgWbManifestWikidataEntityMapping' => $equivEntities,
			'wgWbManifestExternalServiceMapping' => $externalServices,
			]
		);
		$this->mergeMwGlobalArrayValue( 'wgWBRepoSettings', [ 'sparqlEndpoint' => null ] );
		$generator = MediaWikiServices::getInstance()->getService( 'WikibaseManifestGenerator' );
		$result = $generator->generate();

		$this->assertArrayHasKey( self::NAME, $result );
		$this->assertIsString( $result[self::NAME] );
		$this->assertEquals( $siteString, $result[self::NAME] );

		$this->assertArrayHasKey( self::ROOT_SCRIPT_URL, $result );
		$this->assertIsString( $result[self::ROOT_SCRIPT_URL] );
		$this->assertEquals( $rootScriptUrlString, $result[self::ROOT_SCRIPT_URL] );

		$this->assertArrayHasKey( self::EQUIV_ENTITIES, $result );
		$this->assertIsArray( $result[self::EQUIV_ENTITIES] );
		$this->assertArrayHasKey( 'wikidata.org', $result[self::EQUIV_ENTITIES] );
		$this->assertIsArray( $result[self::EQUIV_ENTITIES]['wikidata.org'] );
		$this->assertArrayEquals( $equivEntities, $result[self::EQUIV_ENTITIES]['wikidata.org'] );

		$this->assertArrayHasKey( self::EXTERNAL_SERVICES, $result );
		$this->assertIsArray( $result[self::EXTERNAL_SERVICES] );
		$this->assertArrayEquals( $externalServices, $result[self::EXTERNAL_SERVICES] );

		$this->assertArrayHasKey( self::LOCAL_RDF_NAMESPACES, $result );
		$this->assertIsArray( $result[self::LOCAL_RDF_NAMESPACES] );
		$rdfKeys = [
			"",
			"data",
			"s",
			"ref",
			"v",
			"t",
			"tn",
			"p",
			"ps",
			"psv",
			"psn",
			"pq",
			"pqv",
			"pqn",
			"pr",
			"prv",
			"prn",
			"no",
		];
		foreach ( $rdfKeys as $key ) {
			$this->assertArrayHasKey( $key, $result[self::LOCAL_RDF_NAMESPACES] );
		}

		$this->assertArrayHasKey( self::ENTITY_SOURCES, $result );
		$this->assertIsArray( $result[self::ENTITY_SOURCES] );
		$this->assertArrayHasKey( 'item', $result[self::ENTITY_SOURCES] );
		$this->assertArrayHasKey( 'property', $result[self::ENTITY_SOURCES] );
	}
}
