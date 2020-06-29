//select on change method in jquery....

$('#sub_category_id').on('change', function() {
    alert( this.value );
});


//how to loop inside ajax resonse
response.sub_category.forEach(function(item) {
    data += `<option value="${item.id}">${item.name}</option>`;
});