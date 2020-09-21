const { assert, REST } = require( 'api-testing' );

describe( 'Manifest', () => {
	const client = new REST( 'rest.php/wikibase/manifest/v0' );

	describe( 'GET /manifest', () => {
		it( 'should return the manifest', async () => {
			const { body } = await client.get( '/manifest' );
			assert.hasAllKeys(
				body,
				[ 'name', 'api', 'root_script_url', 'equiv_entities', 'local_rdf_namespaces', 'external_services', 'entity_sources' ]
			);
			assert.typeOf( body.name, 'string' );
			assert.typeOf( body.api, 'object' );
			assert.typeOf( body.root_script_url, 'string' );
			assert.typeOf( body.equiv_entities, 'object' );
			assert.typeOf( body.local_rdf_namespaces, 'object' );
			assert.typeOf( body.external_services, 'object' );
			assert.typeOf( body.entity_sources, 'object' );
		} );
	} );
} );
