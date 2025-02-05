"use strict"
document.addEventListener('DOMContentLoaded',(e)=>{
    let token = document.querySelector('#token').getAttribute('data-token');
    let denomination_difference = document.querySelectorAll('.denomination-difference');
    let denomination_cashcount = document.querySelectorAll('.denomination-cashcount');
    let operation_difference = document.querySelectorAll('.operation-difference');
    let operation_cashcount = document.querySelectorAll('.operation-cashcount');
    let totaL_operation_difference = document.querySelector('.total-operation-difference');
    let total_operation_cashcount = document.querySelector('.total-operation-cashcount');
    let data = JSON.parse(localStorage.getItem(`cash_data_${token}`));
    if (data) {
        totaL_operation_difference.textContent = data.total_operation_difference;
        total_operation_cashcount.value = data.total_operation_cashcount;
        denomination_difference.forEach((item) => {
            let denomination_name = item.getAttribute('data-name');
            if (data.denomination_difference.hasOwnProperty(denomination_name)) {
                item.textContent = data.denomination_difference[denomination_name];
            }
        });
        denomination_cashcount.forEach((item) => {
            let denomination_name = item.getAttribute('name');
            if (data.denomination_cashcount.hasOwnProperty(denomination_name)) {
                item.value = data.denomination_cashcount[denomination_name];
            }
        });
        operation_difference.forEach((item) => {
            let denomination_name = item.getAttribute('data-name');
            if (data.operation_difference.hasOwnProperty(denomination_name)) {
                item.textContent = data.operation_difference[denomination_name];
            }
        });
        operation_cashcount.forEach((item) => {
            let denomination_name = item.getAttribute('data-name');
            if (data.operation_cashcount.hasOwnProperty(denomination_name)) {
                item.textContent = data.operation_cashcount[denomination_name];
            }
        });
    }
});

const operation_billcoin = (element)=>{
    let denomination_closing = document.querySelectorAll('.denomination-closing');
    let denomination_difference = document.querySelectorAll('.denomination-difference');
    let denomination_cashcount = document.querySelectorAll('.denomination-cashcount');
    let operation_closing = document.querySelectorAll('.operation-closing');
    let operation_difference = document.querySelectorAll('.operation-difference');
    let operation_cashcount = document.querySelectorAll('.operation-cashcount');
    let totaL_operation_difference = document.querySelector('.total-operation-difference');
    let total_operation_cashcount = document.querySelector('.total-operation-cashcount');
    if (element){
        const validRegex = /^-?\d*(\.\d{0,2})?$/;
        if (!validRegex.test(element.value)) {
            element.value = element.value.slice(0, -1);
        }
        let denomination = element.getAttribute('data-denomination');
        let index = element.getAttribute('data-index');
        let quantity_closing = parseInt(denomination_closing[index].textContent) || 0;
        let quantity_cashcount = parseInt(denomination_cashcount[index].value) || 0;
        let quantity_difference = quantity_cashcount - quantity_closing;
        let value_difference = parseFloat(quantity_difference) * parseFloat(denomination);
        let value_cashcount = parseFloat(quantity_cashcount) * parseFloat(denomination);
        denomination_difference[index].textContent = quantity_difference;
        operation_difference[index].textContent = value_difference.toFixed(2);
        operation_cashcount[index].textContent = value_cashcount.toFixed(2);
        let result = 0;
        operation_difference.forEach((item, index) => {
            result += parseFloat(item.textContent);
        });
        let total_amount = 0;
        operation_cashcount.forEach((item, index) => {
            total_amount += parseFloat(item.textContent);
        });
        totaL_operation_difference.textContent = result.toFixed(2);
        total_operation_cashcount.value = total_amount.toFixed(2);

        let token = document.querySelector('#token').getAttribute('data-token');
        let object_denomination_difference = {};
        denomination_difference.forEach((item) => {
            let denomination_name = item.getAttribute('data-name');
            object_denomination_difference[denomination_name] = item.textContent;
        });
        let object_denomination_cashcount = {};
        denomination_cashcount.forEach((item) => {
            let denomination_name = item.getAttribute('name');
            object_denomination_cashcount[denomination_name] = item.value;
        });
        let object_operation_difference = {};
        operation_difference.forEach((item) => {
            let denomination_name = item.getAttribute('data-name');
            object_operation_difference[denomination_name] = item.textContent;
        });
        let object_operation_cashcount = {};
        operation_cashcount.forEach((item) => {
            let denomination_name = item.getAttribute('data-name');
            object_operation_cashcount[denomination_name] = item.textContent;
        });
        let data = {
            total_operation_difference: totaL_operation_difference.textContent,
            total_operation_cashcount: total_operation_cashcount.value,
            denomination_difference: object_denomination_difference,
            denomination_cashcount: object_denomination_cashcount,
            operation_difference: object_operation_difference,
            operation_cashcount: object_operation_cashcount
        };
        localStorage.setItem(`cash_data_${token}`, JSON.stringify(data));
    }
}


