class VisitorsChart {
	container = document.querySelector("#visitors-chart-container");
	canvas = document.querySelector("#visitors-chart");
	chart = null;

	constructor() {
		const context = this.canvas.getContext("2d");
		this.chart = new Chart(context, {
			type:"line",
			data: {
				labels:[],
				datasets: [
					{
						label: "Current Period",
						data: [],
						backgroundColor: "rgb(75,192,192)",
						borderColor: "rgb(75,192,192)",
						tension: 0.1,
					},
					{
						label: "Previous Period",
						data: [],
						tension: 0.1,
					}
				]
			},
			options:{
				responsive:true,
				interaction:{
					mode:"index",
					intersect:false
				}
			}
		});
	}

	/**
	 *
	 * @param {URLSearchParams} searchParams
	 */
	async fetchAndRender(searchParams){
		const response = await fetch(`/discord-engagements/visitors?${searchParams.toString()}`, {
			method:"GET",
			cache:"no-cache",
		});

		let data;
		try{
			/** @type {{status: int, error: ?string, visitors: Object[], visitorsLastPeriod: Object[]}} **/
			data = await response.json();
		}catch(jsonSyntaxError){
			alert("The server responded with invalid JSON.");
			return;
		}

		if (data.status === 1){
			this.setLabels(data.visitors);
			this.setPeriodData(0, data.visitors);
			this.setPeriodData(1, data.visitorsLastPeriod);
		}else if (data.status === -1){

		}
	}

	setLabels(visitorsArray){
		const labels = [];

		for (/** @type {{dayStartTimestamp: int, visitors: int, percentCommunicated: float}} */ const visitors of visitorsArray){
			const theDate = new Date();
			theDate.setTime(visitors.dayStartTimestamp * 1000);
			labels.push(theDate.toLocaleString("en-US", {
				year:"numeric",
				month:"2-digit",
				day:"2-digit"
			}));
		}

		this.chart.data.labels = labels;
	}

	setPeriodData(index, visitorsArray){
		const dataYAxisValues = [];
		for (/** @type {{dayStartTimestamp: int, visitors: int, percentCommunicated: float}} */ const visitors of visitorsArray){
			dataYAxisValues.push(visitors.visitors);
		}

		// First data set is the current period
		this.chart.data.datasets[index].data = dataYAxisValues;
		this.chart.update();
	}
}

export default new VisitorsChart();