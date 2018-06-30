<table class="display responsive" width="100%" id="pend_table">
    <thead class="table-header">
    <tr>
        <?php if ($this->user->info->admin) : ?>
            <td><?php echo lang("ctn_209") ?></td>
        <?php endif; ?>
        <td>Case Id</td>
        <td>Case Description</td>
        <td>Date</td>
        <td>Status</td>
       <!-- <td>Case Type</td> -->
        <td>Actual AMount</td>
        <?php if ($this->user->info->admin) : ?>
             <td>Action</td>
        <?php endif; ?>
    </tr>
    </thead>
    <tbody>
    <?php if ($this->user->info->admin) : ?>
        <?php foreach($customcaselist as $record) :  ?>
            <tr>
                <td><?php echo $record['username']; ?></td>
                <td><a target="_blank" href="https://sellercentral.amazon.com/gp/case-dashboard/view-case.html/?ie=UTF8&caseID=<?php echo $record['caseId'] ?>"><?php echo $record['caseId']; ?></a></td>
                <td><?php echo $record['message']; ?></td>
                <td><?php echo date('Y-m-d',strtotime($record['createdAt'])); ?></td>
                <td><?php if(isset($record['case_status']) && $record['case_status'] == 1) echo '<p style="color:red;">Pending</p>'; ?><?php if(isset($record['case_status']) && $record['case_status'] == 2) echo '<p style="color:green;">Success</p>'; ?><?php if(isset($record['case_status']) && $record['case_status'] == 3) echo '<p style="color:deepskyblue;">Denied</p>'; ?><?php if(isset($record['case_status']) && $record['case_status'] == 4) echo '<p style="color:deepskyblue;">Approved</p>'; ?><?php if(isset($record['case_status']) && $record['case_status'] == 5) echo '<p style="color:deepskyblue;">Verification</p>'; ?><?php if(isset($record['case_status']) && $record['case_status'] == 6) echo '<p style="color:deepskyblue;">Case close</p>'; ?></td>
                <!--<td><?php //echo $record['custom_case_type']; ?></td> -->
                <td><?php if($record['amount'] == '') { echo ''; } else { echo "$".$record['amount']; }  ?></td>
                <td><?php if(isset($record['case_status']) && $record['case_status'] != 6): ?>
                    <a href="#" class="case" data-toggle="modal"id="<?php echo $record['custom_id']; ?>" data-target="#myModal">Edit</a> | <?php endif; ?> <a href="<?php echo site_url('Custom_case/remove_custom_case/' . $record['custom_id']); ?>" class="delete" id="delete<?php echo $record['custom_id']; ?>">Delete</a> |  <a href="javascript::" class="user_detail" data-toggle="modal" id="<?php echo $record['custom_id'];?>" data-target="#myModal_detail">Case Detail</a><br>
                </td>
            </tr>
        <?php endforeach; ?>
        <?php else : ?>
        <?php foreach($customcase as $record) : ?>
            <tr>
                <td><a target="_blank" href="https://sellercentral.amazon.com/gp/case-dashboard/view-case.html/?ie=UTF8&caseID=<?php echo $record['caseId'] ?>"><?php echo $record['caseId']; ?></a></td>
                <td><?php echo $record['message']; ?></td>
                <td><?php echo date('Y-m-d',strtotime($record['createdAt'])); ?></td>
                <td><?php if(isset($record['case_status']) && $record['case_status'] == 1) echo '<p style="color:red;">Pending</p>'; ?><?php if(isset($record['case_status']) && $record['case_status'] == 2) echo '<p style="color:green;">Success</p>'; ?><?php if(isset($record['case_status']) && $record['case_status'] == 3) echo '<p style="color:deepskyblue;">Denied</p>'; ?><?php if(isset($record['case_status']) && $record['case_status'] == 4) echo '<p style="color:deepskyblue;">Approved</p>'; ?><?php if(isset($record['case_status']) && $record['case_status'] == 5) echo '<p style="color:deepskyblue;">Verification</p>'; ?><?php if(isset($record['case_status']) && $record['case_status'] == 6) echo '<p style="color:deepskyblue;">Case close</p>'; ?></td>
                <!--<td><?php //echo $record['custom_case_type']; ?></td> -->
                <td><?php if($record['amount'] == '') { echo ''; } else { echo "$". $record['amount']; }  ?></td>
            </tr>
        <?php endforeach; ?>
    <?php endif; ?>
    </tbody>
</table>

<script>

    $(document).ready(function ()
    {
        $('#pend_table').DataTable({
            "searching": true,
            "responsive": true
        });
    });

    $('.delete').on('click', function (e) {
        e.preventDefault();
        var url = $(this).attr('href');
        swal({
                title: "Confirm",
                text: "Are you sure you want to delete this record?",
                type: "warning",
                showCancelButton: true,
                confirmButtonColor: '#DD6B55',
                confirmButtonText: 'YES',
                cancelButtonText: "NO",
                confirmButtonClass: "btn-danger",
                closeOnConfirm: true,
                closeOnCancel: true
            },
            function (isConfirm) {
                if (isConfirm) {
                    swal("Done!", "Case deleted successfully!", "success");
                    window.location.replace(url);
                }
            });
    });

    $('.user_detail').on('click',function(e){
        var id = $(this).attr('id');
        var baseURL = '<?php echo site_url() . 'Custom_case/customecasedetail/' ?>'+id;
        $.ajax({
            type:"GET",
            url:baseURL,
            success: function(result)
            {
                var detail = jQuery.parseJSON(result);
                var date = detail.createdAt.split(' ')[0];

                $('#date').text(date);
                //$('#case_type').text(detail.custom_case_type);
                //$('#case_type_head').text(detail.custom_case_type);
                $('#case_id').text(detail.caseId);

                var amz_status = detail.status;
                if(amz_status == 1)
                    $('#amz_status').text('Pending');
                if(amz_status == 2)
                    $('#amz_status').text('success');
                if(amz_status == 3)
                    $('#amz_status').text('denied');
                if(amz_status == 1)
                    $('#amz_status').text('Approved');
                if(amz_status == 1)
                    $('#amz_status').text('Verification');
                if(amz_status == 1)
                    $('#amz_status').text('Case Closed');


                return false;
            }
        });
    });

    $('.case').on('click', function (e) {
        var id = $(this).attr('id');
        var baseURL = '<?php echo site_url() . 'Custom_case/editCustomCaseDetail/' ?>' + id;
        $.ajax({
            type: "GET",
            url: baseURL,
            success: function (result)
            {
                var data = $.parseJSON(result);
                $('#id').val(data.id);
                $('#case_Id').val(data.caseId);
                var date = data.createdAt.split(' ')[0];
                $('#caseDate').val(date);
                $('#case_status_detail').val(data.status);
                //$('#amazon').val(data.custom_reason);

                if(data.status == 3)
                {
                    $('#amazonDeniedReason').show();
                }
                else
                {
                    $('#amazonDeniedReason').hide();
                }

                return false;
            }
        });
    });

    $(document).ready(function ()
    {
        $('body').on('click', '#selectall', function ()
        {
            if ($(this).hasClass('allChecked'))
            {
                $('input[type="checkbox"]', '#pend_table').prop('checked', false);
            }
            else
            {
                $('input[type="checkbox"]', '#pend_table').prop('checked', true);
            }
            $(this).toggleClass('allChecked');
        })
    });

    $("#case_status").change(function () {
        var selectedValue = $(this).val();
        $("#txtBox").val($(this).find("option:selected").attr("value"))
    });

    $(document).ready(function ()
    {
        $("#casestatus").click(function()
        {
            caseStatusChange();
        });
    });

    function caseStatusChange()
    {
        var chkArray = [];
        $(".caseStatusChange:checked").each(function () {
            chkArray.push($(this).val());
        });
        var selected = chkArray.join(',');
        var txtBox = $('#txtBox').val();

        if (selected.length == 0)
        {
            $('#msg').html("<div class='alert alert-danger' style='margin-left: 20px; width:1200px'>Please Select At least One checkbox.</div>");
        }
        else if (txtBox.length == 0)
        {
            $('#msg').html("<div class='alert alert-danger' style='margin-left: 20px; width:1200px'>Please Select case status.</div>");
        }
        else
        {
            var baseURL = '<?php echo site_url() . 'custom_case/CustomCaseStatusUpdate' ?>';

            $.ajax
            ({
                type: "POST",
                url: baseURL,
                data: {'selected': selected, 'txtbox': txtBox},
                success: function (result) {
                    setTimeout(function () {
                        window.location.reload();
                        return true;
                    }, 1000);
                }
            });
        }
    }

    $(function ()
    {
        $('#case_status_detail').change(function ()
        {
            $('#amazonDeniedReason').hide();
            if (this.options[this.selectedIndex].value == '3')
            {
                $('#amazonDeniedReason').show();
            }
        });
    });



</script>