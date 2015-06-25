<div class="view">   

    <div class="row">
        <div class="col-md-12">
            <h3 class="text-green"><?php echo CHtml::encode($model->faqs_ques); ?></h3>
            <hr/>   
        </div>
    </div>

    <div class="table-responsive">
        <table class="table table-bordered table-striped">            
            <tbody>
                <tr>                    
                    <td><?php echo preg_replace('/(<br>)+$/', '', $model->faqs_ans); ?></td>
                </tr>                
            </tbody>
        </table>
    </div>    
</div>

<div class="modal fade" id="msgModal" tabindex="-1" role="dialog" aria-labelledby="standardModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">            
            <div class="modal-body">
                <img id="show_img"/>                
            </div>            
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