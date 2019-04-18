<?php
require_once 'classes/tracking.php';
$track = new tracking();
$id = $_POST['id'];
$tr = $track->find_by_id($id);
$data = $tr->fetch_array();
?>
<div class="widget widget-tabs widget-quick hidden-print">

    <div class="widget-body">
        <div class="tab-content">

            <!-- Quick Index Tab -->
            <div class="tab-pane active" id="quickIndexTab">
                <div class="row-fluid">
                    
                    <div class="span6">
                        <!-- About -->
                        <h5>Contents</h5>                        
                        <p>Test contents</p>
                        <!-- // About END -->

                        

                    </div>
                    <div class="span6">
                        <h5>&nbsp;</h5>
                        <ul class="unstyled icons">
                            <li class="glyphicons tie"><i></i> Date In:  <span class="label label-inverse">09/03/2018</span></li>
                            <li class="glyphicons tie"><i></i> Date Out:  <span class="label label-inverse">09/03/2018</span></li>
                            <li class="glyphicons tie"><i></i> Transfer From:  <span class="label label-inverse">Asim Zaki</span></li>
                            <li class="glyphicons tie"><i></i> Transfer To:  <span class="label label-inverse">Ajmal Hussain</span></li>
                            <li class="glyphicons tie"><i></i> On desk:  <span class="label label-inverse">Ajmal Hussain</span></li>
                            <li class="glyphicons tie"><i></i> Status:  <span class="label label-inverse">Open</span></li>
                        </ul>
                        <!-- // Bio END -->

                    </div>
                </div>
            </div>
            <!-- // Quick Index Tab END -->

        </div>
        <div class="ribbon-wrapper"><div class="ribbon primary">Details</div></div>
    </div>
</div>