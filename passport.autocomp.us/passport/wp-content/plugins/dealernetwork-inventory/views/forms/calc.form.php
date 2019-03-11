<input id='loanAmount' placeholder='Loan Amount' style='border:3px solid; border-color:transparent;' />
<br />
<input id='APR' placeholder='APR %' style='border:3px solid; border-color:transparent;' />
<br />
<input id='numberOfPayments' placeholder='Number of Payments' style='border:3px solid; border-color:transparent;' />
<br />
<input id='paymentAmount' placeholder='Monthly Payment'  style='border:3px solid; cursor:no-drop; border-color:transparent;' readonly />
<br />
<input id='submitButton' type='button' value='Calculate' />


<script>
	jQuery('#submitButton').click(function()
	{
	// required: loanamount, number of payments, percentage
	
		if(jQuery('#loanAmount').val() == "" || !jQuery.isNumeric(jQuery('#loanAmount').val()))
		{
			jQuery('#loanAmount').css({'border-color':'red'});
		}else
		{
			jQuery('#loanAmount').css({'border-color':'transparent'});
		}

		if(jQuery('#numberOfPayments').val() == "" || !jQuery.isNumeric(jQuery('#numberOfPayments').val()))
		{
			jQuery('#numberOfPayments').css({'border-color':'red'});
		}else
		{
			jQuery('#numberOfPayments').css({'border-color':'transparent'});
		}
		
		if(jQuery('#APR').val() == "" || !jQuery.isNumeric(jQuery('#APR').val()))
		{
			jQuery('#APR').css({'border-color':'red'});
		}else
		{
			jQuery('#APR').css({'border-color':'transparent'});
		}
		
		setInterval(function()
		{	
			if(jQuery('#loanAmount').css('border-color') == 'rgba(0, 0, 0, 0)' && jQuery('#numberOfPayments').css('border-color') == 'rgba(0, 0, 0, 0)' && jQuery('#APR').css('border-color') == 'rgba(0, 0, 0, 0)') 
			{
			var loanAmount;
			var APR;
			var paymentsPerYear;
			var numberOfPayments;
			var paymentAmount;
			var ratePerPeriod;
			
			numberOfPayments = jQuery('#numberOfPayments').val();
			loanAmount = jQuery('#loanAmount').val();
			APR = jQuery('#APR').val() / 100;
			//translate payment interval to number of periods per year
			var paymentInterval = jQuery('#paymentIntervalDropDown').val();
			if (paymentInterval == 'weekly') paymentsPerYear = 52;
			if (paymentInterval == 'biweekly') paymentsPerYear = 104;
			if (paymentInterval == 'monthly') paymentsPerYear = 12;
			if (paymentInterval == 'semimonthly') paymentsPerYear = 24;
			if (paymentInterval == 'annually') paymentsPerYear = 1;
			if (paymentInterval == 'biannually') paymentsPerYear = 2;
			
			ratePerPeriod = APR / 12;
			
			//calculate payment amount
			paymentAmount = (ratePerPeriod * loanAmount) / (1 - Math.pow((1 + ratePerPeriod), -numberOfPayments));
			paymentAmount = paymentAmount.toFixed(2);
			
			//populate <input>s
			jQuery('#paymentAmount').val(paymentAmount);
			jQuery('#numberOfPayments').val(numberOfPayments);
			}
			
			if(jQuery('#paymentAmount').val() == "NaN") jQuery('#paymentAmount').val("Please Correct");
		}, 1);	
			
		});
		
</script>