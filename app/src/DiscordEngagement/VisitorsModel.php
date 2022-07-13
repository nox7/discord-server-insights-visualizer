<?php

	namespace DiscordEngagement;

	use Nox\ORM\Attributes\Model;
	use Nox\ORM\ColumnDefinition;
	use Nox\ORM\Interfaces\MySQLModelInterface;
	use Nox\ORM\MySQLDataTypes\FloatValue;
	use Nox\ORM\MySQLDataTypes\Integer;
	use Nox\ORM\MySQLDataTypes\VariableCharacter;

	#[Model]
	class VisitorsModel implements MySQLModelInterface {

		/**
		 * The name of the database this table belongs to
		 */
		private string $mysqlDatabaseName = \NoxEnv::MYSQL_DB_NAME;

		/**
		 * The name of this Model in the MySQL database as a table
		 */
		private string $mysqlTableName = "visitors";

		/**
		 * The string name of the class this model represents and can instantiate
		 */
		private string $representingClassName = Visitors::class;

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
					name:"visitors",
					classPropertyName: "visitors",
					dataType : new Integer(),
					defaultValue: null,
					isNull:true,
				),
				new ColumnDefinition(
					name:"percent_communicated",
					classPropertyName: "percentCommunicated",
					dataType : new FloatValue(),
					defaultValue: null,
					isNull:true,
				),
			];
		}
	}
