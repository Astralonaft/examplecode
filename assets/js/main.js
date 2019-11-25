$(document).ready(function() {
	/** начнёт работу тогда, когда будет готов DOM, за исключением картинок **/
	$('[data-toggle="tooltip"]').tooltip();
	$('[data-toggle="table"]').attr('class', '');
	$('[data-toggle="table"]').attr('class','sort table table-responsive table-hover mt-3 mb-4 w-100 d-block d-md-table');

});

$('.sandbox-container input').datepicker({
	language: "ru"
});

function openNavR() {
	document.getElementById("mySidenavR").style.width = "250px";
}

function closeNavR() {
	document.getElementById("mySidenavR").style.width = "0";
}

function dateFormated(format) {

	var formatedStr = "";

	var myDate = new Date();
	var month = ('0' + (myDate.getMonth() + 1)).slice(-2);
	var d = ('0' + myDate.getDate()).slice(-2);
	var year = myDate.getFullYear();
	var hours = myDate.getHours();
	var min = myDate.getMinutes();
	var sec = ("0" + myDate.getSeconds()).slice(-2);
	var milisec = myDate.getMilliseconds();

	switch (format) {
		case "hms":
			formatedStr = hours + ':' + min + ':' + sec;
			break;

		case "ymd":
			formatedStr = year + ':' + month + ':' + d;
			break;

	}

	return formatedStr;

}

function createTh(objApp) {
	var th = "";
	for (var i in objApp.tableColumn)
	{
		th += '<th data-field="' + objApp.tableColumn[i]['code'] + '" data-sortable="true" data-visible="' + objApp.tableColumn[i]['show'] + '" >' + objApp.tableColumn[i]['name'] + '</th>';
	}
	return th;
}

function initModalConfirm()
{
	alert('initModalConfirm')




}