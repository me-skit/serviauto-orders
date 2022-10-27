require('./bootstrap');

//--- client datalist actions
const onClientInput = () => {
  const clientInput = event.target;
  const hiddenClientInput = document.getElementById('client_id');

  const option = getOptionChosen(clientInput);
  if (!option) {
    hiddenClientInput.value = '';
  }
  else {
    hiddenClientInput.value = option.dataset.value;
  }
}

const clientInput = document.getElementById('client_name');
if (clientInput) {
  clientInput.addEventListener('input', onClientInput);
}

//--- item actions
const getOptionChosen = input => {
  const options = input.list.options;
  for (let index = 0; index < options.length; index++) {
    if (input.value == options[index].value) {
      return options[index];
    }
  }

  return null;
};

const getTotal = () => {
  const bodyt = document.getElementById('body-table');
  const rowCount = bodyt.rows.length;
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

const onDetailsInput = event => {
  const row = event.target.parentNode.parentNode;
  const descriptionCell = event.target.parentNode;
  const priceCell = row.cells[2];
  const subtotalCell = row.cells[3];
  const datalistInput = descriptionCell.children[0];
  const hiddenItemIdInput = descriptionCell.children[1];
  const hiddenPriceIdInput = descriptionCell.children[2];
  const option = getOptionChosen(datalistInput);

  if (!option) {
    priceCell.innerText = '';
    subtotalCell.innerText = '';
    hiddenItemIdInput.value = '';
    hiddenPriceIdInput.value = '';
  }
  else {
    const quantityInput = row.cells[0].children[0];
    const price = option.dataset.price;

    priceCell.innerText = parseFloat(price).toLocaleString(undefined, {minimumFractionDigits: 2});
    if (quantityInput.value) {
      subtotalCell.innerText = (parseInt(quantityInput.value) * parseFloat(price)).toLocaleString(undefined, {minimumFractionDigits: 2});
      hiddenItemIdInput.value = option.dataset.itemId;
      hiddenPriceIdInput.value = option.dataset.priceId;
    }
  }

  updateTotal();
};

const onQuantityInput = event => {
  const row = event.target.parentNode.parentNode;
  const txtPrice = row.cells[2].innerText;
  const quantityInput = event.target;

  if (txtPrice && quantityInput.value) {
    row.cells[3].innerText = (parseInt(quantityInput.value) * parseFloat(txtPrice)).toLocaleString(undefined, {minimumFractionDigits: 2});
  }
  else {
    row.cells[3].innerText = '';
  }

  updateTotal();
};

const rearrangeNameIndex = index => {
  const bodyt = document.getElementById('body-table');
  const length = bodyt.rows.length;    
  if (index <= length) {
    for (let rowCount = index - 1; rowCount < length; rowCount++) {
      const row = bodyt.rows[rowCount];
      const quantityInput = row.cells[0].children[0];
      const hiddenItemIdInput = row.cells[1].children[1];
      const hiddenPriceIdInput = row.cells[1].children[2];

      quantityInput.setAttribute('name', `items_order[${rowCount}][quantity]`);
      hiddenItemIdInput.setAttribute('name', `items_order[${rowCount}][item_id]`);
      hiddenPriceIdInput.setAttribute('name', `items_order[${rowCount}][price_id]`);
    }
  }
};

const deleteRow = button => {
  const index = button.parentNode.parentNode.rowIndex;
  document.getElementById('items-table').deleteRow(index);
  rearrangeNameIndex(index);
  updateTotal();
};

const createQuantityInput = rowCount => {
    const quantityInput = document.createElement('input');
    quantityInput.type = 'number';
    quantityInput.className = 'form-control';
    quantityInput.setAttribute('name', `items_order[${rowCount}][quantity]`);
    quantityInput.setAttribute('min', '1');
    quantityInput.setAttribute('max', '9999');
    quantityInput.addEventListener('input', onQuantityInput);
    quantityInput.value = 1;
    quantityInput.required = true;
    return quantityInput;
};

const createDatalistInput = () => {
  const datalistInput = document.createElement('input');
  datalistInput.type = 'text';
  datalistInput.className = 'form-control';
  datalistInput.setAttribute('list', 'itemList');
  datalistInput.placeholder = 'Nombre del artículo o servicio...';
  datalistInput.addEventListener('input', onDetailsInput);
  datalistInput.required = true;
  return datalistInput;
};

const createItemIdHiddenInput = rowCount => {
  const hiddenItemIdInput = document.createElement('input');
  hiddenItemIdInput.type = 'hidden';
  hiddenItemIdInput.setAttribute('name', `items_order[${rowCount}][item_id]`);
  return hiddenItemIdInput;
};

const createPriceIdHiddenInput = rowCount => {
  const hiddenPriceIdInput = document.createElement('input');
  hiddenPriceIdInput.type = 'hidden';
  hiddenPriceIdInput.setAttribute('name', `items_order[${rowCount}][price_id]`);
  return hiddenPriceIdInput;
};  

const createDeleteButton = () => {
  const delButton = document.createElement('button');
  delButton.type = 'button';
  delButton.className = 'btn btn-danger btn-sm';
  delButton.addEventListener('click', () => deleteRow(delButton));
  delButton.innerHTML  = '<i class="far fa-trash-alt"></i><span class="d-none d-md-inline"> Borrar</span>';
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
    descriptionCell.appendChild(createDatalistInput());
    descriptionCell.appendChild(createItemIdHiddenInput(rowCount));
    descriptionCell.appendChild(createPriceIdHiddenInput(rowCount));

    const priceCell = newRow.insertCell(2);
    priceCell.className = 'align-middle text-end';

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

// input validations of items
const isTheClientInvalid = () => {
  const hiddenClientInput = document.getElementById('client_id');
  const clientInput = document.getElementById('client_name');

  if (hiddenClientInput.value)
  {
    clientInput.setCustomValidity('');
    return false;
  }

  clientInput.setCustomValidity('Debe intresar un nombre de cliente valido');
  clientInput.reportValidity();
  return true;
}

const thereIsAnyEmptyItem = () => {
  const bodyt = document.getElementById('body-table');

  for (const row of bodyt.rows) {
    const subtotalCell = row.cells[3];
    const descriptionInput = row.cells[1].children[0];

    descriptionInput.setCustomValidity('');
    if (subtotalCell.innerText == '') {
      descriptionInput.setCustomValidity('Debe ingresar un artículo o servicio existente');
      descriptionInput.reportValidity();
      return true;
    }
  }

  return false;
};

const submitOrderForm = () => {
  if (thereIsAnyEmptyItem() || isTheClientInvalid()) {
    return false;
  }

  return true;
};

const submitButton = document.getElementById('btn-submit');
if (submitButton) {
  submitButton.addEventListener('click', submitOrderForm);
}

// add events to inputs and buttons
const quantityInputs = document.getElementsByClassName('quantity-input');
Array.prototype.forEach.call(quantityInputs, item => {
  item.addEventListener('input', onQuantityInput);
});

const descriptionInputs = document.getElementsByClassName('description-input');
Array.prototype.forEach.call(descriptionInputs, item => {
  item.addEventListener('input', onDetailsInput);
});

const delButtons = document.getElementsByClassName('del-button');
Array.prototype.forEach.call(delButtons, item => {
  item.addEventListener('click', () => deleteRow(item));
});

updateTotal();

// nav-links
const setActive = (link) => {
  link.classList.add('active');
}

const navLinks = document.getElementsByClassName('menu-item');
Array.prototype.forEach.call(navLinks, link => {
  link.addEventListener('click', () => setActive(link));
});