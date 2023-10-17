
let postObj = { 
	'trigger' : '1'
}
let post = JSON.stringify(postObj);

window.onunload = function(){
	const url = "../functions/logout.php"
	let xhr = new XMLHttpRequest()
	xhr.open('POST', url, true)
	xhr.setRequestHeader('Content-type', 'application/json; charset=UTF-8')
	xhr.send(post);
	xhr.onload = function () {
    if(xhr.status === 201) {
        console.log("Post successfully created!") 
    	}
	}
}	