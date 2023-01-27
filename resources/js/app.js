require('./bootstrap');

//--- setting the order's date

const dateInput = document.getElementById('new-date');
if (dateInput) {
  const currentDate = new Date();
  currentDate.setHours(currentDate.getHours() - 6);
  dateInput.valueAsDate  = currentDate;
}

// ------------------------------------------------------------
//        Generic: check if there were an option chosen
// ------------------------------------------------------------

const getOptionChosen = input => {
  const options = input.list.options;
  for (let index = 0; index < options.length; index++) {
    if (input.value == options[index].value) {
      return options[index];
    }
  }

  return null;
};

// ------------------------------------------------------------
//                   Getting the order total
// ------------------------------------------------------------

const getTotal = () => {
  const bodyt = document.getElementById('body-table');
  let total = 0;

  for (const row of bodyt.rows) {
    const subtotalCell = row.cells[3];
    if (subtotalCell.innerText) {
      const value = parseFloat(subtotalCell.innerText.replace(/,/g, ''));
      total += value;
    }
  }

  return `Q ${total.toLocaleString(undefined, {minimumFractionDigits: 2})}`;
};

const updateTotal = () => {
  const totalCell = document.getElementById('total-cell');
  if (totalCell) totalCell.innerText = getTotal();
};

updateTotal();

// ------------------------------------------------------------
//                         Delete Row
// ------------------------------------------------------------

const rearrangeNameIndex = index => {
  const bodyt = document.getElementById('body-table');
  const length = bodyt.rows.length;    
  if (index < length) {
    for (let rowCount = index; rowCount < length; rowCount++) {
      const row = bodyt.rows[rowCount];
      const quantityInput = row.cells[0].children[0];
      const hiddenDescription = row.cells[1].children[0];
      const priceInput = row.cells[2].children[0];

      quantityInput.setAttribute('name', `order_items[${rowCount}][quantity]`);
      hiddenDescription.setAttribute('name', `order_items[${rowCount}][description]`);
      priceInput.setAttribute('name', `order_items[${rowCount}][price]`);
    }
  }
};

const deleteRow = button => {
  const index = button.parentNode.parentNode.rowIndex;
  document.getElementById('body-table').deleteRow(index - 1);
  rearrangeNameIndex(index - 1);
  updateTotal();
};

// ------------------------------------------------------------
//                        On Input Actions
// ------------------------------------------------------------

const onQuantityInput = event => {
  const row = event.target.parentNode.parentNode;
  const priceValue = row.cells[2].children[0].value.replace(/,/g, '');
  const quantityValue = event.target.value;

  if (priceValue && quantityValue) {
    row.cells[3].innerText = (parseInt(quantityValue) * parseFloat(priceValue)).toLocaleString(undefined, {minimumFractionDigits: 2});
  }
  else {
    row.cells[3].innerText = '';
  }

  updateTotal();
};

const onDetailsInput = event => {
  const row = event.target.parentNode.parentNode;
  const descriptionCell = event.target.parentNode;
  const priceInput = row.cells[2].children[0];
  const subtotalCell = row.cells[3];
  const datalistInput = descriptionCell.children[0];

  const option = getOptionChosen(datalistInput);
  if (option) {
    const quantityInput = row.cells[0].children[0];
    const price = option.dataset.price;

    priceInput.value = parseFloat(price).toLocaleString(undefined, {minimumFractionDigits: 2});
    if (quantityInput.value) {
      subtotalCell.innerText = (parseInt(quantityInput.value) * parseFloat(price)).toLocaleString(undefined, {minimumFractionDigits: 2});
    }
  }

  updateTotal();
};

const onPriceInput = event => {
  const row = event.target.parentNode.parentNode;
  const quantityValue = row.cells[0].children[0].value;
  const priceValue = event.target.value.replace(/,/g, '');

  if (priceValue && quantityValue) {
    row.cells[3].innerText = (parseInt(quantityValue) * parseFloat(priceValue)).toLocaleString(undefined, {minimumFractionDigits: 2});
  }
  else {
    row.cells[3].innerText = '';
  }

  updateTotal();
};

// ------------------------------------------------------------
//                 Setting Events On Inputs
// ------------------------------------------------------------

const quantityInputs = document.getElementsByClassName('quantity-input');
Array.prototype.forEach.call(quantityInputs, item => {
  item.addEventListener('input', onQuantityInput);
});

const descriptionInputs = document.getElementsByClassName('description-input');
Array.prototype.forEach.call(descriptionInputs, item => {
  item.addEventListener('input', onDetailsInput);
});

const priceInputs = document.getElementsByClassName('price-input');
Array.prototype.forEach.call(priceInputs, item => {
  item.addEventListener('input', onPriceInput);
});

const delButtons = document.getElementsByClassName('del-button');
Array.prototype.forEach.call(delButtons, item => {
  item.addEventListener('click', () => deleteRow(item));
});

// ------------------------------------------------------------
//                         Add New Row
// ------------------------------------------------------------

const createQuantityInput = rowCount => {
    const quantityInput = document.createElement('input');
    quantityInput.type = 'number';
    quantityInput.className = 'form-control quantity-input';
    quantityInput.setAttribute('name', `order_items[${rowCount}][quantity]`);
    quantityInput.setAttribute('min', '1');
    quantityInput.setAttribute('max', '9999');
    quantityInput.addEventListener('input', onQuantityInput);
    quantityInput.value = 1;
    quantityInput.required = true;
    return quantityInput;
};

const createDatalistInput = rowCount => {
  const datalistInput = document.createElement('input');
  datalistInput.type = 'text';
  datalistInput.className = 'form-control description-input';
  datalistInput.setAttribute('list', 'itemList');
  datalistInput.setAttribute('name', `order_items[${rowCount}][description]`);
  datalistInput.placeholder = 'Nombre del artículo o servicio...';
  datalistInput.addEventListener('input', onDetailsInput);
  datalistInput.required = true;
  return datalistInput;
};

const createPriceInput = rowCount => {
  const priceInput = document.createElement('input');
  priceInput.type = 'text';
  priceInput.className = 'form-control text-end price-input';
  priceInput.setAttribute('name', `order_items[${rowCount}][price]`);
  priceInput.setAttribute('pattern', '[0-9]+(\.[0-9]{1,2})?');
  priceInput.addEventListener('input', onPriceInput);
  priceInput.required = true;
  return priceInput;
};

const createDeleteButton = () => {
  const delButton = document.createElement('button');
  delButton.type = 'button';
  delButton.className = 'btn btn-danger btn-sm del-button'
  delButton.addEventListener('click', () => deleteRow(delButton));
  delButton.innerHTML  = '<i class="fas fa-trash-alt"></i><span class="d-none d-md-inline"> Borrar</span>';
  return delButton;
};

const addRow = () => {
  const bodyt = document.getElementById('body-table');
  if (bodyt) {
    const rowCount = bodyt.rows.length;
    const newRow = bodyt.insertRow(-1);

    const quantityCell = newRow.insertCell(0);
    quantityCell.appendChild(createQuantityInput(rowCount));

    const descriptionCell = newRow.insertCell(1);
    descriptionCell.appendChild(createDatalistInput(rowCount));

    const priceCell = newRow.insertCell(2);
    priceCell.appendChild(createPriceInput(rowCount));

    const subtotalCell = newRow.insertCell(3);
    subtotalCell.className = 'align-middle text-end';

    const actionsCell = newRow.insertCell(4);
    actionsCell.className = 'align-middle text-center';
    actionsCell.appendChild(createDeleteButton());
  }
}

const button = document.getElementById('btn-add-item');
if (button) {
  button.addEventListener('click', addRow);
}

// ------------------------------------------------------------
//                  Validations On Submit Form
// ------------------------------------------------------------

const isthereAnEmptyInput = () => {
  const bodyTable = document.getElementById('body-table');

  for (const row of bodyTable.rows) {
    const quantityInput = row.cells[0].children[0];
    const descriptionInput = row.cells[1].children[0];
    const priceInput = row.cells[2].children[0];

    quantityInput.setCustomValidity('');
    if (quantityInput.value.trim() == '') {
      quantityInput.setCustomValidity('La cantidad de artículos no puede estar vacía');
      quantityInput.reportValidity();
      return true;
    }

    descriptionInput.setCustomValidity('');
    if (descriptionInput.value.trim() == '') {
      descriptionInput.setCustomValidity('Artículo o servicio no puede ser vacío');
      descriptionInput.reportValidity();
      return true;
    }

    priceInput.setCustomValidity('');
    if (priceInput.value.trim() == '') {
      priceInput.setCustomValidity('Precio no puede ser vacío');
      priceInput.reportValidity();
      return true;
    }
  }

  return false;
};

const submitOrderForm = () => {
  if (isthereAnEmptyInput()) {
      return false;
  }

  return true;
};

const submitButton = document.getElementById('btn-submit');
if (submitButton) {
  submitButton.addEventListener('click', submitOrderForm);
}

// ------------------------------------------------------------
//                       The Search Clients
// ------------------------------------------------------------

searchQuery = (query, page = 1) => {
  const pagination = document.getElementById('pagination');
  const title = document.getElementById('title');
  query = query.trim();
  const length = query.length;

  const url = '/' + (length ? title.dataset.queryPath : title.dataset.defaultPath) + '?page=' + page + (length ? '&query=' + query : '');
  fetch(url)
  .then(response => {
    if (response.ok) return  response.text();
    
    throw new Error('No se pudo obtener los datos');
  })
  .then(data => {
    pagination.innerHTML = data;
    paginate();
  })
  .catch(error => {
    pagination.innerHTML = error;
  });
}

const search = document.getElementById('search');
if (search) {
  search.addEventListener('keyup', () => searchQuery(search.value));
}

// pagination of the result of a search
pagination = (event, item) => {
  event.preventDefault();
  let page = String(item);
  page = page.split('page=')[1];
  let query = search ? search.value : '';
  searchQuery(query, page);
}

paginate = () => {
  const paginations = document.getElementsByClassName('page-link');
  Array.prototype.forEach.call(paginations, item => item.addEventListener('click', () => pagination(event, item)));
}

paginate();

// ------------------------------------------------------------
//                    Setting Delete Actions
// ------------------------------------------------------------

// setting the delete car action
setDeleteCarAction = () => {
  let delcar_buttons = document.getElementsByClassName('btn-delcar');
  let form = document.getElementById('deletecar-form');
  
  Array.prototype.forEach.call(delcar_buttons, btn => btn.addEventListener('click', (event) => {
    form.action = form.dataset.root + '/cars/' +  event.currentTarget.dataset.car + '?code=' + form.dataset.code;
    const row = event.currentTarget.parentNode.parentNode;

    document.getElementById('car-info-brand').innerText = row.cells[1].innerHTML;
    document.getElementById('car-info-line').innerText = row.cells[2].innerHTML;
    document.getElementById('car-info-year').innerText = row.cells[3].innerHTML;
    document.getElementById('car-info-color').innerText = row.cells[4].innerHTML;
  }));
}

setDeleteCarAction();

// setting the delete item action
setDeleteItemAction = () => {
  let delitem_buttons = document.getElementsByClassName('btn-delitem');
  let form = document.getElementById('deleteitem-form');
  
  Array.prototype.forEach.call(delitem_buttons, btn => btn.addEventListener('click', (event) => {
    form.action = form.dataset.root + '/items/' +  event.currentTarget.dataset.item;
    const row = event.currentTarget.parentNode.parentNode;
    document.getElementById('item-info-description').innerText = row.cells[1].innerHTML;
  }));
}

setDeleteItemAction();

// ------------------------------------------------------------
//                    Setting Delete Actions
// ------------------------------------------------------------

const printBtn = document.getElementById('btn-print');
if (printBtn) {
  printBtn.addEventListener('click', () => print());
}
