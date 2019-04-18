<!-- Row -->
<div class="row-fluid">
    <!-- Column -->
    <div class="span12">

        <!-- Group -->
        <div class="control-group">
            <label class="control-label" for="fileno">File No</label>
            <div class="controls">
                <?php
                require_once 'classes/files.php';
                $files = new files();
                $file_id = $_POST['id'];
                $file = $files->find_by_id($file_id);
                $data = $file->fetch_array();
                ?>
                <input class="span12" type="text" disabled="" value="<?php echo $data['file_no']; ?>"/>
                <input type="hidden" name="hdnfileid" value="<?php echo $file_id; ?>"/>
            </div>
        </div>
        <!-- // Group END -->
        <!-- Group -->
        <div class="control-group">
            <label class="control-label" for="file_department">Transfer To</label>
            <div class="controls">
                <div class="span6">
                    <label>Department</label>
                    <select class="selectpicker span12" id="file_department" name="file_department">
                        <option value="">Select</option>
                        <?php
                        require_once 'classes/departments.php';
                        $departments = new departments();
                        $departs = $departments->find_all();
                        while ($rowd = $departs->fetch_array()) {
                            ?>
                            <option value="<?php echo $rowd['pk_id']; ?>"><?php echo $rowd['name']; ?></option>
                            <?php
                        }
                        ?>
                    </select> 
                </div>
                <div class="span6">
                    <label>User</label>
                    <select class="selectpicker span12" id="file_user" name="file_user">
                        <option value="">Select</option>
                    </select> 
                </div>
            </div>
        </div>
        <!-- // Group END -->
        <div class="control-group">
            <label class="control-label" for="fileno">Subject</label>
            <div class="controls">
                <input class="span12" name="subject" type="text" value=""/>
            </div>
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
        <!-- // Group END -->
        <div class="control-group">
            <label class="control-label" for="fileno">Contents</label>
            <div class="controls">
                <textarea name="contents" class="span12"></textarea>
            </div>
        </div>
        <div class="control-group">
            <label class="control-label" for="fileno">Attachments</label>
            <div class="controls">
                <div class="fileupload fileupload-new" data-provides="fileupload">
                    <span class="btn btn-default btn-file">
                        <span class="fileupload-new">Select file</span>
                        <span class="fileupload-exists">Change</span>
                        <input type="file" name="file" />
                    </span>
                    <span class="fileupload-preview"></span>
                    <a href="#" class="close fileupload-exists" data-dismiss="fileupload" style="float: none">&times;</a>
                </div>
            </div>
        </div>
    </div>
    <!-- // Column END -->



</div>
<!-- // Row END -->