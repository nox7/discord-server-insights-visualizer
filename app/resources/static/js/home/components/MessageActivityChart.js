class MessageActivityChart{
	container = document.querySelector("#message-activity-chart-container");
	canvas = document.querySelector("#message-activity-chart");
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
		const response = await fetch(`/discord-engagements/message-activity?${searchParams.toString()}`, {
			method:"GET",
			cache:"no-cache",
		});

		let data;
		try{
			/** @type {{status: int, error: ?string, messageActivity: Object[], messageActivityLastPeriod: Object[]}} **/
			data = await response.json();
		}catch(jsonSyntaxError){
			alert("The server responded with invalid JSON.");
			return;
		}

		if (data.status === 1){
			this.setLabels(data.messageActivity);
			this.setPeriodData(0, data.messageActivity);
			this.setPeriodData(1, data.messageActivityLastPeriod);
		}else if (data.status === -1){

		}
	}

	setLabels(messageActivityArray){
		const labels = [];

		for (/** @type {{dayStartTimestamp: int, messages: int, messagesPerCommunicator: float}} */ const messageActivity of messageActivityArray){
			const theDate = new Date();
			theDate.setTime(messageActivity.dayStartTimestamp * 1000);
			labels.push(theDate.toLocaleString("en-US", {
				year:"numeric",
				month:"2-digit",
				day:"2-digit"
			}));
		}

		this.chart.data.labels = labels;
	}

	setPeriodData(index, messageActivityArray){
		const dataYAxisValues = [];
		for (/** @type {{dayStartTimestamp: int, messages: int, messagesPerCommunicator: float}} */ const messageActivity of messageActivityArray){
			dataYAxisValues.push(messageActivity.messages);
		}

		// First data set is the current period
		this.chart.data.datasets[index].data = dataYAxisValues;
		this.chart.update();
	}
}

export default new MessageActivityChart();