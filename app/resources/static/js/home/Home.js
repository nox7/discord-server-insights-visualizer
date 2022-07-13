import DateSelectionForm from "./forms/DateSelectionForm.js";

class Home{
	constructor() {
		// Submit the default forms on page load
		DateSelectionForm.onSubmit();
	}

}

export default new Home();