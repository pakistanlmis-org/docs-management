<?php
require_once 'classes/files.php';
require_once 'classes/departments.php';
$files = new files();
$file_id = $_POST['id'];
$file = $files->find_by_id($file_id);
$data = $file->fetch_array();
?>
<!-- Row -->
<div class="row-fluid">

    <!-- Column -->
    <div class="span12">

        <!-- Group -->
        <div class="control-group">
            <label class="control-label" for="fileno">File no</label>
            <div class="controls"><input class="span12" id="fileno" name="fileno" type="text" value="<?php echo $data['file_no']; ?>" /></div>
        </div>
        <div class="control-group">
            <label class="control-label" for="title">Title</label>
            <div class="controls"><input class="span12" id="title" name="title" type="text" value="<?php echo $data['file_title']; ?>" /></div>
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
                        <option value="<?php echo $rowd['pk_id']; ?>" <?php if ($rowd['pk_id'] == $data['file_department']) { ?>selected="" <?php } ?>><?php echo $rowd['name']; ?></option>
                        <?php
                    }
                    ?>
                </select> 
            </div>
        </div>
        <!-- // Group END -->
        <div class="control-group">
            <label class="control-label" for="description">Description</label>
            <div class="controls"><textarea class="span12" id="description" name="description"><?php echo $data['file_description']; ?></textarea></div>
        </div>
        <!-- Group -->
        <div class="control-group">
            <label class="control-label" for="status">Status</label>
            <div class="controls">
                <select class="selectpicker span12" id="status" name="status">
                    <option value="1" <?php if (1 == $data['status']) { ?>selected="" <?php } ?>>Open</option>
                    <option value="2" <?php if (2 == $data['status']) { ?>selected="" <?php } ?>>Closed</option>
                </select>
            </div>
        </div>
        <div class="control-group">
            <label class="control-label" for="receive_from">Receive From</label>
            <div class="controls"><input class="span12" id="receive_from" name="receive_from" type="text" value="<?php echo $data['receive_from']; ?>" /></div>
        </div>
        <!-- // Group END -->
        <div class="control-group">
            <label class="control-label" for="file">Add attachments</label>
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
<input type="hidden" name="fileid" value="<?php echo $file_id; ?>"/>