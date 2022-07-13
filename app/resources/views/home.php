<?php
	$today = new DateTime("now");
	$defaultStartInterval = new DateInterval("P30D");
	$defaultEndDate = $today->format("o-m-d");
	$defaultStartDate = $today->sub($defaultStartInterval)->format("o-m-d");
?>
@Layout = "base.php"
@Head{
	<title>Server Insights Viewer</title>
	<script type="module" src="/js/home/Home.js"></script>
	<script src="https://cdn.jsdelivr.net/npm/chart.js@3.8.0/dist/chart.min.js"></script>
}
@Body{
	<header>
		<h1>Server Insights</h1>
	</header>
	<main>
		<div id="insights-main-content">
			<div class="card mb-3">
				<div class="card-header">
					<h4 class="mb-0">Date Selection</h4>
				</div>
				<div class="card-body">
					<form id="date-selection-form">
						<div class="container-fluid p-0">
							<div class="row align-items-center">
								<div class="col-xl-4">
									<div class="input-group">
										<div class="input-group-text">
											Start Date
										</div>
										<input class="form-control" type="date" name="start-date" id="start-date-input" value="<?= $defaultStartDate ?>">
									</div>
								</div>
								<div class="col-xl-4">
									<div class="input-group">
										<div class="input-group-text">
											End Date
										</div>
										<input class="form-control" type="date" name="end-date" id="end-date-input" value="<?= $defaultEndDate ?>">
									</div>
								</div>
								<div class="col-xl-4 d-flex justify-content-end">
									<div class="form-check form-switch">
										<input class="form-check-input" type="checkbox" role="switch" id="compare-previous-period-input" name="compare-previous-period">
										<label class="form-check-label" for="compare-previous-period-input">Compare to previous year</label>
									</div>
								</div>
							</div>
						</div>
						<div class="mt-3">
							<button type="submit" class="btn btn-primary btn-sm">
								<span>Update Graphs</span>
							</button>
						</div>
					</form>
				</div>
			</div>
			<div class="card mb-3">
				<div class="card-header">
					<h4 class="mb-0">Message Activity</h4>
				</div>
				<div class="card-body">
					<div id="message-activity-chart-container">
						<canvas id="message-activity-chart"></canvas>
					</div>
				</div>
			</div>
			<div class="card mb-3">
				<div class="card-header">
					<h4 class="mb-0">Visitors</h4>
				</div>
				<div class="card-body">
					<div id="visitors-chart-container">
						<canvas id="visitors-chart"></canvas>
					</div>
				</div>
			</div>
		</div>
	</main>
}