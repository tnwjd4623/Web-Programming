var windowW = 400;
var windowH = 430;
var left = Math.ceil((window.screen.width - windowW)/2);
var to = Math.ceil((window.screen.height - windowH)/2);
var write;

search = function() {
	window.open("./search_book.php", "pop_01", "top="+to+", left="+left+", height="+windowH+", width="+windowW);
	return false;

}

write = function(){

	window.open('','_self').close();
}

function modal() {
	document.getElementById("modal").style.display="block";
}
function modal2() {
	document.getElementById("modal2").style.display="block";
}

function close_modal() {
	document.getElementById('modal').style.display="none";
	return false;
}
function close_modal2() {
	document.getElementById('modal2').style.display="none";
	return false;
}
function check_pw(str) {

	if(str =="modify") {
		document.getElementById("modify_pw").style.display="block";
	}

	else if(str == "delete") {
		document.getElemntById("delete_pw").style.display = "block";
	}
}
function comment(index) {
	document.getElementById("hide_comment"+index).style.display="block";
}
