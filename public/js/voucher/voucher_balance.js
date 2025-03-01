document.addEventListener("DOMContentLoaded", () => {
    total_balance();
})
const total_balance = ()=>{
    let difference = document.getElementById('total_difference');
    let debit = document.getElementById('total_debit');
    let credit = document.getElementById('total_credit');
    let debit_inputs = document.querySelectorAll(".debit-input");
    let credit_inputs = document.querySelectorAll(".credit-input");
    let total_debit = 0;
    let total_credit = 0;
    debit_inputs.forEach(item =>{
        total_debit += parseFloat(item.value) || 0;
    })
    credit_inputs.forEach(item =>{
        total_credit += parseFloat(item.value) || 0;
    })
    debit.textContent = total_debit.toFixed(2);
    credit.textContent = total_credit.toFixed(2);
    difference.textContent = (total_debit - total_credit).toFixed(2);
    if (total_debit != total_credit){
        difference.classList.remove('text-yellow-600');
        debit.classList.remove('text-yellow-600','bg-yellow-100');
        credit.classList.remove('text-yellow-600','bg-yellow-100');
        difference.classList.add('text-green-600');
        debit.classList.add('text-green-600','bg-green-100');
        credit.classList.add('text-green-600','bg-green-100');
    }
    if (total_debit == total_credit){
        difference.classList.remove('text-green-600');
        debit.classList.remove('text-green-600','bg-green-100');
        credit.classList.remove('text-green-600','bg-green-100');
        difference.classList.add('text-yellow-600');
        debit.classList.add('text-yellow-600','bg-yellow-100');
        credit.classList.add('text-yellow-600','bg-yellow-100');
    }
}
