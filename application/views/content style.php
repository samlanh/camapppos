<div class="container" style=" padding-right: 0px; padding-left: 0px;">
		<div class="row" style=" margin-right: 0px; margin-left: 0px;">
			<div class="col-xs-2"  style="padding-right: 5px; padding-left: 5px;">
				<div class="panel panel-default">
					<div class="panel-heading clearfix">
						<strong>Header</strong>
					</div>
					<div class="panel-body">
					Body
					</div>
					<div class="panel-footer ">
						Footer
					</div>
                </div>
			</div>

			<div class="col-xs-10" style="padding-right: 5px; padding-left: 5px;">
				<div class="panel panel-default">
					<div class="panel-heading clearfix">
						<strong>Header</strong>
					</div>
					<div class="panel-body">
					Body
					</div>
					<div class="panel-footer ">
						Footer
					</div>
                </div>
			</div>
		</div>
	</div>

<button type="submit" class="submit_button pull-right btn btn-primary" name="submit" id="submit"><i class="fa fa-save" aria-hidden="true"></i> <?= lang('common_submit') ?> </button>



<button type="button" class="btn btn-info" data-toggle="modal" data-target="#contact_dialog">Contact</button>
     
<!-- the div that represents the modal dialog -->
<div class="modal fade" id="contact_dialog" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Enter your name</h4>
            </div>
                <div class="modal-body">
                    <form id="contact_form" action="/onlinejson/test.php" method="POST">
                        First name: <input type="text" name="first_name"><br/>
                        Last name: <input type="text" name="last_name"><br/>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <button type="button" id="submitForm" class="btn btn-default">Send</button>
                </div>
            </div>
        </div>
    </div>

   
    <script>
/* must apply only after HTML has loaded */
$(document).ready(function () {
    $("#contact_form").on("submit", function(e) {
        var postData = $(this).serializeArray();
        var formURL = $(this).attr("action");
        $.ajax({
            url: formURL,
            type: "POST",
            data: postData,
            success: function(data, textStatus, jqXHR) {
                $('#contact_dialog .modal-header .modal-title').html("Result");
                $('#contact_dialog .modal-body').html(data);
                $("#submitForm").remove();
            },
            error: function(jqXHR, status, error) {
                console.log(status + ": " + error);
            }
        });
        e.preventDefault();
    });
     
    $("#submitForm").on('click', function() {
        $("#contact_form").submit();
    });
});
</script>