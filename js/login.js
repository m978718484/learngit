function create(){
	document.getElementById("create").classList.remove("hide");
	document.getElementById("login").classList.add("hide");
}

function login(){
	document.getElementById("login").classList.remove("hide");
	document.getElementById("create").classList.add("hide");
}

function loginCheck(){
	var loginMail = document.getElementById("loginUserName").value;
	var loginPass = document.getElementById("loginPass").value;
	if(loginMail == "m978718484@163.com" && loginPass == "123456"){
		document.getElementById("error").classList.add("hide");
		window.location.replace("http://github.com/m978718484");
	}else{
		document.getElementById("error").classList.remove("hide");
	}
	return false;
}