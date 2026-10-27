<?php
/**
 * Local pattern composition support. Requires PHP 8.0+; no WordPress runtime.
 * Compositions call Snaps\pattern() with the parameters documented in each file.
 */
namespace Snaps;

function pattern( string $name, array $parameters ): void {
	$patterns = [ 'post', 'section-single', 'section-two', 'heading', 'paragraph', 'image', 'gallery', 'list', 'video' ];
	if ( ! in_array( $name, $patterns, true ) ) {
		throw new \InvalidArgumentException( "Unknown pattern: $name" );
	}
	// Each include has its own scope; caller parameters cannot override its path.
	( static function ( string $file, array $parameters ): void {
		extract( $parameters, EXTR_SKIP );
		require $file;
	} )( __DIR__ . "/$name.php", $parameters );
	echo "\n";
}

function text( string $value ): string {
	return htmlspecialchars( $value, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8' );
}

function url( string $value ): string {
	if ( ! filter_var( $value, FILTER_VALIDATE_URL ) || ! in_array( strtolower( parse_url( $value, PHP_URL_SCHEME ) ?? '' ), [ 'http', 'https' ], true ) ) {
		throw new \InvalidArgumentException( "Expected an HTTP(S) media URL: $value" );
	}
	return text( $value );
}
