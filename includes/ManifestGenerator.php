<?php

namespace MediaWiki\Extension\WikibaseManifest;

use Config;

class ManifestGenerator {

	public const NAME = 'name';
	public const ROOT_SCRIPT_URL = 'root_script_url';
	public const API = 'api';
	public const API_ACTION = 'action';
	public const API_REST = 'rest';
	public const EQUIV_ENTITIES = 'equiv_entities';
	public const WIKIDATA_ORG = 'wikidata.org';
	public const LOCAL_RDF_NAMESPACES = 'local_rdf_namespaces';
	public const EXTERNAL_SERVICES = 'external_services';
	public const ENTITY_SOURCES = 'entity_sources';

	private $config;
	private $equivEntitiesFactory;
	private $conceptNamespaces;
	private $externalServicesFactory;
	private $entityNamespacesFactory;

	public function __construct(
		Config $config,
		EquivEntitiesFactory $equivEntitiesFactory,
		ConceptNamespaces $conceptNamespaces,
		ExternalServicesFactory $externalServicesFactory,
		EntityNamespacesFactory $entityNamespacesFactory
	) {
		$this->config = $config;
		$this->equivEntitiesFactory = $equivEntitiesFactory;
		$this->conceptNamespaces = $conceptNamespaces;
		$this->externalServicesFactory = $externalServicesFactory;
		$this->entityNamespacesFactory = $entityNamespacesFactory;
	}

	public function generate(): array {
		$config = $this->config;

		$localRdfNamespaces = $this->conceptNamespaces->getLocal();
		$externalServices = $this->externalServicesFactory->getExternalServices();
		// TODO perhaps we should only add keys to this result when the values are not empty
		return [
			self::NAME => $config->get( 'Sitename' ),
			self::ROOT_SCRIPT_URL => $config->get( 'Server' ) . $config->get( 'ScriptPath' ),
			self::API => [
				self::API_ACTION => $config->get( 'Server' ) . $config->get( 'ScriptPath' ) . '/api.php',
				self::API_REST => $config->get( 'Server' ) . $config->get( 'ScriptPath' ) . '/rest.php'
			],
			self::EQUIV_ENTITIES => [
				self::WIKIDATA_ORG => $this->equivEntitiesFactory->getEquivEntities()->toArray()
			],
			self::LOCAL_RDF_NAMESPACES => $localRdfNamespaces,
			self::EXTERNAL_SERVICES => $externalServices->toArray(),
			self::ENTITY_SOURCES => $this->entityNamespacesFactory->getEntityNamespaces()->toArray()
		];
	}

}
