 <section class="content-header">
          <h1>
            Accounting Report
            <small>Accounting Report</small>
          </h1>
          <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
            <li><a href="#">UI</a></li>
            <li class="active">General</li>
          </ol>
        </section>
  
  <style>
  chart-1{
	  width:100% !important;}
	 .highcharts-container{
		width:100% !important; }
  </style>

	  <section class="content">
      <div class="row">
		<div class="col-md-3">
		<div class="box box-primary" style='min-height:250px'>
            <div class="box-header with-border">
              <h3 class="box-title">Financial Statement</h3>
            </div>
            <!-- /.box-header -->
            <!-- form start -->
            <form role="form">
              <div class="box-body">
				<ul class='accounting'>
				<li><a href="<?php echo BASE_URL()."index.php/accounting_report/profit_and_lost_statement?title=Profit and Loss Statement&&id=reportDetailProfitandLossStatement"; ?>">Profit and Loss Statement</a></li>
				<li><a href="<?php echo BASE_URL()."index.php/accounting_report/profit_and_lost_statement?title=Profit and Loss Statement(Actual vs Budget)&&id=reportDetailProfitandLossStatementActualvsBudget"; ?>">Profit and Loss Statement(Actual vs Budget)</a></li>
				<li><a href="<?php echo BASE_URL()."index.php/accounting_report/profit_and_lost_statement?title=Balance Sheet&&id=reportDetailBalanceSheet"; ?>">Balance Sheet</a></li>
				<li><a href="<?php echo BASE_URL()."index.php/accounting_report/profit_and_lost_statement?title=Statement of Changes in Equity&&id=reportDetailStatementofChangesinEquity"; ?>">Statement of Changes in Equity</a></li>
				</ul>
              </div>

              <!-- /.box-body -->

              
            </form>
          </div>
		</div>
		
		<div class="col-md-3">
		<div class="box box-primary" style='min-height:250px'>
            <div class="box-header with-border">
              <h3 class="box-title">Cash and Cash Equivalents</h3>
            </div>
            <!-- /.box-header -->
            <!-- form start -->
            <form role="form">
              <div class="box-body">
				<ul class='accounting'>
				<li><a href="<?php echo BASE_URL()."index.php/accounting_report/profit_and_lost_statement?title=Cash Summary&&id=reportDetailCashSummary"; ?>">Cash Summary</a></li>
				</ul>
              </div>

              <!-- /.box-body -->

              
            </form>
          </div>
		</div>
		
		
		
		<div class="col-md-3">
		<div class="box box-primary" style='min-height:250px'>
            <div class="box-header with-border">
              <h3 class="box-title">General Ledger</h3>
            </div>
            <!-- /.box-header -->
            <!-- form start -->
            <form role="form">
              <div class="box-body">
				<ul class='accounting'>
				<li><a href="<?php echo BASE_URL()."index.php/accounting_report/profit_and_lost_statement?title=Trial and Balance&&id=reportDetailTrialBalance"; ?>">Trial and Balance</a></li>
				<li><a href="<?php echo BASE_URL()."index.php/accounting_report/profit_and_lost_statement?title=General Ledger Summary&&id=reportDetailGeneralLedgerSummary"; ?>">General Ledger Summary</a></li>
				<li><a href="<?php echo BASE_URL()."index.php/accounting_report/profit_and_lost_statement?title=General Ledger Transactions&&id=reportDetailGeneralLedgerSummary"; ?>">General Ledger Transactions</a></li>
				<li><a href="<?php echo BASE_URL()."index.php/accounting_report/profit_and_lost_statement?title=Starting Balance&&id=reportDetailStartingBalance"; ?>">Starting Balance</a></li>
				</ul>
              </div>

              <!-- /.box-body -->

              
            </form>
          </div>
		</div>
		
		
		<div class="col-md-3">
		<div class="box box-primary" style='min-height:250px'>
            <div class="box-header with-border">
              <h3 class="box-title">Tax Reports</h3>
            </div>
            <!-- /.box-header -->
            <!-- form start -->
            <form role="form">
              <div class="box-body">
				<ul class='accounting'>
				<li><a href="<?php echo BASE_URL()."index.php/accounting_report/profit_and_lost_statement?title=Tax Audit"; ?>">Tax Audit</a></li>
				<li><a href="<?php echo BASE_URL()."index.php/accounting_report/profit_and_lost_statement?title=Tax Summary&&id=reportDetailTaxSummary"; ?>">Tax Summary</a></li>
				<li><a href="<?php echo BASE_URL()."index.php/accounting_report/profit_and_lost_statement?title=Tax Reconciliation&&id=reportDetailTaxReconciliation"; ?>">Tax Reconciliation</a></li>
				<li><a href="<?php echo BASE_URL()."index.php/accounting_report/profit_and_lost_statement?title=Tax Transaction&&id=reportDetailTaxTransactions"; ?>">Tax Transaction</a></li>
				</ul>
              </div>
            </form>
          </div>
		</div>
		
		
		<div class="col-md-3">
		<div class="box box-primary" style='min-height:250px'>
            <div class="box-header with-border">
              <h3 class="box-title">Account Receivable</h3>
            </div>
            <!-- /.box-header -->
            <!-- form start -->
            <form role="form">
              <div class="box-body">
				<ul class='accounting'>
				<li><a href="<?php echo BASE_URL()."index.php/accounting_report/profit_and_lost_statement?title=Aged Receivables&&id=reportDetailAgedReceivable"; ?>">Aged Receivables</a></li>
				<li><a href="<?php echo BASE_URL()."index.php/accounting_report/profit_and_lost_statement?title=Customer Statement&&id=reportDetailCustomerStatement"; ?>">Customer Statement</a></li>
				</ul>
              </div>
            </form>
          </div>
		</div>
		
		<div class="col-md-3">
		<div class="box box-primary" style='min-height:250px'>
            <div class="box-header with-border">
              <h3 class="box-title">Account Payable</h3>
            </div>
            <!-- /.box-header -->
            <!-- form start -->
            <form role="form">
              <div class="box-body">
				<ul class='accounting'>
				<li><a href="<?php echo BASE_URL()."index.php/accounting_report/profit_and_lost_statement?title=Aged Payables&&id=reportDetailAgedPayables"; ?>">Aged Payables</a></li>
				<li><a href="<?php echo BASE_URL()."index.php/accounting_report/profit_and_lost_statement?title=Supplier Statement"; ?>">Supplier Statement</a></li>
				</ul>
              </div>
            </form>
          </div>
		</div>
		
		
		
	
		<div class="col-md-3">
		<div class="box box-primary" style='min-height:250px'>
            <div class="box-header with-border">
              <h3 class="box-title">Sales Invoice</h3>
            </div>
            <!-- /.box-header -->
            <!-- form start -->
            <form role="form">
              <div class="box-body">
				<ul class='accounting'>
				<li><a href="<?php echo BASE_URL()."index.php/accounting_report/profit_and_lost_statement?title=Sales Invoice Total By Customer&&id=reportDetailSalesInvoiceTotalbyCustomer"; ?>">Sales Invoice Total By Customer</a></li>
				<li><a href="<?php echo BASE_URL()."index.php/accounting_report/profit_and_lost_statement?title=Sales Invoice Total By Item&&id=reportDetailSalesInvoiceTotalbyItem"; ?>">Sales Invoice Total By Item</a></li>
				<li><a href="<?php echo BASE_URL()."index.php/accounting_report/profit_and_lost_statement?title=Sales Invoice Total By Custom Field"; ?>">Sales Invoice Total By Custom Field</a></li>
				</ul>
              </div>
            </form>
          </div>
		</div>
		
		
		<div class="col-md-3">
		<div class="box box-primary" style='min-height:250px'>
            <div class="box-header with-border">
              <h3 class="box-title">Fixed Assets</h3>
            </div>
            <!-- /.box-header -->
            <!-- form start -->
            <form role="form">
              <div class="box-body">
				<ul class='accounting'>
				<li><a href="<?php echo BASE_URL()."index.php/accounting_report/profit_and_lost_statement?title=Fixed Asset Summary&&id=reportDetailFixedAssetSummary"; ?>">Fixed Asset Summary</a></li>
				</ul>
              </div>
            </form>
          </div>
		</div>
		
	
		<div class="col-md-3">
		<div class="box box-primary" style='min-height:250px'>
            <div class="box-header with-border">
              <h3 class="box-title">Expense Claims</h3>
            </div>
            <!-- /.box-header -->
            <!-- form start -->
            <form role="form">
              <div class="box-body">
				<ul class='accounting'>
				<li><a href="<?php echo BASE_URL()."index.php/accounting_report/profit_and_lost_statement?title=Expense Claims Summary&&id=reportDetailExpenseClaimsSummary"; ?>">Expense Claims Summary</a></li>
				</ul>
              </div>
            </form>
          </div>
		</div>
		
		<div class="col-md-3">
		<div class="box box-primary" style='min-height:250px'>
            <div class="box-header with-border">
              <h3 class="box-title">Capital Accounts</h3>
            </div>
            <!-- /.box-header -->
            <!-- form start -->
            <form role="form">
              <div class="box-body">
				<ul class='accounting'>
				<li><a href="<?php echo BASE_URL()."index.php/accounting_report/profit_and_lost_statement?title=Capital Accounts Summary"; ?>">Capital Accounts Summary</a></li>
				</ul>
              </div>
            </form>
          </div>
		</div>
		
		<div class="col-md-3">
		<div class="box box-primary" style='min-height:250px'>
            <div class="box-header with-border">
              <h3 class="box-title">Payslips</h3>
            </div>
            <!-- /.box-header -->
            <!-- form start -->
            <form role="form">
              <div class="box-body">
				<ul class='accounting'>
				<li><a href="<?php echo BASE_URL()."index.php/accounting_report/profit_and_lost_statement?title=Payslips Summary&&id=reportDetailPayslipSummary"; ?>">Payslips Summary</a></li>
				<li><a href="<?php echo BASE_URL()."index.php/accounting_report/profit_and_lost_statement?title=Payslips Earnings Summary&&id=PayslipEarningsSummary"; ?>">Payslips Earnings Summary</a></li>
				<li><a href="<?php echo BASE_URL()."index.php/accounting_report/profit_and_lost_statement?title=Payslips Deductions Summary&&id=reportDetailPayslipDeductionsSummary"; ?>">Payslips Deductions Summary</a></li>
				<li><a href="<?php echo BASE_URL()."index.php/accounting_report/profit_and_lost_statement?title=Contributions Summary"; ?>">Contributions Summary</a></li>
				</ul>
              </div>
            </form>
          </div>
		</div>
		
		<div class="col-md-3">
		<div class="box box-primary" style='min-height:250px'>
            <div class="box-header with-border">
              <h3 class="box-title">Tracking Codes</h3>
            </div>
            <!-- /.box-header -->
            <!-- form start -->
            <form role="form">
              <div class="box-body">
				<ul class='accounting'>
				<li><a href="<?php echo BASE_URL()."index.php/accounting_report/profit_and_lost_statement?title=Tracking Exception Report"; ?>">Tracking Exception Report</a></li>
				</ul>
              </div>
            </form>
          </div>
		</div>
	
		
		</div>
		</section>
		
		