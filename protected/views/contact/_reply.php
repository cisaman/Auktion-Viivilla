<div class="view">   

    <div class="row">
        <div class="col-md-12">
            <h3 class="text-green">
                <span style="font-weight: bold;">Reply to Message:</span> 
                <?php echo CHtml::encode($model->contact_subject); ?>
            </h3>
            <hr/>   
        </div>
    </div>   
    <div class="table-responsive">
        <div class="lblmsg"></div>
        <div class="form-group">
            <textarea class="form-control" id="txtmessage" maxlength="600" rows="6" placeholder="Enter your message..."></textarea>
        </div>
        <div class="form-group">
            <input type="button" id="btnSend" name="btnSend" value="Send" class="btn btn-success" />
        </div>
    </div>
</div>

<style type="text/css">

    .modal-body > img {
        width: 100%;
    }

    th{
        width: 150px;
    }

    @media (min-width:320px) and (min-width:360px) {
        .view {
            padding: 0 !important;
        }
    }

    @media (min-width:361px){
        .view {
            padding: 0 30px !important;
        }
    }   
</style>
<script type="text/javascript">
    $('#btnSend').click(function() {
        $('.lblmsg').removeClass('alert alert-danger');
        $('.lblmsg').html('');

        if ($('#txtmessage').val() == '') {
            $('.lblmsg').addClass('alert alert-danger');
            $('.lblmsg').html('Please enter message');
            $('#txtmessage').focus();
        } else {
            var message = $('#txtmessage').val();

            $.ajax({
                url: '/contact/reply',
                type: 'POST',
                dataType: 'JSON',
                data: {message: message, id: <?php echo $model->contact_id ?>},
                success: function(res) {
                    if (res.flag == "1") {
                        $('.lblmsg').removeClass('alert alert-danger');
                        $('.lblmsg').addClass('alert alert-success');
                        $('.lblmsg').html('Message sent successfully.');
                    } else {
                        $('.lblmsg').removeClass('alert alert-success');
                        $('.lblmsg').addClass('alert alert-danger');
                        $('.lblmsg').html('Message not sent.');
                    }
                    $('#txtmessage').val('');
                }
            });
        }
    });
</script>