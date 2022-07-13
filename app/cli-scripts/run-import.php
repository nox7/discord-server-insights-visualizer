<?php

	// Code was made before using Nox library.
	// So doesn't use the OOP classes for ORM

	// Run this file from the CLI

	use Nox\ORM\Abyss;
	use Nox\ORM\DatabaseCredentials;

	if (php_sapi_name() !== "cli"){
		print("This file must be ran from the CLI.");
		return;
	}

	require_once __DIR__ . "/../../vendor/autoload.php";
	require_once __DIR__ . "/../nox-env.php";

	$exports = __DIR__ . "/../resources/insights-exports";
	$insightFolders = array_diff(scandir($exports), ['.','..']);
	$csvFileNames = [
		"guild-communicators.csv",
		"guild-message-activity.csv",
		"guild-muters.csv",
	];

	// Database credentials for Abyss ORM
	Abyss::addCredentials(new DatabaseCredentials(
		host: NoxEnv::MYSQL_HOST,
		username: NoxEnv::MYSQL_USERNAME,
		password: NoxEnv::MYSQL_PASSWORD,
		database: NoxEnv::MYSQL_DB_NAME,
		port: NoxEnv::MYSQL_PORT,
	));

	$abyss = new Abyss();
	$mysqli = $abyss->getConnectionToDatabase(
		databaseName: NoxEnv::MYSQL_DB_NAME,
	);

	// Iterate the folders
	foreach($insightFolders as $directoryName){
		$directoryPath = realpath(sprintf("%s/%s", $exports, $directoryName));
		if (is_dir($directoryPath)){

			// Handle communicators
			$communicatorFile = sprintf("%s/%s", $directoryPath, $csvFileNames[0]);
			$handle = fopen($communicatorFile, "r");
			fgetcsv($handle); // Read first row, headlines
			while($row = fgetcsv($handle)){
				$timestamp = strtotime($row[0]);
				$visitors = $row[1];
				$percentCommunicated = $row[2];
				try{
					$statement = $mysqli->prepare("
						INSERT INTO `visitors`
						(day_start_timestamp, visitors, percent_communicated)
						VALUES
						(?,?,?)
					");
					$statement->bind_param("iid", $timestamp, $visitors, $percentCommunicated);
					$statement->execute();
				}catch(mysqli_sql_exception $e){
					print($e);
				}
			}

			// Handle message activity
			$msgActivityFile = sprintf("%s/%s", $directoryPath, $csvFileNames[1]);
			$handle = fopen($msgActivityFile, "r");
			fgetcsv($handle); // Read first row, headlines
			while($row = fgetcsv($handle)){
				$timestamp = strtotime($row[0]);
				$messages = $row[1];
				$messagePerCommunicator = $row[2];
				try{
					$statement = $mysqli->prepare("
						INSERT INTO `message_activity`
						(day_start_timestamp, messages, messages_per_communicator)
						VALUES
						(?,?,?)
					");
					$statement->bind_param("iid", $timestamp, $messages, $messagePerCommunicator);
					$statement->execute();
				}catch(mysqli_sql_exception $e){
					print($e);
				}
			}

			// Handle server mutes
			$serverMutesFile = sprintf("%s/%s", $directoryPath, $csvFileNames[2]);
			$handle = fopen($serverMutesFile, "r");
			fgetcsv($handle); // Read first row, headlines
			while($row = fgetcsv($handle)){
				$secondRow = fgetcsv($handle); // Read the second row, which is "existing members"
				if ($secondRow) {
					$timestamp = strtotime($row[0]);
					$newMemberMutes = $row[2];
					$existingMemberMutes = $secondRow[2];
					try {
						$statement = $mysqli->prepare("
							INSERT INTO `server_mutes`
							(day_start_timestamp, new_member_mutes, existing_member_mutes)
							VALUES
							(?,?,?)
						");
						$statement->bind_param("iid", $timestamp, $newMemberMutes, $existingMemberMutes);
						$statement->execute();
					} catch (mysqli_sql_exception $e) {
						print($e);
					}
				}
			}

		}
	}
