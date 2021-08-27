<div class="app-content content container-fluid">
  <div class="content-wrapper">
    <div class="content-header row"> </div>
    <div class="content-body">
      <?php if ($this->session->flashdata("messagePr")) { ?>
      <div class="alert alert-info"> <?php echo $this->session->flashdata("messagePr") ?> </div>
      <?php } ?>
      <div class="card card-block">
          <div class="card-header px-0">
            <h4 class="card-title"><?php echo $this->lang->line('Manage Invoices') ?> </h4>
            <a class="heading-elements-toggle"><i class="fa fa-ellipsis-v font-medium-3"></i></a>
            <div class="heading-elements">
                <ul class="list-inline mb-0">
                    <li><a data-action="collapse"><i class="ft-minus"></i></a></li>
                    <li><a data-action="expand"><i class="ft-maximize"></i></a></li>
                    <li><a data-action="close"><i class="ft-x"></i></a></li>
                </ul>
            </div>
        </div>
        <div class="card-content">
            <div id="notify" class="alert alert-success" style="display:none;">
                <a href="#" class="close" data-dismiss="alert">&times;</a>

                <div class="message"></div>
            </div>
            <div class="card-body pt-0">
               <div class="table-header-search-list">
                  <div class="table-header-search-list-left">
                    <div class="excel-button">
                      <button class="btn btn-info">
                        <span>Excel</span>
                      </button> 
                    </div>
                    <div class="dataTables_length">
                      <label>Show 
                        <select class="form-control">
                          <option value="10">10</option>
                          <option value="20">20</option>
                          <option value="50">50</option>
                          <option value="100">100</option>
                          <option value="200">200</option>
                          <option value="500">500</option>
                        </select> 
                      entries</label>
                    </div>
                  </div>
                  <div class="table-header-search-list-right">
                    <div class="form-group">
                      <label>Search:</label>
                      <input type="search" class="form-control" placeholder="" aria-controls="productstable">
                    </div>
                  </div>
                </div>
                <table id="invoices" class="table table-striped table-bordered zero-configuration pt-1">
                    <thead>
                    <tr>
                        <th><?php echo $this->lang->line('No') ?></th>
                        <th>Invoices</th>
                        <th><?php echo $this->lang->line('Customer') ?></th>
                        <th><?php echo $this->lang->line('Date') ?></th>
                        <th><?php echo $this->lang->line('Amount') ?></th>
                        <th><?php echo $this->lang->line('Status') ?></th>
                        <th class="no-sort"><?php echo $this->lang->line('Settings') ?></th>


                    </tr>
                    </thead>
                    <tbody>
                      <tr>
                        <td>1</td>
                        <td><a href="http://13.233.62.90/zobox/invoices/view?id=636">&nbsp; LRP#8123</a></td>
                        <td>Box_F1-Jaydeep</td>
                        <td>20-08-2021</td>
                        <td> ₹ 3,700.00</td>
                        <td><span class="st-due">Due</span></td>
                        <td><a href="http://13.233.62.90/zobox/invoices/view?id=636" class="btn btn-success btn-sm" title="View"><i class="fa fa-eye"></i></a>&nbsp;<a href="http://13.233.62.90/zobox/invoices/printinvoice?id=636&amp;d=1" class="btn btn-info btn-sm" title="Download"><span class="fa fa-download"></span></a></td>
                      </tr>
                    </tbody>

                    <tfoot>
                    <tr>
                        <th><?php echo $this->lang->line('No') ?></th>
                        <th>Invoices</th>
                        <th><?php echo $this->lang->line('Customer') ?></th>
                        <th><?php echo $this->lang->line('Date') ?></th>

                        <th><?php echo $this->lang->line('Amount') ?></th>
                        <th><?php echo $this->lang->line('Status') ?></th>
                        <th class="no-sort"><?php echo $this->lang->line('Settings') ?></th>

                    </tr>
                    </tfoot>
                </table>
                <div class="table-pagi">
                <nav aria-label="...">
                    <ul class="pagination">
                      <li class="page-item disabled">
                        <a class="page-link" href="#" tabindex="-1">Previous</a>
                      </li>
                      <li class="page-item active"><a class="page-link" href="#">1</a></li>
                      <li class="page-item">
                        <a class="page-link" href="#">2 <span class="sr-only">(current)</span></a>
                      </li>
                      <li class="page-item"><a class="page-link" href="#">3</a></li>
                      <li class="page-item">
                        <a class="page-link" href="#">Next</a>
                      </li>
                    </ul>
                  </nav>
              </div>
            </div>
        </div>
      </div>
    </div>
  </div>
</div>
<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>

