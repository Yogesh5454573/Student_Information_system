<form id="addform">
    <div class="row">
        <div class="col-md-12">
            <div class="purchasegrp">
                <label class="purchaseinfo"><span class="aster">* </span>Name</label>
                <input type="text" class="form-control purchaseselects" name="name">
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="purchasegrp">
                <label class="purchaseinfo">Amount</label>
                <input type="number" class="form-control purchaseselects" name="amount">
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="purchasegrp">
                <label class="purchaseinfo">Referral Id</label>
                <input type="text" class="form-control purchaseselects" id="referral_div" name="referral_name">
                <input type="hidden" id="referral_id" name="referral_id">
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12 blkftr">
            <div class="modal-footer taskfooter">
                <button type="submit" class="tasksave1">
                    SAVE
                </button>
            </div>
        </div>
    </div>
</form>
<script>
$(document).ready(function() {

    // Handle focus out event on #referral_div
    $("#referral_div").focusout(function() {
        var inputValue = $(this).val();
        $('#referral_id').val(inputValue);

        $.ajax({
            url: '<?=base_url()?>getid',
            type: 'POST',
            data: { user_id: inputValue },
            success: function(response) {
                try {
                    var result = JSON.parse(response);
                    if (result.getid && result.getid.name) {
                        $('#referral_div').val(result.getid.name);
                        console.log(result.getid.name);
                    } else {
                        console.error("Unexpected response structure:", result);
                        $('#referral_div').val(''); // Clear input if unexpected structure
                    }
                } catch (e) {
                    console.error("Error parsing JSON response:", e);
                    $('#referral_div').val(''); // Clear input on parsing error
                }

                $('#response').html('Server response: ' + response);
            },
            error: function(xhr, status, error) {
                console.error("Failed to send POST request:", error);
                $('#response').html('An error occurred: ' + error);
            }
        });
    });

    // Form validation and submission
    $('#addform').formValidation({
        framework: 'bootstrap',
        fields: {
            name: {
                validators: {
                    notEmpty: {
                        message: 'Enter name'
                    }
                }
            }
        }
    }).on('success.form.fv', function(e) {
        e.preventDefault(); // Prevent form submission

        var form = document.querySelector('#addform');
        var dataForm = new FormData(form);

        $.ajax({
            type: 'POST',
            url: '<?=base_url()?>addData',
            data: dataForm,
            cache: false,
            contentType: false,
            processData: false,
            dataType: 'json',
            success: function(result) {
                if (result == 1) {
                    $('#modal_md').modal('hide');
                    alert('Saved successfully');
                    getData();
                } else {
                    alert('Already exists');
                }
            },
            error: function(xhr, status, error) {
                console.error("Failed to submit form:", error);
                alert('An error occurred while saving data.');
            }
        });
    });
});
</script>
