<?php

	namespace DiscordEngagement;

	use Nox\Http\Attributes\ProcessRequestBody;
	use Nox\Http\Attributes\UseJSON;
	use Nox\Http\JSON\JSONResult;
	use Nox\Http\JSON\JSONSuccess;
	use Nox\Router\Attributes\Controller;
	use Nox\Router\Attributes\Route;
	use Nox\Router\Attributes\RouteBase;
	use Nox\Router\BaseController;

	#[Controller]
	#[RouteBase("/discord-engagements")]
	class DiscordEngagementController extends BaseController{

		#[Route("GET", "/message-activity")]
		#[UseJSON]
		public function getMessageActivity(): JSONResult{
			$startDate = $_GET['start-date'] ?? null;
			$endDate = $_GET['end-date'] ?? null;
			$compareToPreviousPeriod = isset($_GET['compare-previous-period']);

			$messageActivityResults = DiscordEngagementService::getMessageActivity(
				startDate: $startDate,
				endDate:$endDate,
				compareToPreviousPeriod:$compareToPreviousPeriod,
			);

			return new JSONSuccess([
				"messageActivity"=>$messageActivityResults->currentPeriod,
				"messageActivityLastPeriod"=>$messageActivityResults->previousPeriod,
			]);
		}

		#[Route("GET", "/visitors")]
		#[UseJSON]
		public function getVisitors(): JSONResult{
			$startDate = $_GET['start-date'] ?? null;
			$endDate = $_GET['end-date'] ?? null;
			$compareToPreviousPeriod = isset($_GET['compare-previous-period']);

			$visitorsResults = DiscordEngagementService::getVisitors(
				startDate: $startDate,
				endDate:$endDate,
				compareToPreviousPeriod:$compareToPreviousPeriod,
			);

			return new JSONSuccess([
				"visitors"=>$visitorsResults->currentPeriod,
				"visitorsLastPeriod"=>$visitorsResults->previousPeriod,
			]);
		}
	}