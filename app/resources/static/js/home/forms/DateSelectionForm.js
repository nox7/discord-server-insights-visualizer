import MessageActivityChart from "../components/MessageActivityChart.js";
import VisitorsChart from "../components/VisitorsChart.js";

class DateSelectionForm{
	form = document.querySelector("#date-selection-form");
	// previousPeriodCheck = document.querySelector("#compare-previous-period-input");
	isProcessing = false;

	constructor() {
		this.form.addEventListener("submit", e => {
			e.preventDefault();
			this.onSubmit();
		});
	}

	async onSubmit(){

		if (this.isProcessing){
			return;
		}

		this.isProcessing = true;
		const fData = new FormData(this.form);

		// Providing a FormData is actually fine here
		const urlSearchParams = new URLSearchParams(fData);
		await Promise.all([
			MessageActivityChart.fetchAndRender(urlSearchParams),
			VisitorsChart.fetchAndRender(urlSearchParams)
		]);

		this.isProcessing = false;
	}
}

export default new DateSelectionForm();