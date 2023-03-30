function sendData(path, parameters, method='post') {
	//https://www.delftstack.com/zh-tw/howto/javascript/javascript-submit-form-post/
		const form = document.createElement('form');
		form.method = method;
		form.action = path;
		document.body.appendChild(form);
	  
		for (const key in parameters) {
			const formField = document.createElement('input');
			formField.type = 'hidden';
			formField.name = key;
			formField.value = parameters[key];
	  
			form.appendChild(formField);
		}
		form.submit();
	  }
		 
	function gostep4(aaa,bbb,ccc,ddd){
		//loadTextFile("book.php?a="+aaa+"&b="+bbb+"&c="+ccc+"&d="+ddd,"content");
		sendData('book.php', {a:aaa,b:bbb,c:ccc,d:ddd});
	}
	function cancelseat(aa,bb){
		sendData('cancel.php',{canceltime:aa,cancelcon:bb});
	}