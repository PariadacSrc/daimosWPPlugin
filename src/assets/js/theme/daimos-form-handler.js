const daimosFormHandler=(atts)=>{
	return{
		nodeForm:null,
		fieldsHdls:[],
		action:'',
		method:'get',
		formData:null,
		customBefore:null,
		customAfter:null,
		headers:{},
		preapareData:function(){},
		beforeCall:function(){
			try {
				let currentData ={data:{}};
				const selfObj = this;

				if(this.customBefore){
					currentData = {...(eval(selfObj.customBefore))(blockState.target,selfObj.nodeForm)};
				}else{
					currentData.data = getFormData(selfObj.nodeForm);
				}

				return {send:true,...currentData};

			}catch (error) {
				showBlockMsg(selfObj.nodeForm,'error','Ocurrio un error al enviar la informacion...');
				return {send:false};
			}
		},
		afterCall:function(response){
			try {
				let currentData ={};
				const selfObj = this;

				if(blockState.afterAction){
					currentData = {...(eval(selfObj.customAfter))(selfObj.nodeForm,response)};
				}else{
					showBlockMsg(selfObj.nodeForm,response.data.action,response.data.msg);
				}

				//Resset form Fields
				selfObj.nodeForm.reset();
				setTimeout(()=>{
					if(response.data.redirect){
						softRedirect(response.data.redirect);
					}
				},1000);

				return {send:true,...currentData};

			}catch (error) {
				showBlockMsg(form,'error','Ocurrio un error al enviar la informacion...');
				return {send:false};
			}
		},
		mainCall:function(){
			const selfObj = this;
			nodeForm.addEventListener('submit',(e)=>{
				e.preventDefault();
				const invalidFields = this.fieldsHdls.map((item)=>{
					item.fullEval();
					if(!item.status){
						return item;
					}
				});
				
				if(invalidFields.length===0){
					selfObj.formData = {...selfObj.beforeCall()};
					if(selfObj.formData.send){
						axios.post( 
							selfObj.action, 
							selfObj.formData.data,
							{headers: {
				          		'Content-Type': 'multipart/form-data'
				        	}}
				        ).then( response => {
				        	selfObj.afterCall(response);
				        });
					}
				}

			});
		},
		init:function(node){
			const selfObj = this;
			document.addEventListener('daim-form-handler',(e)=>{
				selfObj.nodeForm = node;
				const inputs = selfObj.nodeForm.elements;

				for (var i = 0; i < inputs.length; i++) {

					if(inputs[i].tagName!=='BUTTON' && inputs[i].type!=='submit'){
						let auxField = daimosFieldHandler();
						auxField.init(inputs[i]);

						selfObj.fieldsHdls.push(auxField);
					}
				}
			});
		},
		...atts,
	};
}

const daimosFieldHandler =(atts)=>{
	return{
		node:null,
		status:true,
		nodeContainer:null,
		dataThree:{},
		bindNode:null,
		stringRules:{
			numbers:!/^([0-9])*$/,
			letters:!/^[a-zA-ZáÁéÉíÍóÓúÚñÑüÜ\s]+$/,
			email: /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/
		},
		selectValidations:function(){},
		inputValidations:function(){
			if(this.node.type==='text'){
				if(this.dataThree['dOnlynumber']){this.status = this.evalString(stringRules.numbers);}
				if(this.dataThree['dOnlyletters']){this.status = this.evalString(stringRules.letters);}
			}

			if(this.node.type==='email'){
				this.status = this.evalString(stringRules.email);
			}
		},
		textareaValidations:function(){},
		generalValidations:function(){
			if(this.dataThree['dRequired']){this.status = this.rlRequired();}
		},
		nodeTemplate:function(){
			return `<div>
				<div class="field-container">
					${(this.dataThree['dIcon'])?`<div class="field-icon"><i class="${this.dataThree['dIcon']}"></i></div>`:''}
					<div class="field-block"></div>
					${(this.dataThree['dRequired'])?`<div class="required-block"><span class="fa fa-asterisk"></span></div>`:''}
				</div>
				<div class="field-message"></div>
			</div>`;
		},
		fileNodeTemplate:function(){},
		rlMaxSize:function(){
			return (this.node.value.trim().length > this.dataThree.maxSize);
		},
		rlMinSize:function(){
			return (this.node.value.trim().length < this.dataThree.minSize);
		},
		rlRequired:function(){
			return (this.node.value.trim().length>0 && parseInt(this.node.value)!==0);
		},
		rlFiles:function(){},
		evalString:function(rl){
			return this.stringRules[rl].test(this.node.value);
		},
		setEvents:function(){
			const selfObj = this;

			selfObj.node.addEventListener('change',(e)=>{selfObj.fullEval();});
			selfObj.node.addEventListener('keydown',(e)=>{
				selfObj.fullEval();
				if(!this.status && this.node.type==='text'){
					selfObj.node.value.slice(0, -1);
				}
			});
			//Custom Events
			const dFieldsEvent = new CustomEvent('daim-field-hdlr');
			selfObj.node.dispatchEvent(dFieldsEvent);

		},
		fullEval:function(){

			switch(this.node.tagName) {
				case 'INPUT':
					this.inputValidations();
					this.inputValidations();
					break;
				case 'SELECT':
					this.selectValidations();
					break;
			}
			this.generalValidations();

			if(!this.status){
				console.log('campo invalido');
			}else{
				console.log('campo valido');
			}
		},
		render:async function(){
			if(this.node.type.search('hidden')<0){
				const auxParent = this.node.parentNode;

				this.nodeContainer = document.createElement("div");
				this.nodeContainer.setAttribute('class', `d-handler-form`);
				this.nodeContainer.innerHTML = this.dataThree['dLayout']? 
					(eval(this.dataThree['dLayout']))(this) :
					this.nodeTemplate();

				this.nodeContainer.querySelector('.field-block').appendChild(this.node);
				auxParent.appendChild(this.nodeContainer);
			}

			return true;
		},
		init:function(node){
			const selfObj = this;
			selfObj.node=node;
			
			selfObj.dataThree={...selfObj.node.dataset};
			selfObj.render().then(()=>{
				selfObj.setEvents();
			});
		},
		...atts
	}
}