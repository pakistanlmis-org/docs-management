<?php
require_once 'classes/attachments.php';
$attachments = new attachments();
$file_id = $_POST['id'];
$attachment = $attachments->find_by_file($file_id);
$file = $attachment->fetch_array();
$fileno = $file['FileNo'];
?>
<!-- Row -->
<div class="row-fluid">

    <!-- Column -->
    <div class="span12">
        File No : <?php echo $fileno; ?>
        <table class="table table-bordered table-condensed table-striped table-vertical-center checkboxs js-table-sortable">
            <thead>
                <tr>
                    <th style="width: 1%;" class="center">No.</th>
                    <th>Attachment</th>
                    <th>Author</th>
                    <th class="right" colspan="3">Actions</th>
                </tr>
            </thead>
            <tbody>
                <tr class="selectable">
                    <td class="center">1</td>
                    <td class="center"><a href="uploads/<?php echo $file['file_id']; ?>/<?php echo $file['Attachment']; ?>" target="_blank"><?php echo $file['Attachment']; ?></a></td>
                    <td class="center"><?php echo $file['Author']; ?></td>
                    <td class="center" style="width: 60px;">
                        <a onclick="return confirm('Are you sure you want to delete this attachement?');" href="delete_attachment.php?id=<?php echo $file['pk_id']; ?>" class="btn-action glyphicons remove_2 btn-danger"><i></i></a>
                    </td>
                </tr>
                <!-- Table row -->
                <?php
                $count = 2;
                while ($row = $attachment->fetch_array()) {
                    ?>
                    <tr class="selectable">
                        <td class="center"><?php echo $count; ?></td>
                        <td class="center"><a href="uploads/<?php echo $row['file_id']; ?>/<?php echo $row['Attachment']; ?>" target="_blank"><?php echo $row['Attachment']; ?></a></td>
                        <td class="center"><?php echo $row['Author']; ?></td>
                        <td class="center" style="width: 60px;">
                            <a onclick="return confirm('Are you sure you want to delete this attachement?');" href="delete_attachment.php?id=<?php echo $row['pk_id']; ?>" class="btn-action glyphicons remove_2 btn-danger"><i></i></a>
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

    </div>
    <!-- // Column END -->



</div>
<!-- // Row END -->