const getBindModals =()=>{

	document.querySelectorAll('.bind-closets-modl').forEach((btn)=>{

		btn.addEventListener('click',(e)=>{
			const mdlsHash = btn.dataset.bindHash;
			const mdl = document.querySelector(`.bind-action-mdl-${mdlsHash}`);

			console.log(mdl,mdlsHash);
			mdl.classList.add('showmodal');
		});

	});

}

const closeModals =()=>{
	document.querySelectorAll('.daim-modal-container').forEach((mdl)=>{

		mdl.querySelector('.mdl-closer-handler').addEventListener('click',(e)=>{

			mdl.classList.remove('showmodal');
		});

	});
}

const bindTabs =()=>{
	document.querySelectorAll('.bind-form').forEach((tab)=>{

		tab.querySelector('.bind-area').addEventListener('click',(e)=>{
			e.preventDefault();

			tab.classList.remove('show');
			document.querySelector(tab.dataset.bindTab).classList.add('show');
		});

	});
}

document.addEventListener('DOMContentLoaded',()=>{
	getBindModals();
	closeModals();
	bindTabs();
});


const modalHandler =(atts)=>{
	return{
		status:false,
		layout:null,
		class:'',
		eventsList:[],
		id: null,
		modalNode:null,
		actionSelector:null,
		selfLayout:function(){
			return `<div class="d-modal-block">
				<div class="hide-modal"><i class="fa fa-times"></i></div>
				<div class="modal-body"></div>
			</div>`;
		},
		daimContainer:function(){
			this.modalNode.innerHTML = this.selfLayout();
			const mdlBody= this.modalNode.querySelector('.modal-body');
			if( (typeof this.layout) === 'object'){
				mdlBody.appendChild(this.layout);
			}else{
				mdlBody.innerHTML = this.layout;
			}
		},
		daimShow:function(){
			if(this.status===false){
				this.modalNode.classList.add('showmodal');
				this.status = true;
			}
		},
		daimHidde:function(){
			if(this.status===true){
				this.modalNode.classList.remove('showmodal');
				this.status = false;
			}
		},
		setNewEvent:function(){
		},
		mergeEvents:function(){
			const selfObj = this;

			onEvnt('click','.hide-modal',(e)=>{
				selfObj.daimHidde();
			});

			if(this.actionSelector){
				onEvnt('click',selfObj.actionSelector,(e)=>{
					selfObj.daimShow();
				});
			}
		},
		init:function(){

			this.modalNode = document.createElement("div");
			this.modalNode.setAttribute('class', `daim-modal-container ${this.class}`);
			if(this.id){this.modalNode.id=this.id;}
			this.daimContainer();

			document.body.appendChild(this.modalNode);
			this.mergeEvents();
		},
		...atts
	};
}

const getSectionHtml =(selector,objNode=false,objRemove=false)=>{
	const node = document.querySelector(selector);
	const primenode = node.cloneNode(true);
	if(objRemove){ 
		node.remove();
	}

	return (objNode)?primenode:primenode.innerHTML;
}