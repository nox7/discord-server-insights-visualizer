<?php

	namespace DiscordEngagement;

	use Nox\ORM\Interfaces\ModelInstance;
	use Nox\ORM\Interfaces\MySQLModelInterface;
	use Nox\ORM\ModelClass;

	class Visitors extends ModelClass implements ModelInstance
	{
		public ?int $dayStartTimestamp = null;
		public ?int $visitors;
		public ?float $percentCommunicated;

		public static function getModel(): MySQLModelInterface{
			return new VisitorsModel();
		}

		public function __construct(){
			parent::__construct($this);
		}
	}