<div class="view">   

    <div class="row">
        <div class="col-md-12">
            <h3 class="text-green">
                <span style="font-weight: bold;">Subject:</span> 
                <?php echo CHtml::encode($model->contact_subject); ?>
            </h3>
            <hr/>   
        </div>
    </div>   
    <div class="table-responsive">
        <div class="lblmsg2"></div>        
        <div class="messagesList"></div>
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

    .my_block {
        border: 1px solid #ddd;
        border-radius: 4px;
        padding: 5px;
    }

    .my_block > small {
        display: block;
        font-size: 10px;
        font-style: italic;
        text-align: right;
    }

</style>
<script type="text/javascript">

    $(function() {
        getList();

        $('#replyMessageListTab').click(function() {
            getList();
        });
    });

    function getList() {
        $('.messagesList').html('');
        $.ajax({
            url: '/contact/replyList',
            type: 'POST',
            dataType: 'JSON',
            data: {id: <?php echo $model->contact_id ?>},
            success: function(res) {
                if (res.flag == "1") {
                    $('.lblmsg2').removeClass('alert alert-danger');

                    $.each(res.data, function(key, value) {
                        var message = value.message;
                        var datetime = value.datetime;
                        var data = '<p class="my_block"><b>Message:</b> ' + message + '<br/><small><i class="fa fa-clock-o"></i> ' + datetime + '</small></p>'
                        $('.messagesList').append(data);
                    });

                } else {
                    $('.lblmsg2').removeClass('alert alert-success');
                    $('.lblmsg2').addClass('alert alert-danger');
                    $('.lblmsg2').html('No messages found.');
                }
            }
        });
    }

</script>