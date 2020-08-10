import { Datepicker } from 'vanillajs-datepicker';

export const renderDates=()=>{

	if(document.querySelector('.daim-date-field')){

		document.querySelectorAll('.daim-date-field').forEach(picker=>{
			const validDate = new Date();
			validDate.setFullYear( (validDate.getFullYear()-18) );

			const datepicker = new Datepicker(picker, {
					maxDate: validDate,
					changeDate: function(formattedDate, date, inst) {
						var event = new Event('change');
						picker.dispatchEvent(event);
					}
				});


			
		});
	}
	
}