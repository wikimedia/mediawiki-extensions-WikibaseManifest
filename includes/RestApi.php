<?php

namespace MediaWiki\Extension\WikibaseManifest;

use MediaWiki\Rest\SimpleHandler;

class RestApi extends SimpleHandler {
	private $generator;
	private $emptyArrayCleaner;
	private $emptyValueCleaner;

	public function __construct(
		ManifestGenerator $generator,
		EmptyArrayCleaner $emptyArrayCleaner,
		EmptyValueCleaner $emptyValueCleaner
	) {
		$this->generator = $generator;
		$this->emptyArrayCleaner = $emptyArrayCleaner;
		$this->emptyValueCleaner = $emptyValueCleaner;
	}

	public function run() {
		$output = $this->generator->generate();
		return $this->emptyArrayCleaner->clean( $this->emptyValueCleaner->omitEmptyValues( $output ) );
	}
}
