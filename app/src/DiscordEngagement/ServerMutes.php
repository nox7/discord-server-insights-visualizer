<?php

	namespace DiscordEngagement;

	use Nox\ORM\Interfaces\ModelInstance;
	use Nox\ORM\Interfaces\MySQLModelInterface;
	use Nox\ORM\ModelClass;

	class ServerMutes extends ModelClass implements ModelInstance
	{
		public ?int $dayStartTimestamp = null;
		public ?int $newMemberMutes;
		public ?float $existingMemberMutes;

		public static function getModel(): MySQLModelInterface{
			return new ServerMutesModel();
		}

		public function __construct(){
			parent::__construct($this);
		}
	}