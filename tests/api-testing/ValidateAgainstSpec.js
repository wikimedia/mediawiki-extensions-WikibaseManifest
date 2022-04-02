'use strict';

// allow chai expectations
/* eslint-disable no-unused-expressions */
const chai = require( 'chai' );
const expect = chai.expect;

const { REST } = require( 'api-testing' );
const swaggerCombine = require( 'swagger-combine' );
const chaiResponseValidator = require( 'chai-openapi-response-validator' );
const baseURL = 'rest.php/wikibase-manifest/v0';

describe( 'Manifest', () => {
	const client = new REST( baseURL );

	describe( 'GET /manifest', function () {
		it( 'should return status code 200', async function () {
			const response = await client.get( '/manifest' );
			expect( response.status ).to.equal( 200 );
		} );

		it( 'should satisfy the OpenAPI spec', async function () {
			const response = await client.get( '/manifest' );

			// read openapi spec file and combine with referenced schemas
			const spec = await swaggerCombine( './openapi.json' );
			// sneak the CI server into the 'servers' section of the spec
			spec.servers.push(
				{
					// get the server's URL from api-testing REST client
					url: response.request.app + baseURL,
					description: 'Dynamically added CI test system'
				}
			);

			chai.use( chaiResponseValidator( spec ) );
			expect( response ).to.satisfyApiSpec;
		} );
	} );
} );
