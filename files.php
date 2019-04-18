<?php include 'template/header.php'; ?>
<!-- Content -->
<div id="content">
    <!-- Breadcrumb -->
    <ul class="breadcrumb">
        <li><a href="#" class="glyphicons home"><i></i> Home</a></li>
        <li class="divider"></li>
        <li>Manage Files</li>
    </ul>
    <div class="separator bottom"></div>
    <!-- // Breadcrumb END -->
    <?php if (isset($_GET['status']) && $_GET['status'] == 'attachment') { ?>
        <div class="alert alert-success">
            <button type="button" class="close" data-dismiss="alert">×</button>
            <strong>Success!</strong> Attachment has been deleted successfully!
        </div>
    <?php } ?>
    <?php if (isset($_GET['status']) && $_GET['status'] == 'file') { ?>
        <div class="alert alert-success">
            <button type="button" class="close" data-dismiss="alert">×</button>
            <strong>Success!</strong> File and all its attachments has been deleted successfully!
        </div>
    <?php } ?>
    <?php if (isset($_GET['status']) && $_GET['status'] == 'forbidden') { ?>
        <div class="alert alert-danger">
            <button type="button" class="close" data-dismiss="alert">×</button>
            <strong>Forbidden!</strong> You don't have permission to do this! Please contact your administrator!
        </div>
    <?php } ?>
    <!-- Heading -->
    <div class="heading-buttons">
        <h3>File Management</h3>
        <div class="buttons pull-right">
            <a href="#add-file" data-toggle="modal" class="btn btn-primary btn-icon glyphicons circle_plus"><i></i>New file</a>
        </div>
        <div class="clearfix"></div>
    </div>
    <div class="separator bottom"></div>
    <!-- // Heading END -->

    <div class="innerLR">
        <?php
        require_once 'classes/files.php';
        require_once 'classes/departments.php';
        require_once 'classes/attachments.php';

        $files = new files();
        $result = $files->find_by_user($_SESSION['userid']);
        if ($result) {
            ?>
            <!-- Table -->
            <table class="table table-bordered table-condensed table-striped table-vertical-center checkboxs js-table-sortable">
                <thead>
                    <tr>
                        <th style="width: 1%;" class="uniformjs"><input type="checkbox" /></th>
                        <th style="width: 1%;" class="center">No.</th>
                        <th>Title</th>
                        <th>Department</th>
                        <th>Author</th>
                        <th>No of attachments</th>
                        <th>Receive From</th>
                        <th>Comments</th>
                        <th class="right" colspan="3">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <!-- Table row -->
                    <?php
                    $count = 1;
                    while ($row = $result->fetch_array()) {

                        $attchment = new attachments();
                        $att_count = $attchment->count_all($row['pk_id']);
                        ?>
                        <tr class="selectable">
                            <td class="center uniformjs"><input type="checkbox" /></td>
                            <td class="center"><?php echo $count; ?></td>
                            <td><a href="tracking.php?id=<?php echo $row['pk_id']; ?>"><strong><?php echo $row['file_no']; ?></strong></a></td>
                            <td class="important"><?php echo $row['file_department']; ?></td>
                            <!--<td class="center js-sortable-handle"><span class="glyphicons btn-action single move" style="margin-right: 0;"><i></i></span></td>-->
                            <td class="important"><?php echo $row['username']; ?></td>
                            <td><?php if ($att_count > 0) { ?><a href="#file-detail" data-toggle="modal" id="<?php echo $row['pk_id']; ?>-aid"><i></i><?php echo $att_count; ?></a> <?php
                                } else {
                                    echo $att_count;
                                }
                                ?></td>
                            <td class="important"><?php echo $row['receive_from']; ?></td>
                            <td class="important"><?php echo $row['file_description']; ?></td>
                            <td class="center" style="width: 100px;"><?php echo $row['created_date']; ?></td>
                            <td class="center" style="width: 80px;"><span class="label label-block label-<?php echo (($row['iscreated'] == 'created') ? 'important' : 'inverse' ); ?>"><?php echo $row['iscreated']; ?></span></td>
                            <td class="center" style="width: 100px;">
                                <a href="#transfer-file" data-toggle="modal" id="<?php echo $row['pk_id']; ?>-tid" class="btn-action glyphicons up_arrow btn-action" title="transfer"><i></i></a>
                                <a href="#edit-file" data-toggle="modal" id="<?php echo $row['pk_id']; ?>-fid" class="btn-action glyphicons pen btn-action" title="edit"><i></i></a>
                                <a onclick="return confirm('All the attached files will also be parmanently delete from the system. Are you sure you want to delete the file?');" href="delete_file.php?id=<?php echo $row['pk_id']; ?>" class="btn-action glyphicons remove_2 btn-danger" title="delete"><i></i></a>
                            </td>
                        </tr>
                        <?php
                        $count++;
                    }
                    ?>
                    <!-- // Table row END -->
                    <!-- Table row -->

                    <!-- // Table row END -->
                </tbody>
            </table>
            <!-- // Table END -->
            <?php
        } else {
            echo "<hr><h5>Good news! No active file on your desk!</h5>";
        }
        ?>

        <!-- With selected options -->
        <div class="separator top form-inline small">
            <div class="pull-left checkboxs_actions hide">
                <label class="strong">With selected:</label>
                <select class="selectpicker" data-style="btn-default btn-small" onchange="return confirm('Do you want to delete all the files?')">
                    <option>Select</option>
                    <option>Delete All</option>
                </select>
            </div>
            <!-- // With selected options END -->

            <!-- Pagination -->
            <div class="pagination pull-right" style="margin: 0;">
                <ul>
                    <li class="disabled"><a href="#">&laquo;</a></li>
                    <li class="active"><a href="#">1</a></li>
<!--                    <li><a href="#">2</a></li>
                    <li><a href="#">3</a></li>
                    <li><a href="#">&raquo;</a></li>-->
                    <li class="disabled"><a href="#">&raquo;</a></li>
                </ul>

            </div>
            <div class="clearfix"></div>
        </div>
        <!-- // Pagination END -->

    </div>

    <form class="form-horizontal" enctype="multipart/form-data" style="margin-bottom: 0;" id="validateSubmitForm" method="post" autocomplete="off" action="add-file.php">
        <div class="modal hide fade" id="add-file">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h3>Add new file</h3>
            </div>
            <div class="modal-body">
                <!-- Row -->
                <div class="row-fluid">

                    <!-- Column -->
                    <div class="span12">

                        <!-- Group -->
                        <div class="control-group">
                            <label class="control-label" for="fileno">File no</label>
                            <div class="controls"><input class="span12" id="fileno" name="fileno" type="text" /></div>
                        </div>
                        <div class="control-group">
                            <label class="control-label" for="fileno">Title</label>
                            <div class="controls"><input class="span12" id="title" name="title" type="text" /></div>
                        </div>
                        <!-- // Group END -->

                        <!-- Group -->
                        <div class="control-group">
                            <label class="control-label" for="file_department">Department</label>
                            <div class="controls">
                                <select class="selectpicker span12" id="file_department" name="file_department">
                                    <?php
                                    $departments = new departments();
                                    $depart = $departments->find_all();
                                    while ($rowd = $depart->fetch_array()) {
                                        ?>
                                        <option value="<?php echo $rowd['pk_id']; ?>"><?php echo $rowd['name']; ?></option>
                                        <?php
                                    }
                                    ?>
                                </select> 
                            </div>
                        </div>
                        <!-- // Group END -->
                        <div class="control-group">
                            <label class="control-label" for="fileno">Description</label>
                            <div class="controls"><textarea class="span12" id="description" name="description"></textarea></div>
                        </div>
                        <!-- Group -->
                        <div class="control-group">
                            <label class="control-label" for="status">Status</label>
                            <div class="controls">
                                <select class="selectpicker span12" id="status" name="status">
                                    <option value="1">Open</option>
                                    <option value="2">Closed</option>
                                </select> 
                            </div>
                        </div>
                        <div class="control-group">
                            <label class="control-label" for="receive_from">Receive From</label>
                            <div class="controls"><input class="span12" id="receive_from" name="receive_from" type="text" /></div>
                        </div>
                        <!-- // Group END -->
                        <div class="control-group">
                            <label class="control-label" for="fileno">Attachments</label>
                            <div class="controls">
                                <input type="file" name="file[]" multiple />
                            </div>
                        </div>
                    </div>
                    <!-- // Column END -->



                </div>
                <!-- // Row END -->

                <!--<hr class="separator" />-->

                <!-- Row -->
                <!--                <div class="row-fluid uniformjs">
                
                                     Column 
                                    <div class="span4">
                                        <h4 style="margin-bottom: 10px;">Policy &amp; Newsletter</h4>
                                        <label class="checkbox" for="agree">
                                            <input type="checkbox" class="checkbox" id="agree" name="agree" />
                                            Please agree to our policy
                                        </label>
                                        <label class="checkbox" for="newsletter">
                                            <input type="checkbox" class="checkbox" id="newsletter" name="newsletter" />
                                            Receive Newsletter
                                        </label>
                                    </div>
                                     // Column END 
                
                                     Column 
                                    <div class="span8">
                                        <div id="newsletter_topics">
                                            <h4>Topics</h4>
                                            <p>Select at least two topics you would like to receive in the newsletter.</p>
                                            <label for="topic_marketflash">
                                                <input type="checkbox" id="topic_marketflash" value="marketflash" name="topic" />
                                                Marketflash
                                            </label>
                                            <label for="topic_fuzz">
                                                <input type="checkbox" id="topic_fuzz" value="fuzz" name="topic" />
                                                Latest fuzz
                                            </label>
                                            <label for="topic_digester">
                                                <input type="checkbox" id="topic_digester" value="digester" name="topic" />
                                                Mailing list digester
                                            </label>
                                        </div>
                                    </div>
                                     // Column END 
                
                                </div>-->
                <!-- // Row END -->



            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-icon btn-primary glyphicons circle_ok"><i></i>Save</button>
            </div>
        </div>
    </form>

    <form class="form-horizontal" enctype="multipart/form-data" style="margin-bottom: 0;" id="validateSubmitForm" method="post" autocomplete="off" action="add-file.php">
        <div class="modal hide fade" id="edit-file">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h3>Edit file</h3>
            </div>
            <div class="modal-body" id="edit">
                <div class="center"><img src="common/bootstrap/extend/bootstrap-image-gallery/img/loading.gif"/></div>
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-icon btn-primary glyphicons circle_ok"><i></i>Save</button>
            </div>
        </div>
    </form>

    <form class="form-horizontal" style="margin-bottom: 0;" id="validateForm" method="post" autocomplete="off" action="add-transfer.php" enctype="multipart/form-data">
        <div class="modal hide fade" id="transfer-file">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h3>Transfer file</h3>
            </div>
            <div class="modal-body" id="transfer">
                <div class="center"><img src="common/bootstrap/extend/bootstrap-image-gallery/img/loading.gif"/></div>
            </div>
            <div class="modal-footer">
                <button disabled="" id="submit" type="submit" class="btn btn-icon btn-primary glyphicons circle_ok"><i></i>Save</button>
            </div>
        </div>
    </form>

    <div class="modal hide fade" id="file-detail">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            <h3>Attachments</h3>
        </div>
        <div class="modal-body" id="attachments">
            <div class="center"><img src="common/bootstrap/extend/bootstrap-image-gallery/img/loading.gif"/></div>
        </div>
        <div class="modal-footer">
            <!--<button disabled="" id="submit" type="submit" class="btn btn-icon btn-primary glyphicons circle_ok"><i></i>Save</button>-->
        </div>
    </div>

</div>


<!-- // Content END -->
<?php include 'template/footer.php'; ?>
<script>
    $("a[id$='-tid']").click(function () {
        var value = $(this).attr("id");
        var id = value.replace("-tid", "");

        $.ajax({
            type: "POST",
            url: "ajax-transfer.php",
            data: {
                id: id
            },
            dataType: 'html',
            success: function (data) {
                $('#transfer').html(data);
                $('#submit').removeAttr("disabled");
            }
        });
    });

    $("a[id$='-fid']").click(function () {
        var value = $(this).attr("id");
        var id = value.replace("-fid", "");

        $.ajax({
            type: "POST",
            url: "ajax-edit-file.php",
            data: {
                id: id
            },
            dataType: 'html',
            success: function (data) {
                $('#edit').html(data);
                $('#submit').removeAttr("disabled");
            }
        });
    });

    $("a[id$='-aid']").click(function () {
        var value = $(this).attr("id");
        var id = value.replace("-aid", "");

        $.ajax({
            type: "POST",
            url: "ajax-attachments.php",
            data: {
                id: id
            },
            dataType: 'html',
            success: function (data) {
                $('#attachments').html(data);
            }
        });
    });

    $("#transfer").delegate("#file_department", 'change', function () {
        var id = $(this).val();
        $.ajax({
            type: "POST",
            url: "ajax-get-users.php",
            data: {
                id: id
            },
            dataType: 'html',
            success: function (data) {
                $('#file_user').html(data);
            }
        });
    });
</script>
</body>
</html>