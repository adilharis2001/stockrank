<!DOCTYPE html>
<html lang="en">
	<head>
		<meta http-equiv="content-type" content="text/html; charset=UTF-8">
		<meta charset="utf-8">
		<title>Stock Rank</title>
		<meta name="generator" content="Bootply" />
		<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
		<link href="css/bootstrap.min.css" rel="stylesheet">
		<link rel="stylesheet" type="text/css" href="css/bootstrap-datepicker.css">
    <link rel="stylesheet" href="http://code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">
    <!--[if lt IE 9]>
			<script src="//html5shim.googlecode.com/svn/trunk/html5.js"></script>
		<![endif]-->
		<link href="css/styles.css" rel="stylesheet">
	</head>
	<body>
<nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
      <div class="container-fluid">
        <div class="navbar-header">
          <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          <a class="navbar-brand" href="#">Stock Rank</a>
        </div>
        <div class="navbar-collapse collapse">
          <ul class="nav navbar-nav navbar-right">
            <!--li><a href="#">Dashboard</a></li>
            <li><a href="#">Settings</a></li>
            <li><a href="#">Profile</a></li-->
            <li><a href="#">Logout</a></li>
          </ul>
        </div>
      </div>
</nav>

<div class="container-fluid">
      
      <div class="row row-offcanvas row-offcanvas-left">
        
         <div class="col-sm-3 col-md-2 sidebar-offcanvas" id="sidebar" role="navigation">
           
            <!--ul class="nav nav-sidebar">
              <li class="active"><a href="#">Overview</a></li>
              <li><a href="#">Reports</a></li>
              <li><a href="#">Analytics</a></li>
              <li><a href="#">Export</a></li>
            </ul>
            <ul class="nav nav-sidebar">
              <li><a href="">Nav item</a></li>
              <li><a href="">Nav item again</a></li>
              <li><a href="">One more nav</a></li>
              <li><a href="">Another nav item</a></li>
              <li><a href="">More navigation</a></li>
            </ul>
            <ul class="nav nav-sidebar">
              <li><a href="">Nav item again</a></li>
              <li><a href="">One more nav</a></li>
              <li><a href="">Another nav item</a></li>
            </ul-->
          
        </div><!--/span-->
        
        <div class="col-sm-9 col-md-10 main">
          
          <!--toggle sidebar button-->
          <p class="visible-xs">
            <button type="button" class="btn btn-primary btn-xs" data-toggle="offcanvas"><i class="glyphicon glyphicon-chevron-left"></i></button>
          </p>
          
		  <h2 class="page-header">Welcome</h2>

          <div class="row placeholders">
            <div class="col-md-4" style="border: 2px solid #ccc;padding: 22px;border-radius: 10px;">
			 <form method="post" action="inputInvestment.php">
               <div class="form-group">
                <label for="exampleInputEmail1">Investment Name </label>
                <input type="text" class="form-control" id="add_name" name="name" placeholder="Eg: Daughter's Wedding">
              </div>
              <div class="form-group">
                  <label for="exampleInputEmail1">Starting date of Investment</label>
                  <p><input class="form-control" type="text" name="date" id="datepicker"></p>
              </div>
              <div class="form-group">
                <label for="exampleInputEmail1">Add Investment (In Rupees) </label>
                <input type="text" class="form-control" id="add_investment" name="amount" placeholder="Eg: 20000">
              </div>
              <button type="submit" class="btn btn-default">Add</button>
			  </form>
            </div>
          </div>
          
          <hr>

          <h2 class="sub-header">Current Investments</h2>
          <div class="table-responsive">
            <table class="table table-striped" id="current_tab">
              
            </table>
            <!-- menu tabs--> 
            
            <div id="buy-sell" style="display:none">
              <div class='header_div' style="  margin-right: 12%;text-align: center;">
                <h3 style="color:rgb(12, 197, 127);font-weight:bolder" >
                  Investment Name: <span id='currentSelection'></span>
                </h3>
                
              </div>
               <ul class="nav nav-tabs" role="tablist" >
                <li role="presentation" class="active" id="buy-opt"><a href="#buy-area" aria-controls="buy-area" role="tab" data-toggle="tab" style="color:rgb(12, 197, 127)">Buy </a></li>
                <li role="presentation" class="" id="sell-opt"><a href="#sell-area" aria-controls="sell-area" role="tab" data-toggle="tab" style="color:rgb(12, 197, 127)">Sell</a></li>
                <li role="presentation" class="" id="cp-opt"><a href="#cp-area" aria-controls="cp-area" role="tab" data-toggle="tab" style="color:rgb(12, 197, 127)">Portfolio</a></li>
              </ul>

                           
              <div class="tab-content">
                <div role="tabpanel" class="tab-pane active" id="buy-area" aria-labelledby="0-privacy-tab" style="overflow:auto;height:350px;overflow-x:hidden;">
                        
                </div>
                <div role="tabpanel" class="tab-pane" id="sell-area" aria-labelledby="0-recommend-tab" style="overflow:auto;height:350px;overflow-x:hidden;">              
        
                </div>
                <div role="tabpanel" class="tab-pane" id="cp-area" aria-labelledby="0-port" style="overflow:auto;height:350px;overflow-x:hidden;">              
                </div>
              </div>
            </div>
            <!--div id="options" style="display:none">
              <button class="btn btn-info" id = "buy">Buy</button>
              <button class="btn btn-success" id = "sell">Sell</button>
              <button class="btn btn-danger" id = "cp">Current Portfolio</button>
            </div-->
          </div>
          
      </div><!--/row-->
	</div>
</div><!--/.container-->

<footer>
  <p class="pull-right">Adil Amrit 2015</p>
</footer>
        
	<!-- script references -->
		<script src="js/jquery-1.9.1.js"></script>
		<script src="js/bootstrap.min.js"></script>
    <script src="js/notify.min.js"></script>
		<script src="js/scripts.js"></script>
    <script src="http://code.jquery.com/ui/1.11.4/jquery-ui.js"></script>
    <script type="text/javascript">
      $(document).ready(function(){

        var investment_value = 0; 
        var globalDate = "";
       // $( "#datepicker" ).datepicker();

        $.get("getData.php",function(data){
           // $.notify("Hello World");
            var arr = eval("("+data+")");
            var html_str = "<thead><tr><th>Id</th><th>Investment Name</th><th>Date of Investment</th><th>Investment Amount</th><th>Balance Left</th></tr></thead><tbody>";
            for(var i =0;i<arr.length;i++)
            {
              var id = arr[i]["id"];
              var username = arr[i]["username"];
              var amount = arr[i]["amount"];    
              var investmentName = arr[i]["nameInv"];
              var doj = arr[i]["doj"];
              var amount_left = arr[i]["left"];
              html_str+="<tr class='stock' id="+id+"><td>"+id+"</td><td class='invname'>"+investmentName+"</td><td class='date'>"+doj+"</td><td class='amount'>"+amount+"</td><td class='balanceLeft'>"+amount_left+"</td></tr>";
            }
            html_str+="</tbody>";
            $("#current_tab").html(html_str);

        });

        $(document).delegate('#buy-opt',"click",function(){
          $.get("getBuy.php", function(data){
            var arr = eval("("+data+")");
            var html_str = "<table class='table table-striped'><thead><tr><th>Name</th><th>Score</th><th>Price</th><th>Shares to Buy</th><th></th></tr></thead><tbody>";
            for(var i=0;i<arr.length;i++)
            {
              var id= arr[i]["id"];
              var name = arr[i]["name"];
              var score = arr[i]["score"];
              var close = arr[i]["close"];
              html_str+="<tr id="+id+"><td class='stockName'>"+name+"</td><td>"+score+"</td><td class='currentValue'>"+close+"</td><td class='inp'><input class='no_of_shares' type='number' min='0'></td><td><button class='btn btn-info buy-click' id='"+id+"'>Buy</button></td></tr>"; 
            }
            html_str+="</tbody></table>";
            $("#buy-area").html(html_str);

          });    
        });

         $(document).delegate('#cp-opt',"click",function(){
          $.post("getCp.php",{doj:globalDate}, function(data){
            var arr = eval("("+data+")");
            if(data != '[]'){
            var html_str = "<table class='table table-striped'><thead><tr><th>Stock Name</th><th>Purchase Price</th><th>Stop-loss Price</th><th>Current Price</th><th>Toal Shares Purchased</th><th>Shares Remaining</th></tr></thead><tbody>";
            var portfolioValue = 0;
            for(var i=0;i<arr.length - 1;i++)
            {
              var stockName= arr[i]["stockName"];
              var purchasePrice = arr[i]["purchasePrice"];
              var sharesRemaining = arr[i]["sharesRemaining"];
              var sharesInitiallyPurchased = arr[i]["sharesInitiallyPurchased"];
              var currentClose = arr[i]["currentClose"];
              var stopLoss = arr[i]["stopLoss"];
              portfolioValue += currentClose * sharesRemaining;
              html_str+="<tr><td class='stockName'>"+stockName+"</td><td>"+purchasePrice+"</td><td>"+stopLoss+"</td><td class='currentValue'>"+currentClose+"</td><td class='tot'>"+sharesInitiallyPurchased+"</td><td class = 'rem'>"+sharesRemaining+"</td></tr>"; 
            }
            var gain = arr[arr.length - 1];
            html_str+="</tbody></table><h4 style=\"margin-right: 12%;text-align: center;border: 2px solid rgb(12, 197, 127) \"> Total Gain:"+gain+"<br>Portfolio Value:"+parseInt(portfolioValue)+"</h4>";
            $("#cp-area").html(html_str);
          }
            else{ $("#cp-area").html("<br><br><h4 style=\"color:rgb(12, 197, 127);margin-right: 12%;text-align: center;\">Your portfolio is empty!</h4>");}
  
          });    
        });

         $(document).delegate('#sell-opt',"click",function(){
           $.post("getSell.php",{doj:globalDate},function(data1){
            var arr = eval("("+data1+")");
            if(data1 != '[]'){
            var html_str = "<table class='table'><thead><tr><th>Name</th><th>Score</th><th>Current Price</th><th>Purchase Price</th><th>Shares Remaining</th><th>Shares to Sell</th><th></th></tr></thead><tr><th>Recommended Stocks</th></tr><tbody>";
            var flag = false;
            for(var i=0;i<arr.length;i++)
            {
              var id= arr[i]["id"];
              var name = arr[i]["name"];
              var score = arr[i]["score"];
              if(score < 0.7){
                continue;
              }
              flag = true;
              var close = arr[i]["close"];
              var purchasePrice = arr[i]["pp"];
              var nos = arr[i]["nos"];
              var upid = arr[i]["upid"];
              if(flag)
                html_str+="<tr id="+id+"><td class='stockName'>"+name+"</td><td>"+score+"</td><td class='currentValue'>"+close+"</td><td class='purchasePrice'>"+purchasePrice+"</td><td class='numberofsharespurchased'>"+nos+"</td><td class='inp2'><input class='no_of_shares' type='number' min='0' max='"+nos+"'></td><td><button class='btn btn-info sell-click' id='"+id+"'>Sell</button></td></tr>";     
            } 
              if(!flag)
               html_str+="<tr style=\"color:rgb(12, 197, 127);\"><td></td><td></td><td></td><th>There are currently no stocks recommended to sell!</th><td></td><td></td><td></td></tr>";
             html_str+="<tr></tr><tr><th>Other Stocks in Portfolio</th></tr>";
             var flag = false;
             for(var i=0;i<arr.length;i++)
             {
              var id= arr[i]["id"];
              var name = arr[i]["name"];
              var score = arr[i]["score"];
              if(score > 0.7){
                continue;
              }
              flag = true;
              var close = arr[i]["close"];
              var purchasePrice = arr[i]["pp"];
              var nos = arr[i]["nos"];
              var upid = arr[i]["upid"];
              html_str+="<tr id="+id+"><td class='stockName'>"+name+"</td><td>"+score+"</td><td class='currentValue'>"+close+"</td><td class='purchasePrice'>"+purchasePrice+"</td><td class='numberofsharespurchased'>"+nos+"</td><td class='inp2'><input class='no_of_shares' type='number' min='0' max='"+nos+"'></td><td><button class='btn btn-info sell-click' id='"+id+"'>Sell</button></td></tr>"; 
            }  
            if(!flag)
               html_str+="<tr style=\"color:rgb(12, 197, 127);\"><td></td><td></td><td></td><th>No other shares have been purchased</th><td></td><td></td><td></td></tr>";
            
            html_str+="</tbody></table>";
            $("#sell-area").html(html_str);
            }else{ $("#sell-area").html("<br><br><h4 style=\"color:rgb(12, 197, 127);margin-right: 12%;text-align: center;\">Your portfolio is empty!</h4>");}
           });    
        });

        $(document).delegate(".stock","click",function(){
           
          //$(this).css('background-color','rgb(157, 255, 244)');
          var id = $(this).attr('id');
          $("#buy-sell").show();
          //console.log(id);
          var date = $(this).children(".invname").html();
          globalDate = date;
          $('#currentSelection').html(globalDate);
          var investmentAmount = $(this).children(".amount").html();
          var balanceLeft = $(this).children(".balanceLeft").html();
          investment_value = balanceLeft;
          $.post("alertNotify.php",{doj:globalDate},function(data1){
            if(data1 == "1"){}
            else{
              $.notify("Your "+ data1 +" shares have triggered a stop-loss, and your shares have been sold!", { position:"left",autoHideDelay: 5000 });
            }
          });
          //$('.active.tab-pane').removeClass('active'); 
          //$("#buy-opt").addClass('active');
          //$("#buy-area").show();
          $("#buy-opt").trigger("click");
          $("#sell-opt").trigger("click");
          $("#cp-opt").trigger("click");
          //console.log(date);
          //console.log(investmentAmount);
          //console.log(balanceLeft);
        });

        $(document).delegate(".sell-click","click",function(){
          var tr = $(this).closest('tr');
          var currentValue = tr.children('.currentValue').html();
          var stockName = tr.children('.stockName').html();
          var noOfSharesPurchased = tr.children('.numberofsharespurchased').html();
          var purchasePrice = tr.children('.purchasePrice').html();
          currentValue = parseFloat(currentValue);
          var td_inp = tr.children('.inp2');
          var no_of_shares = td_inp.children('input').val();
          if(no_of_shares != '' && parseInt(no_of_shares) > 0){
           noOfSharesPurchased = parseInt(noOfSharesPurchased);
           no_of_shares = parseInt(no_of_shares);
          if(noOfSharesPurchased < no_of_shares){
             alert("You do not have "+no_of_shares+" shares remaining in "+stockName+". Try "+noOfSharesPurchased+" instead.");
          }else{
            var x;
            if(confirm("Are you sure you want to sell " + no_of_shares + " share/shares in " + stockName + "?") == true){
              x=true;
            }else{
              x=false;
            }
            if(x){
              var sharesRemaining = noOfSharesPurchased - no_of_shares;
              var sellingPrice = no_of_shares * currentValue;
               $.post("sellUserPortfolio.php",{currentValue:currentValue,numberOfShares:no_of_shares,stockName:stockName,sellingPrice:sellingPrice,sharesRemaining:sharesRemaining,sharesInitially:noOfSharesPurchased,doj:globalDate,purchasePrice:purchasePrice},function(response){
                  alert(response);
                  location.reload();
              });
            }
          }
        }else{
          alert("Value cannot be null")
        }
        });

        $(document).delegate(".buy-click","click",function(){
          var tr = $(this).closest('tr');
          var value = tr.children('.currentValue').html();
          var stockName = tr.children('.stockName').html();
          value = parseFloat(value);
          var td_inp = tr.children('.inp');
          var no_of_shares = td_inp.children('input').val();
          if(no_of_shares != '' && parseInt(no_of_shares) > 0){
          //console.log(value);
          //console.log(qq);
          var shares_cost = value * no_of_shares;
          if (shares_cost > investment_value){
            alert("Insufficient Funds! You can buy a maximum of "+parseInt(investment_value/value)+" shares with current funds."+" Please reduce number of stocks or add more funds for "+globalDate);
          }
          else
          {
            var x;
            if (confirm("Are you sure you want buy " + no_of_shares + " share/shares in " + stockName + "?") == true) {
                x = true;
            } else {
                x = false;
            }
            if(x)
            {
              var balanceLeft = investment_value- shares_cost;
              $.post("addUserPortfolio.php",{balanceLeft:balanceLeft,numberOfShares:no_of_shares,stockName:stockName,totalCost:shares_cost,closePrice:value,doj:globalDate},function(response){
                  alert(response);
                  location.reload();
              });
            }
          }
        }else{
          alert("Value cannot be null or negative");
        }

        });

      });
    </script>
	</body>
</html>