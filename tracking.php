<?php include 'template/header.php'; ?>
<!-- Content -->
<div id="content">
    <!-- Breadcrumb -->
    <ul class="breadcrumb">
        <li><a href="files.php" class="glyphicons home"><i></i> File Management</a></li>
        <li class="divider"></li>
        <li>File Tracking System</li>
    </ul>
    <div class="separator bottom"></div>
    <!-- // Breadcrumb END -->

    <!-- Heading -->
    <div class="heading-buttons">
        <h3>File Tracking System</h3>
        <div class="clearfix"></div>
    </div>
    <div class="separator bottom"></div>
    <!-- // Heading END -->
    <?php
    ?>

    <div class="innerLR">	
        <div class="widget">

            <!-- Widget heading -->
            <div class="widget-head">
                <h4 class="heading">Please select file number to view detail</h4>
            </div>
            <!-- // Widget heading END -->

            <div class="widget-body">
                <form action="" method="get">
                    <div class="row-fluid">
                        <div class="span3">
                            <h5>File No</h5>
                            <div class="row-fluid">
                                <select class="span12" id="id" name="id">
                                    <option value="">Select</option>
                                    <?php
                                    require_once 'classes/files.php';
                                    $files = new files();
                                    $file = $files->find_by_user($_SESSION['userid']);
                                    if ($file->num_rows > 0) {
                                        while ($rowd = $file->fetch_array()) {
                                            ?>
                                            <option value="<?php echo $rowd['pk_id']; ?>" <?php if (isset($_GET['id']) && $rowd['pk_id'] == $_GET['id']) echo "selected"; ?>><?php echo $rowd['file_no']; ?></option>
                                            <?php
                                        }
                                    }
                                    ?>
                                </select>

                            </div>
                        </div>
                        <div class="span3">
                            <h5>&nbsp;</h5>
                            <div class="row-fluid">
                                <button class="span2 btn btn-primary" type="submit">Go</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <!-- Table -->
<?php if (isset($_GET['id']) && !empty($_GET['id'])) { ?>
            <table class="table table-bordered table-condensed table-striped table-vertical-center checkboxs js-table-sortable">
                <thead>
                    <tr>
                        <th style="width: 1%;" class="center">No.</th>
                        <th>Subject</th>
                        <th>Transfer From</th>
                        <th>Transfer To</th>
                        <th>Transfer Date</th>
                        <th>Aging</th>
                        <th>Details</th>                        
                    </tr>
                </thead>
                <tbody>
                    <!-- Table row -->
                    <?php
                    require_once 'classes/tracking.php';
                    $tracking = new tracking();
                    $result = $tracking->find_by_file($_GET['id']);
                    $count = 1;
                    while ($row = $result->fetch_array()) {
                        ?>
                        <tr class="selectable">
                            <td class="center"><?php echo $count; ?></td>
                            <td><strong><?php echo $row['subject']; ?></strong></td>
                            <td class="important"><?php echo $row['from']; ?></td>
                            <td class="important"><?php echo $row['to']; ?></td>
                            <td class="important"><?php echo $row['in_date']; ?></td>
                            <td class="important"><?php echo $row['aging']; ?> days</td>
                            <td class="center" style="width: 60px;">
                                <a href="<?php echo $row['file_path']; ?>" target="_blank" class="btn-action glyphicons file btn-success"><i></i></a>
                                <a href="#details" id="<?php echo $row['pk_id']; ?>-did" data-toggle="modal" class="btn-action glyphicons more btn-success"><i></i></a>
                            </td>
                        </tr>
                        <?php $count++;
                    }
                    ?>
                    <!-- // Table row END -->

                    <!-- // Table row END -->
                </tbody>
            </table>
<?php } ?>
        <!-- // Table END -->

        <!-- With selected options -->
        <!--        <div class="separator top form-inline small">
                    <div class="pull-left checkboxs_actions hide">
                        <label class="strong">With selected:</label>
                        <select class="selectpicker" data-style="btn-default btn-small">
                            <option>Action</option>
                            <option>Action</option>
                            <option>Action</option>
                        </select>
                    </div>
                     // With selected options END 
        
                     Pagination 
                    <div class="pagination pull-right" style="margin: 0;">
                        <ul>
                            <li class="disabled"><a href="#">&laquo;</a></li>
                            <li class="active"><a href="#">1</a></li>
                            <li><a href="#">2</a></li>
                            <li><a href="#">3</a></li>
                            <li><a href="#">&raquo;</a></li>
                        </ul>
                    </div>
                    <div class="clearfix"></div>
                </div>-->
        <!-- // Pagination END -->

    </div>	

    <div class="modal hide fade" id="details">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            <h3>File Transfer Details</h3>
        </div>
        <div class="modal-body" id="transfer-details">
            <div class="center"><img src="common/bootstrap/extend/bootstrap-image-gallery/img/loading.gif"/></div>
        </div>
        <div class="modal-footer">

        </div>
    </div>

</div>
<!-- // Content END -->
<?php include 'template/footer.php'; ?>
<script>
    $("a[id$='-did']").click(function () {
        var value = $(this).attr("id");
        var id = value.replace("-did", "");

        $.ajax({
            type: "POST",
            url: "ajax-details.php",
            data: {
                id: id
            },
            dataType: 'html',
            success: function (data) {
                $('#transfer-details').html(data);
            }
        });
    });
</script>
</body>
</html>