<div id="<?php echo $id ?>"></div>
<script type="text/javascript">
    var chart = c3.generate({
        bindto: '<?php echo "#$id" ?>',
        data: {
            x: '<?php echo $field1 ?>',
            rows: <?php echo $data ?>,
            groups: [<?php echo $groups ?>],
            type: 'bar',
            order: null,

        },
        legend: {
            position: 'right'
        },
        axis: {
            x: {
                type: 'category'
            }
        },
        point: {
            show: true
        },
    });
</script>






