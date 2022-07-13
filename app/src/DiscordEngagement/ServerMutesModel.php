<?php

	namespace DiscordEngagement;

	use Nox\ORM\Attributes\Model;
	use Nox\ORM\ColumnDefinition;
	use Nox\ORM\Interfaces\MySQLModelInterface;
	use Nox\ORM\MySQLDataTypes\FloatValue;
	use Nox\ORM\MySQLDataTypes\Integer;
	use Nox\ORM\MySQLDataTypes\VariableCharacter;

	#[Model]
	class ServerMutesModel implements MySQLModelInterface {

		/**
		 * The name of the database this table belongs to
		 */
		private string $mysqlDatabaseName = \NoxEnv::MYSQL_DB_NAME;

		/**
		 * The name of this Model in the MySQL database as a table
		 */
		private string $mysqlTableName = "server_mutes";

		/**
		 * The string name of the class this model represents and can instantiate
		 */
		private string $representingClassName = ServerMutes::class;

		public function getDatabaseName(): string{
			return $this->mysqlDatabaseName;
		}

		public function getName(): string{
			return $this->mysqlTableName;
		}

		public function getInstanceName(): string{
			return $this->representingClassName;
		}

		public function getColumns(): array{
			return [
				new ColumnDefinition(
					name:"day_start_timestamp",
					classPropertyName: "dayStartTimestamp",
					dataType : new Integer(),
					defaultValue: 0,
					isPrimary: true,
					isNull:false,
				),
				new ColumnDefinition(
					name:"new_member_mutes",
					classPropertyName: "newMemberMutes",
					dataType : new Integer(),
					defaultValue: null,
					isNull:true,
				),
				new ColumnDefinition(
					name:"existing_member_mutes",
					classPropertyName: "existingMemberMutes",
					dataType : new Integer(),
					defaultValue: null,
					isNull:true,
				),
			];
		}
	}
