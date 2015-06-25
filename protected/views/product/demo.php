
<input id="demo2" type="text" class="col-md-12 form-control" placeholder="Search cities..." autocomplete="off" />

<script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl ?>/bootstrap/dashboard/js/bootstrap-typeahead.min.js" charset="UTF-8"></script>


<script type="text/javascript">
    var sellers = [];
    $.ajax({
        url: '/index.php/sellers/getAllSellers',
        type: 'POST',
        async: false,
        dataType: 'JSON',
        success: function (res) {
            $('#Product_product_sellersID').text('');
            $.each(res, function (key, value) {
                sellers.push(value);
            });
        }
    });

    $(function () {
        function displayResult(item) {
            alert(item.value);
        }

        $('#demo2').typeahead({
            source: sellers,
            displayField: 'name',
            valueField: 'id',
            onSelect: displayResult
        });
    })
</script>