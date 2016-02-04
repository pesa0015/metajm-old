$('#calendar').fullCalendar({
	height: 400,
	eventAfterRender: function() {
        $('.fc-week').css('height','10px');
    }
});