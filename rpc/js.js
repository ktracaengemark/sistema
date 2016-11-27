//get a reference to the select element
$select = $('#people');

// get the hash
var csrf_test_name = $("input[name=csrf_test_name]").val();


//request the JSON data and parse into the select element
$.ajax({
    url: 'json.php',
    dataType: 'JSON',
    type: "POST",
    data: {
        '<?php echo $this->security->get_csrf_token_name(); ?>': '<?php echo $this->security->get_csrf_hash(); ?>',
    },
    success: function (data) {
        //clear the current content of the select
        $select.html('');
        //iterate over the data and append a select option
        $.each(data, function (key, val) {
            $select.append('<option id="' + val.id + '">' + val.name + '</option>');
        })
    },
    error: function () {
        //if there is an error append a 'none available' option
        $select.html('<option id="-1">ERRO</option>');
    }
});