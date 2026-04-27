<?php

namespace coursely\App\Core\Setup;

class FilesModSetup
{
	public function initialize(): void
	{
		add_filter( 'file_mod_allowed', [$this, 'allow_file_mod_for_certain_ops'], 10, 2 );
	}

	public function allow_file_mod_for_certain_ops( $allow_file_mod, $context ): bool
	{
		if ($context === 'object_cache_dropin') {
			return true;
		}

		return $allow_file_mod;
	}
}
