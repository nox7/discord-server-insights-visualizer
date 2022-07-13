<?php

	namespace DiscordEngagement;

	use Nox\ORM\Interfaces\ModelInstance;
	use Nox\ORM\Interfaces\MySQLModelInterface;
	use Nox\ORM\ModelClass;

	class MessageActivity extends ModelClass implements ModelInstance
	{
		public ?int $dayStartTimestamp = null;
		public ?int $messages;
		public ?int $messagesPerCommunicator;

		public static function getModel(): MySQLModelInterface{
			return new MessageActivityModel();
		}

		public function __construct(){
			parent::__construct($this);
		}
	}