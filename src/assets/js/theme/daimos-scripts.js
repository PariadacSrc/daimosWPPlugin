/*==================================Core Styles Methods*/
const mainJsStyleSheets = (attr)=>{
	var style = document.createElement("style");

	//Attributes
	const attrKeys = Object.keys(attr);
	attrKeys.map((item)=>{
		style.setAttribute(item,attr[item]);
	});


	style.appendChild(document.createTextNode(""));
	document.head.appendChild(style);

	return style.sheet;
};

const addCSSRule = (sheet, selector, rules, index)=>{
	if("insertRule" in sheet) {
		sheet.insertRule(selector + "{" + rules + "}", index);
	}
	else if("addRule" in sheet) {
		sheet.addRule(selector, rules, index);
	}
}

/*==================================Sliders Methods*/
const settingsSliderGeneric=(item)=>{
	return {
	  dots: false,
	  adaptiveHeight:true,
	  infinite: true,
	  autoplay:false,
	  prevArrow:'<i class="daim-slider-a-left fa fa-angle-left slick-arrow"></i>',
	  nextArrow:'<i class="daim-slider-a-right fa fa-angle-right slick-arrow"></i>',
	  slidesToShow: parseInt(item.dataset.showitems),
	  responsive: [
	    {
	      breakpoint: 1025,
	      settings: {
	        slidesToShow: 1,
	        arrows:false
	      }
	    }
	  ]
	}
}

const getCustomSettings=(obj)=>{
	const {customSettings} = obj.dataset;
	if(customSettings){
		try{ 
			return eval(customSettings)();
		}catch (e){
			return {};
		}
	}

	return {};
}

const initSliderGeneric=($start=true)=>{

	document.querySelectorAll('.daim-slider-standar').forEach((item,index)=>{

		//set Hash
		const slideHash = `new-slider-generic-${index}`;
		item.classList.add(`new-slider-generic-${index}`);
		item.dataset.sliderHashKey = slideHash;

		if ($start) {

			//Merge the default theme settings whit custom developer theme settings
			const newSlide = {
				...settingsSliderGeneric(item),
				...getCustomSettings(item)
			}

			jQuery(item).slick(newSlide);

			//Validation
			var{diffitems,postcount}=item.dataset;
			if (valSliderCountItems(diffitems,postcount,item)) {
				item.classList.add('one-page-slider');
				addCSSRule(sheetMediaDesktop,`.${slideHash}.one-page-slider .slick-track` , `width: 100%!important`);
			}

			//Fix Height Element
			resizeSliderHeightBox(item,`.${slideHash} .daim-slide.daim-tmp-generic>div>div:nth-child(2)>div`,sheetMediaDesktop);
			resizeSliderFullBox(item,`.${slideHash} .daim-tmp-featured_picture .daim-bg-img`,sheetMediaDesktop);
		}

	});
}

const initSliderBondSlides=($start=true)=>{

	document.querySelectorAll('.daim-bind-slides-group').forEach((item,index)=>{

		if ($start) {
			
			const container = item.querySelector('.daim-bind-container-slide');
			const slides = item.querySelector('.daim-bind-main-slides');
			const showItems = parseInt(slides.dataset.showitems);

			//set Hash
			const slideHash = `bind-slide-n-${index}`;
			item.classList.add(`bind-slide-n-${index}`);

			//validate Styles
			if (slides.querySelectorAll('.daim-bind-content').length<= showItems) {
				addCSSRule(sheetMediaDesktop,`.${slideHash} .daim-bind-main-slides .slick-track` , `width: 100%!important`);
			}

			jQuery(container).slick({
			  slidesToShow: 1,
			  slidesToScroll: 1,
			  arrows: false,
			  fade: true,
			  prevArrow:'<i class="daim-slider-a-left fa fa-angle-left slick-arrow"></i>',
			  nextArrow:'<i class="daim-slider-a-right fa fa-angle-right slick-arrow"></i>',
			  asNavFor: `.${slideHash} .daim-bind-main-slides`,
			  responsive: [
			    {
			      breakpoint: 1025,
			      settings: {
			        slidesToShow: 1,
			        arrows: true,
			      }
			    }
			  ]
			});

			jQuery(slides).slick({
			  dots: false,
			  adaptiveHeight:true,
			  infinite: true,
			  autoplay:false,
			  focusOnSelect: true,
			  slidesToShow: showItems,
			  asNavFor:`.${slideHash} .daim-bind-container-slide`,
			  responsive: [
			    {
			      breakpoint: 1025,
			      settings: {
			        slidesToShow: 1,
			      }
			    }
			  ]
			});
		}

	});
}

const setBindArrows=()=>{

    document.querySelectorAll(".daim-bind-arrow").forEach((arrow)=>{

        arrow.addEventListener('click',(e)=>{
            e.preventDefault();

            let {bindSlider,direction} = arrow.dataset;

            switch(direction) {
                case 'left':
                    jQuery(bindSlider).slick('slickPrev');
                    break;
                case 'right':
                    jQuery(bindSlider).slick('slickNext');
                    break;
            }
            
        });

    });
}

const quickSortSlides=(slider)=>{

	if(slider.length<1){
		return [];
	}

	const pivotIndex = Math.floor(slider.length / 2);
	const pivot = slider[pivotIndex];

	const sameAsPivot = [];
	const lowerHalf = [];
	const upperHalf = [];

	slider.forEach((item,index)=>{

		if(item.offsetHeight<=pivot.offsetHeight){
			
			if(item.offsetHeight===pivot.offsetHeight){
				sameAsPivot.push(item);
			}else{
				lowerHalf.push(item);
			}

		}else{
			upperHalf.push(item);
		}

	});

	return [].concat(quickSortSlides(lowerHalf),sameAsPivot,quickSortSlides(upperHalf));
}

const resizeSliderHeightBox=(slider,selector,sheet)=>{

	if(slider.querySelectorAll(selector).length>0){
		const arrayBox = Object.values(slider.querySelectorAll(selector));
		const ordSlides = quickSortSlides(arrayBox);
		const maxHeight = ordSlides[ordSlides.length-1].offsetHeight;

		addCSSRule(sheet, selector, `height: ${maxHeight}px`);
	}
}

const resizeSliderFullBox=(slider,selector,sheet)=>{

	if(slider.querySelectorAll(selector).length>0){
		const arrayBox = Object.values(slider.querySelectorAll(selector));
		const ordSlides = quickSortSlides(arrayBox);
		const maxHeight = ordSlides[ordSlides.length-1].offsetWidth;

		addCSSRule(sheet, selector, `height: ${maxHeight}px;`);
	}
}

const valSliderCountItems=(diff,countItems)=>{

	diff=parseInt(diff);
	countItems=parseInt(countItems);

	return (diff && countItems<0)?true:false;
}

const mediaOnePageSlider =(action='slickAdd')=>{

	document.querySelectorAll('.one-page-slider').forEach((item,index)=>{

		let{postcount}=item.dataset;
		postcount = Math.abs(parseInt(postcount));

		for (var i = 0; i < postcount; i++) {

			var currentIndex = item.querySelectorAll('.slick-slide').length -1;

			switch (action) {
			  case 'slickRemove':
			  	jQuery(item).slick(action,currentIndex);
			  	break;
			  default:
			  	jQuery(item).slick(action,'<div></div>');
			    break;
			}

		}

	});
}

/*==================================Elements Styles*/
const imgPostHeight=()=>{
	document.querySelectorAll('.single-entry-header .post-image').forEach((element,index)=>{

		const img = element.querySelector('img');

		if(img.offsetHeight<=element.offsetHeight){
			addCSSRule(sheetMediaDesktop, '.single-entry-header .post-image>img', `margin-top: 0%;`);
		}	

	});
}


/*==================================NavBar Actions*/
const setCollapseBtns =()=>{

	document.querySelectorAll('.daim-collapse-nav').forEach((block)=>{

		const collpsBtn = block.querySelector('.collapse-btn>button');

		collpsBtn.addEventListener('click',(e)=>{
			e.preventDefault();
			block.classList.toggle('d-show-collapse');
		});
	});
}


//**Global Vars
//Media Sheet
const sheetMediaDesktop = mainJsStyleSheets({media:'(min-width: 1025px)'});
const sheetMediaMovile = mainJsStyleSheets({media:'(max-width: 728px)'});

document.addEventListener('DOMContentLoaded',()=>{

	initSliderGeneric();
	initSliderBondSlides();

	//SettingStyles
	imgPostHeight();

	//Events
	setCollapseBtns();

	//_Media Query List
	window.matchMedia('(min-width: 1025px)').addListener((mql)=>{
		if(mql.matches){
			//mediaOnePageSlider();
		}
	});
	window.matchMedia('(max-width: 1024px)').addListener((mql)=>{
		if(mql.matches){
			//mediaOnePageSlider('slickRemove');
		}
	});
});