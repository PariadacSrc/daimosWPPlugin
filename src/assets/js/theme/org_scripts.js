//
const contactFields=(data)=>{
	let str = ``;
	if(Array.isArray(data)){

		data.map((element,index)=>{
			const conct = (index!==(data.length-1))?',':'';
			str+= `${element.nombre_pais}${conct}`;
		})
	}

	return str;
}

//
const getFormValues =(selector)=>{

	const form = document.querySelector(selector);
	const reach_fields = [];
	form.querySelectorAll('[data-name]').forEach((element, index)=>{
		
		if(parseInt(element.value)!==0){
			reach_fields.push({key:element.dataset.name, value: element.value});
		}

	});

	return reach_fields;
}

const getReachResults = async (fields,template,container,current=1)=>{

	//Set Research Query
	let query = ``;
	fields.map((element,index)=>{

		const ampsimb = (index!==(fields.length-1))?'&':'';
		query+= `${element.key}=${element.value}${ampsimb}`;
	})

	//Load Data Template
	container.innerHTML = '<tr><td colspan="6">Cargando...</td></tr>';

	//Main Research
	let res = await axios.get(`${uerMainEndponit.main}${uerMainEndponit.branchs.organizations}?${query}&page=${current}&perpage=12`);
	let {data} = res.data; 

	//Set Records
	let {last_page,current_page} = data;
	setContainerRecords(data.data,template,container);

	//Return paginator data
	return {current:current_page,totals:last_page};
}

const setContainerRecords = (data,template,container)=>{

	container.innerHTML = '';

	data.forEach((record)=>{

		const node = template.cloneNode(true);
		node.querySelectorAll('[data-key]').forEach((target)=>{

			if (!target.dataset.attrkey) {
				if (!Array.isArray(record[target.dataset.key])) {
					target.innerHTML = record[target.dataset.key];
				}

				if(target.dataset.action){
					target.innerHTML =  (eval(target.dataset.action))(record[target.dataset.key]);
				}

			}else{
				target.setAttribute(target.dataset.attrkey, record[target.dataset.key]);
			}
			
		});

		container.appendChild(node);
	});
}

const initTemplate =(container,child)=>{
	const data = document.querySelector(container).querySelector(child);
	document.querySelector(container).removeChild(data);

	return data;
}

const getPaginator =(selector,current,totals,status=1)=>{
		
	const srcItems = [];
	for (var i = 0; i < totals; i++) { srcItems.push(i); }

		document.querySelectorAll(selector).forEach((item)=>{

			if(totals>1){
				jQuery(item).pagination({
					dataSource : srcItems,
				    pageNumber: current,
				    pageSize: 1,
				    callback: function(data, pagination) {
				       	
				    	if(status===0){

				    		fullFormSet(pagination.pageNumber);
				    	}
				    }
				});
			}else{
				item.innerHTML='';
			}

		});

	status = 0;
}

//
const initOptions = async (selector,route, keys={})=>{

	let {branchs,main} = uerMainEndponit

	let res = await axios.get(`${main}${branchs[route]}`);
	let {data} = res.data;

	document.querySelectorAll(selector).forEach((item)=>{

		if(data){
			data.map((option)=>{

				const node = document.createElement('option');
				node.value = option[keys.val];
				node.textContent = option[keys.name];

				item.appendChild(node);
			});
		}

	});

}

const fullFormSet=(current=1)=>{
	getReachResults(getFormValues('.uer-reacher-container'),mainTemplate,templateContainer,current).then((data)=>{
		getPaginator('[data-paginator="1"]',data.current,data.totals);
	});
}

const mainTemplate = initTemplate('.uer-main-results tbody', 'tr');
const templateContainer = document.querySelector('.uer-main-results tbody');

document.addEventListener('DOMContentLoaded',()=>{

	//Set all form Options
	initOptions('[data-name="id_pais"]','countries',{val:'id_pais',name:'nombre_pais'});
	initOptions('[data-name="id_area_interes"]','area_interest',{val:'id_areainteres',name:'descripcion_areainteres'});
	initOptions('[data-name="id_ods"]','ods',{val:'id_objetivo',name:'descripcion_objetivo'});

	fullFormSet();

	document.querySelectorAll('.uer-trigger-research').forEach((item)=>{

		item.addEventListener('submit', (e)=>{
			e.preventDefault();
			fullFormSet();
		})

	});
	
});