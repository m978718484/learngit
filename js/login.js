function create(){
	document.getElementById("create").classList.remove("hide");
	document.getElementById("login").classList.add("hide");
}

function login(){
	document.getElementById("login").classList.remove("hide");
	document.getElementById("create").classList.add("hide");
}

function loginCheck(){
	var loginMail = document.getElementById("loginMail").value;
	var loginPass = document.getElementById("loginPass").value;
	if(loginMail == "nallely@novella.com" && loginPass == "Wcg2016"){
		document.getElementById("error").classList.add("hide");
		window.location.replace("http://webcodegeeks.com");
	}else{
		document.getElementById("error").classList.remove("hide");
	}
	return false;
}