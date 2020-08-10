const alertInputsErrors = (e, error) => {
  let parent = e.closest("div");
  clearFormErrors(e);
  let para = document.createElement("span");
  para.classList.add("errorelement");
  const errormsn = error.map(e => {
    return e.message;
  });
  let node = document.createTextNode(errormsn.toString());
  para.appendChild(node);
  parent.appendChild(para);
};

const clearFormErrors = element => {
  let find = element ? element.closest("div") : document;
  find.querySelectorAll(".errorelement").forEach(e => {
    e.remove();
  });
};

const validateFormRules = (errors = [], event = null) => {
  let bodyForm = event ? event.target : document;
  try {
    clearFormErrors();
    bodyForm.querySelectorAll(".validate").forEach((e, i) => {
      let target = e.tagName === "SELECT" ? e.closest("div.select-wrapper") : e;
      target.classList.remove("invalid");
      const error = validateOneField(e);
      if (error.length > 0) {
        alertInputsErrors(e, error);
        errors.push(error);
        target.classList.add("invalid");
      }
    });
  } catch (error) {
    console.log(error);
  }

  return errors;
};

const validateOneField = element => {
  let errors = [];
  element = element.target ? element.target : element;
  if (element.value.length === 0) {
    let label = document.querySelector(
      `label[for="${element.getAttribute("id")}"]`
    ).textContent;
    errors.push({
      type: "emptyflield",
      element: element,
      message: `The "${label}" field is empty`
    });
  }
  if (element.classList.contains("vbond")) {
    if (!bondSameValue(element)) {
      errors.push({
        type: "notmatch",
        element: element,
        message: `The password value and confirmation do not match`
      });
    }
  }
  if (element.classList.contains("vphone")) {
    if (!phoneValidation(element)) {
      errors.push({
        type: "phoneincomplete",
        element: element,
        message: `Field ${element.getAttribute("placeholder")}is not complete`
      });
    }
  }
  if (element.classList.contains("vlimit")) {
    if (element.value.length < element.dataset.minsize) {
      errors.push({
        type: "minlimint",
        element: element,
        message: `The password cannot be less than ${
          element.dataset.minsize
        } characters and a maximum of ${element.dataset.maxsize}`
      });
    }
  }
  return errors;
};

//Event Attach Main Method
const attachEvent = (
  selector,
  listener,
  action = "add",
  event = "keyup"
) => {
  const inputs = document.querySelectorAll(selector);
  switch (action) {
    case "remove":
      for (let i = 0; i < inputs.length; i++) {
        inputs[i].removeEventListener(event, listener);
      }
      break;

    default:
      for (let i = 0; i < inputs.length; i++) {
        inputs[i].addEventListener(event, listener);
      }
      break;
  }
};

/*__Form Validations Methos*/

//
const clearBlankSpaces = element => {
  element.target.value = element.target.value.replace(/ /g, "");
};

const limitSize = element => {
  element = element.target ? element.target : element;
  element.value =
    element.value.length > element.dataset.maxsize
      ? element.value.slice(0, -1)
      : element.value;
};

const numberFormat = element => {
  try {
    element = element.target ? element.target : element;
    element.value = element.value.replace(/[.]/g, "");
    onlyNumber(element);
    if (element.value.length > 2) {
      const front = element.value.slice(0, -1);
      const back = element.value.slice(-1);
      element.value = `${front}.${back}`;
    }
  } catch (error) {
    console.log(error);
  }
};

const alfaNumeric = element => {
  element = element.target ? element.target : element;
  onlyLetters(onlyNumber(element));
};

const onlyLetters = element => {
  element = element.target ? element.target : element;
  element.value = !/^[a-zA-ZáÁéÉíÍóÓúÚñÑüÜ\s]+$/.test(element.value)
    ? element.value.slice(0, -1)
    : element.value;
};

const onlyNumber = element => {
  element = element.target ? element.target : element;
  element.value = !/^([0-9])*$/.test(element.value)
    ? element.value.slice(0, -1)
    : element.value;
};

const phoneMask = element => {
  element = element.target ? element.target : element;
  let newVal = "___-___-____";

  let nonumbers = element.value.replace(/[+_-]/g, "").replace(/ /g, "");
  if (newVal.length > element.value.length) {
    nonumbers = nonumbers.slice(0, -1);
  }

  nonumbers.split("").map(e => {
    if (/^([0-9])*$/.test(e)) {
      newVal = newVal.replace("_", e);
    }
  });

  element.value = newVal;
  return newVal;
};

//
const fileUploadTriggerPart = e => {
  e.preventDefault();
  try {
    document.querySelector(e.target.dataset.bondfile).click();
  } catch (error) {
    console.log(error);
  }
};

const notEmpty = element => {
  return element.value.length === 0 ? true : false;
};

const bondSameValue = element => {
  try {
    const filterTargetValue = element.target
      ? element.target.value
      : element.value;
    const filterBondValue = element.target
      ? document.querySelector(element.target.dataset.bondfield).value
      : document.querySelector(element.dataset.bondfield).value;

    if (filterTargetValue === filterBondValue) {
      return true;
    } else {
      return false;
    }
  } catch (error) {
    console.log(error);
    return false;
  }
};

const phoneValidation = element => {
  element = element.target ? element.target : element;
  return "___-___-____".length === phoneMask(element).replace(/_/g, "").length
    ? true
    : false;
};

const validateEmail = element => {
  const email = element.target ? element.target.value : element.value;
  var re = /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
  return re.test(String(email).toLowerCase());
};

const newFileName = (file, id) => {
  const extension = file.name.split(".").pop();
  return `user_picture_${id}.${extension}`;
};

const pictureLoader = (event,bind) => {

  const { files } = event.target;
  const reader = new FileReader();

  reader.onloadend = function () {
    bind.src = reader.result;
  }
  
  reader.readAsDataURL(files[0]);
};

const fetchDateFormat = date => {
  let day = date.getDate() < 10 ? "0" + date.getDate() : date.getDate();
  let month =
    date.getMonth() + 1 < 10
      ? "0" + (date.getMonth() + 1)
      : date.getMonth() + 1;
  return `${date.getFullYear()}-${month}-${day}`;
};

const myMove = (
  selector = "",
  options = { interval: 0, newposition: 0 }
) => {
  let element = document.querySelector(selector);
  var pos = 0;
  const interval = options.newposition / (options.interval / 100);
  var id = setInterval(frame, interval);
  function frame() {
    if (pos >= options.newposition) {
      clearInterval(id);
    } else {
      pos = pos + interval;
      element.scrollTop = pos;
    }
  }
};