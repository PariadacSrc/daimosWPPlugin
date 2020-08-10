const onEvnt = (eventName, selector, handler) => {
  document.addEventListener(eventName, function(event) {
    const elements = document.querySelectorAll(selector);
    const path = event.composedPath();
    path.forEach(function(node) {
      elements.forEach(function(elem) {
        if (node === elem) {
          handler.call(elem, event);
        }
      });
    });
  }, true);
}

const getFullDataStepForm=(block)=>{

	const formData = new FormData();


	block.querySelectorAll('form').forEach((element)=>{
		const auxData = new FormData(element);

		for(var pair of auxData.entries()) {
		   formData.append(pair[0],pair[1]); 
		}
	});

	return formData;
}

const logOutUser =()=>{
	document.querySelectorAll('.d-log-out').forEach((btn)=>{

		btn.addEventListener('click',(e)=>{
			e.preventDefault();

			const sendUrl = btn.dataset.actionCall;
			axios.post( sendUrl, Qs.stringify( [] ) )
			.then( response => {
				softRedirect();
			})
		});

	});
}

const softRedirect =(location=null)=>{

	setTimeout(() => {

		if(location){
			window.location.replace(location);
		}else{
			const address=document.location.origin+document.location.pathname;
	 		window.location.replace(address);
		}

	}, 1200);
}

const runBeforeSubmit =(form)=>{
	form.querySelectorAll('.f-required').forEach((field)=>{
		field.classList.remove('f-required');
		evalFields(field);
	});
}

const evalFields =(field)=>{

	switch(field.tagName) {
		case 'INPUT':
			
			if(field.getAttribute('type')==='checkbox'){
				if(!field.checked){
					field.classList.add('f-required');
				}
			}

			if(field.getAttribute('type')!=='file'){
				if(notEmpty(field)){
					field.classList.add('f-required');
				}
			}

			break;
	}

	if(notEmpty(field)){
		field.classList.add('f-required');
	}

	if(field.value===0 || field.value==='0'){
		field.classList.add('f-required');
	}
}

const evalFiles=(files)=>{

	const errors =[];

	for (var i = 0; i < files.length; i++) {
		
		var kSize = parseInt(files[i].size / 1024);

		if (kSize>5000) {
			errors.push('El tamaño de la imagen es superior a los 5MB');
		}

		if(!(/\.(jpg|png|pdf)$/i).test(files[i].name)){
			errors.push('El formato del archivo es invalido (Formatos validos: png,jpg,pdf)');
		}
	}

	return errors;
}

const notEmpty = element => {
	if(element.getAttribute('type')!=='file'){
		return clearBlankSpaces(element).value.length === 0 ? true : false;
	}
  	return true;
};

const clearBlankSpaces = element => {
	const newElement = element.cloneNode(true);
	newElement.value = newElement.value.replace(/ /g, "");
	return newElement;
};

const getFormData=(form)=>{
	return (new FormData(form));
}

const pictureLoader = (event,bind,rname) => {

  const { files } = event.target;
  const reader = new FileReader();

  reader.onloadend = function () {
    bind.src = reader.result;
  }

  rname.innerHTML=files[0].name;
  reader.readAsDataURL(files[0]);
};


const newAttach =()=>{

	onEvnt('change','.target-bindfile input[type="file"]',(e)=>{
		const foundErrors = evalFiles(e.target.files);
		const field = e.target.closest('.target-bindfile');
		const targetName = field.querySelector('.target-route');

		if(foundErrors.length>0){
			targetName.classList.add('found-img-error');
			targetName.innerHTML= foundErrors[0];
		}else{
			targetName.classList.remove('found-img-error');
			pictureLoader(event,field.querySelector('img'),targetName );
			e.target.classList.remove('f-required');
		}
	});

	onEvnt('click','.target-bindfile button',(e)=>{
		e.preventDefault();

		const bindField= e.target.closest('.target-bindfile').querySelector('input[type="file"]');
		bindField.click();
	});

	
}

const validateFiles=()=>{
}

document.addEventListener('DOMContentLoaded',()=>{
	logOutUser();
	newAttach();
});