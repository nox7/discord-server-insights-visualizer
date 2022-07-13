<?php

	namespace DiscordEngagement;

	use Nox\ORM\ColumnQuery;

	class DiscordEngagementService{

		public static function getMessageActivity(
			string $startDate,
			string $endDate,
			bool $compareToPreviousPeriod,
		): MessageActivityResults{
			$startDateTime = \DateTimeImmutable::createFromFormat("Y-m-d", $startDate);
			$endDateTime = \DateTimeImmutable::createFromFormat("Y-m-d", $endDate);

			$result = new MessageActivityResults();

			/** @var MessageActivity[] $messageActivites */
			$result->currentPeriod = MessageActivity::query(
				columnQuery: (new ColumnQuery())
					->where("day_start_timestamp",">=",$startDateTime->getTimestamp())
					->and()
					->where("day_start_timestamp","<=",$endDateTime->getTimestamp())
			);

			if ($compareToPreviousPeriod){
				// Get the previous period by finding the difference between the start date time and the end date time
				// Then using those new DateTimes to get the previous period
				//$difference = $startDateTime->diff($endDateTime);

				// Update, just subtract a year
				$yearDifference = new \DateInterval("P1Y");
				$previousPeriodStartDateTime = $startDateTime->sub($yearDifference);
				$previousPeriodEndDateTime = $endDateTime->sub($yearDifference);

				/** @var MessageActivity[] $messageActivites */
				$result->previousPeriod = MessageActivity::query(
					columnQuery: (new ColumnQuery())
						->where("day_start_timestamp",">=",$previousPeriodStartDateTime->getTimestamp())
						->and()
						->where("day_start_timestamp","<=",$previousPeriodEndDateTime->getTimestamp())
				);
			}

			return $result;
		}

		public static function getVisitors(
			string $startDate,
			string $endDate,
			bool $compareToPreviousPeriod,
		): MessageActivityResults{
			$startDateTime = \DateTimeImmutable::createFromFormat("Y-m-d", $startDate);
			$endDateTime = \DateTimeImmutable::createFromFormat("Y-m-d", $endDate);

			$result = new MessageActivityResults();

			/** @var Visitors[] $visitors */
			$result->currentPeriod = Visitors::query(
				columnQuery: (new ColumnQuery())
					->where("day_start_timestamp",">=",$startDateTime->getTimestamp())
					->and()
					->where("day_start_timestamp","<=",$endDateTime->getTimestamp())
			);

			if ($compareToPreviousPeriod){
				$yearDifference = new \DateInterval("P1Y");
				$previousPeriodStartDateTime = $startDateTime->sub($yearDifference);
				$previousPeriodEndDateTime = $endDateTime->sub($yearDifference);

				/** @var Visitors[] $visitors */
				$result->previousPeriod = Visitors::query(
					columnQuery: (new ColumnQuery())
						->where("day_start_timestamp",">=",$previousPeriodStartDateTime->getTimestamp())
						->and()
						->where("day_start_timestamp","<=",$previousPeriodEndDateTime->getTimestamp())
				);
			}

			return $result;
		}
	}