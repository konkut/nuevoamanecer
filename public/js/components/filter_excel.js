document.getElementById('filter').addEventListener('change', function () {
    document.getElementById('custom-range').style.display = this.value === 'custom' ? 'flex' : 'none';
});
