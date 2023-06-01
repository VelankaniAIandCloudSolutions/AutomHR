<?php 
       $s_year = '2015';
              $select_y = date('Y');

              $s_month = date('m');
              $e_year = date('Y');
?>
<div class="content">
  <section class="panel panel-white">
            
    <div class="panel-heading">

            <?=$this->load->view('report_header');?>
            <button id="exportButton" class="btn  btn-primary pull-right">
                <span ><i class="fa fa-file-excel-o" aria-hidden="true"></i></span>
                <span>Export to Excel</span> 
            </button>
            
        </div>
        
        <div class="panel-body">
            
            <div class="fill body reports-top rep-new-band">
                <div class="criteria-container fill-container hidden-print">
                    <div class="criteria-band">
                    <form method="post" action="">
                        <div class=" <?php echo ($this->session->userdata('user_type_name') =='company_admin' || $this->tank_auth->get_role_id()==1)? 'col-md-2':'col-md-4';?>">
                            <label><?=lang('month');?> </label>
                            <select class="select floating form-control" id="attendance_month" name="attendance_month" required>  
                            
                                <?php 
                                for ($ji=1; $ji <=12 ; $ji++) {  
                                    $sele1='';
                                    

                                    if(isset($_POST['attendance_month']) && !empty($_POST['attendance_month']))
                                    {
                                    if($_POST['attendance_month']==$ji)
                                    {
                                        $sele1='selected';
                                    }

                                    }
 
                                    

                                    ?>
                                <option value="<?php echo $ji; ?>" <?php echo $sele1;?>><?php echo date('F',strtotime($select_y.'-'.$ji)); ?></option>    
                                <?php } ?>
                                
                            </select>
                        </div>
                        
                        <div class="<?php echo ($this->session->userdata('user_type_name') =='company_admin' || $this->tank_auth->get_role_id()==1)? 'col-md-2':'col-md-4';?>">
                            <label><?=lang('year');?> </label>
                            <select class="select floating form-control" id="attendance_year" name="attendance_year" required> 
                            
                            <?php for($k =$e_year;$k>=$s_year;$k--){ 
                                $sele2='';
                                if(isset($_POST['attendance_year']) && !empty($_POST['attendance_year']))
                                {
                                if($_POST['attendance_year']==$k)
                                {
                                    $sele2='selected';
                                }
                                }

                                ?>
                            <option value="<?php echo $k; ?>" <?php echo $sele2;?> ><?php echo $k; ?></option>
                            <?php } ?>
                            </select>
                        </div>

                        <div class="<?php echo ($this->session->userdata('user_type_name') =='company_admin' || $this->tank_auth->get_role_id()==1)? 'col-md-2':'col-md-4';?>">
                            <label>Branch</label>
                            <select class="select floating form-control" id="branch" name="branch" required> 
                                <option value="0" <?php echo ($selectedBranch == 0) ? 'selected' : ''; ?>>All</option>
                                <option value="2" <?php echo ($selectedBranch == 2) ? 'selected' : ''; ?>>Velankani Tech Park</option>
                                <option value="3" <?php echo ($selectedBranch == 3) ? 'selected' : ''; ?>>Unit 2 Factory</option>
                                <option value="4" <?php echo ($selectedBranch == 4) ? 'selected' : ''; ?>>The Oterra</option>
                            </select>
                        </div>



                        <button class="btn btn-success" type="submit" id="run_report_btn">
                        <?=lang('run_report')?>
                        </button>

          </div>
        </div>

        <div class="rep-container">
            <div class="page-header text-center1">
                <h3 class="reports-headerspacing">
                    Biometric Attendance Report
                </h3>
                <div class="rep-container">

                <div class="col-md-12" style="overflow-x:scroll; margin-top:10px;margin-bottom:10px;">
                <br>
              <?php if(!empty($start_date)){?>
                    <table  id="biometric_attendance_report" class="table table-striped custom-table m-b-0">
                    <thead>
                    <tr>
                        <th>#</th>
                        <th>Employee </th>
                        <th>Organization</th>
                        <th>Department</th>
                        <th>Total Hours</th>
                        <?php
                        for($i=1;$i<=$num_days;$i++){
                            ?>
                          <th class="singleline"><?php echo $i.'-'.$cur_month;?></th>
                          <?php
                         }
                         ?>
                         </tr>
                    </thead>
                    <tbody>
                    </table>
                <?php }?>
                

                </div>

            </div>
            </div>
        </div>
    </div>
  </section>
</div>
<style>
  .singleline,td{
    white-space: nowrap;
  }
  </style>
  
<script src="https://code.jquery.com/jquery-3.5.1.js"></script>
<script src="https://cdn.datatables.net/1.13.3/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.3.5/js/dataTables.buttons.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.3.5/js/buttons.html5.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/Blob.js/1.1.2/Blob.min.js"></script>
<script src="https://unpkg.com/xlsx/dist/xlsx.full.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/FileSaver.js/2.0.5/FileSaver.min.js"></script>


<script>
    var jsonData = <?php echo $apiResponse; ?>;
    var currMonth = <?php echo $cur_month2; ?>;
    console.log(jsonData);

    if (jsonData) {
      // Create an object to store the grouped data
        var groupedData = {};

        // Iterate through the JSON data
        for (var i = 0; i < jsonData["attendance-daily"].length; i++) {
            var attendanceData = jsonData["attendance-daily"][i];

            // Check if the userid key exists in the groupedData object
            if (!groupedData.hasOwnProperty(attendanceData.userid)) {
                // If the key doesn't exist, create an array for the userid
                groupedData[attendanceData.userid] = [];
            }
            // Push the attendanceData into the corresponding userid array
            groupedData[attendanceData.userid].push(attendanceData);
        }
        var table = document.getElementById("biometric_attendance_report");
        var tableBody = table.getElementsByTagName("tbody")[0];

        var rowNum = 1;
        for (var userid in groupedData) {
            if (groupedData.hasOwnProperty(userid)) {
            var userData = groupedData[userid];

            var row = tableBody.insertRow();

            var serialNumberCell = row.insertCell();
            serialNumberCell.innerHTML = rowNum++;

            var employeeNameCell = row.insertCell();
            employeeNameCell.innerHTML = userData[0].username;
            
            var organizationNameCell = row.insertCell();
            organizationNameCell.innerHTML = userData[0].organization_name;

            var departmentNameCell = row.insertCell();
            departmentNameCell.innerHTML = userData[0].department_name;
            
            var totalHours = 0; // Initialize total hours

            // Iterate through the dates
            for (var day = 1; day <= <?php echo $num_days; ?>; day++) {
                var worktime = "";
                // Find the entry with the corresponding process date
                for (var i = 0; i < userData.length; i++) {
                    var entry = userData[i];
                    var processdateParts = entry.processdate.split("/");
                    var processDay = parseInt(processdateParts[0]);
                    var processMonth = parseInt(processdateParts[1]);
                    if (day === processDay && processMonth === currMonth) {
                        worktime = entry.worktime_hhmm;
                        totalHours += convertToMinutes(worktime);
                        break;
                    }
                }

                // Insert the worktime for each date
                var worktimeCell = row.insertCell();
                worktimeCell.innerHTML = worktime;
            }
            var totalHoursCell = row.insertCell(4); 
            totalHoursCell.innerHTML = convertToHHMM(totalHours);
            }
        }

    }

    function convertToMinutes(time) {
    var timeParts = time.split(":");
    var hours = parseInt(timeParts[0]);
    var minutes = parseInt(timeParts[1]);

    return hours * 60 + minutes;
  }

  function convertToHHMM(minutes) {
    var hours = Math.floor(minutes / 60);
    var minutesRemaining = minutes % 60;

    return hours.toString().padStart(2, "0") + ":" + minutesRemaining.toString().padStart(2, "0");
  }

$(document).ready(function() {
    var table  = $('#biometric_attendance_report').DataTable();

    $('#exportButton').click(function (event) {
        event.preventDefault(); // Prevent the default form submission behavior
        var allData = table.data();

        // Create an array to hold all rows of data, including table headers
        var dataRows = [];

        // Get table headers
        var headers = [];
        table.columns().header().each(function (header) {
        headers.push(header.innerHTML);
        });
        dataRows.push(headers);

        // Iterate over each row and extract the data
        allData.each(function (data) {
        var rowData = [];
        data.forEach(function (value) {
            rowData.push(value);
        });
        dataRows.push(rowData);
        });

        // Create a worksheet with the data
        var ws = XLSX.utils.aoa_to_sheet(dataRows);

        // Create a workbook and add the worksheet
        var wb = XLSX.utils.book_new();
        XLSX.utils.book_append_sheet(wb, ws, 'Attendance Report');

        // Generate XLSX file
        var wbout = XLSX.write(wb, { bookType: 'xlsx', type: 'binary' });

        // Convert string to ArrayBuffer
        function s2ab(s) {
        var buf = new ArrayBuffer(s.length);
        var view = new Uint8Array(buf);
        for (var i = 0; i < s.length; i++) view[i] = s.charCodeAt(i) & 0xff;
        return buf;
        }

        // Create Blob and trigger download
        var blob = new Blob([s2ab(wbout)], { type: 'application/octet-stream' });
        saveAs(blob, 'attendance_report.xlsx');

      });

  });


</script>
    
<style>
    #biometric_attendance_report td {
  font-weight: normal;
}
</style>