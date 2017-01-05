function create(){
	document.getElementById("create").classList.remove("hide");
	document.getElementById("login").classList.add("hide");
}

function login(){
	document.getElementById("login").classList.remove("hide");
	document.getElementById("create").classList.add("hide");
}

function loginCheck(){
	var loginUserName = document.getElementById("loginUserName").value;
	var loginPass = document.getElementById("loginPass").value;
	if(loginUserName == "2601917" && loginPass == "2601917"){
		document.getElementById("error").classList.add("hide");
		window.location.replace("pages/search.html");
	}else{
		document.getElementById("error").classList.remove("hide");
	}
	return false;
}